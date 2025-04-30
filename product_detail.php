<!DOCTYPE html>
<html lang="zh-Hant">
<head>
  <meta charset="UTF-8">
  <title>輸入商品網址並設定監控</title>
</head>
<body>
  <h2>🛒 設定商品價格監控</h2>

  <?php
  $shopid = '';
  $itemid = '';
  $error = '';

  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['shopee_url'])) {
      $url = $_POST['shopee_url'] ?? '';

      // 嘗試解析網址中 .i.shopid.itemid 結構
      if (preg_match('/\.i\.(\d+)\.(\d+)/', $url, $matches)) {
          $shopid = $matches[1];
          $itemid = $matches[2];
      } elseif (preg_match('/\/product\/(\d+)\/(\d+)/', $url, $matches)) {
          $shopid = $matches[1];
          $itemid = $matches[2];
      } else {
          $error = "❌ 無法從網址解析出 shopid 與 itemid。請確認網址格式正確。";
      }
  }
  ?>

  <form method="POST">
    <label>貼上蝦皮商品網址：</label><br>
    <input type="text" name="shopee_url" style="width:400px" required
           value="<?= htmlspecialchars($_POST['shopee_url'] ?? '') ?>"><br><br>
    <button type="submit">解析網址 ➜ 輸入商品選項</button>
  </form>

  <hr>

  <?php if ($shopid && $itemid): ?>
    <form method="POST" action="save_selection.php">
      <input type="hidden" name="shopid" value="<?= $shopid ?>">
      <input type="hidden" name="product_id" value="<?= $itemid ?>">

      <label>商品名稱（可自訂）：</label><br>
      <input type="text" name="product_name" required><br><br>

      <label>選項名稱（例：#01 白皙色）</label><br>
      <input type="text" name="option_name" required><br><br>

      <label>模型 ID（可選填）：</label><br>
      <input type="text" name="model_id"><br><br>

      <label>目標價格（可選填）：</label><br>
      <input type="number" name="target_price"><br><br>

      <button type="submit">✅ 加入監控清單</button>
    </form>
  <?php elseif ($error): ?>
    <p style="color:red"><?= $error ?></p>
  <?php endif; ?>
</body>
</html>
