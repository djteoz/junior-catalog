#!/usr/bin/env bash
set -euo pipefail

missing=0
vars=(DOCKERHUB_USERNAME DOCKERHUB_TOKEN)
for v in "${vars[@]}"; do
  if [ -z "${!v:-}" ]; then
    echo "ERROR: Required env var $v is not set. Set it as repository secret for CD workflow." >&2
    missing=1
  fi
done

if [ "$missing" -ne 0 ]; then
  echo "CD secrets preflight failed" >&2
  exit 1
fi

echo "CD secrets present"
