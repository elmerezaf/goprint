<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="{{ __('messages.meta_description') }}">
    <title>@yield('title') | GoPrint</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #f59e0b;
            --primary-dark: #d97706;
            --primary-light: #fef3c7;
            --accent: #f97316;
            --dark: #1f2937;
            --gray-900: #1f2937;
            --gray-700: #374151;
            --gray-500: #6b7280;
            --gray-300: #d1d5db;
            --gray-100: #f3f4f6;
            --white: #ffffff;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'PingFang SC', 'Hiragino Sans GB', 'Microsoft YaHei', sans-serif;
            line-height: 1.7;
            color: var(--gray-700);
        }

        /* ========== Original Structure ========== */

        /* Navigation - Custom Style */
        .navbar-brand { font-weight: 800; font-size: 1.5rem; }
        .navbar { background-color: #f38a3b !important; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .navbar .nav-item { margin: 0 0.75rem; }
        .navbar .nav-link { color: var(--white) !important; font-weight: 500; transition: color 0.3s ease; }
        .navbar .nav-link:hover { color: var(--primary) !important; }

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
            top: 0; left: -50%;
            width: 200%; height: 100%;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
        .hero-title { font-size: 2.8rem; font-weight: 800; margin-bottom: 20px; }
        .hero-subtitle { font-size: 1.2rem; opacity: 0.9; margin-bottom: 30px; }
        .hero-features { display: flex; gap: 30px; margin-bottom: 30px; flex-wrap: wrap; }
        .hero-feature { display: flex; align-items: center; gap: 8px; font-size: 1rem; }
        .hero-feature i { color: #28a745; }

        /* Section Headers */
        .section-header { text-align: center; margin-bottom: 40px; }
        .section-title {
            font-size: 2rem; font-weight: 800; color: var(--dark);
            margin-bottom: 10px; position: relative; display: inline-block;
        }
        .section-title::after {
            content: '';
            position: absolute; bottom: -10px; left: 50%;
            transform: translateX(-50%); width: 60px; height: 4px;
            background: var(--primary); border-radius: 2px;
        }

        /* Product Cards */
        .products-section { padding: 60px 0; background: var(--white); }
        .product-card {
            border: 1px solid var(--gray-300); border-radius: 8px;
            overflow: hidden; transition: all 0.3s ease; height: 100%;
        }
        .product-card:hover { box-shadow: 0 8px 24px rgba(0,0,0,0.12); transform: translateY(-5px); }
        .product-image {
            width: 100%; padding-top: 100%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            position: relative; overflow: hidden;
        }
        .product-image i {
            position: absolute; top: 50%; left: 50%; transform: translate(-50%,-50%);
            font-size: 48px; color: white; opacity: 0.9;
        }
        .product-content { padding: 20px; }
        .product-title { font-size: 1.1rem; font-weight: 700; color: var(--dark); margin-bottom: 8px; }
        .product-spec { font-size: 0.85rem; color: var(--gray-500); margin-bottom: 10px; }
        .product-meta { display: flex; flex-direction: column; gap: 5px; margin-bottom: 15px; }
        .product-delivery { font-size: 0.9rem; color: #28a745; font-weight: 600; }
        .product-price { font-size: 1.1rem; color: var(--accent); font-weight: 700; }
        .product-desc { font-size: 0.85rem; color: var(--gray-500); margin-bottom: 15px; line-height: 1.5; }
        .product-link { display: inline-block; color: var(--primary); font-weight: 600; font-size: 0.9rem; text-decoration: none; }
        .product-link:hover { color: var(--accent); }

        /* Categories Section */
        .categories-section { padding: 60px 0; background: var(--gray-100); }
        .category-list { list-style: none; padding: 0; margin: 0; display: flex; flex-wrap: wrap; gap: 10px; justify-content: center; }
        .category-list li { margin-bottom: 0; }
        .category-list a {
            display: block; padding: 10px 20px; background: var(--white);
            color: var(--gray-700); text-decoration: none; border-radius: 4px;
            border: 1px solid var(--gray-300); transition: all 0.3s ease; font-size: 0.9rem;
        }
        .category-list a:hover { background: var(--primary); color: var(--white); border-color: var(--primary); }

        /* Popular Products Grid */
        .popular-section { padding: 60px 0; background: var(--white); }
        .popular-grid { display: grid; grid-template-columns: repeat(6, 1fr); gap: 20px; }
        .popular-item { text-align: center; text-decoration: none; color: var(--gray-700); }
        .popular-item:hover { color: var(--primary); }
        .popular-image {
            width: 100%; padding-top: 100%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 8px; margin-bottom: 10px; position: relative; overflow: hidden;
        }
        .popular-image i { position: absolute; top: 50%; left: 50%; transform: translate(-50%,-50%); font-size: 28px; color: white; }
        .popular-card-image { position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; }
        .popular-name { font-size: 0.85rem; font-weight: 500; }

        /* Quote Section */
        .quote-section {
            padding: 60px 0;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
        }
        .quote-section .section-title { color: white; }
        .quote-section .section-title::after { background: white; }
        .quote-methods { display: flex; justify-content: center; gap: 40px; flex-wrap: wrap; margin-top: 40px; }
        .quote-method {
            text-align: center; padding: 30px;
            background: rgba(255,255,255,0.1); border-radius: 12px;
            min-width: 250px; transition: all 0.3s ease;
        }
        .quote-method:hover { background: rgba(255,255,255,0.2); transform: translateY(-5px); }
        .quote-method i { font-size: 48px; margin-bottom: 15px; display: block; }
        .quote-method h4 { font-size: 1.2rem; font-weight: 700; margin-bottom: 10px; }
        .quote-method p { font-size: 0.9rem; opacity: 0.9; margin-bottom: 15px; }
        .quote-method a {
            display: inline-block; background: white; color: var(--primary);
            padding: 10px 25px; border-radius: 25px; font-weight: 600;
            text-decoration: none; transition: all 0.3s ease;
        }
        .quote-method a:hover { background: var(--accent); color: white; }

        /* Footer */
        footer { background: var(--dark); color: var(--white); padding: 40px 0 20px; }
        footer a { color: rgba(255,255,255,0.8); text-decoration: none; }
        footer a:hover { color: var(--primary); }
        footer h5 { font-size: 1.05rem; margin-bottom: 12px; }
        footer ul { padding-left: 0; }
        footer ul li a { font-size: 0.88rem; }
        footer p { font-size: 0.88rem; margin-bottom: 0; }
        .footer-contact i { color: var(--primary); width: 20px; }
        .footer-hours p { margin-bottom: 4px; }

        /* ========== Hero Carousel ========== */
        .hero-carousel { position: relative; max-width: 1920px; margin: 0 auto; }
        .hero-carousel .carousel-item { position: relative; }
        .hero-carousel .carousel-item img { width: 100%; height: auto; display: block; }
        .hero-carousel .carousel-control-prev,
        .hero-carousel .carousel-control-next { opacity: 1 !important; z-index: 10; }
        .hero-carousel .carousel-caption {
            position: absolute; top: 50%; transform: translateY(-50%); bottom: auto;
            text-align: left; left: 10%; right: 10%; max-width: 650px; z-index: 2;
            padding: 30px 35px; background: rgba(0,0,0,0.55);
            backdrop-filter: blur(10px); border-radius: 16px;
            border: 1px solid rgba(255,255,255,0.15);
            box-shadow: 0 8px 32px rgba(0,0,0,0.35);
        }
        .hero-carousel .carousel-caption h1 {
            font-size: 2.6rem; font-weight: 800; margin-bottom: 15px; color: white;
            text-shadow: 2px 2px 8px rgba(0,0,0,0.6); animation: carouselFadeInUp 0.8s ease;
        }
        .hero-carousel .carousel-caption p {
            font-size: 1.1rem; opacity: 0.95; margin-bottom: 25px; color: white;
            text-shadow: 1px 1px 4px rgba(0,0,0,0.5);
            animation: carouselFadeInUp 0.8s ease 0.2s both; line-height: 1.7;
        }
        .hero-carousel .carousel-caption .btn {
            animation: carouselFadeInUp 0.8s ease 0.4s both;
            padding: 14px 40px; font-weight: 700; border-radius: 30px;
            font-size: 1.1rem; letter-spacing: 0.5px;
        }
        .hero-carousel .carousel-indicators { bottom: 30px; z-index: 3; }
        .hero-carousel .carousel-indicators button {
            width: 45px; height: 4px; border-radius: 2px; margin: 0 6px;
            opacity: 0.5; border: none;
        }
        .hero-carousel .carousel-indicators button.active { opacity: 1; width: 60px; }
        .hero-carousel .carousel-control-prev,
        .hero-carousel .carousel-control-next {
            width: 60px; height: 60px; top: 50%; transform: translateY(-50%);
            bottom: auto; opacity: 0; transition: all 0.3s ease; z-index: 3;
        }
        .hero-carousel:hover .carousel-control-prev,
        .hero-carousel:hover .carousel-control-next { opacity: 1; }
        .hero-carousel .carousel-control-prev { left: 20px; }
        .hero-carousel .carousel-control-next { right: 20px; }
        .hero-carousel .carousel-control-prev-icon,
        .hero-carousel .carousel-control-next-icon {
            background-color: rgba(255,255,255,0.2); border-radius: 50%;
            padding: 30px; background-size: 50%;
        }
        .hero-carousel .carousel-control-prev-icon:hover,
        .hero-carousel .carousel-control-next-icon:hover { background-color: rgba(255,255,255,0.35); }
        .hero-features-overlay {
            position: absolute; bottom: 60px; right: 10%; z-index: 2;
            display: flex; gap: 30px;
        }
        .hero-features-overlay .feature-item {
            display: flex; align-items: center; gap: 8px; color: white;
            font-size: 0.95rem; font-weight: 500;
            background: rgba(255,255,255,0.15); padding: 10px 20px;
            border-radius: 25px; backdrop-filter: blur(5px);
        }
        .hero-features-overlay .feature-item i { color: #28a745; }
        @keyframes carouselFadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* ========== Design Tools ========== */
        .design-tools-section { padding: 60px 0; background: var(--gray-100); }
        .design-tools-header { text-align: center; margin-bottom: 10px; }
        .design-tools-header h2 { font-size: 1.6rem; font-weight: 800; color: var(--dark); margin-bottom: 5px; }
        .design-tools-header p { color: var(--gray-500); font-size: 0.95rem; }
        .design-tools-grid { display: grid; grid-template-columns: repeat(5, 1fr); gap: 12px; margin-top: 30px; }
        .design-tool-card {
            display: flex; flex-direction: column; align-items: center; padding: 20px 10px;
            background: var(--white); border: 1px solid var(--gray-300); border-radius: 8px;
            text-decoration: none; color: var(--gray-700); transition: all 0.3s ease; cursor: pointer;
        }
        .design-tool-card:hover {
            border-color: var(--primary); box-shadow: 0 4px 16px rgba(0,102,204,0.15);
            transform: translateY(-3px); color: var(--primary);
        }
        .design-tool-card .tool-icon {
            width: 60px; height: 60px;
            background: linear-gradient(135deg, var(--primary-light) 0%, #cceeff 100%);
            border-radius: 12px; display: flex; align-items: center;
            justify-content: center; margin-bottom: 10px;
        }
        .design-tool-card .tool-icon i { font-size: 28px; color: var(--primary); }
        .design-tool-card:hover .tool-icon { background: var(--primary); }
        .design-tool-card:hover .tool-icon i { color: white; }
        .design-tool-card span { font-size: 0.82rem; font-weight: 500; text-align: center; }
        .design-tools-cta { text-align: center; margin-top: 30px; }
        .design-tools-cta .btn { padding: 12px 40px; border-radius: 25px; font-weight: 600; }

        /* ========== Product Center ========== */
        .product-center-section { padding: 60px 0; background: var(--white); }
        .product-center-section .section-header { margin-bottom: 30px; }
        .category-sidebar {
            background: var(--gray-100); border-radius: 8px; padding: 20px;
            border: 1px solid var(--gray-300);
        }
        .category-sidebar h4 {
            font-size: 1.1rem; font-weight: 700; color: var(--dark);
            margin-bottom: 15px; padding-bottom: 10px; border-bottom: 2px solid var(--primary);
        }
        .category-sidebar ul { list-style: none; padding: 0; margin: 0; }
        .category-sidebar li { margin-bottom: 2px; }
        .category-sidebar li a {
            display: block; padding: 10px 15px; color: var(--gray-700);
            text-decoration: none; border-radius: 6px; font-size: 0.9rem;
            font-weight: 500; transition: all 0.2s ease;
        }
        .category-sidebar li a:hover,
        .category-sidebar li a.active { background: var(--primary); color: white; }
        .category-sidebar li a i { width: 20px; margin-right: 8px; }
        .product-center-card {
            border: 1px solid var(--gray-300); border-radius: 8px; overflow: hidden;
            transition: all 0.3s ease; height: 100%; background: white;
        }
        .product-center-card:hover { box-shadow: 0 8px 24px rgba(0,0,0,0.1); transform: translateY(-4px); }
        .product-center-card .card-img-wrap {
            width: 100%; padding-top: 100%;
            background: linear-gradient(135deg, #f59e0b 0%, #f97316 100%);
            position: relative; overflow: hidden;
        }
        .product-center-card .card-img-wrap i {
            position: absolute; top: 50%; left: 50%; transform: translate(-50%,-50%);
            font-size: 48px; color: white; opacity: 0.9;
        }
        .product-card-image { position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; }
        .product-center-card .card-badge {
            position: absolute; top: 10px; right: 10px; padding: 4px 12px;
            border-radius: 12px; font-size: 0.75rem; font-weight: 700; text-transform: uppercase;
        }
        .product-center-card .card-badge.hot { background: #ff4444; color: white; }
        .product-center-card .card-badge.new-badge { background: #28a745; color: white; }
        .product-center-card .card-badge.sale { background: #ff8800; color: white; }
        .product-center-card .card-body { padding: 16px; }
        .product-center-card .card-body h5 { font-size: 1rem; font-weight: 700; color: var(--dark); margin-bottom: 6px; }
        .product-center-card .card-body .card-desc { font-size: 0.82rem; color: var(--gray-500); margin-bottom: 12px; line-height: 1.5; }
        .product-center-card .card-body .card-price { font-size: 1.1rem; color: var(--accent); font-weight: 700; margin-bottom: 12px; }
        .product-center-card .card-body .card-actions { display: flex; gap: 8px; }
        .product-center-card .card-body .card-actions .btn { flex: 1; font-size: 0.82rem; padding: 6px 12px; border-radius: 4px; }

        /* ========== Promo Cards ========== */
        .promo-cards-section { padding: 50px 0; background: var(--white); }
        .promo-card {
            border-radius: 12px; overflow: hidden; border: 1px solid var(--gray-300);
            transition: all 0.3s; height: 100%;
        }
        .promo-card:hover { box-shadow: 0 8px 30px rgba(0,0,0,0.1); transform: translateY(-3px); }
        .promo-card .promo-card-header {
            background: linear-gradient(135deg, var(--primary), var(--accent));
            color: white; padding: 20px; text-align: center;
        }
        .promo-card .promo-card-header h5 { font-weight: 700; margin: 0; }
        .promo-card .promo-card-body { padding: 20px; text-align: center; }
        .promo-card .promo-card-body .promo-desc { color: var(--gray-500); font-size: 0.9rem; }

        /* ========== Testimonials ========== */
        .testimonials-section { padding: 60px 0; background: var(--gray-100); }
        .testimonial-card {
            background: white; border-radius: 12px; padding: 30px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.06); height: 100%;
        }
        .testimonial-card .quote-icon { color: var(--primary); font-size: 2rem; margin-bottom: 10px; }
        .testimonial-card .testimonial-text { font-size: 0.95rem; color: var(--gray-700); line-height: 1.8; margin-bottom: 15px; }
        .testimonial-card .testimonial-author { font-weight: 700; color: var(--dark); }
        .testimonial-card .testimonial-role { font-size: 0.82rem; color: var(--gray-500); }

        /* ========== Trust Badges ========== */
        .trust-badges { padding: 40px 0; background: var(--white); border-top: 1px solid var(--gray-300); }
        .trust-badges .row { align-items: center; }
        .trust-badge-item { text-align: center; padding: 20px; }
        .trust-badge-item i { font-size: 40px; color: var(--primary); margin-bottom: 10px; }
        .trust-badge-item h5 { font-size: 1rem; font-weight: 700; color: var(--dark); margin-bottom: 5px; }
        .trust-badge-item p { font-size: 0.85rem; color: var(--gray-500); margin: 0; }
        
        /* ========== Pagination Fix - Force Override Bootstrap ========== */
        .pagination { 
            display: flex !important; 
            list-style: none !important; 
            padding: 0 !important; 
            margin: 1rem 0 !important; 
            flex-wrap: wrap !important; 
            justify-content: center !important; 
        }
        .pagination > li { 
            margin: 2px !important; 
            display: inline-block !important;
        }
        .pagination > li > a,
        .pagination > li > span,
        .pagination > li > a.page-link,
        .pagination > li > span.page-link { 
            display: inline-flex !important; 
            align-items: center !important; 
            justify-content: center !important;
            padding: 8px 14px !important; 
            border: 1px solid #d1d5db !important; 
            border-radius: 6px !important; 
            text-decoration: none !important; 
            color: #374151 !important; 
            background: white !important;
            font-size: 0.85rem !important;
            min-width: 36px !important;
            height: 36px !important;
            line-height: 1 !important;
            box-shadow: none !important;
        }
        .pagination > li > a:hover,
        .pagination > li > a.page-link:hover { 
            background: #f59e0b !important; 
            border-color: #f59e0b !important; 
            color: white !important; 
        }
        .pagination > li.active > span,
        .pagination > li.active > span.page-link { 
            background: #f59e0b !important; 
            border-color: #f59e0b !important; 
            color: white !important; 
            font-weight: 600 !important;
        }
        .pagination > li.disabled > span,
        .pagination > li.disabled > span.page-link { 
            color: #6b7280 !important; 
            background: #f3f4f6 !important; 
            cursor: not-allowed !important;
        }
        .pagination > li > a svg,
        .pagination > li > span svg {
            width: 14px !important;
            height: 14px !important;
        }

        /* ========== Product Detail ========== */
        .product-detail-image-container { width: 100%; padding-top: 100%; position: relative; overflow: hidden; }
        .product-detail-image { position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; }

        /* ========== Buttons Override ========== */
        .btn-primary { background-color: #f59e0b !important; border-color: #f59e0b !important; color: white !important; font-weight: 600; }
        .btn-primary:hover { background-color: #d97706 !important; border-color: #d97706 !important; }
        .btn-outline-primary { border-color: #f59e0b !important; color: #f59e0b !important; }
        .btn-outline-primary:hover { background-color: #f59e0b !important; border-color: #f59e0b !important; color: white !important; }

        /* ========== Utility ========== */
        .max-w-6xl { max-width: 72rem; } .max-w-5xl { max-width: 64rem; } .max-w-4xl { max-width: 56rem; }
        .max-w-3xl { max-width: 48rem; } .max-w-2xl { max-width: 42rem; } .max-w-xl { max-width: 36rem; }
        .mx-auto { margin-left: auto; margin-right: auto; }
        .text-2xl { font-size: 1.5rem; line-height: 2rem; } .text-xl { font-size: 1.25rem; line-height: 1.75rem; }
        .text-3xl { font-size: 1.875rem; line-height: 2.25rem; } .text-4xl { font-size: 2.25rem; line-height: 2.5rem; }
        .text-6xl { font-size: 3.75rem; line-height: 1; }
        .font-bold { font-weight: 700; } .mb-6 { margin-bottom: 2.5rem; } .mt-6 { margin-top: 2.5rem; }
        .py-8 { padding-top: 2rem; padding-bottom: 2rem; } .py-12 { padding-top: 3rem; padding-bottom: 3rem; }
        .py-3 { padding-top: 0.75rem; padding-bottom: 0.75rem; }
        .w-20 { width: 5rem; } .w-24 { width: 6rem; } .h-24 { height: 6rem; }
        .rounded-full { border-radius: 50%; } .items-center { align-items: center; }
        .ml-2 { margin-left: 0.5rem; } .gap-3 { gap: 0.75rem; }
        .d-flex.align-items-center.gap-3 { gap: 0.75rem; }

        /* ========== Top Banner ========== */
        .top-banner { background-color: #f59e0b; padding: 8px 0; border-bottom: 1px solid #d97706; }
        .top-banner .container { display: flex; justify-content: space-between; align-items: center; }
        .top-banner .banner-text { display: flex; align-items: center; gap: 8px; color: white; font-size: 0.85rem; font-weight: 500; flex: 1; }
        .top-banner .banner-text i { font-size: 1rem; }
        .top-banner .banner-right { display: flex; align-items: center; gap: 15px; }
        .top-banner .banner-phone { display: flex; align-items: center; gap: 5px; color: white; text-decoration: none; font-size: 0.9rem; font-weight: 600; }
        .top-banner .banner-phone:hover { color: #fff3cd; }

        /* ========== Top Bar ========== */
        .top-bar { background-color: #f8f9fa; padding: 6px 0; border-bottom: 1px solid #e9ecef; }
        .top-bar .whatsapp-link { display: flex; align-items: center; gap: 5px; color: #25d366; text-decoration: none; font-weight: 600; font-size: 0.9rem; }
        .top-bar .whatsapp-link:hover { color: #128c7e; }
        .top-bar .login-link, .top-bar .register-link { color: #374151; text-decoration: none; font-size: 0.85rem; font-weight: 500; }
        .top-bar .login-link:hover, .top-bar .register-link:hover { color: #f59e0b; }
        .top-bar .separator { margin: 0 8px; color: #9ca3af; }
        .top-bar .welcome-text { color: #374151; font-size: 0.85rem; font-weight: 500; }
        .top-bar .service-hours { color: #6b7280; font-size: 0.78rem; }

        /* Mobile Menu Actions */
        .mobile-menu-actions { border-top: 1px solid rgba(255,255,255,0.1); padding-top: 10px; margin-top: 10px; }
        .mobile-menu-actions .nav-item { margin: 0; }
        .mobile-menu-actions .nav-link { color: rgba(255,255,255,0.8) !important; padding: 10px 0; border-bottom: 1px solid rgba(255,255,255,0.05); }
        .mobile-menu-actions .nav-link:hover { color: var(--primary) !important; }

        /* ========== Responsive ========== */
        @media (max-width: 1200px) { .design-tools-grid { grid-template-columns: repeat(5, 1fr); } }
        @media (max-width: 992px) {
            .hero-title { font-size: 2rem; }
            .popular-grid { grid-template-columns: repeat(3, 1fr); }
            .design-tools-grid { grid-template-columns: repeat(5, 1fr); }
        }
        @media (max-width: 768px) {
            .hero-title { font-size: 1.8rem; }
            .hero-features { gap: 15px; }
            .popular-grid { grid-template-columns: repeat(2, 1fr); }
            .quote-methods { gap: 20px; }
            .design-tools-grid { grid-template-columns: repeat(5, 1fr); gap: 8px; }
            .hero-carousel .carousel-caption h1 { font-size: 1.8rem; }
            .hero-carousel .carousel-caption p { font-size: 0.95rem; }
            .hero-carousel .carousel-caption .btn { padding: 10px 25px; font-size: 0.9rem; }
            .hero-features-overlay { display: none; }
            .top-banner .container { flex-direction: column; gap: 8px; }
            .top-banner .banner-text span { white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 100%; }
        }
        @media (max-width: 576px) {
            .design-tools-grid { grid-template-columns: repeat(5, 1fr); gap: 6px; }
            .design-tool-card { padding: 10px 5px; }
            .design-tool-card .tool-icon { width: 40px; height: 40px; margin-bottom: 6px; }
            .design-tool-card .tool-icon i { font-size: 20px; }
            .design-tool-card span { font-size: 0.7rem; }
            .top-bar .login-link, .top-bar .register-link { font-size: 0.75rem; }
            .top-bar .separator { margin: 0 4px; }
            .top-bar .whatsapp-link { font-size: 0.8rem; }
            .product-center-card { margin-bottom: 1rem; }
            section { padding: 30px 0 !important; }
            .section-header { margin-bottom: 20px; }
            .section-title { font-size: 1.5rem; }
        }
        @media (max-width: 991px) {
            .navbar .navbar-collapse { padding-top: 1rem; }
            .navbar .nav-item { margin: 0.5rem 0; }
        }
    </style>
</head>
<body>
    <!-- Top Banner - Promotion (Original Style) -->
    <div class="top-banner">
        <div class="container">
            <div class="banner-text">
                <i class="fas fa-percent"></i>
                <span>{{ __('messages.promo_banner_text') }}</span>
            </div>
            <div class="banner-right">
                <a href="tel:+85225657997" class="banner-phone">
                    <i class="fas fa-phone"></i> 2565 7997
                </a>
            </div>
        </div>
    </div>

    <!-- Second Top Bar - WhatsApp & Login (Original Style) -->
    <div class="top-bar">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <div class="top-bar-left">
                    <a href="https://api.whatsapp.com/send?phone=85260987508" class="whatsapp-link" target="_blank">
                        <i class="fab fa-whatsapp"></i> 6098 7508
                    </a>
                    <span class="service-hours d-none d-md-inline ms-3">
                        <i class="far fa-clock me-1"></i>{{ __('messages.footer_weekday') }} 09:00-18:00 | {{ __('messages.footer_saturday') }} 09:00-13:00
                    </span>
                </div>
                <div class="top-bar-right d-flex align-items-center">
                    <a href="{{ route('products.index') }}" class="search-icon me-3 d-md-none">
                        <i class="fas fa-search" style="color:#6b7280; font-size:1.2rem;"></i>
                    </a>
                    <div class="d-flex align-items-center">
                        @guest
                            <a href="{{ route('login') }}" class="login-link">{{ __('messages.login') }}</a>
                            <span class="separator">|</span>
                            <a href="{{ route('register') }}" class="register-link">{{ __('messages.register') }}</a>
                        @else
                            <span class="welcome-text">{{ __('messages.welcome_back') }}, {{ Auth::user()->name }}</span>
                        @endguest
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Navigation (Original Orange Style) -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <i class="fas fa-print me-2"></i>GoPrint
            </a>
            <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ url('/') }}">{{ __('messages.home') }}</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('products.index') }}">{{ __('messages.products') }}</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('designer.index') }}">{{ __('messages.start_design') }}</a></li>
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

                <div class="navbar-nav d-md-none mobile-menu-actions">
                    <div class="nav-item"><a class="nav-link" href="{{ route('login') }}"><i class="fas fa-sign-in-alt me-2"></i>{{ __('messages.login') }}</a></div>
                    <div class="nav-item"><a class="nav-link" href="{{ route('register') }}"><i class="fas fa-user-plus me-2"></i>{{ __('messages.register') }}</a></div>
                    <div class="nav-item"><a class="nav-link" href="{{ route('products.index') }}"><i class="fas fa-search me-2"></i>{{ __('messages.search') }}</a></div>
                </div>

                <div class="d-flex align-items-center gap-3 mt-3 mt-md-0">
                    <div class="d-none d-lg-flex align-items-center gap-2">
                        <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm">{{ __('messages.login') }}</a>
                        <a href="{{ route('register') }}" class="btn btn-warning btn-sm text-white">{{ __('messages.register') }}</a>
                    </div>
                    <div class="dropdown d-none d-md-block">
                        <button class="btn btn-outline-light dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="fas fa-globe"></i> {{ __('messages.language') }}
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('setlocale', 'zh-HK') }}">{{ __('messages.chinese_traditional') }}</a></li>
                            <li><a class="dropdown-item" href="{{ route('setlocale', 'en') }}">{{ __('messages.english') }}</a></li>
                        </ul>
                    </div>
                    @guest
                    @else
                        <div class="dropdown d-none d-md-block">
                            <button class="btn btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown" style="color: var(--dark);">
                                {{ Auth::user()->name }}
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                @if(Auth::user()->role === 'admin')
                                <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}"><i class="fas fa-cog me-2"></i>{{ __('messages.admin_panel') }}</a></li>
                                @endif
                                <li><a class="dropdown-item" href="{{ route('dashboard') }}"><i class="fas fa-tachometer-alt me-2"></i>{{ __('messages.dashboard') }}</a></li>
                                <li><a class="dropdown-item" href="{{ route('orders.index') }}"><i class="fas fa-receipt me-2"></i>{{ __('messages.my_orders') }}</a></li>
                                <li><a class="dropdown-item" href="{{ route('addresses.index') }}"><i class="fas fa-map-marker-alt me-2"></i>{{ __('messages.addresses') }}</a></li>
                                <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="fas fa-user-cog me-2"></i>{{ __('messages.profile') }}</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}" class="dropdown-item">
                                        @csrf
                                        <button type="submit" class="btn btn-link p-0 text-start"><i class="fas fa-sign-out-alt me-2"></i>{{ __('messages.logout') }}</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @endguest
                    <a href="{{ route('order.create') }}" class="btn btn-warning text-white d-none d-md-block">{{ __('messages.order') }}</a>
                </div>
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <!-- Footer (Original Style) -->
    <footer>
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-5 col-md-6 mb-4 mb-md-0">
                    <h5 class="mb-3">{{ __('messages.company_name_full') }}</h5>
                    <p class="mb-2" style="font-size:0.9rem;">{{ __('messages.company_desc_footer') }}</p>
                    <div class="footer-contact">
                        <p class="mb-1"><i class="fas fa-phone me-2"></i>{{ __('messages.phone') }}: (852) 2565 7997</p>
                        <p class="mb-1"><i class="fab fa-whatsapp me-2"></i>WhatsApp: (852) 6098 7508</p>
                        <p class="mb-1"><i class="fas fa-envelope me-2"></i>{{ __('messages.email') }}: sales@giftandpremium.com.hk</p>
                        <p class="mb-1"><i class="fas fa-map-marker-alt me-2"></i>{{ __('messages.office_address') }}:</p>
                        <p class="ms-4 mb-1">{!! __('messages.footer_address_line1') !!}<br>{!! __('messages.footer_address_line2') !!}</p>
                        <p class="mb-1"><i class="fas fa-subway me-2"></i>{!! __('messages.footer_mtr_info') !!}</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                    <h5 class="mb-3">{{ __('messages.quick_links') }}</h5>
                    <ul class="list-unstyled footer-links">
                        <li class="mb-1"><a href="{{ url('/') }}">{{ __('messages.home') }}</a></li>
                        <li class="mb-1"><a href="{{ route('products.index') }}">{{ __('messages.products') }}</a></li>
                        <li class="mb-1"><a href="{{ route('designer.index') }}">{{ __('messages.start_design') }}</a></li>
                        <li class="mb-1"><a href="{{ url('/about') }}">{{ __('messages.about') }}</a></li>
                        <li class="mb-1"><a href="{{ url('/contact') }}">{{ __('messages.contact') }}</a></li>
                        <li class="mb-1"><a href="{{ route('order.create') }}">{{ __('messages.get_quote') }}</a></li>
                    </ul>
                </div>
                <div class="col-lg-4 col-md-12">
                    <h5 class="mb-3">{{ __('messages.office_hours_label') }}</h5>
                    <div class="footer-hours">
                        <p class="mb-1">{{ __('messages.footer_weekday') }}：09:00 - 18:00</p>
                        <p class="mb-1">{{ __('messages.footer_saturday') }}：09:00 - 13:00</p>
                        <p class="mb-2">{{ __('messages.footer_sunday_holiday') }}：{{ __('messages.footer_closed') }}</p>
                        <p class="mt-3" style="font-size:0.85rem; color:rgba(255,255,255,0.5);">{{ __('messages.visit_by_appointment') }}</p>
                    </div>
                </div>
            </div>
            <hr class="my-4" style="border-color: rgba(255,255,255,0.1);">
            <div class="text-center">
                <p class="mb-0">&copy; {{ date('Y') }} {{ __('messages.all_rights_reserved') }}</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')

    <!-- WhatsApp Floating Button -->
    <a href="https://api.whatsapp.com/send?phone=85260987508&text={{ urlencode(__('messages.whatsapp_default_message')) }}"
       class="whatsapp-float"
       target="_blank" rel="noopener noreferrer">
        <i class="fab fa-whatsapp"></i>
        <span class="whatsapp-text">WhatsApp</span>
    </a>
    <style>
        .whatsapp-float {
            position: fixed; bottom: 30px; right: 30px;
            width: 60px; height: 60px; background-color: #25d366;
            color: white; border-radius: 50%; display: flex; align-items: center;
            justify-content: center; font-size: 28px;
            box-shadow: 0 4px 15px rgba(37, 211, 102, 0.4);
            text-decoration: none; z-index: 1000; transition: all 0.3s ease;
        }
        .whatsapp-float:hover { width: 140px; border-radius: 30px; background-color: #128c7e; box-shadow: 0 6px 20px rgba(37, 211, 102, 0.5); }
        .whatsapp-text { display: none; margin-left: 10px; font-size: 14px; font-weight: 600; white-space: nowrap; }
        .whatsapp-float:hover .whatsapp-text { display: inline; }
        @media (max-width: 768px) {
            .whatsapp-float { bottom: 20px; right: 20px; width: 55px; height: 55px; font-size: 24px; }
            .whatsapp-float:hover { width: 120px; }
        }
    </style>
</body>
</html>