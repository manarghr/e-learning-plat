<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "etaalim";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Retrieve form data
        $name       = $_POST['name'];
        $email    = $_POST['email'];
        $phone      = $_POST['phone'];
        $major      = $_POST['major'];
        $level      = $_POST['level'];
        $experience = $_POST['experience'];
        $skillsArray = isset($_POST['skills']) && is_array($_POST['skills']) ? $_POST['skills'] : [];
        $skills = implode(", ", $skillsArray);
        $password   = $_POST['password'];

        // Hash password
        // $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert into mentor table
        $sql = "INSERT INTO mentor (name, email, phone, major, level, experience, skills, password) 
                VALUES (:name, :email, :phone, :major, :level, :experience, :skills, :password)";
        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':major', $major);
        $stmt->bindParam(':level', $level);
        $stmt->bindParam(':experience', $experience);
        $stmt->bindParam(':skills', $skills);
        $stmt->bindParam(':password', $hashed_password);

        $stmt->execute();

        echo "Mentor registered successfully!";
    }

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$conn = null;
?>
