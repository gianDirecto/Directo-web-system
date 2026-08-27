<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Resume Form</title>
<link href="mainResumeStyle.css" rel="stylesheet">
</head>
<body>

  <form method="GET" action="generated.php">

    <div class="sheet">

      <div class="header-bar">
        <input type="text" name="full_name" placeholder="YOUR FULL NAME" required>
      </div>

      <div class="form-body">

        <h2>Contact</h2>
        <label>Phone</label>
        <input type="text" name="phone" placeholder="09xxxxxxxxx">
        <label>Email</label>
        <input type="email" name="email" placeholder="you@email.com">
        <label>Location</label>
        <input type="text" name="location" placeholder="Asingan, Pangasinan">
        <label>LinkedIn</label>
        <input type="text" name="linkedin" placeholder="linkedin.com/in/you">

        <h2>Certifications</h2>
        <label>Certificates</label>
        <input type="text" name="cert_name" placeholder="e.g. Packet Tracer">

        <h2>Program Taken</h2>
        <label>Program / Major</label>
        <input type="text" name="program_taken" placeholder="e.g. BSIT">

        <h2>Career Objective</h2>
        <textarea name="objective" placeholder="Motivated and detail-oriented profession..."></textarea>

        <h2>Key Skills</h2>
        <label>Technical</label>
        <input type="text" name="skills_technical" placeholder="e.g. Excel, Python, SQL">
        <label>Soft Skills</label>
        <input type="text" name="skills_soft" placeholder="e.g. Communication, Teamwork">

        <h2>Education</h2>
        <label><strong>Tertiary</strong></label>
        <input type="text" name="tertiary_school" placeholder="Degree / Institution / Year (e.g. BSIT | XYZ University | 2024)">

        <label><strong>Secondary</strong></label>
        <input type="text" name="secondary_school" placeholder="School Name | Strand / Year (e.g. High School | 2020)">
        
        <label><strong>Primary</strong></label>
        <input type="text" name="primary_school" placeholder="School Name | Year (e.g. Elementary School | 2016)">

        <h2>Projects / Internships</h2>
        <label>Project Title & Company</label>
        <input type="text" name="project_title" placeholder="Project Title">

        <button type="submit" class="submit-btn">Generate Resume</button>

      </div>

    </div>

  </form>

</body>
</html>