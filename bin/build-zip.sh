#!/usr/bin/env bash
# Build an installable theme zip from committed files.
#
# Usage: bin/build-zip.sh [git-ref]   (default: HEAD)
# Output: dist/n0kmo-lcars-<version>.zip, containing an n0kmo-lcars/ folder.
set -euo pipefail

cd "$(dirname "$0")/.."

ref="${1:-HEAD}"
slug="n0kmo-lcars"
version="$(git show "${ref}:style.css" | sed -n 's/^Version: *//p' | head -n 1)"
out="dist/${slug}-${version}.zip"

mkdir -p dist
git archive --format=zip --prefix="${slug}/" --output="${out}" "${ref}"
echo "${out}"
