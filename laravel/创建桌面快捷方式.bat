@echo off
chcp 65001 >nul
echo ========================================
echo   创建桌面快捷方式
echo ========================================
echo.

set "SCRIPT_DIR=%~dp0"
set "TARGET=%SCRIPT_DIR%启动水印移除工具.bat"
set "SHORTCUT=%USERPROFILE%\Desktop\GoPrint水印移除工具.lnk"
set "ICON=%SCRIPT_DIR%watermark_remover_gui.py"

REM 使用 PowerShell 创建快捷方式
powershell -Command "$WshShell = New-Object -ComObject WScript.Shell; $Shortcut = $WshShell.CreateShortcut('%SHORTCUT%'); $Shortcut.TargetPath = '%TARGET%'; $Shortcut.WorkingDirectory = '%SCRIPT_DIR%'; $Shortcut.Description = 'GoPrint 水印移除工具 - 使用 OpenCV Inpainting 技术'; $Shortcut.Save()"

if exist "%SHORTCUT%" (
    echo [成功] 快捷方式已创建到桌面！
    echo 快捷方式路径: %SHORTCUT%
) else (
    echo [失败] 无法创建快捷方式
)

echo.
pause
