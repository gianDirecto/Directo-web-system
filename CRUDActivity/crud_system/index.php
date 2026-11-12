
<?php
require_once "config.php";

$keyword = trim($_GET["keyword"] ?? "");
$gender = $_GET["gender"] ?? "";
$dateCreated = $_GET["date_created"] ?? "";

// Validate gender
if (!in_array($gender, ["", "Male", "Female", "Other"], true)) {
    $gender = "";
}

if ($dateCreated !== "") {
    $dateObject = DateTime::createFromFormat("Y-m-d", $dateCreated);

    if (!$dateObject || $dateObject->format("Y-m-d") !== $dateCreated) {
        $dateCreated = "";
    }
}

$searchValue = "%" . $keyword . "%";

$sql = "
    SELECT
        u.user_ID,
        u.Firstname,
        u.Lastname,
        u.Middlename,
        u.Birthdate,
        u.Gender,
        u.Email,
        u.date_created,

        GROUP_CONCAT(
            DISTINCT CONCAT(
                c.name,
                ' (', c.course_code, ') - ',
                COALESCE(c.description, ''),
                ' [', c.status, ']'
            )
            ORDER BY c.name
            SEPARATOR ' | '
        ) AS course_details

    FROM `User` u

    LEFT JOIN User_Course uc
        ON u.user_ID = uc.user_ID

    LEFT JOIN Course c
        ON uc.course_ID = c.Course_ID

    WHERE
        (
            ? = ''
            OR u.Firstname LIKE ?
            OR u.Lastname LIKE ?
            OR u.Middlename LIKE ?

            OR EXISTS (
                SELECT 1
                FROM User_Course uc2
                INNER JOIN Course c2
                    ON uc2.course_ID = c2.Course_ID
                WHERE uc2.user_ID = u.user_ID
                AND (
                    c2.description LIKE ?
                    OR c2.course_code LIKE ?
                )
            )
        )

        AND (? = '' OR u.Gender = ?)

        AND (? = '' OR DATE(u.date_created) = ?)

    GROUP BY
        u.user_ID,
        u.Firstname,
        u.Lastname,
        u.Middlename,
        u.Birthdate,
        u.Gender,
        u.Email,
        u.date_created

    ORDER BY u.user_ID DESC
";

$stmt = $conn->prepare($sql);

$stmt->bind_param(
    "ssssssssss",
    $keyword,
    $searchValue,
    $searchValue,
    $searchValue,
    $searchValue,
    $searchValue,
    $gender,
    $gender,
    $dateCreated,
    $dateCreated
);

$stmt->execute();

$result = $stmt->get_result();

$users = $result->fetch_all(MYSQLI_ASSOC);

$notice = $_GET["notice"] ?? "";
$message = "";

if ($notice === "added") {
    $message = "User successfully added.";
} elseif ($notice === "updated") {
    $message = "User successfully updated.";
} elseif ($notice === "deleted") {
    $message = "User successfully deleted.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>User Management System</title>

    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">

    <div class="page-header">
        <div>
            <p class="eyebrow">ADMINISTRATION</p>
            <h1>User Management System</h1>
            <p class="subtitle">
                Manage user information and their associated courses.
            </p>
        </div>

        <a href="create.php" class="button button-primary">
            + Add New User
        </a>
    </div>

    <?php if ($message !== ""): ?>
        <div class="alert alert-success">
            <?= clean($message) ?>
        </div>
    <?php endif; ?>


    <div class="panel">

        <div class="section-heading">
            <div>
                <h2>Search and Filters</h2>
                <p>Find users using keywords, gender, or creation date.</p>
            </div>
        </div>

        <form method="GET" action="index.php">

            <div class="filter-grid">

                <div class="form-group">
                    <label for="keyword">Search Keyword</label>

                    <input
                        type="text"
                        id="keyword"
                        name="keyword"
                        placeholder="Search names, course codes..."
                        value="<?= clean($keyword) ?>"
                    >
                </div>

                <div class="form-group">
                    <label for="gender">Gender</label>

                    <select name="gender" id="gender">
                        <option value="">All Genders</option>

                        <option value="Male"
                            <?= $gender === "Male" ? "selected" : "" ?>>
                            Male
                        </option>

                        <option value="Female"
                            <?= $gender === "Female" ? "selected" : "" ?>>
                            Female
                        </option>

                        <option value="Other"
                            <?= $gender === "Other" ? "selected" : "" ?>>
                            Other
                        </option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="date_created">Date Created</label>

                    <input
                        type="date"
                        id="date_created"
                        name="date_created"
                        value="<?= clean($dateCreated) ?>"
                    >
                </div>

                <div class="filter-actions">
                    <button type="submit" class="button button-primary">
                        Search
                    </button>

                    <a href="index.php" class="button button-light">
                        Reset
                    </a>
                </div>

            </div>

        </form>
    </div>


    <div class="panel">

        <div class="section-heading">
            <div>
                <h2>User Records</h2>
                <p><?= count($users) ?> record(s) found.</p>
            </div>
        </div>

        <div class="table-wrap">

            <table>

                <thead>
                    <tr>
                        <th>ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Middle Name</th>
                        <th>Birthdate</th>
                        <th>Gender</th>
                        <th>Email</th>
                        <th>Courses</th>
                        <th>Date Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>

                    <?php if (count($users) > 0): ?>

                        <?php foreach ($users as $user): ?>

                            <tr>
                                <td><?= clean($user["user_ID"]) ?></td>

                                <td><?= clean($user["Firstname"]) ?></td>

                                <td><?= clean($user["Lastname"]) ?></td>

                                <td>
                                    <?= $user["Middlename"] !== null && $user["Middlename"] !== ""
                                        ? clean($user["Middlename"])
                                        : '<span class="muted">N/A</span>' ?>
                                </td>

                                <td><?= clean($user["Birthdate"]) ?></td>

                                <td>
                                    <span class="tag">
                                        <?= clean($user["Gender"]) ?>
                                    </span>
                                </td>

                                <td><?= clean($user["Email"]) ?></td>

                                <td class="course-cell">
                                    <?php if ($user["course_details"] !== null): ?>
                                        <?= clean($user["course_details"]) ?>
                                    <?php else: ?>
                                        <span class="muted">No course assigned</span>
                                    <?php endif; ?>
                                </td>

                                <td><?= clean($user["date_created"]) ?></td>

                                <td>
                                    <div class="action-group">

                                        <a
                                            href="edit.php?id=<?= (int)$user["user_ID"] ?>"
                                            class="button button-small button-edit"
                                        >
                                            Edit
                                        </a>

                                        <form
                                            action="delete.php"
                                            method="POST"
                                            onsubmit="return confirm('Are you sure you want to delete this user?');"
                                        >
                                            <input
                                                type="hidden"
                                                name="user_ID"
                                                value="<?= (int)$user["user_ID"] ?>"
                                            >

                                            <button
                                                type="submit"
                                                class="button button-small button-delete"
                                            >
                                                Delete
                                            </button>
                                        </form>

                                    </div>
                                </td>
                            </tr>

                        <?php endforeach; ?>

                    <?php else: ?>

                        <tr>
                            <td colspan="10" class="empty-state">
                                No user records found.
                            </td>
                        </tr>

                    <?php endif; ?>

                </tbody>

            </table>

        </div>

    </div>

    <div class="footer">
        User Management System
    </div>

</div>

</body>
</html>
