
<?php
$isEdit = ($mode === "edit");

$pageTitle = $isEdit ? "Edit User" : "Add New User";
$buttonText = $isEdit ? "Update User" : "Save User";
$formAction = $isEdit ? "update.php" : "submit.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= clean($pageTitle) ?></title>

    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container form-page">

    <div class="page-header">
        <div>
            <p class="eyebrow">USER MANAGEMENT</p>
            <h1><?= clean($pageTitle) ?></h1>
            <p class="subtitle">
                Enter the user's information and select their courses.
            </p>
        </div>

        <a href="index.php" class="button button-light">
            Back to Records
        </a>
    </div>

    <?php if ($errorMessage !== ""): ?>
        <div class="alert alert-error">
            <?= clean($errorMessage) ?>
        </div>
    <?php endif; ?>

    <div class="panel">

        <div class="section-heading">
            <div>
                <h2>User Information</h2>
                <p>Fields marked with * are required.</p>
            </div>
        </div>

        <form action="<?= clean($formAction) ?>" method="POST">

            <?php if ($isEdit): ?>
                <input
                    type="hidden"
                    name="user_ID"
                    value="<?= (int)$user["user_ID"] ?>"
                >
            <?php endif; ?>

            <div class="form-grid">

                <div class="form-group">
                    <label for="Firstname">
                        First Name <span class="required">*</span>
                    </label>

                    <input
                        type="text"
                        id="Firstname"
                        name="Firstname"
                        maxlength="100"
                        value="<?= clean($user["Firstname"]) ?>"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="Lastname">
                        Last Name <span class="required">*</span>
                    </label>

                    <input
                        type="text"
                        id="Lastname"
                        name="Lastname"
                        maxlength="100"
                        value="<?= clean($user["Lastname"]) ?>"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="Middlename">Middle Name</label>

                    <input
                        type="text"
                        id="Middlename"
                        name="Middlename"
                        maxlength="100"
                        value="<?= clean($user["Middlename"]) ?>"
                    >
                </div>

                <div class="form-group">
                    <label for="Birthdate">
                        Birthdate <span class="required">*</span>
                    </label>

                    <input
                        type="date"
                        id="Birthdate"
                        name="Birthdate"
                        max="<?= date('Y-m-d') ?>"
                        value="<?= clean($user["Birthdate"]) ?>"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="Gender">
                        Gender <span class="required">*</span>
                    </label>

                    <select id="Gender" name="Gender" required>
                        <option value="">Select Gender</option>

                        <option value="Male"
                            <?= $user["Gender"] === "Male" ? "selected" : "" ?>>
                            Male
                        </option>

                        <option value="Female"
                            <?= $user["Gender"] === "Female" ? "selected" : "" ?>>
                            Female
                        </option>

                        <option value="Other"
                            <?= $user["Gender"] === "Other" ? "selected" : "" ?>>
                            Other
                        </option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="Email">
                        Email Address <span class="required">*</span>
                    </label>

                    <input
                        type="email"
                        id="Email"
                        name="Email"
                        maxlength="150"
                        value="<?= clean($user["Email"]) ?>"
                        required
                    >
                </div>

                <div class="form-group full-width">
                    <label for="courses">Select Courses</label>

                    <select name="courses[]" id="courses" multiple>

                        <?php foreach ($courses as $course): ?>

                            <?php
                            $courseID = (int)$course["Course_ID"];

                            $isSelected = in_array(
                                $courseID,
                                $selectedCourses,
                                true
                            );
                            ?>

                            <option
                                value="<?= $courseID ?>"
                                <?= $isSelected ? "selected" : "" ?>
                            >
                                <?= clean($course["name"]) ?>
                                (<?= clean($course["course_code"]) ?>)

                                <?= $course["status"] === "off"
                                    ? "- Inactive"
                                    : "" ?>
                            </option>

                        <?php endforeach; ?>

                    </select>

                </div>

            </div>

            <div class="form-actions">
                <button type="submit" class="button button-primary">
                    <?= clean($buttonText) ?>
                </button>

                <a href="index.php" class="button button-light">
                    Cancel
                </a>
            </div>

        </form>

    </div>

</div>

</body>
</html>
