$ErrorActionPreference = "Continue"

$repoRoot = (Resolve-Path (Join-Path $PSScriptRoot "..")).Path
Set-Location $repoRoot

$serverPidFile = Join-Path $repoRoot "storage\logs\local-server.pid"
$mysqlPidFile = Join-Path $repoRoot "storage\logs\local-mysql.pid"

function Stop-FromPidFile($pidFile, $label) {
    if (-not (Test-Path $pidFile)) {
        Write-Host "${label}: ingen pid-fil funnet."
        return
    }

    $procId = Get-Content $pidFile -ErrorAction SilentlyContinue
    if ($procId) {
        $proc = Get-Process -Id $procId -ErrorAction SilentlyContinue
        if ($proc) {
            Stop-Process -Id $procId -Force -ErrorAction SilentlyContinue
            Write-Host "${label}: stoppet prosess $procId"
        } else {
            Write-Host "${label}: prosess $procId finnes ikke lenger."
        }
    }

    Remove-Item $pidFile -Force -ErrorAction SilentlyContinue
}

Stop-FromPidFile -pidFile $serverPidFile -label "Webserver"
Stop-FromPidFile -pidFile $mysqlPidFile -label "MySQL"
