<?php
session_start();
require_once 'database/db_connection.php'; // Ensure this path is correct

header('Content-Type: application/json');

// 1. Get user data from session (if logged in)
$user_id = $_SESSION['user_id'] ?? null;
// Assuming you store the user's name in a session variable upon login
$customer_name = $_SESSION['customer_name'] ?? null; 

// 2. Get click data from POST request
$product_id = $_POST['id'] ?? null;
$product_name = $_POST['name'] ?? null;
$product_category = $_POST['category'] ?? null;
$click_type = $_POST['click_type'] ?? null; // NEW: Added in JavaScript below

// 3. Get user IP address
$ip_address = $_SERVER['REMOTE_ADDR'];

// 4. Input validation
if (!$product_id || !$product_name || !$product_category || !in_array($click_type, ['buy', 'share'])) {
    http_response_code(400); // Bad Request
    echo json_encode(['status' => 'error', 'message' => 'Missing or invalid tracking data.']);
    exit;
}

if ($con) {
    try {
        // Prepare the INSERT statement
        $query = "INSERT INTO product_clicks (user_id, customer_name, product_id, product_name, product_category, click_type, ip_address) 
                  VALUES (?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $con->prepare($query);
        
        // Bind parameters: (i=integer for user_id, s=string for all others)
        // Since user_id can be NULL, we bind it as 'i' if set, or 's' (string 'NULL') if not set, but using 's' for consistency is safer.
        // For NULL values in prepared statements, it's safer to use bind_param only for non-NULL values, but in this case, 
        // passing null or an empty string for the optional fields is fine if the column is nullable.
        $stmt->bind_param(
            "issssss", 
            $user_id, 
            $customer_name, 
            $product_id, 
            $product_name, 
            $product_category, 
            $click_type, 
            $ip_address
        );

        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo json_encode(['status' => 'success', 'message' => 'Click tracked successfully.']);
        } else {
            http_response_code(500); // Internal Server Error
            echo json_encode(['status' => 'error', 'message' => 'Database insert failed.']);
        }
        
        $stmt->close();
        mysqli_close($con);

    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['status' => 'error', 'message' => 'An exception occurred: ' . $e->getMessage()]);
        if ($con) mysqli_close($con);
    }
} else {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Database connection failed.']);
}
?>