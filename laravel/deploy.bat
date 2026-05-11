@echo off
chcp 65001 >nul

echo === GoPrint 一键部署脚本 ===
echo.

docker --version >nul 2>&1
if %errorlevel% neq 0 (
    echo ❌ Docker 未安装，请先安装 Docker
    pause
    exit /b 1
)

docker-compose --version >nul 2>&1
if %errorlevel% neq 0 (
    echo ❌ Docker Compose 未安装，请先安装 Docker Compose
    pause
    exit /b 1
)

echo 📦 正在构建 Docker 镜像...
docker-compose build

echo.
echo 🚀 正在启动容器...
docker-compose up -d

echo.
echo ⏳ 等待数据库初始化...
timeout /t 10 /nobreak >nul

echo.
echo 🔧 正在执行数据库迁移...
docker-compose exec web php artisan migrate --force

echo.
echo 🔗 正在创建存储链接...
docker-compose exec web php artisan storage:link

echo.
echo 🔑 正在生成应用密钥...
docker-compose exec web php artisan key:generate

echo.
echo ✅ 部署完成！
echo.
echo 🌐 访问地址：
echo   - 主网站: http://localhost:8000
echo   - phpMyAdmin: http://localhost:8080
echo.
echo 📝 默认数据库信息：
echo   - 数据库名: goprint
echo   - 用户名: admin
echo   - 密码: secret
echo.
pause
