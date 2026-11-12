
<?php
require_once "config.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: index.php");
    exit;
}

$firstname = trim($_POST["Firstname"] ?? "");
$lastname = trim($_POST["Lastname"] ?? "");
$middlename = trim($_POST["Middlename"] ?? "");
$birthdate = trim($_POST["Birthdate"] ?? "");
$gender = trim($_POST["Gender"] ?? "");
$email = trim($_POST["Email"] ?? "");

$courseIDs = [];

if (isset($_POST["courses"]) && is_array($_POST["courses"])) {
    foreach ($_POST["courses"] as $courseID) {

        $courseID = filter_var($courseID, FILTER_VALIDATE_INT);

        if ($courseID !== false && $courseID > 0) {
            $courseIDs[] = $courseID;
        }
    }
}

$courseIDs = array_unique($courseIDs);

if (
    $firstname === "" ||
    $lastname === "" ||
    $birthdate === "" ||
    $gender === "" ||
    $email === ""
) {
    die("Please complete all required fields. <a href='create.php'>Go back</a>.");
}

if (!in_array($gender, ["Male", "Female", "Other"], true)) {
    die("Invalid gender selected. <a href='create.php'>Go back</a>.");
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("Please enter a valid email address. <a href='create.php'>Go back</a>.");
}

$dateObject = DateTime::createFromFormat("Y-m-d", $birthdate);

if (
    !$dateObject ||
    $dateObject->format("Y-m-d") !== $birthdate ||
    $birthdate > date("Y-m-d")
) {
    die("Please enter a valid birthdate. <a href='create.php'>Go back</a>.");
}

$stmt = $conn->prepare("
    SELECT user_ID
    FROM `User`
    WHERE Email = ?
");

$stmt->bind_param("s", $email);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows > 0) {
    die("Email address already exists. <a href='create.php'>Go back</a>.");
}

try {

    $conn->begin_transaction();

    $checkCourse = $conn->prepare("
        SELECT Course_ID
        FROM Course
        WHERE Course_ID = ?
        AND status = 'on'
    ");

    foreach ($courseIDs as $courseID) {

        $checkCourse->bind_param("i", $courseID);
        $checkCourse->execute();

        $result = $checkCourse->get_result();

        if ($result->num_rows === 0) {
            throw new Exception("One or more selected courses are invalid or inactive.");
        }
    }

    $sql = "
        INSERT INTO `User`
        (
            Firstname,
            Lastname,
            Middlename,
            Birthdate,
            Gender,
            Email
        )
        VALUES (?, ?, ?, ?, ?, ?)
    ";

    $stmt = $conn->prepare($sql);

    $middlenameValue = ($middlename === "") ? null : $middlename;

    $stmt->bind_param(
        "ssssss",
        $firstname,
        $lastname,
        $middlenameValue,
        $birthdate,
        $gender,
        $email
    );

    $stmt->execute();

    $userID = $conn->insert_id;

    $insertCourse = $conn->prepare("
        INSERT INTO User_Course (user_ID, course_ID)
        VALUES (?, ?)
    ");

    foreach ($courseIDs as $courseID) {

        $insertCourse->bind_param("ii", $userID, $courseID);
        $insertCourse->execute();
    }

    $conn->commit();

    header("Location: index.php?notice=added");
    exit;

} catch (Exception $e) {

    $conn->rollback();

    if ($e instanceof mysqli_sql_exception && $e->getCode() == 1062) {
        die("This email address already exists. <a href='create.php'>Go back</a>.");
    }

    die("Unable to add user. " . clean($e->getMessage()) . " <a href='create.php'>Go back</a>.");
}
?>
