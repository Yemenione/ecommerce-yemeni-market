# Deploy Script for Hostinger
Write-Host "Starting Deployment Build..." -ForegroundColor Green

# 1. Build Assets
Write-Host "Building Frontend Assets..."
npm run build

# 2. Create Deploy Directory
$deployDir = "deploy"
if (Test-Path $deployDir) {
    Remove-Item $deployDir -Recurse -Force
}
New-Item -ItemType Directory -Force -Path $deployDir | Out-Null

# 3. Copy Files
Write-Host "Copying Files..."
$filesToCopy = @(
    "app",
    "bootstrap",
    "config",
    "database",
    "lang",
    "public",
    "resources",
    "routes",
    "storage",
    "vendor",
    ".env.example",
    "artisan",
    "composer.json",
    "composer.lock",
    "package.json",
    "vite.config.js"
)

foreach ($item in $filesToCopy) {
    if (Test-Path $item) {
        Copy-Item -Path $item -Destination $deployDir -Recurse -Force
    } else {
        Write-Host "Warning: $item not found!" -ForegroundColor Yellow
    }
}

# Copy .env.production to .env if it exists
if (Test-Path ".env.production") {
    Write-Host "Found .env.production, copying as .env..." -ForegroundColor Cyan
    Copy-Item -Path ".env.production" -Destination "$deployDir\.env" -Force
}

# Copy root_htaccess_simple to .htaccess to fix 403 error
if (Test-Path "root_htaccess_simple") {
    Write-Host "Copying root .htaccess..." -ForegroundColor Cyan
    Copy-Item -Path "root_htaccess_simple" -Destination "$deployDir\.htaccess" -Force
}


# 4. Create proper public folder structure for Hostinger (if needed)
# Hostinger public_html usually serves from public_html directly. 
# Laravel serves from public.
# We will keep standard structure and user will point domain to /public or move contents.
# Standard Laravel deployment recommendation: Keep structure, point document root to public.

# 5. Zip the directory (Skipped - User will zip manually)
# Write-Host "Zipping Files..."
# $zipFile = "project_release.zip"
# if (Test-Path $zipFile) {
#     Remove-Item $zipFile -Force
# }
# 
# Compress-Archive -Path "$deployDir\*" -DestinationPath $zipFile
# 
# Write-Host "Build Complete! The 'deploy' folder is ready. Please zip it manually and upload to Hostinger." -ForegroundColor Green
