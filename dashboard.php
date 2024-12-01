<?php
session_start();
include("connection.php"); // Include database connection

// Check if the admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: dashboard.php"); // Redirect to login if not logged in
    exit;
}

// Handle delete order action
if (isset($_GET['delete_order_id'])) {
    $order_id = (int)$_GET['delete_order_id'];

    // Delete the order from the database
    $delete_sql = "DELETE FROM payments WHERE order_id = $order_id";
    if (mysqli_query($conn, $delete_sql)) {
        echo "<script>alert('Order deleted successfully'); window.location.href = 'dashboard.php';</script>";
        exit;
    } else {
        echo "<script>alert('Error deleting order: " . mysqli_error($conn) . "'); window.location.href = 'dashboard.php';</script>";
        exit;
    }
}

// Pagination logic (optional)
$limit = 10; // Number of records per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Fetch payment information from the database with pagination
$sql = "SELECT 
            order_id,
            user_id, 
            FullName, 
            address, 
            payment_method,  
            payment_date, 
            total_amount, 
            order_status 
        FROM payments";
$result = mysqli_query($conn, $sql);

if (!$result) {
    echo "Error fetching payments: " . mysqli_error($conn);
    exit;
}

// Count the total number of payments for pagination
$total_sql = "SELECT COUNT(*) AS total FROM payments";
$total_result = mysqli_query($conn, $total_sql);
$total_row = mysqli_fetch_assoc($total_result);
$total_records = $total_row['total'];
$total_pages = ceil($total_records / 10);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Payments</title>
    <link rel="stylesheet" href="css/admin_dashboard.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-white navbar-light shadow sticky-top p-0">
        <a href="index.php" class="navbar-brand d-flex align-items-center px-3 px-lg-4">
            <h2 class="m-0">
                <img src="image/fax logo.jpg" alt="FAX Parcel Print Logo" class="logo">
                <span style="color: black;">FAX Parcel</span> <span style="color: red;">Print</span>
            </h2>
        </a>
        <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto p-4 p-lg-0">
                <a href="index.php" class="nav-item nav-link active">Home</a>
                <a href="about.html" class="nav-item nav-link">About</a>
                <a href="contact.php" class="nav-item nav-link">Contact</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <h1>Admin Dashboard - Payments</h1>

        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>User ID</th>
                    <th>Full Name</th>
                    <th>Address</th>
                    <th>Payment Method</th>
                    <th>Payment Date</th>
                    <th>Total Amount</th>
                    <th>Order Status</th>
                    <th>Actions</th> <!-- Added actions column -->
                </tr>
            </thead>
            <tbody>
                <?php
                // Loop through payments and display them
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        // Format the payment date
                        $formatted_date = date('F j, Y, g:i a', strtotime($row['payment_date']));
                        echo "<tr>
                                <td>" . htmlspecialchars($row['order_id']) . "</td>
                                <td>" . htmlspecialchars($row['user_id']) . "</td>
                                <td>" . htmlspecialchars($row['FullName']) . "</td>
                                <td>" . htmlspecialchars($row['address']) . "</td>
                                <td>" . htmlspecialchars($row['payment_method']) . "</td>
                                <td>" . $formatted_date . "</td>
                                <td>" . htmlspecialchars(number_format($row['total_amount'], 2)) . "</td>
                                <td>" . htmlspecialchars($row['order_status']) . "</td>
                                <td>
                                    <a href='?delete_order_id=" . $row['order_id'] . "' onclick='return confirm(\"Are you sure you want to delete this order?\")' class='delete-btn'>Delete</a>
                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='8'>No payments found</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="pagination">
            <?php
            for ($i = 1; $i <= $total_pages; $i++) {
                echo "<a href='dashboard.php?page=$i'>$i</a>";
            }
            ?>
        </div>

        <a href="index.php" class="Back">Back</a>
        <a href="logout.php" class="logout">Logout</a>
    </div>
</body>
<style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 1200px;
            margin: 50px auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th, table td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }

        table th {
            background-color: #3498db;
            color: white;
        }

        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        table tr:hover {
            background-color: #f1f1f1;
        }

        .logout {
            display: block;
            width: 100px;
            margin: 20px auto;
            padding: 10px;
            background: #e74c3c;
            color: white;
            text-align: center;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
        }

        .logout:hover {
            background: #c0392b;
        }

        .pagination {
            text-align: center;
            margin-top: 20px;
        }

        .pagination a {
            margin: 0 5px;
            padding: 8px 16px;
            background-color: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        .pagination a:hover {
            background-color: #2980b9;
        }

        .Back {
            display: block;
            width: 100px;
            margin: 20px auto;
            padding: 10px;
            background: #3498db;
            color: white;
            text-align: center;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
        }

        .Back:hover {
            background: #2980b9;
        }

        .delete-btn {
        color: red;
        text-decoration: none;
    }

    .delete-btn:hover {
        text-decoration: underline;
    }
    </style>
    <link rel="stylesheet" href="css/admin.css">
    <link href="Frontpage components/css/frontpagestyle.css" rel="stylesheet">
    <link href="FrontEndDesign/img/favicon-32x32.png" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Nunito:wght@600;700;800&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="Frontpage components/lib/animate/animate.min.css" rel="stylesheet">
    <link href="Frontpage components/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="Frontpage components/css/bootstrapfrontpage.min.css" rel="stylesheet">
    </html>
