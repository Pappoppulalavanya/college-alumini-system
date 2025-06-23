<?php
include 'db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input
    $fullname = trim($_POST['fullname']);
    $college_id = trim($_POST['college_id']);
    $gender = trim($_POST['gender']);
    $batch = trim($_POST['batch']);
    $course = trim($_POST['course']);
    $company = trim($_POST['company']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // ✅ Check if required fields are filled
    if (empty($fullname) || empty($email) || empty($_POST['password'])) {
        echo "<script>alert('Please fill all required fields.'); window.history.back();</script>";
        exit;
    }

    // ✅ Check if email already exists
    $check = mysqli_prepare($conn, "SELECT email FROM alumni WHERE email = ?");
    mysqli_stmt_bind_param($check, "s", $email);
    mysqli_stmt_execute($check);
    mysqli_stmt_store_result($check);

    if (mysqli_stmt_num_rows($check) > 0) {
        echo "<script>alert('Email already registered. Please use a different one.'); window.history.back();</script>";
        exit;
    }
    mysqli_stmt_close($check);

    // ✅ Handle profile picture upload
    $uploadDir = "uploads/";
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $picName = $_FILES['profile_pic']['name'];
    $tmpName = $_FILES['profile_pic']['tmp_name'];
    $uploadPath = $uploadDir . basename($picName);

    if (!move_uploaded_file($tmpName, $uploadPath)) {
        echo "<script>alert('Error uploading profile picture.'); window.history.back();</script>";
        exit;
    }

    // ✅ Insert data into alumni table
    $sql = "INSERT INTO alumni (fullname, college_id, gender, batch, course, company, email, password, profile_pic)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sssssssss", $fullname, $college_id, $gender, $batch, $course, $company, $email, $password, $uploadPath);

    if (mysqli_stmt_execute($stmt)) {
        echo "<script>alert('Registration successful! Redirecting to login...'); window.location.href='login.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
?>
