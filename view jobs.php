<?php
include 'db.php';

$sql = "SELECT * FROM job_posts ORDER BY posted_at DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Posted Jobs</title>
  <link rel="stylesheet" href="css/view jobs.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
</head>
<body>
  <div class="container">
    <h1>Latest Job Opportunities</h1>
    <div class="job-container">
      <?php while($row = mysqli_fetch_assoc($result)) { ?>
        <div class="job-card">
          <h2><?= htmlspecialchars($row['job_title']) ?></h2>
          <p><strong>Company:</strong> <?= htmlspecialchars($row['company_name']) ?></p>
          <p><strong>Location:</strong> <?= htmlspecialchars($row['location']) ?></p>
          <p><strong>Vacancy:</strong> <?= $row['vacancy'] ?></p>
          <p><strong>Designation:</strong> <?= htmlspecialchars($row['designation']) ?></p>
          <p><strong>Description:</strong> <?= nl2br(htmlspecialchars($row['description'])) ?></p>
          <p class="meta"><strong>Posted By:</strong> <?= htmlspecialchars($row['posted_by']) ?></p>
          <p class="meta"><strong>Date:</strong> <?= $row['posted_at'] ?></p>
        </div>
      <?php } ?>
    </div>
  </div>
</body>
</html>
