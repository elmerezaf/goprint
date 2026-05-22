@echo off
echo ========================================
echo       GoPrint Yi Jian Huan Yuan Cheng Xu
echo ========================================
echo.

setlocal enabledelayedexpansion

set BACKUP_ROOT=D:\backups\goprint
set TARGET_DIR=C:\xampp\htdocs\goprint
set MYSQL_BIN=C:\xampp\mysql\bin

if not exist "%BACKUP_ROOT%" (
    echo ERROR: Backup directory not found!
    echo %BACKUP_ROOT%
    pause
    exit /b 1
)

echo.
echo [1/4] Finding available backups...
echo.
echo Available backups:
echo ========================================
set count=0
for /f "tokens=*" %%D in ('dir /B /AD "%BACKUP_ROOT%" 2^>nul') do (
    set /a count+=1
    echo   [!count!] %%D
)
echo ========================================
echo.

if !count! EQU 0 (
    echo No backups found!
    pause
    exit /b 1
)

set /p choice=Enter backup number to restore (1-!count!):

if "!choice!"=="" (
    echo ERROR: No selection!
    pause
    exit /b 1
)

set selected_folder=
set /a index=0
for /f "tokens=*" %%D in ('dir /B /AD "%BACKUP_ROOT%" 2^>nul') do (
    set /a index+=1
    if !index! EQU !choice! set "selected_folder=%%D"
)

if "!selected_folder!"=="" (
    echo ERROR: Invalid selection!
    pause
    exit /b 1
)

set SELECTED_BACKUP=%BACKUP_ROOT%\!selected_folder!

echo.
echo [2/4] Confirm restore...
echo.
echo This will:
echo   - Drop and recreate database 'goprint_db'
echo   - Restore all files to: %TARGET_DIR%
echo.
set /p confirm=Continue? (Y/N):
if /i not "!confirm!"=="Y" (
    echo Cancelled.
    pause
    exit /b 0
)

echo.
echo [3/4] Restoring database...
echo   - Creating database...
"%MYSQL_BIN%\mysql.exe" -u root --password= -e "DROP DATABASE IF EXISTS goprint_db; CREATE DATABASE goprint_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;" >nul 2>&1

if not exist "%SELECTED_BACKUP%\database.sql" (
    echo ERROR: Database backup file not found!
    pause
    exit /b 1
)

echo   - Importing database...
"%MYSQL_BIN%\mysql.exe" -u root --password= --default-character-set=utf8mb4 goprint_db < "%SELECTED_BACKUP%\database.sql"
if errorlevel 1 (
    echo ERROR: Database restore failed!
    pause
    exit /b 1
)
echo Database restore: OK

echo.
echo [4/4] Restoring website files...
if not exist "%SELECTED_BACKUP%\website" (
    echo ERROR: Website backup not found!
    pause
    exit /b 1
)

echo   - Removing existing files...
if exist "%TARGET_DIR%" (
    rd /S /Q "%TARGET_DIR%" >nul 2>&1
)

echo   - Copying backup files...
xcopy "%SELECTED_BACKUP%\website\*" "%TARGET_DIR%\" /E /I /Y /Q
if errorlevel 1 (
    echo ERROR: File restore failed!
    pause
    exit /b 1
)
echo File restore: OK

echo.
echo ========================================
echo    Restore Complete!
echo ========================================
echo.
echo Restored from: !selected_folder!
echo.

if exist "%TARGET_DIR%" (
    explorer "%TARGET_DIR%"
)

pause
