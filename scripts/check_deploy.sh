#!/usr/bin/env bash
set -euo pipefail

# Simple pre-deploy checks
errors=0

if grep -E "^APP_DEBUG=true" .env.example >/dev/null; then
  echo "ERROR: APP_DEBUG is true in .env.example — set APP_DEBUG=false for production."
  errors=1
fi

if [ "$errors" -ne 0 ]; then
  echo "Pre-deploy checks failed. Aborting."
  exit 1
fi

echo "Pre-deploy checks passed."
