<?php
session_start();
include("connection.php");

if (isset($_POST['submit'])) {
    $email = trim($_POST['email']); // Remove extra spaces
    $password = trim($_POST['password']); // Remove extra spaces

    // Check if inputs are empty
    if (empty($email) || empty($password)) {
        $_SESSION['login_error'] = "Email or password cannot be empty!";
        header('Location: login.php'); // Redirect back to login page
        exit;
    }

    // Prepare and execute the SQL statement
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = mysqli_prepare($conn, $sql);

    if (!$stmt) {
        $_SESSION['login_error'] = "Database error: " . mysqli_error($conn);
        header('Location: login.php');
        exit;
    }

    mysqli_stmt_bind_param($stmt, 's', $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $storedPassword = $row['password'];

        // Verify the entered password with the stored hashed password
        if (password_verify($password, $storedPassword)) {
            // Set session variables
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['full_name'] = $row['FullName'];
            $_SESSION['address'] = $row['address'];
            $_SESSION['logged_in'] = true;

            header('Location: index.php');
            exit;
        } else {
            $_SESSION['login_error'] = "Incorrect password!";
        }
    } else {
        $_SESSION['login_error'] = "User not found!";
    }

    // Redirect back to login page with error
    header('Location: login.php');
    exit;
}
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Form</title>
    <link rel="icon" type="image/x-icon" href="favicon.ico">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css">
</head>

<body>
    <div class="login-background">
        <div class="login-overlay"></div>

        <div class="login-form">
            <div class="text">Login</div>
            <form action="Login.php" method="post">
                <div class="field">
                    <span><i class="fas fa-envelope"></i></span>
                    <input type="email" name="email" id="email" required oninput="clearEmailText()">
                    <label for="email" id="emailLabel">Email</label>
                </div>
                <div class="field">
                    <span><i class="fas fa-lock"></i></span>
                    <input type="password" name="password" required>
                    <label for="password">Password</label>
                </div>

                <?php
                if (isset($_SESSION['login_error'])) {
                    echo '<div class="error-msg">'.$_SESSION['login_error'].'</div>';
                    unset($_SESSION['login_error']);
                }
                ?>

                <button type="submit" name="submit">Login</button>
                <p class="text-center mt-3">Dont have account yet? <a href="register.php">Register here</a>.</p>
                <p class="text-center mt-3">Are you an admin? <a href="admin.php">Login as Admin</a>.</p>
            </form>
        </div>
    </div>

    <style>
        /* Full-screen background for login page */
        .login-background {
            background-image: url('fax parcel.jpg'); /* Background image */
            background-size: cover;
            background-position: center;
            position: relative;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background-repeat: no-repeat;
        }

        /* Overlay to darken the background */
        .login-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(241, 160, 186, 0.356); /* Soft pink overlay */
        }

        /* Login Form */
        .login-form {
            position: relative;
            background: rgba(255, 255, 255, 0.9); /* White background with transparency */
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            z-index: 1;
        }

        .login-form .text {
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 20px;
            color: #333;
            text-align: center;
        }

        .field {
            position: relative;
            margin-bottom: 20px;
        }

        .field input {
            width: calc(100% - 24px); /* Adjust input width */
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 5px;
            outline: none;
            font-size: 16px;
        }

        .field span {
            position: absolute;
            top: 50%;
            left: 10px;
            transform: translateY(-50%);
            color: #555;
        }

        .field label {
            position: absolute;
            top: 50%;
            left: 10px;
            transform: translateY(-50%);
            color: #777;
            pointer-events: none;
            transition: 0.3s;
        }

        .field input:focus + label,
        .field input:valid + label,
        .field input:not(:placeholder-shown) + label,
        .field input:not(:placeholder-shown) ~ span {
            transform: translateY(-150%);
            font-size: 12px;
            color: #3498db;
        }

        .field input:not(:placeholder-shown) ~ span {
            color: #3498db;
        }

        .error-msg {
            color: #e74c3c;
            margin-top: 10px;
            text-align: center;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 18px;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #2980b9;
        }

        .text-center a {
            color: #3498db;
            font-weight: 600;
        }

        .text-center a:hover {
        text-decoration: underline;
    }
    </style>

</body>

</html>
