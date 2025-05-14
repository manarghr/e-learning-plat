<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "etaali";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Retrieve form data
        $name       = $_POST['name'];
        $email      = $_POST['email'];
        $phone      = $_POST['phone'];
        $major      = $_POST['major'];
        $level      = $_POST['level'];
        $experience = $_POST['experience'];
        $skillsArray = isset($_POST['skills']) && is_array($_POST['skills']) ? $_POST['skills'] : [];
        $skills = implode(", ", $skillsArray);
        $password = $_POST['password'];

        // Check if email already exists
        $check_email = $conn->prepare("SELECT COUNT(*) FROM mentor WHERE email = :email");
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

        // Check if profile picture is uploaded
        if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == 0) {
            // Validate file extension - only allow JPG
            $fileExtension = strtolower(pathinfo($_FILES['profile_picture']['name'], PATHINFO_EXTENSION));
            
            if ($fileExtension !== 'jpg') {
                // Not a JPG file, show JavaScript alert and stop execution
                echo '<script>
                    alert("The profile picture must be in JPG format.");
                    window.history.back();
                </script>';
                exit;
            }
        }

        // Hash password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

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

        // Get the mentor's id_mentor (the ID generated after insert)
        $id_mentor = $conn->lastInsertId();

        // Process the profile picture if uploaded
        if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == 0) {
            // Create directory if it doesn't exist
            $uploadDir = 'mentor_images/';
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            
            $fileTmpName = $_FILES['profile_picture']['tmp_name'];
            $fileName = $id_mentor . '.jpg'; // Always save as JPG with id_mentor as filename
            $filePath = $uploadDir . $fileName;
            
            // Move the uploaded file to the target directory
            if (move_uploaded_file($fileTmpName, $filePath)) {
                // Update the mentor record with the profile picture path
                $profile_picture_path = $uploadDir . $fileName;
                
                $updateSql = "UPDATE mentor SET profile_picture = :profile_picture WHERE id_mentor = :id_mentor";
                $updateStmt = $conn->prepare($updateSql);

                $updateStmt->bindParam(':profile_picture', $profile_picture_path);
                $updateStmt->bindParam(':id_mentor', $id_mentor);

                $updateStmt->execute();
                
                echo '<script>
                    alert("Mentor registered successfully!");
                    window.location.href = "mentor.php";
                </script>';
            } else {
                echo '<script>
                    alert("Error uploading profile picture. Mentor registered but without profile picture.");
                    window.location.href = "mentor.php";
                </script>';
            }
        } else {
            echo '<script>
                alert("Mentor registered successfully! No profile picture was uploaded.");
                window.location.href = "mentor.php";
            </script>';
        }
    }
} catch (PDOException $e) {
    echo '<script>
        alert("Error: ' . str_replace("'", "\'", $e->getMessage()) . '");
        window.history.back();
    </script>';
}

$conn = null;
?>