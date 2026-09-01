<?php
$price = $_GET['price'];
$discountRate = 0.0;
if ($price < 50) {
    $discountRate = 0.0;
} elseif ($price >= 50 && $price <= 99.99) {
    $discountRate = 0.10;
} elseif ($price >= 100 && $price <= 199.99) {
    $discountRate = 0.15;
} else {
    $discountRate = 0.20;
}
$discountAmount = $price * $discountRate;
$finalPrice = $price - $discountAmount;
echo "Original Price: P" . number_format($price, 2) . "<br>";
echo "Discount Amount: P" . number_format($discountAmount, 2) . "<br>";
echo "Final Price: P" . number_format($finalPrice, 2) . "<br>";
?>