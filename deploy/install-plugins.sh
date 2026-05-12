#!/bin/bash
# Pi Dentist — Plugin Install Script (WP-CLI)
# Run this from LocalWP "Open Site Shell" terminal.
# Or from any environment where `wp` cli is available and points to pidentist.vn
#
# Usage:
#   bash deploy/install-plugins.sh
#
# NOTE: Requires WP-CLI and WordPress root in current context.

set -e

echo "══════════════════════════════════════════"
echo " Pi Dentist — Plugin Stack Install"
echo "══════════════════════════════════════════"
echo ""

# ── 1. Main Plugins (5) ──────────────────────
echo "▸ Installing 5 main plugins..."

wp plugin install custom-post-type-ui --activate
echo "  ✓ Custom Post Type UI"

wp plugin install seo-by-rank-math --activate
echo "  ✓ Rank Math SEO"



wp plugin install litespeed-cache --activate
echo "  ✓ LiteSpeed Cache"

wp plugin install wordfence --activate
echo "  ✓ Wordfence Security"

wp plugin install updraftplus --activate
echo "  ✓ UpdraftPlus Backup"

echo ""

# ── 2. Supplementary Plugins (2) ─────────────
echo "▸ Installing 2 supplementary plugins..."

wp plugin install redis-cache --activate
echo "  ✓ Redis Object Cache"

wp plugin install nginx-helper --activate
echo "  ✓ Nginx Helper"


echo ""

# ── 3. Verify ────────────────────────────────
echo "▸ Verifying plugin status..."
echo ""
wp plugin list --status=active --format=table
echo ""

# ── 4. Flush rewrite rules (after CPT UI) ────
echo "▸ Flushing rewrite rules..."
wp rewrite flush
echo "  ✓ Rewrite rules flushed"

echo ""
echo "══════════════════════════════════════════"
echo " ✅ All 7 plugins installed and active!"
echo "══════════════════════════════════════════"
echo ""
echo "Next steps:"
echo "  1. Check WP Admin → No PHP errors"
echo "  2. Verify sidebar menus: Rank Math, etc."
echo ""
