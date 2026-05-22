@echo off
echo ========================================
echo       GoPrint Yi Jian Bei Fen Cheng Xu
echo ========================================
echo.

setlocal enabledelayedexpansion

set BACKUP_ROOT=D:\backups\goprint
set SOURCE_DIR=C:\xampp\htdocs\goprint
set MYSQL_BIN=C:\xampp\mysql\bin

echo Step 1 - Create backup directory...
if not exist "%BACKUP_ROOT%" mkdir "%BACKUP_ROOT%"

for /f "tokens=1-3 delims=/-. " %%a in ("%DATE%") do set Y=%%a& set M=%%b& set D=%%c
set T=%TIME: =0%
set HH=%T:~0,2%
set MM=%T:~3,2%
set SS=%T:~6,2%
set DATETIME=%Y%-%M%-%D%_%HH%-%MM%-%SS%

set BACKUP_PATH=%BACKUP_ROOT%\%DATETIME%

echo Step 2 - Cleanup old backups (keep last 2 + new one = 3)...
set count=0
for /f "tokens=*" %%D in ('dir /B /AD "%BACKUP_ROOT%"') do set /a count+=1
set /a skip=count-2
if !skip! gtr 0 (
    set idx=0
    for /f "tokens=*" %%D in ('dir /B /AD "%BACKUP_ROOT%"') do (
        set /a idx+=1
        if !idx! leq !skip! (
            rd /S /Q "%BACKUP_ROOT%\%%D" >nul 2>&1
        )
    )
)
echo Done.

echo Step 3 - Create backup folder...
mkdir "%BACKUP_PATH%" 2>nul
if not exist "%BACKUP_PATH%" (
    echo ERROR: Cannot create backup folder!
    pause
    exit /b 1
)
echo Backup location: %BACKUP_PATH%

echo.
echo Step 4 - Check MySQL tools...
if not exist "%MYSQL_BIN%\mysqldump.exe" (
    echo ERROR: Cannot find mysqldump.exe
    pause
    exit /b 1
)
echo MySQL tools: OK

echo.
echo Step 5 - Backup database (goprint_db)...
"%MYSQL_BIN%\mysqldump.exe" -u root --password= --no-tablespaces goprint_db > "%BACKUP_PATH%\database.sql"
if errorlevel 1 (
    echo ERROR: Database backup failed!
    pause
    exit /b 1
)
echo Database backup: OK

echo.
echo Step 6 - Backup website files...
xcopy "%SOURCE_DIR%" "%BACKUP_PATH%\website\" /E /I /Y /Q
if errorlevel 1 (
    echo ERROR: File backup failed!
    pause
    exit /b 1
)
echo File backup: OK

echo ========================================
echo    Backup Complete!
echo ========================================
echo.
echo Location: %BACKUP_PATH%
echo.
if exist "%BACKUP_PATH%" (
    explorer "%BACKUP_PATH%"
)
echo.
pause
