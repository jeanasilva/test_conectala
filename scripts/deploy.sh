#!/usr/bin/env bash
set -euo pipefail


# Usage: deploy.sh [app_port] [phpmyadmin_port]
# The repository is expected to be at /root/test_conectala on the server (copied by the Action).
REMOTE_DIR=/root/test_conectala
APP_PORT=${1:-8020}
PHPMYADMIN_PORT=${2:-8021}

echo "Deploying to ${REMOTE_DIR} (APP_PORT=${APP_PORT}, PHPMYADMIN_PORT=${PHPMYADMIN_PORT})"

cd "$REMOTE_DIR"
echo "Deploy folder: ${REMOTE_DIR}"
if [ -d .git ]; then
  echo "Found .git — updating from origin/main"
  git fetch --all --prune
  git reset --hard origin/main
else
  echo "No .git directory found — using files as they are (the Action copies the repository to ${REMOTE_DIR})."
fi

if [ -f docker-compose.yml ]; then
  echo "Adjusting ports in docker-compose.yml"
  # Backup
  cp docker-compose.yml docker-compose.yml.bak || true

  # Replace common host port mappings. This is a simple textual replace:
  # - app: '8080:80' -> '${APP_PORT}:80'
  # - phpmyadmin: '8082:80' -> '${PHPMYADMIN_PORT}:80'
  sed -i "s/\b8080:80\b/${APP_PORT}:80/g" docker-compose.yml || true
  sed -i "s/\b8082:80\b/${PHPMYADMIN_PORT}:80/g" docker-compose.yml || true

  echo "Starting containers (docker compose up -d --build)"
  docker compose pull || true
  docker compose up -d --build
else
  echo "docker-compose.yml not found in ${REMOTE_DIR}. Exiting with error."
  exit 2
fi

echo "Prune unused images (optional)"
docker image prune -f || true

echo "Deploy finished."
