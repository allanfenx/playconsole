#!/usr/bin/env bash
set -euo pipefail

ROOT="$(cd "$(dirname "$0")/.." && pwd)"
ENV_FILE="$ROOT/.env.deploy"

if [[ ! -f "$ENV_FILE" ]]; then
  echo "Crie $ENV_FILE a partir de .env.deploy.example (HOST, USER e senha do FTP)." >&2
  exit 1
fi

if ! command -v lftp >/dev/null 2>&1; then
  echo "Instale o lftp: brew install lftp" >&2
  exit 1
fi

set -a
# shellcheck disable=SC1090
source "$ENV_FILE"
set +a

: "${FTP_HOST:?FTP_HOST vazio}"
: "${FTP_USER:?FTP_USER vazio}"
: "${FTP_PASS:?FTP_PASS vazio}"

FTP_SSL="${FTP_SSL:-false}"
DEPLOY_HTACCESS="${DEPLOY_HTACCESS:-0}"

PUBLIC_EXCLUDE='-x ^router\.php$ -X .DS_Store'
if [[ "$DEPLOY_HTACCESS" != "1" ]]; then
  PUBLIC_EXCLUDE="$PUBLIC_EXCLUDE -x ^\.htaccess$"
fi

lftp "$FTP_HOST" -u "$FTP_USER,$FTP_PASS" -e "
set ftp:ssl-force $FTP_SSL;
set ssl:verify-certificate false;
mirror $PUBLIC_EXCLUDE --reverse --continue --dereference -x ^\.git/\$ $ROOT/public public_html;
mirror -X .DS_Store --reverse --continue --dereference $ROOT/includes includes;
quit
"

echo "Deploy concluído: public/ → public_html/ e includes/ → includes/"
echo ".env e credentials/ não foram enviados."
