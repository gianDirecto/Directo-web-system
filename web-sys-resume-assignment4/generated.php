<?php

$full_name        = $_GET['full_name'] ?? '';
$phone            = $_GET['phone'] ?? '';
$email            = $_GET['email'] ?? '';
$location         = $_GET['location'] ?? '';
$linkedin         = $_GET['linkedin'] ?? '';
$cert_name        = $_GET['cert_name'] ?? '';
$program_taken    = $_GET['program_taken'] ?? '';
$objective        = $_GET['objective'] ?? '';
$skills_technical = $_GET['skills_technical'] ?? '';
$skills_soft      = $_GET['skills_soft'] ?? '';
$tertiary_school  = $_GET['tertiary_school'] ?? '';
$secondary_school = $_GET['secondary_school'] ?? '';
$primary_school   = $_GET['primary_school'] ?? '';
$project_title    = $_GET['project_title'] ?? '';

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title><?php echo htmlspecialchars($full_name); ?> - Resume</title>
  <link href="generatedResumeStyle.css" rel="stylesheet">
</head>

<body>

  <div class="sheet">

    <div class="header-bar">
      <h1><?php echo htmlspecialchars($full_name); ?></h1>
    </div>

    <div class="resume-body">

      <h2>Contact</h2>

      <div class="sub-label">Phone</div>
      <p><?php echo htmlspecialchars($phone); ?></p>

      <div class="sub-label">Email</div>
      <p><?php echo htmlspecialchars($email); ?></p>

      <div class="sub-label">Location</div>
      <p><?php echo htmlspecialchars($location); ?></p>

      <div class="sub-label">LinkedIn</div>
      <p><?php echo htmlspecialchars($linkedin); ?></p>


      <h2>Certifications</h2>
      <p><?php echo htmlspecialchars($cert_name); ?></p>


      <h2>Program Taken</h2>
      <p><?php echo htmlspecialchars($program_taken); ?></p>


      <h2>Career Objective</h2>
      <p><?php echo htmlspecialchars($objective); ?></p>


      <h2>Key Skills</h2>

      <div class="sub-label">Technical</div>
      <p><?php echo htmlspecialchars($skills_technical); ?></p>

      <div class="sub-label">Soft Skills</div>
      <p><?php echo htmlspecialchars($skills_soft); ?></p>


      <h2>Education</h2>

      <p>
        <strong>Tertiary:</strong>
        <?php echo htmlspecialchars($tertiary_school); ?>
      </p>

      <p>
        <strong>Secondary:</strong>
        <?php echo htmlspecialchars($secondary_school); ?>
      </p>

      <p>
        <strong>Primary:</strong>
        <?php echo htmlspecialchars($primary_school); ?>
      </p>


      <h2>Projects / Internships</h2>

      <p>
        <strong>Project Title & Company:</strong>
        <?php echo htmlspecialchars($project_title); ?>
      </p>

    </div>

  </div>

</body>

</html>