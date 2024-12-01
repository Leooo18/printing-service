<?php
session_start();

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require_once 'connection.php';

    $user_id = $_SESSION['user_id'];
    $currentPassword = $_POST['currentPassword'];
    $newPassword = $_POST['newPassword'];
    $confirmPassword = $_POST['confirmPassword'];

    // Validate passwords
    if ($newPassword !== $confirmPassword) {
        $error = "New passwords do not match.";
    } else {
        // Check current password
        $sql = "SELECT password FROM users WHERE user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->bind_result($hashedPassword);
        $stmt->fetch();
        $stmt->close();

        if (!password_verify($currentPassword, $hashedPassword)) {
            $error = "Current password is incorrect.";
        } else {
            // Hash new password
            $newHashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

            // Update the password
            $sql = "UPDATE users SET password = ? WHERE user_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("si", $newHashedPassword, $user_id);

            if ($stmt->execute()) {
                // Redirect to myaccount.php after success
                header("Location: myaccount.php");
                exit;
            } else {
                $error = "Error updating password.";
            }

            $stmt->close();
            $conn->close();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
.eye-icon {
    position: absolute;
    right: 10px; 
    top: 50%;
    transform: translateY(-50%); 
    cursor: pointer;
    font-size: 20px; 
}

.password-container {
    position: relative;
}

input.form-control {
    padding-right: 40px;
}

    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h4 class="text-center">Change Password</h4>
            </div>
            <div class="card-body">
                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php elseif (!empty($success)): ?>
                    <div class="alert alert-success"><?php echo $success; ?></div>
                <?php endif; ?>
                <form action="change_password.php" method="POST">
                    <div class="mb-3 password-container">
                        <label for="currentPassword" class="form-label">Current Password</label>
                        <input type="password" name="currentPassword" id="currentPassword" class="form-control" required>
                    </div>
                    <div class="mb-3 password-container">
                        <label for="newPassword" class="form-label">New Password</label>
                        <input type="password" name="newPassword" id="newPassword" class="form-control" required>
                        <span class="eye-icon" onclick="togglePasswordVisibility('newPassword')">
                            👁️
                        </span>
                    </div>
                    <div class="mb-3 password-container">
                        <label for="confirmPassword" class="form-label">Confirm New Password</label>
                        <input type="password" name="confirmPassword" id="confirmPassword" class="form-control" required>
                        <span class="eye-icon" onclick="togglePasswordVisibility('confirmPassword')">
                            👁️
                        </span>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Update Password</button>
                        <a href="myaccount.php" class="btn btn-secondary mt-2">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Function to toggle password visibility
        function togglePasswordVisibility(inputId) {
            var input = document.getElementById(inputId);
            if (input.type === "password") {
                input.type = "text";
            } else {
                input.type = "password";
            }
        }
    </script>
</body>
</html>
