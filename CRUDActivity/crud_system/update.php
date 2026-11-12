
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
    die("Please complete all required fields. <a href='edit.php?id=$id'>Go back</a>.");
}

if (!in_array($gender, ["Male", "Female", "Other"], true)) {
    die("Invalid gender selected. <a href='edit.php?id=$id'>Go back</a>.");
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("Please enter a valid email address. <a href='edit.php?id=$id'>Go back</a>.");
}

$dateObject = DateTime::createFromFormat("Y-m-d", $birthdate);

if (
    !$dateObject ||
    $dateObject->format("Y-m-d") !== $birthdate ||
    $birthdate > date("Y-m-d")
) {
    die("Please enter a valid birthdate. <a href='edit.php?id=$id'>Go back</a>.");
}

$stmt = $conn->prepare("
    SELECT user_ID
    FROM `User`
    WHERE Email = ?
    AND user_ID <> ?
");

$stmt->bind_param("si", $email, $id);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows > 0) {
    die("Email address already belongs to another user. <a href='edit.php?id=$id'>Go back</a>.");
}

try {

    $conn->begin_transaction();

    $stmt = $conn->prepare("
        SELECT user_ID
        FROM `User`
        WHERE user_ID = ?
    ");

    $stmt->bind_param("i", $id);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        throw new Exception("User not found.");
    }

    $checkCourse = $conn->prepare("
        SELECT Course_ID
        FROM Course
        WHERE Course_ID = ?
    ");

    foreach ($courseIDs as $courseID) {

        $checkCourse->bind_param("i", $courseID);
        $checkCourse->execute();

        $result = $checkCourse->get_result();

        if ($result->num_rows === 0) {
            throw new Exception("One or more selected courses do not exist.");
        }
    }

    $sql = "
        UPDATE `User`
        SET
            Firstname = ?,
            Lastname = ?,
            Middlename = ?,
            Birthdate = ?,
            Gender = ?,
            Email = ?
        WHERE user_ID = ?
    ";

    $stmt = $conn->prepare($sql);

    $middlenameValue = ($middlename === "") ? null : $middlename;

    $stmt->bind_param(
        "ssssssi",
        $firstname,
        $lastname,
        $middlenameValue,
        $birthdate,
        $gender,
        $email,
        $id
    );

    $stmt->execute();

    $stmt = $conn->prepare("
        DELETE FROM User_Course
        WHERE user_ID = ?
    ");

    $stmt->bind_param("i", $id);
    $stmt->execute();

    $insertCourse = $conn->prepare("
        INSERT INTO User_Course (user_ID, course_ID)
        VALUES (?, ?)
    ");

    foreach ($courseIDs as $courseID) {

        $insertCourse->bind_param("ii", $id, $courseID);
        $insertCourse->execute();
    }

    $conn->commit();

    header("Location: index.php?notice=updated");
    exit;

} catch (Exception $e) {

    $conn->rollback();

    if ($e instanceof mysqli_sql_exception && $e->getCode() == 1062) {
        die("This email address already exists. <a href='edit.php?id=$id'>Go back</a>.");
    }

    die("Unable to update user. <a href='edit.php?id=$id'>Go back</a>.");
}
?>
