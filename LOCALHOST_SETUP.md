Lokal oppstart for Samling med Laragon

Krav
- Laragon installert i C:\laragon (eller D:\laragon)
- MySQL root uten passord lokalt
- Prosjektets .env peker til:
  - DB_CONNECTION=mysql
  - DB_HOST=127.0.0.1
  - DB_PORT=3306
  - DB_DATABASE=laravel
  - DB_USERNAME=root
  - DB_PASSWORD=

Start med ett klikk
- Dobbeltklikk start-local.bat

Start fra terminal
- powershell -NoProfile -ExecutionPolicy Bypass -File scripts/start-local.ps1
- Egen port: powershell -NoProfile -ExecutionPolicy Bypass -File scripts/start-local.ps1 -Port 9010
- Tving reimport av database.sql:
  powershell -NoProfile -ExecutionPolicy Bypass -File scripts/start-local.ps1 -ForceImport

Stopp
- powershell -NoProfile -ExecutionPolicy Bypass -File scripts/stop-local.ps1

Hva scriptet gjør
- Finner Laragon automatisk
- Starter MySQL hvis den ikke allerede kjører på port 3306
- Oppretter databasen laravel hvis den mangler
- Importerer database.sql hvis tabellen countrycode mangler (eller ved -ForceImport)
- Starter PHP innebygd server på valgt port

Tips
- Hvis porten er i bruk, start med annen port (for eksempel -Port 9010)
- Hvis du bytter DB-passord i Laragon, oppdater .env tilsvarende
