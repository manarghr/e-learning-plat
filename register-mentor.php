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
        $email    = $_POST['email'];
        $phone      = $_POST['phone'];
        $major      = $_POST['major'];
        $level      = $_POST['level'];
        $experience = $_POST['experience'];
        $skillsArray = isset($_POST['skills']) && is_array($_POST['skills']) ? $_POST['skills'] : [];
        $skills = implode(", ", $skillsArray);
        $password = $_POST['password'];

   
        //Hash password
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

        echo "Mentor registered successfully!";

        print_r($_FILES['profile_picture']);
        // Get the mentor's id_mentor (the ID generated after insert)
        $id_mentor = $conn->lastInsertId();

        // Process the profile picture if uploaded
        if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == 0) {
            $uploadDir = 'C:\xampp\htdocs\etaalim\e-learning-plat\mentor_img\\'; // Directory to save the uploaded image
            $fileTmpName = $_FILES['profile_picture']['tmp_name'];
            $fileExtension = strtolower(pathinfo($_FILES['profile_picture']['name'], PATHINFO_EXTENSION));
            $fileName = $id_mentor . '.' . $fileExtension; // Name the file using id_mentor

            // Check if the file is an image
            $allowedExtensions = ['jpg', 'jpeg', 'png'];
            if (in_array($fileExtension, $allowedExtensions)) {
                // Move the uploaded file to the target directory
                if (move_uploaded_file($fileTmpName, $uploadDir . $fileName)) {
                    echo "File uploaded successfully as " . $fileName;
                } else {
                    echo "Error moving the file.";
                }
            } else {
                echo "Invalid file type. Only JPG, JPEG, and PNG are allowed.";
            }

            // Update the mentor record with the profile picture file name
            $updateSql = "UPDATE mentor SET profile_picture = :profile_picture WHERE id_mentor = :id_mentor";
            $updateStmt = $conn->prepare($updateSql);

            $updateStmt->bindParam(':profile_picture', $fileName);
            $updateStmt->bindParam(':id_mentor', $id_mentor);

            $updateStmt->execute();
        } else {
            echo "No file uploaded or there was an upload error.";
        }

        echo "Mentor registered successfully!";
    }

}catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$conn = null;
?>
