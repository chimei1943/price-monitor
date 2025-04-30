<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>設定商品價格監控</title>
</head>
<body>
  <h2>🛒 設定商品價格監控</h2>

  <form method="GET" action="">
    <label>貼上蝦皮商品網址：</label><br>
    <input type="text" name="url" style="width: 400px;" required>
    <br><br>
    <button type="submit">解析網址 → 輸入商品選項</button>
  </form>

  <hr>

  <?php
  if (isset($_GET['url'])) {
      $url = $_GET['url'];
      $pattern = '/(?:i|product)\.(\d+)\.(\d+)/';
      if (preg_match($pattern, $url, $matches)) {
          $shopid = $matches[1];
          $itemid = $matches[2];
      } else {
          echo "<p style='color:red;'>❌ 無法從網址解析出 shopid 和 itemid，請檢查格式。</p>";
          exit;
      }
  ?>

  <form action="save_selection.php" method="POST">
    <input type="hidden" name="shopid" value="<?= $shopid ?>">
    <input type="hidden" name="itemid" value="<?= $itemid ?>">

    <label>商品名稱：</label><br>
    <input type="text" name="product_name" required><br><br>

    <label>選項名稱（如：#01 白皙色）：</label><br>
    <input type="text" name="option_name"><br><br>

    <label>模型 ID（可空白）：</label><br>
    <input type="text" name="model_id"><br><br>

    <label>目標價格（元）：</label><br>
    <input type="number" name="target_price"><br><br>

    <button type="submit">✅ 加入監控清單</button>
  </form>

  <?php } ?>

</body>
</html>

