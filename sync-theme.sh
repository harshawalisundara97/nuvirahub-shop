#!/bin/bash
# sync-theme.sh — push theme-src/ changes into the local XAMPP WordPress
# Usage:  ./sync-theme.sh          (one-shot sync)
#         ./sync-theme.sh --watch  (auto-sync on every save; needs fswatch)

set -e
SRC="/Users/ranjana/Harsha/Projects/nuvira-shop/theme-src/nuvira-shop/"
DEST="/Applications/XAMPP/xamppfiles/htdocs/nuvira-shop/wp-content/themes/nuvira-shop/"

sync_once() {
  rsync -a --delete --exclude '.DS_Store' "$SRC" "$DEST"
  echo "✓ synced $(date +%H:%M:%S) → http://localhost/nuvira-shop/"
}

if [ "$1" = "--watch" ]; then
  if ! command -v fswatch >/dev/null; then
    echo "⚠ fswatch not installed. Install with:  brew install fswatch"
    exit 1
  fi
  sync_once
  echo "👀 Watching $SRC for changes (Ctrl-C to stop)…"
  fswatch -o "$SRC" | while read; do sync_once; done
else
  sync_once
fi
