<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "etaali";

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
            echo '<script>
                alert("Error: Missing required fields.");
                window.history.back();
            </script>';
            exit;
        }

        // Check if email already exists
        $check_email = $conn->prepare("SELECT COUNT(*) FROM student WHERE email = :email");
        $check_email->bindParam(':email', $email);
        $check_email->execute();
        
        if ($check_email->fetchColumn() > 0) {
            // Email already exists, show JavaScript alert and stop execution
            echo '<script>
                alert("This email address is already registered. Please use a different email.");
                window.history.back();
            </script>';
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

        echo '<script>
            alert("Registration successful!");
            window.location.href = "index.php";
        </script>';
    } else {
        echo "Invalid request method.";
    }
} catch (PDOException $e) {
    echo '<script>
        alert("Database error: ' . str_replace("'", "\'", $e->getMessage()) . '");
        window.history.back();
    </script>';
}
?>