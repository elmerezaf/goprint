@echo off
chcp 65001 >nul
echo ========================================
echo   GoPrint 水印移除工具 - 启动中...
echo ========================================
echo.

cd /d "%~dp0"

REM 检查 Python 是否安装
python --version >nul 2>&1
if errorlevel 1 (
    echo [错误] 未找到 Python，请先安装 Python
    echo 下载地址: https://www.python.org/downloads/
    echo.
    pause
    exit /b 1
)

REM 检查并安装依赖
echo [信息] 检查依赖...
python -c "import cv2" >nul 2>&1
if errorlevel 1 (
    echo [信息] 正在安装 OpenCV...
    pip install opencv-python numpy
)

REM 尝试安装拖放支持（可选）
python -c "import tkinterdnd2" >nul 2>&1
if errorlevel 1 (
    echo [信息] 正在安装拖放支持...
    pip install tkinterdnd2
)

echo.
echo [信息] 启动 GUI 工具...
echo.
python watermark_remover_gui.py

if errorlevel 1 (
    echo.
    echo [错误] 程序异常退出
    pause
)
