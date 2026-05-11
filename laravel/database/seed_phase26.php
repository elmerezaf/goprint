<?php
/**
 * GoPrint Database Seeder - Phase 26
 * Inserts expanded product categories and products for the printing platform.
 */
$conn = new mysqli('localhost', 'root', '', 'goprint_db');
$conn->set_charset('utf8mb4');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "Seeding categories and products...\n";

// ---------- Categories ----------
$categories = [
    [3, '宣傳單張印刷', '傳單、摺頁、單張等各類宣傳印刷品'],
    [4, '書本印刷', '書刊、雜誌、畫冊、說明書等書本類印刷'],
    [5, '貼紙印刷', '各類不乾膠貼紙、透明貼紙、標籤印刷'],
    [6, '海報印刷', '各類海報、展板、橫額等大幅面印刷'],
    [7, '信封文儀', '信封、信紙、公文袋等辦公室文儀印刷'],
    [8, '橫額展架', '戶外橫額、易拉架、展板等展示器材印刷'],
];

$stmt = $conn->prepare("INSERT IGNORE INTO category (cat_id, cat_name, cat_desc, create_time) VALUES (?, ?, ?, NOW())");
foreach ($categories as $cat) {
    $stmt->bind_param('iss', $cat[0], $cat[1], $cat[2]);
    $stmt->execute();
    echo "  Category: {$cat[1]}\n";
}
$stmt->close();

// ---------- Products ----------
$products = [
    // cat_id=1 商務印刷
    [6, 1, '商務名片套裝', 188.00, 999, '500張名片，300g銅版紙，專版UV印刷，免費設計', ''],
    [7, 1, '畫冊印刷', 350.00, 500, '騎馬釘裝訂，全彩色印刷，200g啞粉紙', ''],
    [8, 1, '書刊雜誌印刷', 280.00, 500, 'A4尺寸，封面過膠，內頁80g書紙', ''],

    // cat_id=2 包裝設計
    [9, 2, '禮品包裝盒', 399.00, 300, '特殊紙質，燙金Logo，可選多種材質', ''],
    [10, 2, '手提紙袋', 250.00, 800, '200g白卡紙，彩色印刷，可加繩', ''],
    [11, 2, '彩盒印刷', 320.00, 400, '瓦楞彩盒，UV印刷，農曆新年前優惠', ''],

    // cat_id=3 宣傳單張
    [12, 3, 'A5宣傳單張', 120.00, 999, '1000張，157g銅版紙，雙面彩色印刷', ''],
    [13, 3, 'A4三摺頁', 180.00, 999, '200g啞粉紙，風琴摺，適合產品介紹', ''],
    [14, 3, '雙面傳單', 90.00, 999, 'A5尺寸，128g銅版紙，特價快速印刷', ''],
    [15, 3, 'A4單張', 150.00, 999, '1000張，157g銅版紙，專業色彩管理', ''],

    // cat_id=4 書本印刷
    [16, 4, '膠裝書刊', 450.00, 300, 'A5尺寸，封面彩色內頁黑白，專業膠裝', ''],
    [17, 4, '精裝書', 600.00, 200, '硬皮精裝，全彩色印刷，書脊燙金', ''],
    [18, 4, '騎馬釘小冊子', 220.00, 500, 'A4騎馬釘，8-16頁，封面過膠', ''],
    [19, 4, '說明書印刷', 180.00, 800, 'A5騎馬釘，黑白印刷，批量優惠', ''],

    // cat_id=5 貼紙印刷
    [20, 5, '圓形貼紙', 80.00, 999, '1000張，防水PVC，可選多種尺寸', ''],
    [21, 5, '條形碼標籤', 120.00, 999, '不乾膠，白底黑字，可連號', ''],
    [22, 5, '透明貼紙', 150.00, 999, '全透明PVC，彩色印刷，防水防曬', ''],
    [23, 5, '啞面貼紙', 110.00, 999, '啞面不乾膠，高級質感，適合Logo', ''],

    // cat_id=6 海報印刷
    [24, 6, 'A2海報', 50.00, 999, '200g啞粉紙，單面印刷，高清彩色', ''],
    [25, 6, 'A1戶外海報', 80.00, 999, 'PP防水紙，彩色印刷，抗紫外線', ''],
    [26, 6, 'Foamboard展板', 120.00, 200, 'KT板裱貼，邊緣包邊，可加支架', ''],
    [27, 6, 'A3海報', 35.00, 999, '200g銅版紙，單面印刷，最快當日可取', ''],

    // cat_id=7 信封文儀
    [28, 7, '彩色信封', 200.00, 999, 'DL尺寸，1000個，彩色印刷', ''],
    [29, 7, '信紙本', 160.00, 600, 'A4尺寸，100頁/本，80g書紙', ''],
    [30, 7, '公文袋', 250.00, 800, '牛皮紙，A4尺寸，可印公司Logo', ''],
    [31, 7, '長形信封', 180.00, 999, '9號長形信封，1000個', ''],

    // cat_id=8 橫額展架
    [32, 8, '戶外橫額', 300.00, 200, '防水帆布，熱升華印刷，包繩及袋', ''],
    [33, 8, 'X架易拉架', 180.00, 150, '防水PP，彩色印刷，包便攜支架', ''],
    [34, 8, '背景板噴畫', 500.00, 100, '戶外噴畫，包鋁架及安裝，適合活動', ''],
    [35, 8, '掛畫海報', 220.00, 200, '防水布料，上下掛軸，可摺疊收藏', ''],
];

$stmt = $conn->prepare("INSERT IGNORE INTO product (pro_id, cat_id, pro_name, pro_price, pro_stock, pro_desc, create_time) VALUES (?, ?, ?, ?, ?, ?, NOW())");
foreach ($products as $p) {
    $stmt->bind_param('iisdss', $p[0], $p[1], $p[2], $p[3], $p[4], $p[5]);
    $stmt->execute();
    echo "  Product: {$p[2]}\n";
}
$stmt->close();

// ---------- Verify ----------
$r = $conn->query("SELECT COUNT(*) as c FROM category");
echo "\nTotal categories: " . $r->fetch_assoc()['c'] . "\n";
$r = $conn->query("SELECT COUNT(*) as c FROM product");
echo "Total products: " . $r->fetch_assoc()['c'] . "\n";

$conn->close();
echo "\nSeeding completed successfully!\n";
