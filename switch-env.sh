#!/bin/bash

# Switch between local and share/online mode for Laravel Sail

if [ "$1" == "local" ]; then
    echo "🏠 Switching to LOCAL mode..."

    sed -i 's|^APP_URL=.*|APP_URL=http://localhost|' .env
    sed -i 's|^ASSET_URL=.*|ASSET_URL=http://localhost|' .env

    ./vendor/bin/sail artisan config:clear
    ./vendor/bin/sail artisan cache:clear

    echo "✅ Done! Your app is now configured for local development."
    echo "   Access at: http://localhost/admin"

elif [ "$1" == "share" ]; then
    if [ -z "$2" ]; then
        echo "❌ Please provide the share URL"
        echo "   Usage: ./switch-env.sh share <url>"
        echo "   Example: ./switch-env.sh share http://y5pmy1780s.laravel-sail.site:8080"
        exit 1
    fi

    echo "🌐 Switching to SHARE/ONLINE mode..."

    sed -i "s|^APP_URL=.*|APP_URL=$2|" .env
    sed -i "s|^ASSET_URL=.*|ASSET_URL=$2|" .env

    ./vendor/bin/sail artisan config:clear
    ./vendor/bin/sail artisan cache:clear

    echo "✅ Done! Your app is now configured for sharing."
    echo "   Access at: $2/admin"

else
    echo "🔄 Laravel Environment Switcher"
    echo ""
    echo "Usage:"
    echo "  ./switch-env.sh local                    - Switch to local development"
    echo "  ./switch-env.sh share <url>              - Switch to share/online mode"
    echo ""
    echo "Examples:"
    echo "  ./switch-env.sh local"
    echo "  ./switch-env.sh share http://y5pmy1780s.laravel-sail.site:8080"
fi
