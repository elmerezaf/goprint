@echo off
echo ============================================
echo GoPrint - Python & OpenCV Installation
echo ============================================
echo.

echo Step 1: Checking Python installation...
python --version >nul 2>&1
if %errorlevel% equ 0 (
    echo ✅ Python is already installed
    python --version
    goto :check_opencv
)

echo ❌ Python not found. Installing Python 3.11...
echo.

echo Please wait, downloading Python installer...
powershell -Command "Invoke-WebRequest -Uri 'https://www.python.org/ftp/python/3.11.9/python-3.11.9-amd64.exe' -OutFile 'C:\temp\python_installer.exe'"

echo.
echo Running Python installer (silent mode)...
C:\temp\python_installer.exe /quiet InstallAllUsers=1 PrependPath=1 Include_test=0

echo.
echo Waiting for installation to complete...
timeout /t 30 /nobreak

echo.
echo Cleaning up installer...
del C:\temp\python_installer.exe >nul 2>&1

echo ✅ Python installation completed
python --version

:check_opencv
echo.
echo Step 2: Checking OpenCV installation...
python -c "import cv2" 2>nul
if %errorlevel% equ 0 (
    echo ✅ OpenCV is already installed
    python -c "import cv2; print('OpenCV version:', cv2.__version__)"
    goto :run_script
)

echo ❌ OpenCV not found. Installing OpenCV...
echo.
python -m pip install opencv-python --quiet
python -m pip install opencv-python-headless --quiet

echo.
echo ✅ OpenCV installation completed
python -c "import cv2; print('OpenCV version:', cv2.__version__)"

:run_script
echo.
echo ============================================
echo All dependencies installed!
echo ============================================
echo.
echo Running watermark removal script...
echo.

python remove_watermark.py

echo.
echo ============================================
echo Process completed!
echo ============================================
pause
