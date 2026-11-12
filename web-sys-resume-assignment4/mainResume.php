<?php

$errors = [];

$full_name = $_GET['full_name'] ?? '';
$phone = $_GET['phone'] ?? '';
$email = $_GET['email'] ?? '';
$location = $_GET['location'] ?? '';
$linkedin = $_GET['linkedin'] ?? '';
$cert_name = $_GET['cert_name'] ?? '';
$program_taken = $_GET['program_taken'] ?? '';
$objective = $_GET['objective'] ?? '';
$skills_technical = $_GET['skills_technical'] ?? '';
$skills_soft = $_GET['skills_soft'] ?? '';
$tertiary_school = $_GET['tertiary_school'] ?? '';
$secondary_school = $_GET['secondary_school'] ?? '';
$primary_school = $_GET['primary_school'] ?? '';
$project_title = $_GET['project_title'] ?? '';

if (isset($_GET['submit'])) {

    if (trim($full_name) === '') {
        $errors['full_name'] = 'Full Name is required.';
    }

    if (trim($phone) === '') {
        $errors['phone'] = 'Phone is required.';
    }

    if (trim($email) === '') {
        $errors['email'] = 'Email is required.';
    }

    if (trim($location) === '') {
        $errors['location'] = 'Location is required.';
    }

    if (trim($linkedin) === '') {
        $errors['linkedin'] = 'LinkedIn is required.';
    }

    if (trim($cert_name) === '') {
        $errors['cert_name'] = 'Certificates is required.';
    }

    if (trim($program_taken) === '') {
        $errors['program_taken'] = 'Program / Major is required.';
    }

    if (trim($objective) === '') {
        $errors['objective'] = 'Career Objective is required.';
    }

    if (trim($skills_technical) === '') {
        $errors['skills_technical'] = 'Technical Skills is required.';
    }

    if (trim($skills_soft) === '') {
        $errors['skills_soft'] = 'Soft Skills is required.';
    }

    if (trim($tertiary_school) === '') {
        $errors['tertiary_school'] = 'Tertiary School is required.';
    }

    if (trim($secondary_school) === '') {
        $errors['secondary_school'] = 'Secondary School is required.';
    }

    if (trim($primary_school) === '') {
        $errors['primary_school'] = 'Primary School is required.';
    }

    if (trim($project_title) === '') {
        $errors['project_title'] = 'Project Title & Company is required.';
    }

    if (empty($errors)) {
        $query = http_build_query([
            'full_name' => $full_name,
            'phone' => $phone,
            'email' => $email,
            'location' => $location,
            'linkedin' => $linkedin,
            'cert_name' => $cert_name,
            'program_taken' => $program_taken,
            'objective' => $objective,
            'skills_technical' => $skills_technical,
            'skills_soft' => $skills_soft,
            'tertiary_school' => $tertiary_school,
            'secondary_school' => $secondary_school,
            'primary_school' => $primary_school,
            'project_title' => $project_title
        ]);

        header("Location: generated.php?$query");
        exit();
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Resume Form</title>
    <link href="mainResumeStyle.css" rel="stylesheet">
</head>

<body>

    <form method="GET" action="mainResume.php">

        <div class="sheet">

            <div class="header-bar">
                <input type="text" name="full_name" placeholder="YOUR FULL NAME" value="<?php echo htmlspecialchars($full_name); ?>">
                <div class="error"><?php echo $errors['full_name'] ?? ''; ?></div>
            </div>

            <div class="form-body">

                <h2>Contact</h2>

                <label>Phone</label>
                <input type="text" name="phone" placeholder="+63 912 345 6789" value="<?php echo htmlspecialchars($phone); ?>">
                <div class="error"><?php echo $errors['phone'] ?? ''; ?></div>

                <label>Email</label>
                <input type="text" name="email" placeholder="you@email.com" value="<?php echo htmlspecialchars($email); ?>">
                <div class="error"><?php echo $errors['email'] ?? ''; ?></div>

                <label>Location</label>
                <input type="text" name="location" placeholder="Asingan, Pangasinan" value="<?php echo htmlspecialchars($location); ?>">
                <div class="error"><?php echo $errors['location'] ?? ''; ?></div>

                <label>LinkedIn</label>
                <input type="text" name="linkedin" placeholder="linkedin.com/in/you" value="<?php echo htmlspecialchars($linkedin); ?>">
                <div class="error"><?php echo $errors['linkedin'] ?? ''; ?></div>

                <h2>Certifications</h2>
                <label>Certificates</label>
                <input type="text" name="cert_name" placeholder="e.g. Packet Tracer" value="<?php echo htmlspecialchars($cert_name); ?>">
                <div class="error"><?php echo $errors['cert_name'] ?? ''; ?></div>

                <h2>Program Taken</h2>
                <label>Program / Major</label>
                <input type="text" name="program_taken" placeholder="e.g. BSIT" value="<?php echo htmlspecialchars($program_taken); ?>">
                <div class="error"><?php echo $errors['program_taken'] ?? ''; ?></div>

                <h2>Career Objective</h2>
                <textarea name="objective" placeholder="Motivated and detail-oriented profession..."><?php echo htmlspecialchars($objective); ?></textarea>
                <div class="error"><?php echo $errors['objective'] ?? ''; ?></div>

                <h2>Key Skills</h2>
                <label>Technical</label>
                <input type="text" name="skills_technical" placeholder="e.g. Excel, Python, SQL" value="<?php echo htmlspecialchars($skills_technical); ?>">
                <div class="error"><?php echo $errors['skills_technical'] ?? ''; ?></div>

                <label>Soft Skills</label>
                <input type="text" name="skills_soft" placeholder="e.g. Communication, Teamwork" value="<?php echo htmlspecialchars($skills_soft); ?>">
                <div class="error"><?php echo $errors['skills_soft'] ?? ''; ?></div>

                <h2>Education</h2>
                <label><strong>Tertiary</strong></label>
                <input type="text" name="tertiary_school" placeholder="Degree / Institution / Year (e.g. BSIT | XYZ University | 2024)" value="<?php echo htmlspecialchars($tertiary_school); ?>">
                <div class="error"><?php echo $errors['tertiary_school'] ?? ''; ?></div>

                <label><strong>Secondary</strong></label>
                <input type="text" name="secondary_school" placeholder="School Name | Strand / Year (e.g. High School | 2020)" value="<?php echo htmlspecialchars($secondary_school); ?>">
                <div class="error"><?php echo $errors['secondary_school'] ?? ''; ?></div>

                <label><strong>Primary</strong></label>
                <input type="text" name="primary_school" placeholder="School Name | Year (e.g. Elementary School | 2016)" value="<?php echo htmlspecialchars($primary_school); ?>">
                <div class="error"><?php echo $errors['primary_school'] ?? ''; ?></div>

                <h2>Projects / Internships</h2>
                <label>Project Title & Company</label>
                <input type="text" name="project_title" placeholder="Project Title" value="<?php echo htmlspecialchars($project_title); ?>">
                <div class="error"><?php echo $errors['project_title'] ?? ''; ?></div>

                <button type="submit" class="submit-btn" name="submit">Generate Resume</button>

            </div>

        </div>

    </form>

</body>

</html>