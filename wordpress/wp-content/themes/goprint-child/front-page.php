<?php
/**
 * Custom Home Page Template for Go Print Child Theme
 * Professional Printing Services Homepage
 *
 * @package goprint-child
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();
?>

<!-- Top Bar -->
<div class="top-bar">
    <div class="container">
        <div class="top-bar-left">
            <a href="tel:+85226906288">📞 +852 2690 6288</a>
            <span class="separator">|</span>
            <a href="mailto:info@goprint.com.hk">✉️ info@goprint.com.hk</a>
            <span class="separator">|</span>
            <span>📍 九龍觀塘成業街16號怡生工業中心</span>
        </div>
        <div class="top-bar-right">
            <a href="#" class="lang-switch">繁體中文</a>
            <a href="#" class="lang-switch">English</a>
        </div>
    </div>
</div>

<!-- Main Header -->
<header class="main-header">
    <div class="container">
        <div class="header-left">
            <a href="<?php echo home_url(); ?>" class="logo">
                <div class="logo-icon">🖨️</div>
                <div class="logo-text-group">
                    <span class="logo-text">Go Print</span>
                    <span class="logo-tagline">專業印刷服務</span>
                </div>
            </a>
        </div>
        <nav class="main-nav">
            <?php
            wp_nav_menu( array(
                'theme_location' => 'primary_menu',
                'menu_class'     => 'nav-list',
                'container'      => false,
                'fallback_cb'    => false,
            ) );
            ?>
        </nav>
        <div class="header-right">
            <a href="#online-quote" class="quote-btn pulse-animation">立即獲取報價</a>
        </div>
    </div>
</header>

<!-- Hero Banner -->
<section class="hero-banner">
    <div class="hero-slider">
        <div class="hero-slide active" style="background: linear-gradient(135deg, #0066cc 0%, #004499 100%);">
            <div class="container">
                <div class="hero-content">
                    <div class="hero-badge">🔥 限時優惠</div>
                    <h1>專業數碼印刷服務</h1>
                    <p>一站式解決您的印刷需求，最快<span class="highlight">24小時</span>交貨</p>
                    <div class="hero-features">
                        <span>✓ 免費設計諮詢</span>
                        <span>✓ 香港本地製作</span>
                        <span>✓ 全港最低價保証</span>
                    </div>
                    <div class="hero-buttons">
                        <a href="#services" class="hero-btn primary">探索我們的服務</a>
                        <a href="#online-quote" class="hero-btn secondary">立即報價</a>
                    </div>
                </div>
            </div>
            <div class="hero-decoration">
                <div class="deco-circle"></div>
                <div class="deco-circle"></div>
            </div>
        </div>
        <div class="hero-slide" style="background: linear-gradient(135deg, #0099cc 0%, #006699 100%);">
            <div class="container">
                <div class="hero-content">
                    <div class="hero-badge">🏢 企業首選</div>
                    <h1>企業宣傳物料專家</h1>
                    <p>為您的品牌打造專業形象，從名片到包裝盒</p>
                    <div class="hero-features">
                        <span>✓ 500+ 企業客戶信賴</span>
                        <span>✓ 15年行業經驗</span>
                        <span>✓ 99%準時交貨</span>
                    </div>
                    <div class="hero-buttons">
                        <a href="#products" class="hero-btn primary">查看產品目錄</a>
                        <a href="#contact" class="hero-btn secondary">聯絡我們</a>
                    </div>
                </div>
            </div>
            <div class="hero-decoration">
                <div class="deco-circle"></div>
                <div class="deco-circle"></div>
            </div>
        </div>
    </div>
    <div class="hero-dots">
        <span class="dot active" data-slide="0"></span>
        <span class="dot" data-slide="1"></span>
    </div>
</section>

<!-- Services Overview -->
<section id="services" class="services-overview">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">我們的5大核心印刷服務</h2>
            <p class="section-subtitle">專注品質 · 客戶至上 · 快速交付</p>
        </div>
        <div class="services-grid">
            <div class="service-card" data-service="business-cards">
                <div class="service-icon">👔</div>
                <h3>名片印刷</h3>
                <p>啞膠、光膜、凹凸、燙金等多種工藝</p>
                <div class="service-meta">
                    <span class="delivery">1個工作天交貨</span>
                    <span class="price">$50/100張起</span>
                </div>
                <a href="#business-cards" class="service-link">了解更多 →</a>
            </div>
            <div class="service-card" data-service="flyers">
                <div class="service-icon">📄</div>
                <h3>宣傳單張</h3>
                <p>A5/A4/A3多尺寸，彩色/黑白可選</p>
                <div class="service-meta">
                    <span class="delivery">1個工作天交貨</span>
                    <span class="price">$0.3/張起</span>
                </div>
                <a href="#flyers" class="service-link">了解更多 →</a>
            </div>
            <div class="service-card" data-service="booklets">
                <div class="service-icon">📚</div>
                <h3>書刊印刷</h3>
                <p>騎馬釘、膠裝、線膠裝多种装订方式</p>
                <div class="service-meta">
                    <span class="delivery">2-3個工作天</span>
                    <span class="price">低至5折</span>
                </div>
                <a href="#booklets" class="service-link">了解更多 →</a>
            </div>
            <div class="service-card" data-service="envelopes">
                <div class="service-icon">✉️</div>
                <h3>信封印刷</h3>
                <p>彩色信封、C5/DL格式企業專用</p>
                <div class="service-meta">
                    <span class="delivery">2-4個工作天</span>
                    <span class="price">$260/100個起</span>
                </div>
                <a href="#envelopes" class="service-link">了解更多 →</a>
            </div>
            <div class="service-card" data-service="packaging">
                <div class="service-icon">📦</div>
                <h3>包裝盒印刷</h3>
                <p>禮品盒、產品包裝、定制刀模</p>
                <div class="service-meta">
                    <span class="delivery">5-7個工作天</span>
                    <span class="price">根據尺寸報價</span>
                </div>
                <a href="#packaging" class="service-link">了解更多 →</a>
            </div>
        </div>
    </div>
</section>

<!-- Detailed Services Section -->
<section id="business-cards" class="detailed-service">
    <div class="container">
        <div class="service-detail">
            <div class="service-images">
                <img src="https://trae-api-cn.mchost.guru/api/ide/v1/text_to_image?prompt=professional%20business%20cards%20print%20high%20quality%20design&image_size=landscape_4_3" alt="名片印刷" class="main-image" />
                <div class="image-gallery">
                    <img src="https://trae-api-cn.mchost.guru/api/ide/v1/text_to_image?prompt=matte%20finish%20business%20cards&image_size=square" alt="啞膠名片" />
                    <img src="https://trae-api-cn.mchost.guru/api/ide/v1/text_to_image?prompt=glossy%20business%20cards&image_size=square" alt="光膜名片" />
                    <img src="https://trae-api-cn.mchost.guru/api/ide/v1/text_to_image?prompt=gold%20foil%20business%20cards&image_size=square" alt="燙金名片" />
                </div>
            </div>
            <div class="service-content">
                <span class="service-label">服務一</span>
                <h2>名片印刷</h2>
                <p class="service-intro">專業名片印刷服務，提供多種紙質和加工選擇，讓您的第一印像與眾不同。</p>
                
                <div class="service-features">
                    <h4>可選紙質</h4>
                    <ul>
                        <li>300g 啞膠咭片 - 啞面質感，商務首選</li>
                        <li>300g 光膜咭片 - 光亮表面，色彩鮮豔</li>
                        <li>350g 特种紙 - 紋理紙張，獨特品味</li>
                        <li>FSC環保紙 - 環保認證，綠色選擇</li>
                    </ul>
                </div>
                
                <div class="service-features">
                    <h4>加工工藝</h4>
                    <ul>
                        <li>✅ 啞膠 / 光膠覆膜</li>
                        <li>✅ 局部UV</li>
                        <li>✅ 燙金 / 燙銀</li>
                        <li>✅ 凹凸压印</li>
                        <li>✅ 圓角切割</li>
                    </ul>
                </div>
                
                <div class="service-pricing">
                    <div class="price-table">
                        <div class="price-row header">
                            <span>規格</span>
                            <span>100張</span>
                            <span>500張</span>
                            <span>1000張</span>
                        </div>
                        <div class="price-row">
                            <span>啞膠咭片</span>
                            <span>$50</span>
                            <span>$180</span>
                            <span>$280</span>
                        </div>
                        <div class="price-row">
                            <span>光膜咭片</span>
                            <span>$50</span>
                            <span>$180</span>
                            <span>$280</span>
                        </div>
                        <div class="price-row">
                            <span>FSC環保咭片</span>
                            <span>$68</span>
                            <span>$250</span>
                            <span>$400</span>
                        </div>
                    </div>
                </div>
                
                <div class="service-actions">
                    <a href="#online-quote" class="btn btn-primary">立即報價</a>
                    <a href="#contact" class="btn btn-secondary">電話查詢</a>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="flyers" class="detailed-service alt-bg">
    <div class="container">
        <div class="service-detail reverse">
            <div class="service-content">
                <span class="service-label">服務二</span>
                <h2>宣傳單張印刷</h2>
                <p class="service-intro">高質量宣傳單張，適用於產品推廣、活動宣傳、公司介紹等多種用途。</p>
                
                <div class="service-features">
                    <h4>可選規格</h4>
                    <ul>
                        <li>A5 (148 x 210mm) - 方便派發</li>
                        <li>A4 (210 x 297mm) - 標準尺寸</li>
                        <li>A3 (297 x 420mm) - 大版面宣傳</li>
                        <li>自訂尺寸 - 按需定制</li>
                    </ul>
                </div>
                
                <div class="service-features">
                    <h4>紙質選擇</h4>
                    <ul>
                        <li>128g 銅版紙 - 經濟實惠</li>
                        <li>157g 銅版紙 - 質感適中</li>
                        <li>200g 啞粉紙 - 高級啞面</li>
                        <li>250g 啞粉紙 - 厚實耐用</li>
                    </ul>
                </div>
                
                <div class="service-highlights">
                    <div class="highlight-item">
                        <span class="highlight-number">600+</span>
                        <span class="highlight-label">張起印量</span>
                    </div>
                    <div class="highlight-item">
                        <span class="highlight-number">24h</span>
                        <span class="highlight-label">最速交貨</span>
                    </div>
                    <div class="highlight-item">
                        <span class="highlight-number">$315</span>
                        <span class="highlight-label">A5 600張</span>
                    </div>
                </div>
                
                <div class="service-actions">
                    <a href="#online-quote" class="btn btn-primary">立即報價</a>
                    <a href="#contact" class="btn btn-secondary">電話查詢</a>
                </div>
            </div>
            <div class="service-images">
                <img src="https://trae-api-cn.mchost.guru/api/ide/v1/text_to_image?prompt=professional%20flyer%20brochure%20print&image_size=landscape_4_3" alt="宣傳單張印刷" class="main-image" />
                <div class="image-gallery">
                    <img src="https://trae-api-cn.mchost.guru/api/ide/v1/text_to_image?prompt=color%20flyer%20printing&image_size=square" alt="彩色傳單" />
                    <img src="https://trae-api-cn.mchost.guru/api/ide/v1/text_to_image?prompt=black%20white%20flyer&image_size=square" alt="黑白傳單" />
                    <img src="https://trae-api-cn.mchost.guru/api/ide/v1/text_to_image?prompt=brochure%20printing&image_size=square" alt="宣傳冊" />
                </div>
            </div>
        </div>
    </div>
</section>

<section id="booklets" class="detailed-service">
    <div class="container">
        <div class="service-detail">
            <div class="service-images">
                <img src="https://trae-api-cn.mchost.guru/api/ide/v1/text_to_image?prompt=professional%20booklet%20catalog%20printing&image_size=landscape_4_3" alt="書刊印刷" class="main-image" />
                <div class="image-gallery">
                    <img src="https://trae-api-cn.mchost.guru/api/ide/v1/text_to_image?prompt=saddle%20stitch%20booklet&image_size=square" alt="騎馬釘書刊" />
                    <img src="https://trae-api-cn.mchost.guru/api/ide/v1/text_to_image?prompt=perfect%20bound%20book&image_size=square" alt="膠裝書" />
                    <img src="https://trae-api-cn.mchost.guru/api/ide/v1/text_to_image?prompt=spiral%20bound%20book&image_size=square" alt="線膠裝書" />
                </div>
            </div>
            <div class="service-content">
                <span class="service-label">服務三</span>
                <h2>書刊印刷</h2>
                <p class="service-intro">專業書刊印刷服務，提供多種装订方式，適合產品目錄、公司年報、培訓手冊等。</p>
                
                <div class="service-features">
                    <h4>装訂方式</h4>
                    <ul>
                        <li>騎馬釘 - 適合薄冊，成本經濟</li>
                        <li>膠裝 - 書脊平整，外觀專業</li>
                        <li>線膠裝 - 耐用美觀，可180度平展</li>
                        <li>精裝 - 高檔選擇，適用於正式場合</li>
                    </ul>
                </div>
                
                <div class="service-features">
                    <h4>尺寸選擇</h4>
                    <ul>
                        <li>A5 (148 x 210mm) - 輕巧便攜</li>
                        <li>A4 (210 x 297mm) - 標準辦公</li>
                        <li>210 x 210mm - 方形特規</li>
                        <li>自訂尺寸 - 按需定制</li>
                    </ul>
                </div>
                
                <div class="discount-banner">
                    <span class="discount-icon">🏷️</span>
                    <span class="discount-text">限时优惠：柯式騎馬釘書刊低至<b>5折</b>起！</span>
                    <span class="discount-deadline">優惠至月底</span>
                </div>
                
                <div class="service-actions">
                    <a href="#online-quote" class="btn btn-primary">立即報價</a>
                    <a href="#contact" class="btn btn-secondary">電話查詢</a>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="envelopes" class="detailed-service alt-bg">
    <div class="container">
        <div class="service-detail reverse">
            <div class="service-content">
                <span class="service-label">服務四</span>
                <h2>信封印刷</h2>
                <p class="service-intro">企業形象從細節做起，專業彩色信封印刷服務，提升企業品牌形象。</p>
                
                <div class="service-features">
                    <h4>可選格式</h4>
                    <ul>
                        <li>DL (220 x 110mm) - 商業信件標準</li>
                        <li>C5 (229 x 162mm) - A5信紙適用</li>
                        <li>C4 (324 x 229mm) - A4文件專用</li>
                        <li>4" x 9" / 4.5" - 美式標準</li>
                    </ul>
                </div>
                
                <div class="service-features">
                    <h4>紙質選擇</h4>
                    <ul>
                        <li>80g 書寫紙 - 經濟實惠</li>
                        <li>100g 書寫紙 - 質感較好</li>
                        <li>120g 啞粉紙 - 高檔印刷</li>
                        <li>白色/米色 可選</li>
                    </ul>
                </div>
                
                <div class="price-highlight">
                    <span class="price-from">$260</span>
                    <span class="price-unit">/ 100個起</span>
                    <span class="price-note">含彩色印刷</span>
                </div>
                
                <div class="service-actions">
                    <a href="#online-quote" class="btn btn-primary">立即報價</a>
                    <a href="#contact" class="btn btn-secondary">電話查詢</a>
                </div>
            </div>
            <div class="service-images">
                <img src="https://trae-api-cn.mchost.guru/api/ide/v1/text_to_image?prompt=professional%20envelope%20printing%20business&image_size=landscape_4_3" alt="信封印刷" class="main-image" />
                <div class="image-gallery">
                    <img src="https://trae-api-cn.mchost.guru/api/ide/v1/text_to_image?prompt=color%20envelope&image_size=square" alt="彩色信封" />
                    <img src="https://trae-api-cn.mchost.guru/api/ide/v1/text_to_image?prompt=white%20envelope&image_size=square" alt="白色信封" />
                    <img src="https://trae-api-cn.mchost.guru/api/ide/v1/text_to_image?prompt=business%20letterhead&image_size=square" alt="信紙" />
                </div>
            </div>
        </div>
    </div>
</section>

<section id="packaging" class="detailed-service">
    <div class="container">
        <div class="service-detail">
            <div class="service-images">
                <img src="https://trae-api-cn.mchost.guru/api/ide/v1/text_to_image?prompt=professional%20gift%20box%20packaging%20printing&image_size=landscape_4_3" alt="包裝盒印刷" class="main-image" />
                <div class="image-gallery">
                    <img src="https://trae-api-cn.mchost.guru/api/ide/v1/text_to_image?prompt=custom%20gift%20box&image_size=square" alt="禮品盒" />
                    <img src="https://trae-api-cn.mchost.guru/api/ide/v1/text_to_image?prompt=product%20packaging%20box&image_size=square" alt="產品盒" />
                    <img src="https://trae-api-cn.mchost.guru/api/ide/v1/text_to_image?prompt=paper%20bag%20printing&image_size=square" alt="紙袋" />
                </div>
            </div>
            <div class="service-content">
                <span class="service-label">服務五</span>
                <h2>包裝盒印刷</h2>
                <p class="service-intro">定制專屬包裝方案，從禮品盒到產品包裝，打造品牌形象的最後一環。</p>
                
                <div class="service-features">
                    <h4>包裝類型</h4>
                    <ul>
                        <li>禮品盒 - 珠寶、食品、化妝品</li>
                        <li>產品包裝盒 - 電子產品、玩具、生活用品</li>
                        <li>紙袋 - 手挽袋、購物袋</li>
                        <li>展示盒 - 陳列包裝、促銷包裝</li>
                    </ul>
                </div>
                
                <div class="service-features">
                    <h4>加工工藝</h4>
                    <ul>
                        <li>✅ 柯式印刷 - 色彩鮮豔</li>
                        <li>✅ 燙金/燙銀 - 高檔質感</li>
                        <li>✅ 局部UV - 突出重點</li>
                        <li>✅ 擊凸/壓紋 - 特殊效果</li>
                        <li>✅ 開窗工藝 - 展示產品</li>
                    </ul>
                </div>
                
                <div class="service-note">
                    <span class="note-icon">💡</span>
                    <span class="note-text">訂購數量500個以上，可享免費刀模設計！</span>
                </div>
                
                <div class="service-actions">
                    <a href="#online-quote" class="btn btn-primary">立即報價</a>
                    <a href="#contact" class="btn btn-secondary">電話查詢</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Online Quote Section -->
<section id="online-quote" class="online-quote-section">
    <div class="container">
        <div class="quote-wrapper">
            <div class="quote-header">
                <h2>🧮 在線即時報價</h2>
                <p>選擇服務類型，輸入尺寸和數量，即時獲取精確報價</p>
            </div>
            <div class="quote-form-container">
                <form class="quote-form" id="quoteForm">
                    <div class="form-section">
                        <h3>1️⃣ 選擇印刷服務</h3>
                        <div class="service-selector">
                            <label class="service-option">
                                <input type="radio" name="service_type" value="business-cards" checked>
                                <span class="option-content">
                                    <span class="option-icon">👔</span>
                                    <span class="option-name">名片印刷</span>
                                </span>
                            </label>
                            <label class="service-option">
                                <input type="radio" name="service_type" value="flyers">
                                <span class="option-content">
                                    <span class="option-icon">📄</span>
                                    <span class="option-name">宣傳單張</span>
                                </span>
                            </label>
                            <label class="service-option">
                                <input type="radio" name="service_type" value="booklets">
                                <span class="option-content">
                                    <span class="option-icon">📚</span>
                                    <span class="option-name">書刊印刷</span>
                                </span>
                            </label>
                            <label class="service-option">
                                <input type="radio" name="service_type" value="envelopes">
                                <span class="option-content">
                                    <span class="option-icon">✉️</span>
                                    <span class="option-name">信封印刷</span>
                                </span>
                            </label>
                            <label class="service-option">
                                <input type="radio" name="service_type" value="packaging">
                                <span class="option-content">
                                    <span class="option-icon">📦</span>
                                    <span class="option-name">包裝盒</span>
                                </span>
                            </label>
                        </div>
                    </div>
                    
                    <div class="form-section">
                        <h3>2️⃣ 填寫印刷要求</h3>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="quantity">印刷數量</label>
                                <select id="quantity" name="quantity">
                                    <option value="100">100張</option>
                                    <option value="200">200張</option>
                                    <option value="500" selected>500張</option>
                                    <option value="1000">1000張</option>
                                    <option value="2000">2000張</option>
                                    <option value="5000">5000張</option>
                                    <option value="10000">10000張</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="paper">紙質選擇</label>
                                <select id="paper" name="paper">
                                    <option value="matte">啞膠/啞粉紙</option>
                                    <option value="glossy">光膜/銅版紙</option>
                                    <option value="eco">環保紙</option>
                                    <option value="special">特種紙</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="size">尺寸</label>
                                <select id="size" name="size">
                                    <option value="standard">標準尺寸</option>
                                    <option value="custom">自訂尺寸</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="finishing">加工工藝</label>
                                <select id="finishing" name="finishing">
                                    <option value="none">無</option>
                                    <option value="lamination">覆膜</option>
                                    <option value="foil">燙金/銀</option>
                                    <option value="spot-uv">局部UV</option>
                                    <option value="emboss">凹凸压印</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-section">
                        <h3>3️⃣ 您的聯絡方式</h3>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="name">姓名 *</label>
                                <input type="text" id="name" name="name" required placeholder="請輸入您的姓名">
                            </div>
                            <div class="form-group">
                                <label for="phone">電話 *</label>
                                <input type="tel" id="phone" name="phone" required placeholder="+852 XXXX XXXX">
                            </div>
                        </div>
                        <div class="form-group full-width">
                            <label for="email">電郵 *</label>
                            <input type="email" id="email" name="email" required placeholder="your@email.com">
                        </div>
                        <div class="form-group full-width">
                            <label for="remarks">備註 (可上傳設計檔案)</label>
                            <textarea id="remarks" name="remarks" rows="3" placeholder="如有特殊要求或需要上傳設計檔案，請在此說明"></textarea>
                        </div>
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <span class="btn-icon">📨</span>
                            提交查詢
                        </button>
                        <p class="form-note">我們將在1個工作天內回覆您的報價查詢</p>
                    </div>
                </form>
                
                <div class="quote-aside">
                    <div class="aside-section">
                        <h4>📞 其他報價方式</h4>
                        <div class="contact-methods">
                            <div class="contact-item">
                                <span class="contact-icon">📱</span>
                                <div class="contact-info">
                                    <strong>致電我們</strong>
                                    <a href="tel:+85226906288">+852 2690 6288</a>
                                </div>
                            </div>
                            <div class="contact-item">
                                <span class="contact-icon">✉️</span>
                                <div class="contact-info">
                                    <strong>電郵報價</strong>
                                    <a href="mailto:quote@goprint.com.hk">quote@goprint.com.hk</a>
                                </div>
                            </div>
                            <div class="contact-item">
                                <span class="contact-icon">💬</span>
                                <div class="contact-info">
                                    <strong>WhatsApp</strong>
                                    <a href="https://wa.me/85226906288">+852 2690 6288</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="aside-section">
                        <h4>⏰ 服務承諾</h4>
                        <ul class="service-promises">
                            <li>✓ 報價回覆：1個工作天內</li>
                            <li>✓ 標準訂單：1-3個工作天交貨</li>
                            <li>✓ 加急服務：24小時可選</li>
                            <li>✓ 免費修改：一次免費修改</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Why Choose Us -->
<section class="why-choose-us">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">為什麼選擇Go Print？</h2>
            <p class="section-subtitle">專業、高效、可靠 - 您值得信賴的印刷夥伴</p>
        </div>
        <div class="advantages-grid">
            <div class="advantage-card">
                <div class="advantage-icon">⚡</div>
                <h3>快速交付</h3>
                <p>標準訂單1-3個工作天，加急服務24小時可選</p>
            </div>
            <div class="advantage-card">
                <div class="advantage-icon">💰</div>
                <h3>價格優惠</h3>
                <p>工廠直銷，沒有中間商，保証全港最優惠價格</p>
            </div>
            <div class="advantage-card">
                <div class="advantage-icon">✨</div>
                <h3>品質保証</h3>
                <p>採用進口設備和材料，嚴格品質控制</p>
            </div>
            <div class="advantage-card">
                <div class="advantage-icon">🎨</div>
                <h3>免費設計</h3>
                <p>專業設計團隊提供免費設計諮詢服務</p>
            </div>
            <div class="advantage-card">
                <div class="advantage-icon">🔄</div>
                <h3>靈活訂購</h3>
                <p>小批量訂單也可承接，100張起印</p>
            </div>
            <div class="advantage-card">
                <div class="advantage-icon">🚚</div>
                <h3>送貨服務</h3>
                <p>全港免運費（偏遠地區除外），工商區優先</p>
            </div>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="stats-section">
    <div class="container">
        <div class="stats-grid">
            <div class="stat-item">
                <span class="stat-number">15+</span>
                <span class="stat-label">年行業經驗</span>
            </div>
            <div class="stat-item">
                <span class="stat-number">500+</span>
                <span class="stat-label">企業客戶</span>
            </div>
            <div class="stat-item">
                <span class="stat-number">10,000+</span>
                <span class="stat-label">已完成訂單</span>
            </div>
            <div class="stat-item">
                <span class="stat-number">99%</span>
                <span class="stat-label">準時交貨</span>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials -->
<section class="testimonials-section">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">客戶評價</h2>
            <p class="section-subtitle">听听他们怎么说</p>
        </div>
        <div class="testimonials-grid">
            <div class="testimonial-card">
                <div class="testimonial-rating">⭐⭐⭐⭐⭐</div>
                <p class="testimonial-text">"Go Print的服務非常專業，名片印刷品質一流，交貨速度快，下次一定再合作！"</p>
                <div class="testimonial-author">
                    <div class="author-avatar">陳</div>
                    <div class="author-info">
                        <strong>陳先生</strong>
                        <span>某上市公司市場總監</span>
                    </div>
                </div>
            </div>
            <div class="testimonial-card">
                <div class="testimonial-rating">⭐⭐⭐⭐⭐</div>
                <p class="testimonial-text">"包裝盒的質量超出預期，工廠師傅很有耐心，幫我們解決了好幾個設計上的問題。"</p>
                <div class="testimonial-author">
                    <div class="author-avatar">李</div>
                    <div class="author-info">
                        <strong>李小姐</strong>
                        <span>某珠寶品牌負責人</span>
                    </div>
                </div>
            </div>
            <div class="testimonial-card">
                <div class="testimonial-rating">⭐⭐⭐⭐⭐</div>
                <p class="testimonial-text">"第一次合作就被他們的專業度感動，書刊印刷精美，價格也很合理，性價比極高！"</p>
                <div class="testimonial-author">
                    <div class="author-avatar">王</div>
                    <div class="author-info">
                        <strong>王總</strong>
                        <span>某培訓機構創辦人</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section id="contact" class="contact-section">
    <div class="container">
        <div class="contact-wrapper">
            <div class="contact-info">
                <h2>聯絡我們</h2>
                <p>立即聯絡我們，獲取專業印刷建議</p>
                
                <div class="contact-details">
                    <div class="contact-item">
                        <span class="contact-icon">📞</span>
                        <div class="contact-content">
                            <strong>電話</strong>
                            <a href="tel:+85226906288">+852 2690 6288</a>
                        </div>
                    </div>
                    <div class="contact-item">
                        <span class="contact-icon">✉️</span>
                        <div class="contact-content">
                            <strong>電郵</strong>
                            <a href="mailto:info@goprint.com.hk">info@goprint.com.hk</a>
                        </div>
                    </div>
                    <div class="contact-item">
                        <span class="contact-icon">💬</span>
                        <div class="contact-content">
                            <strong>WhatsApp</strong>
                            <a href="https://wa.me/85226906288">+852 2690 6288</a>
                        </div>
                    </div>
                    <div class="contact-item">
                        <span class="contact-icon">📍</span>
                        <div class="contact-content">
                            <strong>地址</strong>
                            <span>九龍觀塘成業街16號<br>怡生工業中心A座8樓</span>
                        </div>
                    </div>
                    <div class="contact-item">
                        <span class="contact-icon">🕐</span>
                        <div class="contact-content">
                            <strong>服務時間</strong>
                            <span>星期一至五: 9:00-18:00<br>星期六: 9:00-13:00</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="contact-map">
                <div class="map-placeholder">
                    <span class="map-icon">🗺️</span>
                    <p>地圖加載中...</p>
                    <small>九龍觀塘成業街16號怡生工業中心</small>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Footer -->
<footer class="main-footer">
    <div class="container">
        <div class="footer-content">
            <div class="footer-section brand">
                <div class="footer-logo">
                    <span class="logo-icon">🖨️</span>
                    <span class="logo-text">Go Print</span>
                </div>
                <p>專業印刷服務供應商，為您的品牌打造完美形象。</p>
                <div class="social-links">
                    <a href="#" class="social-link">Facebook</a>
                    <a href="#" class="social-link">Instagram</a>
                    <a href="#" class="social-link">WhatsApp</a>
                </div>
            </div>
            <div class="footer-section">
                <h4>印刷服務</h4>
                <ul>
                    <li><a href="#business-cards">名片印刷</a></li>
                    <li><a href="#flyers">宣傳單張</a></li>
                    <li><a href="#booklets">書刊印刷</a></li>
                    <li><a href="#envelopes">信封印刷</a></li>
                    <li><a href="#packaging">包裝盒印刷</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h4>客戶服務</h4>
                <ul>
                    <li><a href="#online-quote">網上報價</a></li>
                    <li><a href="#">訂單查詢</a></li>
                    <li><a href="#">送貨安排</a></li>
                    <li><a href="#">常見問題</a></li>
                    <li><a href="#contact">聯絡我們</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h4>聯絡資訊</h4>
                <ul>
                    <li>📞 +852 2690 6288</li>
                    <li>✉️ info@goprint.com.hk</li>
                    <li>📍 九龍觀塘成業街16號</li>
                    <li>🕐 星期一至五 9:00-18:00</li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>© 2024 Go Print Hong Kong. All rights reserved. | <a href="#">私隱政策</a> | <a href="#">使用條款</a></p>
        </div>
    </div>
</footer>

<!-- Back to Top Button -->
<div class="back-to-top" id="backToTop">
    <span>↑</span>
</div>

<?php get_footer(); ?>
