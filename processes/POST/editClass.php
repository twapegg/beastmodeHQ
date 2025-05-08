<?php
session_start();

require '../../vendor/autoload.php'; // Load dependencies

use Cloudinary\Configuration\Configuration;
use Cloudinary\Api\Upload\UploadApi;
use Dotenv\Dotenv;

// Check if the user is logged in and their role is admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../../auth/login.php");
    exit();
}

// Load .env variables
$dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();

// Cloudinary configuration
Configuration::instance([
    'cloud' => [
        'cloud_name' => $_ENV['CLOUDINARY_CLOUD_NAME'],
        'api_key' => $_ENV['CLOUDINARY_API_KEY'],
        'api_secret' => $_ENV['CLOUDINARY_API_SECRET'],
    ],
    'url' => [
        'secure' => true
    ]
]);

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "beastmodehq";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle edit class request
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $classId = intval($_POST['class_id']);
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $image = $_FILES['image'];

    // Validate input
    if (empty($name)) {
        header("Location: ../../admin/classes.php?error=empty_fields");
        exit();
    }

    try {
        // Check if a new image is uploaded
        if (!empty($image['tmp_name'])) {
            // Upload new image to Cloudinary
            $upload = (new UploadApi())->upload($image["tmp_name"]);
            $imageUrl = $upload['secure_url']; // Get the public URL of the uploaded image

            // Update class with new image
            $query = "UPDATE classes SET name = ?, description = ?, image_url = ? WHERE id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("sssi", $name, $description, $imageUrl, $classId);
        } else {
            // Update class without changing the image
            $query = "UPDATE classes SET name = ?, description = ? WHERE id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ssi", $name, $description, $classId);
        }

        if ($stmt->execute()) {
            header("Location: ../../admin/classes.php?success=Class Updated Successfully!");
        } else {
            header("Location: ../../admin/classes.php?error=Class Update Failed!");
        }

        $stmt->close();
    } catch (Exception $e) {
        // Handle Cloudinary upload errors
        header("Location: ../../admin/classes.php?error=Error uploading image: " . $e->getMessage());
    }
}

$conn->close();
exit();
?>