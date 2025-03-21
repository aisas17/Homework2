<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $errors = [];

    // Validate name
    if (empty($name)) {
        $errors['name_error'] = 'Name is required.';
    }

    // Validate email
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email_error'] = 'Valid email is required.';
    }

    // Validate password
    if (empty($password)) {
        $errors['password_error'] = 'Password is required.';
    }

    // If there are errors, redirect back to the form with error messages
    if (!empty($errors)) {
        $query = http_build_query($errors);
        header("Location: index.html?$query");
        exit;
    }

    // If no errors, display confirmation message
    echo "<h1>Form Submitted Successfully</h1>";
    echo "<p>Name: " . htmlspecialchars($name) . "</p>";
    echo "<p>Email: " . htmlspecialchars($email) . "</p>";
}
?>
