
<?php
require_once "config.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: index.php");
    exit;
}

$id = filter_input(INPUT_POST, "user_ID", FILTER_VALIDATE_INT);

if (!$id || $id <= 0) {
    header("Location: index.php");
    exit;
}

$stmt = $conn->prepare("
    DELETE FROM `User`
    WHERE user_ID = ?
");

$stmt->bind_param("i", $id);
$stmt->execute();

header("Location: index.php?notice=deleted");
exit;
?>
