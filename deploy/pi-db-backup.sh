#!/bin/bash
# Pi Dentist — Database Backup Script
# Run via cron: 0 4 * * * /usr/local/bin/pi-db-backup.sh >> /var/log/pi-backup.log 2>&1
#
# Ref: PROJECT_SPEC_WP.md section 16.7.2
#
# Features:
#   - mysqldump with --single-transaction (no lock for InnoDB)
#   - gzip compression
#   - Retention: 14 days
#   - rsync to backup VPS (optional, comment out if not needed)
#
# Setup:
#   chmod 700 /usr/local/bin/pi-db-backup.sh
#   chown root:root /usr/local/bin/pi-db-backup.sh
#   echo "YOUR_DB_PASS" > /root/.db-backup-pass
#   chmod 0400 /root/.db-backup-pass

set -euo pipefail

# ─────────────────────────────────────────────
# Configuration
# ─────────────────────────────────────────────
DATE=$(date +%Y%m%d-%H%M%S)
BACKUP_DIR="/var/backups/pidentist/db"
DB_NAME="pidentist_db"
DB_USER="pidentist_backup"
DB_PASS="$(cat /root/.db-backup-pass)"   # file 0400 owned by root
RETENTION_DAYS=14

# Backup VPS (optional — comment out BACKUP_VPS if not using)
# BACKUP_VPS="backup@<BACKUP_VPS_IP>"
# BACKUP_KEY="/root/.ssh/backup_key"

# ─────────────────────────────────────────────
# Create backup directory
# ─────────────────────────────────────────────
mkdir -p "$BACKUP_DIR"

# ─────────────────────────────────────────────
# Dump database
# --single-transaction: consistent snapshot for InnoDB (no table lock)
# --quick: row-by-row retrieval (low memory usage)
# --routines --triggers: include stored procedures & triggers
# ─────────────────────────────────────────────
echo "[$(date)] Starting backup: db-$DATE.sql.gz"

mysqldump \
  --user="$DB_USER" \
  --password="$DB_PASS" \
  --single-transaction \
  --quick \
  --lock-tables=false \
  --add-drop-table \
  --routines \
  --triggers \
  "$DB_NAME" | gzip > "$BACKUP_DIR/db-$DATE.sql.gz"

FILESIZE=$(du -h "$BACKUP_DIR/db-$DATE.sql.gz" | cut -f1)
echo "[$(date)] Backup created: db-$DATE.sql.gz ($FILESIZE)"

# ─────────────────────────────────────────────
# Clean up old backups (> RETENTION_DAYS)
# ─────────────────────────────────────────────
DELETED=$(find "$BACKUP_DIR" -name "db-*.sql.gz" -mtime +$RETENTION_DAYS -delete -print | wc -l)
echo "[$(date)] Cleaned up $DELETED old backup(s)"

# ─────────────────────────────────────────────
# Sync to backup VPS (optional)
# Uncomment below if you have a secondary backup server
# ─────────────────────────────────────────────
# if [ -n "${BACKUP_VPS:-}" ] && [ -n "${BACKUP_KEY:-}" ]; then
#     rsync -avz --delete \
#       -e "ssh -i $BACKUP_KEY -o StrictHostKeyChecking=no" \
#       "$BACKUP_DIR/" \
#       "$BACKUP_VPS:/var/backups/pidentist/db/"
#     echo "[$(date)] Synced to backup VPS: $BACKUP_VPS"
# fi

echo "[$(date)] Backup completed successfully"
