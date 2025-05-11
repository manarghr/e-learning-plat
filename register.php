<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "etaalim";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
       
        $name = $_POST['name'];
        $adresse = $_POST['adresse'];
        $phone = $_POST['phone'];
        $major = $_POST['major'];
        $level = $_POST['level'];
        $password = $_POST['password'];

        
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        
        $sql = "INSERT INTO student (name, adresse, phone, major, level, password) 
                VALUES (:name, :adresse, :phone, :major, :level, :password)";
        $stmt = $conn->prepare($sql);

        
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':adresse', $adresse);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':major', $major);
        $stmt->bindParam(':level', $level);
        $stmt->bindParam(':password', $hashed_password);

        
        $stmt->execute();

        echo "Registration successful!";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}


$conn = null;
?>