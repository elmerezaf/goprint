<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') | GoPrint</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #0066cc;
            --primary-dark: #004499;
            --primary-light: #e6f7ff;
            --accent: #ff6600;
            --dark: #1a1a2e;
            --gray-900: #212529;
            --gray-700: #495057;
            --gray-500: #6c757d;
            --gray-300: #dee2e6;
            --gray-100: #f8f9fa;
            --white: #ffffff;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'PingFang SC', 'Hiragino Sans GB', 'Microsoft YaHei', sans-serif;
            line-height: 1.7;
            color: var(--gray-700);
        }

        /* Navigation - Keeping Original Style */
        .navbar-brand {
            font-weight: 800;
            font-size: 1.5rem;
        }

        .navbar {
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        /* Hero Banner */
        .hero-section {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            padding: 80px 0;
            position: relative;
            overflow: hidden;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: -50%;
            width: 200%;
            height: 100%;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }

        .hero-title {
            font-size: 2.8rem;
            font-weight: 800;
            margin-bottom: 20px;
        }

        .hero-subtitle {
            font-size: 1.2rem;
            opacity: 0.9;
            margin-bottom: 30px;
        }

        .hero-features {
            display: flex;
            gap: 30px;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }

        .hero-feature {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 1rem;
        }

        .hero-feature i {
            color: #28a745;
        }

        /* Quick Links */
        .quick-links {
            background: var(--white);
            padding: 25px 0;
            border-bottom: 1px solid var(--gray-300);
        }

        .quick-link {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 15px;
            color: var(--gray-700);
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .quick-link:hover {
            background: var(--primary-light);
            color: var(--primary);
            transform: translateY(-3px);
        }

        .quick-link i {
            font-size: 32px;
            margin-bottom: 8px;
            color: var(--primary);
        }

        .quick-link span {
            font-size: 14px;
            font-weight: 500;
        }

        /* Section Headers */
        .section-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .section-title {
            font-size: 2rem;
            font-weight: 800;
            color: var(--dark);
            margin-bottom: 10px;
            position: relative;
            display: inline-block;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 4px;
            background: var(--primary);
            border-radius: 2px;
        }

        /* Product Cards - Following e-print style */
        .products-section {
            padding: 60px 0;
            background: var(--white);
        }

        .product-card {
            border: 1px solid var(--gray-300);
            border-radius: 8px;
            overflow: hidden;
            transition: all 0.3s ease;
            height: 100%;
        }

        .product-card:hover {
            box-shadow: 0 8px 24px rgba(0,0,0,0.12);
            transform: translateY(-5px);
        }

        .product-image {
            height: 180px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .product-image i {
            font-size: 48px;
            color: white;
            opacity: 0.9;
        }

        .product-content {
            padding: 20px;
        }

        .product-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 8px;
        }

        .product-spec {
            font-size: 0.85rem;
            color: var(--gray-500);
            margin-bottom: 10px;
        }

        .product-meta {
            display: flex;
            flex-direction: column;
            gap: 5px;
            margin-bottom: 15px;
        }

        .product-delivery {
            font-size: 0.9rem;
            color: #28a745;
            font-weight: 600;
        }

        .product-price {
            font-size: 1.1rem;
            color: var(--accent);
            font-weight: 700;
        }

        .product-desc {
            font-size: 0.85rem;
            color: var(--gray-500);
            margin-bottom: 15px;
            line-height: 1.5;
        }

        .product-link {
            display: inline-block;
            color: var(--primary);
            font-weight: 600;
            font-size: 0.9rem;
            text-decoration: none;
        }

        .product-link:hover {
            color: var(--accent);
        }

        /* Categories Section */
        .categories-section {
            padding: 60px 0;
            background: var(--gray-100);
        }

        .category-list {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            justify-content: center;
        }

        .category-list li {
            margin-bottom: 0;
        }

        .category-list a {
            display: block;
            padding: 10px 20px;
            background: var(--white);
            color: var(--gray-700);
            text-decoration: none;
            border-radius: 4px;
            border: 1px solid var(--gray-300);
            transition: all 0.3s ease;
            font-size: 0.9rem;
        }

        .category-list a:hover {
            background: var(--primary);
            color: var(--white);
            border-color: var(--primary);
        }

        /* Popular Products Grid */
        .popular-section {
            padding: 60px 0;
            background: var(--white);
        }

        .popular-grid {
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            gap: 20px;
        }

        .popular-item {
            text-align: center;
            text-decoration: none;
            color: var(--gray-700);
        }

        .popular-item:hover {
            color: var(--primary);
        }

        .popular-image {
            width: 100%;
            height: 100px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 8px;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .popular-image i {
            font-size: 28px;
            color: white;
        }

        .popular-name {
            font-size: 0.85rem;
            font-weight: 500;
        }

        /* Quote Section */
        .quote-section {
            padding: 60px 0;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
        }

        .quote-section .section-title {
            color: white;
        }

        .quote-section .section-title::after {
            background: white;
        }

        .quote-methods {
            display: flex;
            justify-content: center;
            gap: 40px;
            flex-wrap: wrap;
            margin-top: 40px;
        }

        .quote-method {
            text-align: center;
            padding: 30px;
            background: rgba(255,255,255,0.1);
            border-radius: 12px;
            min-width: 250px;
            transition: all 0.3s ease;
        }

        .quote-method:hover {
            background: rgba(255,255,255,0.2);
            transform: translateY(-5px);
        }

        .quote-method i {
            font-size: 48px;
            margin-bottom: 15px;
            display: block;
        }

        .quote-method h4 {
            font-size: 1.2rem;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .quote-method p {
            font-size: 0.9rem;
            opacity: 0.9;
            margin-bottom: 15px;
        }

        .quote-method a {
            display: inline-block;
            background: white;
            color: var(--primary);
            padding: 10px 25px;
            border-radius: 25px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .quote-method a:hover {
            background: var(--accent);
            color: white;
        }

        /* Footer - Keeping Original Style */
        footer {
            background: var(--dark);
            color: var(--white);
            padding: 40px 0 20px;
        }

        footer a {
            color: rgba(255,255,255,0.8);
            text-decoration: none;
        }

        footer a:hover {
            color: var(--primary);
        }

        /* ========== Hero Carousel ========== */
        .hero-carousel {
            position: relative;
        }

        .hero-carousel .carousel-item {
            height: 520px;
            position: relative;
            overflow: hidden;
        }

        .hero-carousel .carousel-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
        }

        .hero-carousel .carousel-item.slide-1::before {
            background: linear-gradient(135deg, rgba(0,102,204,0.92) 0%, rgba(0,68,153,0.88) 100%);
        }

        .hero-carousel .carousel-item.slide-2::before {
            background: linear-gradient(135deg, rgba(255,102,0,0.9) 0%, rgba(204,81,0,0.85) 100%);
        }

        .hero-carousel .carousel-item.slide-3::before {
            background: linear-gradient(135deg, rgba(26,26,46,0.92) 0%, rgba(0,102,204,0.85) 100%);
        }

        .hero-carousel .carousel-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .hero-carousel .carousel-caption {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            bottom: auto;
            text-align: left;
            left: 10%;
            right: 10%;
            max-width: 650px;
            z-index: 2;
        }

        .hero-carousel .carousel-caption h1 {
            font-size: 3rem;
            font-weight: 800;
            margin-bottom: 20px;
            animation: carouselFadeInUp 0.8s ease;
        }

        .hero-carousel .carousel-caption p {
            font-size: 1.2rem;
            opacity: 0.9;
            margin-bottom: 30px;
            animation: carouselFadeInUp 0.8s ease 0.2s both;
            line-height: 1.8;
        }

        .hero-carousel .carousel-caption .btn {
            animation: carouselFadeInUp 0.8s ease 0.4s both;
            padding: 14px 40px;
            font-weight: 700;
            border-radius: 30px;
            font-size: 1.1rem;
            letter-spacing: 0.5px;
        }

        .hero-carousel .carousel-indicators {
            bottom: 30px;
            z-index: 3;
        }

        .hero-carousel .carousel-indicators button {
            width: 45px;
            height: 4px;
            border-radius: 2px;
            margin: 0 6px;
            opacity: 0.5;
            border: none;
        }

        .hero-carousel .carousel-indicators button.active {
            opacity: 1;
            width: 60px;
        }

        .hero-carousel .carousel-control-prev,
        .hero-carousel .carousel-control-next {
            width: 60px;
            height: 60px;
            top: 50%;
            transform: translateY(-50%);
            bottom: auto;
            opacity: 0;
            transition: all 0.3s ease;
            z-index: 3;
        }

        .hero-carousel:hover .carousel-control-prev,
        .hero-carousel:hover .carousel-control-next {
            opacity: 1;
        }

        .hero-carousel .carousel-control-prev { left: 20px; }
        .hero-carousel .carousel-control-next { right: 20px; }

        .hero-carousel .carousel-control-prev-icon,
        .hero-carousel .carousel-control-next-icon {
            background-color: rgba(255,255,255,0.2);
            border-radius: 50%;
            padding: 30px;
            background-size: 50%;
        }

        .hero-carousel .carousel-control-prev-icon:hover,
        .hero-carousel .carousel-control-next-icon:hover {
            background-color: rgba(255,255,255,0.35);
        }

        /* Hero features overlay */
        .hero-features-overlay {
            position: absolute;
            bottom: 60px;
            right: 10%;
            z-index: 2;
            display: flex;
            gap: 30px;
        }

        .hero-features-overlay .feature-item {
            display: flex;
            align-items: center;
            gap: 8px;
            color: white;
            font-size: 0.95rem;
            font-weight: 500;
            background: rgba(255,255,255,0.15);
            padding: 10px 20px;
            border-radius: 25px;
            backdrop-filter: blur(5px);
        }

        .hero-features-overlay .feature-item i {
            color: #28a745;
        }

        @keyframes carouselFadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* ========== Online Design Tools ========== */
        .design-tools-section {
            padding: 60px 0;
            background: var(--gray-100);
        }

        .design-tools-header {
            text-align: center;
            margin-bottom: 10px;
        }

        .design-tools-header h2 {
            font-size: 1.6rem;
            font-weight: 800;
            color: var(--dark);
            margin-bottom: 5px;
        }

        .design-tools-header p {
            color: var(--gray-500);
            font-size: 0.95rem;
        }

        .design-tools-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 12px;
            margin-top: 30px;
        }

        .design-tool-card {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px 10px;
            background: var(--white);
            border: 1px solid var(--gray-300);
            border-radius: 8px;
            text-decoration: none;
            color: var(--gray-700);
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .design-tool-card:hover {
            border-color: var(--primary);
            box-shadow: 0 4px 16px rgba(0,102,204,0.15);
            transform: translateY(-3px);
            color: var(--primary);
        }

        .design-tool-card .tool-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, var(--primary-light) 0%, #cceeff 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 10px;
        }

        .design-tool-card .tool-icon i {
            font-size: 28px;
            color: var(--primary);
        }

        .design-tool-card:hover .tool-icon {
            background: var(--primary);
        }

        .design-tool-card:hover .tool-icon i {
            color: white;
        }

        .design-tool-card span {
            font-size: 0.82rem;
            font-weight: 500;
            text-align: center;
        }

        .design-tools-cta {
            text-align: center;
            margin-top: 30px;
        }

        .design-tools-cta .btn {
            padding: 12px 40px;
            border-radius: 25px;
            font-weight: 600;
        }

        /* ========== Product Center ========== */
        .product-center-section {
            padding: 60px 0;
            background: var(--white);
        }

        .product-center-section .section-header {
            margin-bottom: 30px;
        }

        .category-sidebar {
            background: var(--gray-100);
            border-radius: 8px;
            padding: 20px;
            border: 1px solid var(--gray-300);
        }

        .category-sidebar h4 {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid var(--primary);
        }

        .category-sidebar ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .category-sidebar li {
            margin-bottom: 2px;
        }

        .category-sidebar li a {
            display: block;
            padding: 10px 15px;
            color: var(--gray-700);
            text-decoration: none;
            border-radius: 6px;
            font-size: 0.9rem;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .category-sidebar li a:hover,
        .category-sidebar li a.active {
            background: var(--primary);
            color: white;
        }

        .category-sidebar li a i {
            width: 20px;
            margin-right: 8px;
        }

        /* Product center cards */
        .product-center-card {
            border: 1px solid var(--gray-300);
            border-radius: 8px;
            overflow: hidden;
            transition: all 0.3s ease;
            height: 100%;
            background: white;
        }

        .product-center-card:hover {
            box-shadow: 0 8px 24px rgba(0,0,0,0.1);
            transform: translateY(-4px);
        }

        .product-center-card .card-img-wrap {
            height: 180px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .product-center-card .card-img-wrap i {
            font-size: 48px;
            color: white;
            opacity: 0.9;
        }

        .product-center-card .card-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
        }

        .product-center-card .card-badge.hot { background: #ff4444; color: white; }
        .product-center-card .card-badge.new-badge { background: #28a745; color: white; }
        .product-center-card .card-badge.sale { background: #ff8800; color: white; }

        .product-center-card .card-body {
            padding: 16px;
        }

        .product-center-card .card-body h5 {
            font-size: 1rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 6px;
        }

        .product-center-card .card-body .card-desc {
            font-size: 0.82rem;
            color: var(--gray-500);
            margin-bottom: 12px;
            line-height: 1.5;
        }

        .product-center-card .card-body .card-price {
            font-size: 1.1rem;
            color: var(--accent);
            font-weight: 700;
            margin-bottom: 12px;
        }

        .product-center-card .card-body .card-actions {
            display: flex;
            gap: 8px;
        }

        .product-center-card .card-body .card-actions .btn {
            flex: 1;
            font-size: 0.82rem;
            padding: 6px 12px;
            border-radius: 4px;
        }

        /* ========== Enhanced Product Section ========== */
        .products-section {
            padding: 60px 0;
            background: var(--gray-100);
        }

        /* ========== Trust Badges ========== */
        .trust-badges {
            padding: 40px 0;
            background: var(--white);
            border-top: 1px solid var(--gray-300);
        }

        .trust-badges .row {
            align-items: center;
        }

        .trust-badge-item {
            text-align: center;
            padding: 20px;
        }

        .trust-badge-item i {
            font-size: 40px;
            color: var(--primary);
            margin-bottom: 10px;
        }

        .trust-badge-item h5 {
            font-size: 1rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 5px;
        }

        .trust-badge-item p {
            font-size: 0.85rem;
            color: var(--gray-500);
            margin: 0;
        }

        /* ========== Utility Classes (Breeze/Tailwind compatibility) ========== */
        .max-w-6xl { max-width: 72rem; }
        .max-w-5xl { max-width: 64rem; }
        .max-w-4xl { max-width: 56rem; }
        .max-w-3xl { max-width: 48rem; }
        .max-w-2xl { max-width: 42rem; }
        .max-w-xl { max-width: 36rem; }
        .mx-auto { margin-left: auto; margin-right: auto; }

        .text-2xl { font-size: 1.5rem; line-height: 2rem; }
        .text-xl { font-size: 1.25rem; line-height: 1.75rem; }
        .text-3xl { font-size: 1.875rem; line-height: 2.25rem; }
        .text-4xl { font-size: 2.25rem; line-height: 2.5rem; }
        .text-6xl { font-size: 3.75rem; line-height: 1; }
        .font-bold { font-weight: 700; }

        .mb-6 { margin-bottom: 2.5rem; }
        .mt-6 { margin-top: 2.5rem; }
        .py-8 { padding-top: 2rem; padding-bottom: 2rem; }
        .py-12 { padding-top: 3rem; padding-bottom: 3rem; }
        .py-3 { padding-top: 0.75rem; padding-bottom: 0.75rem; }

        .w-20 { width: 5rem; }
        .w-24 { width: 6rem; }
        .h-24 { height: 6rem; }
        .rounded-full { border-radius: 50%; }
        .items-center { align-items: center; }
        .ml-2 { margin-left: 0.5rem; }
        .gap-3 { gap: 0.75rem; }

        .d-flex.align-items-center.gap-3 { gap: 0.75rem; }

        /* ========== Responsive ========== */
        @media (max-width: 1200px) {
            .design-tools-grid {
                grid-template-columns: repeat(5, 1fr);
            }
        }

        @media (max-width: 992px) {
            .hero-title {
                font-size: 2rem;
            }

            .quick-grid {
                grid-template-columns: repeat(3, 1fr);
            }

            .popular-grid {
                grid-template-columns: repeat(3, 1fr);
            }

            .design-tools-grid {
                grid-template-columns: repeat(4, 1fr);
            }
        }

        @media (max-width: 768px) {
            .hero-title {
                font-size: 1.8rem;
            }

            .hero-features {
                gap: 15px;
            }

            .quick-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .popular-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .quote-methods {
                gap: 20px;
            }

            .design-tools-grid {
                grid-template-columns: repeat(3, 1fr);
            }

            .hero-carousel .carousel-item {
                height: 380px;
            }

            .hero-carousel .carousel-caption h1 {
                font-size: 1.8rem;
            }

            .hero-carousel .carousel-caption p {
                font-size: 0.95rem;
            }

            .hero-carousel .carousel-caption .btn {
                padding: 10px 25px;
                font-size: 0.9rem;
            }

            .hero-features-overlay {
                display: none;
            }
        }

        @media (max-width: 576px) {
            .design-tools-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .hero-carousel .carousel-item {
                height: 300px;
            }

            .hero-carousel .carousel-caption h1 {
                font-size: 1.3rem;
            }

            .hero-carousel .carousel-caption p {
                font-size: 0.82rem;
                margin-bottom: 15px;
            }

            .hero-carousel .carousel-caption .btn {
                padding: 8px 20px;
                font-size: 0.82rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation - Original Style -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <i class="fas fa-print me-2"></i>GoPrint
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ url('/') }}">{{ __('messages.home') }}</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('products.index') }}">{{ __('messages.products') }}</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/about') }}">{{ __('messages.about') }}</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/contact') }}">{{ __('messages.contact') }}</a></li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('cart.index') }}">
                            <i class="fas fa-shopping-cart"></i> {{ __('messages.cart') }}
                            @php
                                $cart = session()->get('cart', []);
                                $count = array_sum(array_column($cart, 'quantity'));
                            @endphp
                            @if($count > 0)
                                <span class="badge bg-warning text-dark">{{ $count }}</span>
                            @endif
                        </a>
                    </li>
                </ul>
                <div class="d-flex align-items-center gap-3">
                    <div class="dropdown">
                        <button class="btn btn-outline-light dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="fas fa-globe"></i> {{ __('messages.language') }}
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('setlocale', 'en') }}">{{ __('messages.english') }}</a></li>
                            <li><a class="dropdown-item" href="{{ route('setlocale', 'zh-HK') }}">{{ __('messages.chinese_traditional') }}</a></li>
                            <li><a class="dropdown-item" href="{{ route('setlocale', 'zh-CN') }}">{{ __('messages.chinese_simplified') }}</a></li>
                        </ul>
                    </div>
                    @guest
                        <a href="{{ route('login') }}" class="btn btn-light text-primary">{{ __('messages.login') }}</a>
                        <a href="{{ route('register') }}" class="btn btn-warning text-white">{{ __('messages.register') }}</a>
                    @else
                        <div class="dropdown">
                            <button class="btn btn-light text-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                {{ Auth::user()->name }}
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                @if(Auth::user()->role === 'admin')
                                <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">{{ __('messages.admin_panel') }}</a></li>
                                @endif
                                <li><a class="dropdown-item" href="{{ route('dashboard') }}">{{ __('messages.dashboard') }}</a></li>
                                <li><a class="dropdown-item" href="{{ route('orders.index') }}">{{ __('messages.my_orders') }}</a></li>
                                <li><a class="dropdown-item" href="{{ route('addresses.index') }}">{{ __('messages.addresses') }}</a></li>
                                <li><a class="dropdown-item" href="{{ route('profile.edit') }}">{{ __('messages.profile') }}</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}" class="dropdown-item">
                                        @csrf
                                        <button type="submit" class="btn btn-link p-0 text-start">{{ __('messages.logout') }}</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @endguest
                    <a href="{{ route('order.create') }}" class="btn btn-warning text-white">{{ __('messages.order') }}</a>
                </div>
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <!-- Footer - Original Style -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5>Gift and Premium Limited</h5>
                    <p>{{ __('messages.copyright') }}</p>
                    <p><i class="fas fa-phone"></i> {{ __('messages.phone') }}: (852) 2565 7997</p>
                    <p><i class="fas fa-envelope"></i> {{ __('messages.email') }}: sales@giftandpremium.com.hk</p>
                    <p><i class="fas fa-map-marker-alt"></i> {{ __('messages.address') }}: 香港北角屈臣道4-6號海景大廈B座605室</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <h5>Quick Links</h5>
                    <p><a href="{{ url('/') }}">Home</a> | <a href="{{ route('products.index') }}">Products</a> | <a href="{{ url('/about') }}">About</a> | <a href="{{ url('/contact') }}">Contact</a></p>
                </div>
            </div>
            <hr class="my-4" style="border-color: rgba(255,255,255,0.1);">
            <div class="text-center">
                <p class="mb-0">&copy; {{ date('Y') }} Gift and Premium Limited. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
