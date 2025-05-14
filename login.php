<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "etaali";

// Function to sanitize input data
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Process login form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $email = sanitize_input($_POST['email']);
        $password = sanitize_input($_POST['password']);
        $user_type = ""; // Will be set to 'student' or 'mentor'
        $user_data = null;
        
        // First check student table
        $stmt = $conn->prepare("SELECT * FROM student WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        
        if ($stmt->rowCount() > 0) {
            $user_data = $stmt->fetch(PDO::FETCH_ASSOC);
            $user_type = "student";
        } else {
            // If not found in student table, check mentor table
            $stmt = $conn->prepare("SELECT * FROM mentor WHERE email = :email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            
            if ($stmt->rowCount() > 0) {
                $user_data = $stmt->fetch(PDO::FETCH_ASSOC);
                $user_type = "mentor";
            }
        }
        
        // Verify password if user found
        if ($user_data && password_verify($password, $user_data['password'])) {
            // Set session variables
            $_SESSION['logged_in'] = true;
            $_SESSION['user_type'] = $user_type;
            $_SESSION['user_id'] = $user_type == 'student' ? $user_data['id_student'] : $user_data['id_mentor'];
            $_SESSION['user_name'] = $user_data['name'];
            $_SESSION['user_email'] = $user_data['email'];
            
            // Return success response for AJAX
            echo json_encode([
                'status' => 'success',
                'message' => 'Login successful',
                'user_type' => $user_type,
                'user_name' => $user_data['name']
            ]);
        } else {
            // Return error response for AJAX
            echo json_encode([
                'status' => 'error',
                'message' => 'Invalid email or password'
            ]);
        }
    } catch (PDOException $e) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Database error: ' . $e->getMessage()
        ]);
    }
    
    $conn = null;
    exit;
}
?>