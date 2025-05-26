#!/bin/bash

MIGRATIONS_DIR="source/Migrations"

if [ $# -eq 1 ]; then
    TARGET_FILE="$MIGRATIONS_DIR/$1.php"
    if [ -f "$TARGET_FILE" ]; then
        php "$TARGET_FILE"
    else
        echo "Arquivo '$TARGET_FILE' não encontrado."
        exit 1
    fi
else
    PHP_FILES=($(ls -r "$MIGRATIONS_DIR"/*.php))
    for FILE in "${PHP_FILES[@]}"; do
        php "$FILE"
    done
fi
