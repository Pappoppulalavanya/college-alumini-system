<?php
session_start();
include 'db.php'; // connect to your DB

$email = $_POST['email'];
$password = $_POST['password'];

// Use prepared statements to prevent SQL injection
$stmt = $conn->prepare("SELECT id, name, email, password FROM users WHERE email=?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
    if (password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['name'] = $user['name'];
        $_SESSION['email'] = $user['email'];
        header("Location: dash board.php"); // redirect to dashboard
    } else {
        echo "Invalid login credentials.";
    }
} else {
    echo "Invalid login credentials.";
}
?>
