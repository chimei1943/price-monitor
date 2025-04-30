<?php
// 連線資料庫
$mysqli = new mysqli("localhost", "root", "", "price_monitor");
if ($mysqli->connect_error) {
    die("連線失敗：" . $mysqli->connect_error);
}

// 抓出最新一筆監控商品
$result = $mysqli->query("SELECT * FROM monitored_products ORDER BY id DESC LIMIT 1");
if (!$result || $result->num_rows === 0) {
    die("❌ 資料庫沒有商品可以監控");
}

$row = $result->fetch_assoc();

// 模擬「目前市價」（實際應改為爬蟲抓蝦皮）
$simulated_current_price = rand(200, 800);  // 隨機一個價格，模擬用
$target_price = $row['target_price'];

echo "<h3>📦 商品：{$row['product_name']}</h3>";
echo "<p>目標價格：$target_price 元</p>";
echo "<p>目前價格（模擬）：$simulated_current_price 元</p>";

if ($simulated_current_price <= $target_price) {
    echo "<p style='color:green;'>✅ 價格符合條件，建議進行價格調整或通知！</p>";
} else {
    echo "<p style='color:gray;'>⏳ 價格尚未低於目標，暫不通知。</p>";
}
