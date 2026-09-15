<?php
/**
 * Bank transfer (BACS) checkout: a receipt-upload step on the order-received
 * page, admin-post handler that attaches the receipt + reference to the
 * order, and a review panel on the order edit screen so the shop owner can
 * verify payment before shipping.
 *
 * @package NuviraShop
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Renders the receipt-upload form on the thank-you page for orders paid by
 * bank transfer that are still waiting on payment confirmation.
 *
 * @param int $order_id Order ID.
 */
add_action(
	'woocommerce_thankyou',
	function ( $order_id ) {
		if ( ! $order_id ) {
			return;
		}
		$order = wc_get_order( $order_id );
		if ( ! $order || 'bacs' !== $order->get_payment_method() ) {
			return;
		}

		$reference   = $order->get_meta( '_nuvira_payment_reference' );
		$receipt_id  = $order->get_meta( '_nuvira_receipt_id' );
		$uploaded    = ! empty( $reference ) && ! empty( $receipt_id );
		$just_synced = isset( $_GET['nuvira_receipt'] ) && 'success' === $_GET['nuvira_receipt']; // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- read-only success flag, no state change.
		?>
		<section class="ns-receipt-panel">
			<?php if ( $uploaded ) : ?>
				<h2><?php esc_html_e( 'Receipt received — thank you!', 'nuvira-shop' ); ?></h2>
				<p><?php esc_html_e( "We've got your payment reference and receipt. We'll confirm and ship your order shortly.", 'nuvira-shop' ); ?></p>
				<?php if ( $just_synced ) : ?>
					<p class="ns-receipt-success"><?php esc_html_e( 'Upload successful.', 'nuvira-shop' ); ?></p>
				<?php endif; ?>
			<?php else : ?>
				<h2><?php esc_html_e( 'Confirm your bank transfer', 'nuvira-shop' ); ?></h2>
				<p><?php esc_html_e( 'Paid by bank transfer? Upload your receipt and payment reference below so we can verify it and ship your order.', 'nuvira-shop' ); ?></p>
				<form class="ns-receipt-form" method="post" enctype="multipart/form-data" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
					<input type="hidden" name="action" value="nuvira_upload_receipt">
					<input type="hidden" name="order_id" value="<?php echo esc_attr( $order->get_id() ); ?>">
					<input type="hidden" name="order_key" value="<?php echo esc_attr( $order->get_order_key() ); ?>">
					<?php wp_nonce_field( 'nuvira_upload_receipt_' . $order->get_id(), 'nuvira_receipt_nonce' ); ?>

					<label for="nuvira_reference"><?php esc_html_e( 'Payment reference / transaction ID', 'nuvira-shop' ); ?></label>
					<input type="text" id="nuvira_reference" name="nuvira_reference" required placeholder="<?php echo esc_attr( 'e.g. Order #' . $order->get_order_number() ); ?>">

					<label for="nuvira_receipt"><?php esc_html_e( 'Receipt image (JPG, PNG or PDF, max 5MB)', 'nuvira-shop' ); ?></label>
					<input type="file" id="nuvira_receipt" name="nuvira_receipt" accept="image/jpeg,image/png,application/pdf" required>

					<button type="submit" class="ns-btn ns-btn-accent"><?php esc_html_e( 'Send receipt', 'nuvira-shop' ); ?></button>
				</form>
			<?php endif; ?>
		</section>
		<?php
	}
);

/**
 * Handles the receipt upload form submission — validates the order and
 * nonce, stores the file in the media library, and saves the reference
 * number + attachment ID on the order for the shop owner to review.
 */
function nuvira_shop_handle_receipt_upload() {
	if ( empty( $_POST['order_id'] ) || empty( $_POST['order_key'] ) ) {
		wp_die( esc_html__( 'Missing order details.', 'nuvira-shop' ) );
	}

	$order_id = absint( $_POST['order_id'] );

	if ( ! isset( $_POST['nuvira_receipt_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nuvira_receipt_nonce'] ) ), 'nuvira_upload_receipt_' . $order_id ) ) {
		wp_die( esc_html__( 'Security check failed. Please go back and try again.', 'nuvira-shop' ) );
	}

	$order = wc_get_order( $order_id );
	if ( ! $order || $order->get_order_key() !== wp_unslash( $_POST['order_key'] ) ) {
		wp_die( esc_html__( 'Order not found.', 'nuvira-shop' ) );
	}

	if ( 'bacs' !== $order->get_payment_method() ) {
		wp_die( esc_html__( 'This order is not paid by bank transfer.', 'nuvira-shop' ) );
	}

	$reference = isset( $_POST['nuvira_reference'] ) ? sanitize_text_field( wp_unslash( $_POST['nuvira_reference'] ) ) : '';
	if ( '' === $reference ) {
		wp_die( esc_html__( 'Please enter a payment reference.', 'nuvira-shop' ) );
	}

	if ( empty( $_FILES['nuvira_receipt']['name'] ) ) {
		wp_die( esc_html__( 'Please choose a receipt file to upload.', 'nuvira-shop' ) );
	}

	require_once ABSPATH . 'wp-admin/includes/file.php';
	require_once ABSPATH . 'wp-admin/includes/media.php';
	require_once ABSPATH . 'wp-admin/includes/image.php';

	add_filter( 'upload_mimes', 'nuvira_shop_allowed_receipt_mimes' );
	$attachment_id = media_handle_upload( 'nuvira_receipt', 0 );
	remove_filter( 'upload_mimes', 'nuvira_shop_allowed_receipt_mimes' );

	if ( is_wp_error( $attachment_id ) ) {
		wp_die( esc_html( $attachment_id->get_error_message() ) );
	}

	$order->update_meta_data( '_nuvira_payment_reference', $reference );
	$order->update_meta_data( '_nuvira_receipt_id', $attachment_id );
	$order->add_order_note(
		sprintf(
			/* translators: %s: customer-entered payment reference. */
			esc_html__( 'Customer uploaded a payment receipt. Reference: %s', 'nuvira-shop' ),
			$reference
		)
	);
	$order->save();

	wp_safe_redirect( add_query_arg( 'nuvira_receipt', 'success', $order->get_checkout_order_received_url() ) );
	exit;
}
add_action( 'admin_post_nuvira_upload_receipt', 'nuvira_shop_handle_receipt_upload' );
add_action( 'admin_post_nopriv_nuvira_upload_receipt', 'nuvira_shop_handle_receipt_upload' );

/**
 * Restricts the receipt upload to images and PDFs only.
 *
 * @param array $mimes Allowed mime types.
 * @return array
 */
function nuvira_shop_allowed_receipt_mimes( $mimes ) {
	return array(
		'jpg|jpeg' => 'image/jpeg',
		'png'      => 'image/png',
		'pdf'      => 'application/pdf',
	);
}

/**
 * Shows the payment reference + receipt on the order edit screen so the
 * shop owner can verify payment before marking the order as shipped.
 *
 * @param WC_Order $order Order being edited.
 */
add_action(
	'woocommerce_admin_order_data_after_billing_address',
	function ( $order ) {
		if ( 'bacs' !== $order->get_payment_method() ) {
			return;
		}

		$reference  = $order->get_meta( '_nuvira_payment_reference' );
		$receipt_id = $order->get_meta( '_nuvira_receipt_id' );

		echo '<div class="nuvira-receipt-review" style="margin-top:16px;padding:12px;border:1px solid #dcd3c4;border-radius:8px;background:#fbf9f4;">';
		echo '<strong>' . esc_html__( 'Bank transfer receipt', 'nuvira-shop' ) . '</strong><br>';

		if ( ! $reference && ! $receipt_id ) {
			echo '<em>' . esc_html__( 'Customer has not uploaded a receipt yet.', 'nuvira-shop' ) . '</em>';
			echo '</div>';
			return;
		}

		if ( $reference ) {
			echo '<p style="margin:6px 0;">' . esc_html__( 'Reference:', 'nuvira-shop' ) . ' <strong>' . esc_html( $reference ) . '</strong></p>';
		}

		if ( $receipt_id ) {
			$url      = wp_get_attachment_url( $receipt_id );
			$mime     = get_post_mime_type( $receipt_id );
			if ( $url ) {
				if ( 0 === strpos( (string) $mime, 'image/' ) ) {
					echo '<a href="' . esc_url( $url ) . '" target="_blank" rel="noopener"><img src="' . esc_url( $url ) . '" style="max-width:220px;height:auto;border-radius:6px;border:1px solid #dcd3c4;" alt="' . esc_attr__( 'Payment receipt', 'nuvira-shop' ) . '"></a>';
				} else {
					echo '<a href="' . esc_url( $url ) . '" target="_blank" rel="noopener">' . esc_html__( 'View receipt file', 'nuvira-shop' ) . '</a>';
				}
			}
		}

		echo '</div>';
	}
);
