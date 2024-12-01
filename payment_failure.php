<?php
// Retrieve the payment_id from the URL
$paymentId = $_GET['payment_id'];

// Update the payment status to 'failed'
include('connection.php');
$stmt = $conn->prepare("UPDATE payment SET payment_status = 'failed' WHERE payment_id = ?");
$stmt->bind_param("i", $paymentId);
$stmt->execute();

echo "Payment failed. Please try again.";
?>
