# Simple Script to generate MySQL dump
# Usage: powershell -File scripts\generate_dump.ps1

Write-Host "Reading .env..."
$envContent = Get-Content ".env"
$dbUser = "root"
$dbPass = ""
$dbName = "ecommerce_hp"

# Simple parsing
foreach ($line in $envContent) {
    if ($line.StartsWith("DB_DATABASE=")) { $dbName = $line.Substring(12).Trim() }
    if ($line.StartsWith("DB_USERNAME=")) { $dbUser = $line.Substring(12).Trim() }
    if ($line.StartsWith("DB_PASSWORD=")) { $dbPass = $line.Substring(12).Trim() }
}

$outputFile = "ecommerce_hp_latest.sql"
$mysqldump = "C:\xampp\mysql\bin\mysqldump.exe"

if (-not (Test-Path $mysqldump)) {
    Write-Warning "mysqldump not found at $mysqldump. Assuming it is in PATH."
    $mysqldump = "mysqldump"
}

Write-Host "Dumping database '$dbName' to '$outputFile'..."

# Execute
# Note: Empty password might cause issues with -p argument if not handled carefully
$args = @("-u", $dbUser)
if ($dbPass -ne "") {
    $args += "-p$dbPass"
}
$args += $dbName
$args += "--result-file=$outputFile"

# Use & operator for command checks
try {
    & $mysqldump $args
    if ($LASTEXITCODE -eq 0) {
        Write-Host "Success!" -ForegroundColor Green
    }
    else {
        Write-Error "Dump failed with exit code $LASTEXITCODE"
    }
}
catch {
    Write-Error "Error executing mysqldump: $_"
}
