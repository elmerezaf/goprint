GoPrint WordPress Website
Gift and Premium Enterprise Limited - 印刷服务网站

## 项目简介

本项目是我为Gift and Premium Enterprise Limited开发的官方网站，基于WordPress CMS构建，主要提供印刷服务产品展示和客户联系功能。

## 核心功能

- 产品目录管理 - 展示各种印刷产品，支持分类浏览
- 联系我们表单 - 接收客户的印刷服务询价
- 自定义主题开发 - 使用goprint-child子主题，在不修改WordPress核心文件的前提下进行定制
- 安全表单处理 - 添加了nonce验证和输入过滤，防止XSS和SQL注入
- 响应式设计 - 适配手机、平板和桌面设备

## 技术栈

- CMS: WordPress 6.x
- 主题: 自定义子主题 (goprint-child)
- 数据库: MySQL 8.x
- 服务器: Apache 2.4 + HTTPS配置
- PHP: 8.1+

## 文件结构

wordpress/
├── wp-admin/          # WordPress管理后台
├── wp-content/        # 用户内容（主题、插件）
│   └── themes/
│       └── goprint-child/  # 自定义子主题
├── wp-includes/       # WordPress核心库
├── wp-config.php      # 数据库配置文件
└── index.php          # 入口文件

goprint-child/         # 子主题文件
├── front-page.php     # 首页模板
├── page-services.php  # 服务页面模板
├── page-contact.php   # 联系页面模板
├── functions.php      # 主题功能文件
└── style.css          # 样式文件

## 安全特性

- HTTPS全站加密（使用OpenSSL生成自签名证书）
- WordPress安全头部配置（X-Frame-Options等）
- 表单输入过滤与验证（sanitize_text_field等函数）
- 防止SQL注入措施（使用WordPress内置API）

## 开发记录

2026-04-28: WordPress安装与配置完成
2026-04-28: 子主题创建与激活
2026-04-29: SSL/HTTPS配置完成
2026-04-29: 联系表单安全优化

## 关联项目

本网站与以下系统一起开发和使用：

- 产品管理系统: ../laravel/
- MVC原型: ../02_MVC/

## 部署信息

- 开发环境: http://localhost:8888
- 生产环境: goprint.com.hk