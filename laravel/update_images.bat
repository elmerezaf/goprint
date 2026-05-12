@echo off
echo ============================================
echo GoPrint - MySQL & Image Update Script
echo ============================================
echo.

echo Step 1: Starting MySQL service...
net start MySQL
if %errorlevel% neq 0 (
    echo MySQL service may already be running or requires admin rights
    echo Trying alternative method...
)

echo.
echo Step 2: Waiting for MySQL to be ready...
timeout /t 3 /nobreak > nul

echo.
echo Step 3: Running product image update script...
php update_product_images.php

echo.
echo Step 4: Verifying images...
dir storage\app\public\products\*.jpg

echo.
echo ============================================
echo Process completed!
echo ============================================
pause
