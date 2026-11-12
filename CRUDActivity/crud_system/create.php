
<?php
require_once "config.php";

$mode = "create";

$user = [
    "Firstname" => "",
    "Lastname" => "",
    "Middlename" => "",
    "Birthdate" => "",
    "Gender" => "",
    "Email" => ""
];

$selectedCourses = [];
$errorMessage = "";

$stmt = $conn->prepare("
    SELECT Course_ID, name, course_code, status
    FROM Course
    WHERE status = 'on'
    ORDER BY name
");

$stmt->execute();

$result = $stmt->get_result();
$courses = $result->fetch_all(MYSQLI_ASSOC);

require "form.php";
?>
