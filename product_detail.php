<?php
// 取得網址參數
$shopid = $_GET['shopid'] ?? '';
$itemid = $_GET['itemid'] ?? '';

if (!$shopid || !$itemid) {
    echo "請提供正確的 shopid 與 itemid";
    exit;
}

// 呼叫蝦皮 API
$url = "https://shopee.tw/api/v4/item/get?itemid={$itemid}&shopid={$shopid}";
$ch = curl_init($url);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64)',
    'Referer: https://shopee.tw/'
]);

$response = curl_exec($ch);
curl_close($ch);

// ❗ debug 用：印出原始回應（成功後可註解掉）
echo "<pre style='background:#eee;padding:1em;border:1px solid #ccc;'>原始回應（除錯用）：\n";
print_r($response);
echo "</pre>";

$data = json_decode($response, true);

// 檢查是否成功抓到 models
if (!isset($data['data']['models']) || empty($data['data']['models'])) {
    echo "<p style='color:red;'>❌ 抓不到商品選項，可能原因：</p>";
    echo "<ul>
            <li>1. 商品已下架或ID錯誤</li>
            <li>2. 蝦皮API阻擋（限制IP、要求登入）</li>
            <li>3. 回傳格式已改變</li>
          </ul>";
    exit;
}

// 顯示選項
$models = $data['data']['models'];

echo "<h2>選擇你要監控的規格：</h2>";
echo "<form action='save_selection.php' method='POST'>";
echo "<input type='hidden' name='product_id' value='{$itemid}'>";

foreach ($models as $m) {
    $name = htmlspecialchars($m['name']);
    $price = $m['price'] / 100000; // 轉換為 NT$
    $model_id = $m['model_id'];
    echo "<label><input type='radio' name='model_id' value='{$model_id}'> {$name} - NT\${$price}</label><br>";
}

echo "<button type='submit'>開始監控</button>";
echo "</form>";
?>
