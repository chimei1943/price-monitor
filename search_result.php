<?php
if (isset($_GET['q'])) {
  $query = urlencode($_GET['q']);
  // 假資料（之後會改成真的從蝦皮搜尋）
  $products = [
    ["id" => "111", "title" => "S洗髮精 400ml", "price" => 249],
    ["id" => "112", "title" => "S洗髮精 800ml", "price" => 399],
  ];
  echo "<h2>搜尋結果：</h2>";
  foreach ($products as $p) {
    echo "<div><b>{$p['title']}</b> - \${$p['price']} 
    <a href='product_detail.php?id={$p['id']}'>查看選項</a></div>";
  }
}
?>
