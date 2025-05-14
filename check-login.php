<?php
session_start();

// Check if user is logged in
$response = [
    'logged_in' => isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true,
    'user_name' => isset($_SESSION['user_name']) ? $_SESSION['user_name'] : '',
    'user_type' => isset($_SESSION['user_type']) ? $_SESSION['user_type'] : '',
    'user_id' => isset($_SESSION['user_id']) ? $_SESSION['user_id'] : ''
];

// Return JSON response
header('Content-Type: application/json');
echo json_encode($response);
exit;
?>
