# Build Release Package Script
# Usage: .\scripts\build_release.ps1

$ErrorActionPreference = "Stop"
$releaseFile = "release.tar.gz"

Write-Host "1. Compiling Assets (npm run build)..." -ForegroundColor Cyan
cmd /c "npm run build"

Write-Host "2. Creating Archive ($releaseFile)..." -ForegroundColor Cyan
if (Test-Path $releaseFile) { Remove-Item $releaseFile }

# Exclusions
$excludes = @(
    "node_modules",
    "vendor",
    ".git",
    ".github",
    ".idea",
    ".vscode",
    "tests",
    "storage/framework/cache/data/*",
    "storage/framework/sessions/*",
    "storage/framework/views/*",
    "storage/logs/*",
    "*.log",
    ".env",
    "deploy.ps1",
    $releaseFile
)

# Build tar command
# Note: Requires tar.exe (available in Win10+)
$excludeArgs = $excludes | ForEach-Object { "--exclude $_" }
$tarArgs = @("-czvf", $releaseFile) + $excludeArgs + @(".")

Write-Host "Running tar..."
try {
    Start-Process -FilePath "tar.exe" -ArgumentList $tarArgs -Wait -NoNewWindow
    Write-Host "Success! Package created: $releaseFile" -ForegroundColor Green
    Write-Host "Size: $( (Get-Item $releaseFile).Length / 1MB ) MB" -ForegroundColor Gray
} catch {
    Write-Error "Failed to create archive. Ensure tar.exe is installed."
}
