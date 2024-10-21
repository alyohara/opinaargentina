#!/bin/bash

# Check if the user has root privileges
if [[ ! $(id -u) -eq 0 ]]; then
    echo "This script requires root privileges. Please run it with sudo."
    exit 1
fi

# Execute the commands
sudo git pull
sudo php artisan route:cache
sudo php artisan config:cache
sudo php artisan view:cache
sudo php artisan optimize:clear
