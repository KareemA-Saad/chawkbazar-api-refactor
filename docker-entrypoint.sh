#!/bin/sh
set -e

# =============================================================================
# Laravel Docker Entrypoint Script for Railway/Render
# =============================================================================

echo "🚀 Starting Laravel application..."
echo "   Working directory: $(pwd)"

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
# 2. Validate APP_KEY is set
# =============================================================================
if [ -z "${APP_KEY}" ]; then
    echo "❌ ERROR: APP_KEY environment variable is not set!"
    echo "   Please set APP_KEY in your deployment platform (Railway/Render)."
    echo "   Generate with: php artisan key:generate --show"
    exit 1
fi

# =============================================================================
# 3. Run migrations BEFORE caching (if enabled)
# =============================================================================
echo ""
echo "=========================================="
echo "        MIGRATION CHECK"
echo "=========================================="
echo "RUN_MIGRATIONS = '${RUN_MIGRATIONS}'"
echo ""

if [ "${RUN_MIGRATIONS}" = "true" ]; then
    echo "🔄 Running database migrations..."
    echo "   DB_HOST: ${DB_HOST}"
    echo "   DB_PORT: ${DB_PORT}"
    echo "   DB_DATABASE: ${DB_DATABASE}"
    echo ""
    
    # List available migrations
    echo "📋 Listing pending migrations..."
    php artisan migrate:status 2>&1 || echo "   (migrate:status failed, continuing anyway)"
    echo ""
    
    # Run migrations with verbose output
    echo "🚀 Executing: php artisan migrate --force"
    if php artisan migrate --force; then
        echo "✅ Migrations completed successfully!"
    else
        echo "❌ Migration failed! Error code: $?"
        echo "   Continuing anyway..."
    fi
else
    echo "⏭️  Skipping migrations (RUN_MIGRATIONS is not 'true')"
    echo "   To run migrations, set RUN_MIGRATIONS=true in Railway/Render"
fi

echo ""
echo "=========================================="

# =============================================================================
# 4. Cache configuration (production optimization)
# =============================================================================
echo "⚡ Caching configuration..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# =============================================================================
# 5. Display startup info
# =============================================================================
echo ""
echo "✅ Laravel application ready!"
echo "   - Environment: ${APP_ENV:-production}"
echo "   - Debug: ${APP_DEBUG:-false}"
echo "   - Port: ${PORT:-8080}"

# =============================================================================
# 6. Execute the main command
# =============================================================================
if [ "$1" = "php" ] && [ "$2" = "artisan" ] && [ "$3" = "serve" ]; then
    exec php artisan serve --host=0.0.0.0 --port=${PORT:-8080}
else
    exec "$@"
fi
