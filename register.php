<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "etaalim";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Sanitize & receive data
        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $phone = $_POST['phone'] ?? '';
        $major = $_POST['major'] ?? '';
        $level = $_POST['level'] ?? '';
        $password = $_POST['password'] ?? '';

        if (!$name || !$email || !$phone || !$major || !$level || !$password) {
            echo "Error: Missing required fields.";
            exit;
        }

        // Hash password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert into DB
        $sql = "INSERT INTO student (name, email, phone, major, level, password)
                VALUES (:name, :email, :phone, :major, :level, :password)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':major', $major);
        $stmt->bindParam(':level', $level);
        $stmt->bindParam(':password', $hashed_password);
        $stmt->execute();

        echo "Registration successful!";
    } else {
        echo "Invalid request method.";
    }
} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage();
}
