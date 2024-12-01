<?php
session_start();
include("connection.php");

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'User is not logged in.']);
    exit; // or redirect to the login page
}

$user_id = $_SESSION['user_id'];

$query = "SELECT FullName, address FROM users WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($full_name, $address);

if ($stmt->num_rows > 0) {
    $stmt->fetch(); // Fetch the full_name and address if they're available
} else {
    echo json_encode(['status' => 'error', 'message' => 'User details not found in the database.']);
    exit;
}

header('Content-Type: application/json');

// PayMongo API key (use your actual PayMongo secret key)
$apiKey = 'sk_test_C5e4t6QCqGkWhrgmTrzP1tr4'; // Replace with your actual PayMongo secret key
$paymongoUrl = 'https://api.paymongo.com/v1/payment_links';

// Get the incoming JSON body
$data = json_decode(file_get_contents('php://input'), true);

// Process the data from JSON
$printType = $_POST['print_type']; // e.g., "color"
$printSize = $_POST['print_size']; // e.g., "A4"
$quantity = $_POST['quantity'];
$amount = $_POST['amount'];

if (!isset($amount) || $amount <= 0) {
    echo json_encode(['status' => 'error', 'message' => 'Amount not valid']);
    exit;
}

// Calculate the total price
$printTypePrice = ($printType == 'color') ? 10 : 5;
$printSizePrice = ($printSize == 'letter') ? 3 : (($printSize == 'legal') ? 4 : 2);
$totalAmount = ($printTypePrice + $printSizePrice) * $quantity;

// Step 1: Save the user information into user_db if it's not already present
// Assume this comes from your session or authentication

if (isset($_FILES['file']) && $_FILES['file']['error'] == UPLOAD_ERR_OK) {
    $fileTmpPath = $_FILES['file']['tmp_name'];
    $fileName = $_FILES['file']['name'];
    $fileSize = $_FILES['file']['size'];
    $fileType = $_FILES['file']['type'];

    $uploadDir = 'uploads/';
    $uploadPath = $uploadDir . basename($fileName);

    if (!move_uploaded_file($fileTmpPath, $uploadPath)) {
        echo json_encode(['status' => 'error', 'message' => 'Failed to upload the file.']);
        exit;
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'No file uploaded or upload error.']);
    exit;
}


// Step 2: Save the payment details into payment table
$userId = $_SESSION['user_id'];
$paymentMethod = 'gcash'; // Assuming you're using GCash, change this if needed
$orderStatus = 'pending';

$stmt = $conn->prepare("INSERT INTO payments (user_id, FullName, address, payment_method, payment_date, total_amount, order_status, image_path) 
VALUES (?, ?, ?, ?, NOW(), ?, ?, ?)");
$stmt->bind_param("isssdss", $userId, $full_name, $address, $paymentMethod, $amount, $orderStatus, $uploadPath);
$stmt->execute();

// Make the PayMongo API request to create the payment link
$curl = curl_init();

curl_setopt_array($curl, [
  CURLOPT_URL => "https://api.paymongo.com/v1/links",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => json_encode([
    'data' => [
        'attributes' => [
                'amount' => $amount * 100,
                'description' => 'Purchase from Fax Parcel Print.'
        ]
    ]
  ]),
  CURLOPT_HTTPHEADER => [
    "accept: application/json",
    "authorization: Basic c2tfdGVzdF9DNWU0dDZRQ3FHa1docmdtVHJ6UDF0cjQ6",
    "content-type: application/json"
  ],
]);


$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

// Handle the response
if ($err) {
    echo json_encode(['status' => 'error', 'message' => 'cURL Error #: ' . $err]);
} else {
    $responseData = json_decode($response, true);
            if (isset($responseData['data']['attributes']['checkout_url'])) {
                echo json_encode(['checkout_url' => $responseData['data']['attributes']['checkout_url']]);
            } else {
                echo json_encode(['error' => 'Failed to Create payment link.']);
            }
        }

?>