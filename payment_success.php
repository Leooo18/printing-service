<?php
// Retrieve the payment_id from the URL
$paymentId = $_GET['payment_id'];

// Update the payment status to 'completed'
include('connection.php');
$stmt = $conn->prepare("UPDATE payment SET payment_status = 'completed' WHERE payment_id = ?");
$stmt->bind_param("i", $paymentId);
$stmt->execute();

echo "Payment successful! Your payment has been completed.";
?>
