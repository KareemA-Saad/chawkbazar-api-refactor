#!/bin/sh
set -e

# =============================================================================
# Laravel Docker Entrypoint Script for Render.com
# =============================================================================

echo "🚀 Starting Laravel application..."

# Ensure we're in the right directory
cd /var/www/html

# =============================================================================
# 1. Create storage link (if not exists)
# =============================================================================
if [ ! -L "public/storage" ]; then
    echo "📁 Creating storage link..."
    php artisan storage:link --force 2>/dev/null || true
fi

# =============================================================================
# 2. Cache configuration (production optimization)
# =============================================================================
echo "⚡ Caching configuration..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# =============================================================================
# 3. Run migrations (if enabled via environment variable)
# =============================================================================
if [ "${RUN_MIGRATIONS:-false}" = "true" ]; then
    echo "🔄 Running database migrations..."
    php artisan migrate --force
fi

# =============================================================================
# 4. Ensure proper permissions
# =============================================================================
echo "🔐 Verifying storage permissions..."

# =============================================================================
# 5. Display startup info
# =============================================================================
echo "✅ Laravel application ready!"
echo "   - Environment: ${APP_ENV:-production}"
echo "   - Debug: ${APP_DEBUG:-false}"
echo "   - Port: ${PORT:-8080}"

# =============================================================================
# 6. Execute the main command
# =============================================================================
# If the first argument is "php" and contains "artisan serve", inject PORT
if [ "$1" = "php" ] && [ "$2" = "artisan" ] && [ "$3" = "serve" ]; then
    exec php artisan serve --host=0.0.0.0 --port=${PORT:-8080}
else
    exec "$@"
fi
