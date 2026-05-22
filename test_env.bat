@echo off
chcp 65001 >nul
echo ========================================
echo       GoPrint 环境测试工具
echo ========================================
echo.

set MYSQL_BIN=C:\xampp\mysql\bin
set SOURCE_DIR=C:\xampp\htdocs\goprint
set BACKUP_DIR=C:\xampp\backups\goprint

echo 正在检查环境...
echo.

echo [1] 检查 XAMPP MySQL 路径...
if exist "%MYSQL_BIN%\mysqldump.exe" (
    echo     ✓ mysqldump.exe 存在
) else (
    echo     ✗ mysqldump.exe 不存在
    echo     路径: %MYSQL_BIN%\mysqldump.exe
    goto :error
)

if exist "%MYSQL_BIN%\mysql.exe" (
    echo     ✓ mysql.exe 存在
) else (
    echo     ✗ mysql.exe 不存在
    goto :error
)

echo.
echo [2] 检查网站目录...
if exist "%SOURCE_DIR%" (
    echo     ✓ 网站目录存在: %SOURCE_DIR%
) else (
    echo     ✗ 网站目录不存在
    goto :error
)

echo.
echo [3] 检查 WordPress 配置...
if exist "%SOURCE_DIR%\wordpress\wp-config.php" (
    echo     ✓ wp-config.php 存在
) else (
    echo     ✗ wp-config.php 不存在
    goto :error
)

echo.
echo [4] 测试 MySQL 连接...
echo     正在连接数据库...
"%MYSQL_BIN%\mysql.exe" -u root --password= -e "SELECT 1" >nul 2>&1
if errorlevel 1 (
    echo     ✗ MySQL 连接失败
    echo     请确保 XAMPP MySQL 服务已启动
    goto :error
) else (
    echo     ✓ MySQL 连接成功
)

echo.
echo [5] 检查数据库是否存在...
"%MYSQL_BIN%\mysql.exe" -u root --password= -e "USE goprint_db" >nul 2>&1
if errorlevel 1 (
    echo     ✗ 数据库 goprint_db 不存在
    echo     请先创建数据库或导入 SQL 文件
    goto :error
) else (
    echo     ✓ 数据库 goprint_db 存在
)

echo.
echo ========================================
echo   测试完成！所有环境正常 ✅
echo ========================================
echo.
echo 你现在可以运行 backup.bat 进行备份了
echo.
pause
goto :eof

:error
echo.
echo ========================================
echo   测试失败 ❌
echo ========================================
echo.
echo 请根据以上错误信息修复问题后再重试
echo.
pause
