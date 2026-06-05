param(
    [int]$Port = 9000,
    [switch]$ForceImport
)

$ErrorActionPreference = "Stop"

$repoRoot = (Resolve-Path (Join-Path $PSScriptRoot "..")).Path
Set-Location $repoRoot

function Get-LaragonRoot {
    $candidates = @(
        "C:\laragon",
        "D:\laragon",
        "C:\Program Files\Laragon"
    )

    foreach ($path in $candidates) {
        if (Test-Path $path) {
            return $path
        }
    }

    throw "Fant ikke Laragon. Installer Laragon eller oppdater stier i scripts/start-local.ps1."
}

function Get-PhpExe($laragonRoot) {
    $phpDirs = Get-ChildItem (Join-Path $laragonRoot "bin\php") -Directory -ErrorAction SilentlyContinue |
        Sort-Object Name -Descending

    foreach ($dir in $phpDirs) {
        $phpExe = Join-Path $dir.FullName "php.exe"
        if (Test-Path $phpExe) {
            return $phpExe
        }
    }

    throw "Fant ingen php.exe i Laragon."
}

function Get-MySqlPaths($laragonRoot) {
    $mysqlDirs = Get-ChildItem (Join-Path $laragonRoot "bin\mysql") -Directory -ErrorAction SilentlyContinue |
        Sort-Object Name

    $preferred = $mysqlDirs | Where-Object { $_.Name -like "mysql-8*" } | Select-Object -First 1
    $selected = if ($preferred) { $preferred } else { $mysqlDirs | Select-Object -First 1 }

    if (-not $selected) {
        throw "Fant ingen MySQL-installasjon i Laragon."
    }

    $base = $selected.FullName
    $mysqlExe = Join-Path $base "bin\mysql.exe"
    $mysqldExe = Join-Path $base "bin\mysqld.exe"
    $myIni = Join-Path $base "my.ini"

    if (-not (Test-Path $mysqlExe) -or -not (Test-Path $mysqldExe) -or -not (Test-Path $myIni)) {
        throw "MySQL-bin\konfig mangler i $base"
    }

    return [PSCustomObject]@{
        MySqlExe = $mysqlExe
        MySqldExe = $mysqldExe
        MyIni = $myIni
    }
}

function Wait-ForPort([int]$TargetPort, [int]$TimeoutSeconds = 20) {
    $deadline = (Get-Date).AddSeconds($TimeoutSeconds)
    while ((Get-Date) -lt $deadline) {
        $listening = Get-NetTCPConnection -LocalPort $TargetPort -State Listen -ErrorAction SilentlyContinue
        if ($listening) {
            return $true
        }
        Start-Sleep -Milliseconds 500
    }
    return $false
}

$laragonRoot = Get-LaragonRoot
$phpExe = Get-PhpExe -laragonRoot $laragonRoot
$mysql = Get-MySqlPaths -laragonRoot $laragonRoot

$mysqlListening = Get-NetTCPConnection -LocalPort 3306 -State Listen -ErrorAction SilentlyContinue
if (-not $mysqlListening) {
    Write-Host "Starter MySQL fra Laragon..."
    $mysqlProcess = Start-Process -FilePath $mysql.MySqldExe -ArgumentList "--defaults-file=$($mysql.MyIni)" -PassThru -WindowStyle Hidden
    if (-not (Wait-ForPort -TargetPort 3306 -TimeoutSeconds 20)) {
        throw "MySQL startet ikke på port 3306."
    }
    Set-Content -Path (Join-Path $repoRoot "storage\logs\local-mysql.pid") -Value $mysqlProcess.Id
} else {
    Write-Host "MySQL kjører allerede på port 3306."
}

& $mysql.MySqlExe -u root -e "CREATE DATABASE IF NOT EXISTS laravel CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

$tableExists = & $mysql.MySqlExe -N -u root -D laravel -e "SHOW TABLES LIKE 'countrycode';"
if ($ForceImport -or -not $tableExists) {
    Write-Host "Importerer database.sql..."
    & $mysql.MySqlExe -u root -D laravel -e "source database.sql"
} else {
    Write-Host "Databasen er allerede importert (countrycode finnes)."
}

$portInUse = Get-NetTCPConnection -LocalPort $Port -State Listen -ErrorAction SilentlyContinue
if ($portInUse) {
    throw "Port $Port er i bruk. Velg en annen port, for eksempel: .\start-local.bat -Port 9010"
}

$phpArgs = "artisan serve --host=127.0.0.1 --port=$Port"
$phpProcess = Start-Process -FilePath $phpExe -ArgumentList $phpArgs -WorkingDirectory $repoRoot -PassThru
Set-Content -Path (Join-Path $repoRoot "storage\logs\local-server.pid") -Value $phpProcess.Id

Write-Host ""
Write-Host "Samling er startet lokalt."
Write-Host "URL: http://127.0.0.1:$Port"
Write-Host "Stopp med: powershell -ExecutionPolicy Bypass -File scripts/stop-local.ps1"
