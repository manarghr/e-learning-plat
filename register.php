<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "etaalim";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get form data
        $name = $_POST['name'];
        $adresse = $_POST['adresse'];
        $phone = $_POST['phone'];
        $major = $_POST['major'];
        $level = $_POST['level'];
        $password = $_POST['password'];

        // Hash the password for security
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert data into the student table using a prepared statement
        $sql = "INSERT INTO student (name, adresse, phone, major, level, password) 
                VALUES (:name, :adresse, :phone, :major, :level, :password)";
        $stmt = $conn->prepare($sql);

        // Bind parameters
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':adresse', $adresse);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':major', $major);
        $stmt->bindParam(':level', $level);
        $stmt->bindParam(':password', $hashed_password);

        // Execute the statement
        $stmt->execute();

        echo "Registration successful!";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// Close the connection
$conn = null;
?>