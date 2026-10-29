#!/usr/bin/env bash
set -e

cd "$(dirname "$0")"

pgrep mariadbd > /dev/null || (mariadbd-safe --user=mysql > /dev/null 2>&1 &)
sleep 2

php -S 0.0.0.0:8000 -t public public/index.php
