
<?php
require_once "config.php";

// Get user ID
$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

if (!$id || $id <= 0) {
    header("Location: index.php");
    exit;
}

$stmt = $conn->prepare("
    SELECT *
    FROM `User`
    WHERE user_ID = ?
");

$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    die("User not found. <a href='index.php'>Return to records</a>.");
}

$stmt = $conn->prepare("
    SELECT course_ID
    FROM User_Course
    WHERE user_ID = ?
");

$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();

$selectedCourses = [];

while ($row = $result->fetch_assoc()) {
    $selectedCourses[] = (int)$row["course_ID"];
}

$stmt = $conn->prepare("
    SELECT Course_ID, name, course_code, status
    FROM Course
    ORDER BY name
");

$stmt->execute();

$result = $stmt->get_result();
$courses = $result->fetch_all(MYSQLI_ASSOC);

$mode = "edit";
$errorMessage = "";

require "form.php";
?>
