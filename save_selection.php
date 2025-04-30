<?php
$mysqli = new mysqli("localhost", "root", "", "price_monitor");

$model_id = $_POST['model_id'];
$product_id = $_POST['product_id'];

$stmt = $mysqli->prepare("INSERT INTO monitored_products (product_id, model_id) VALUES (?, ?)");
$stmt->bind_param("ss", $product_id, $model_id);
$stmt->execute();

echo "已設定監控！";
?>
