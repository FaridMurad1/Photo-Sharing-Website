<?php
session_start();
include 'db_handle.php'; // Include your database connection file

// Check if the image_id is set
if (isset($_GET['image_url'])) {
    $image_url = $_GET['image_url'];

    // Fetch the image from the database
    $stmt = $conn->prepare("SELECT * FROM images WHERE address = ?");
    $stmt->bind_param("s", $image_url);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $image = $result->fetch_assoc(); // Get image data
    } else {
        echo "Image not found.";
        exit();
    }
} else {
    echo "No image specified.";
    exit();
}

// Handle image deletion
if (isset($_POST['delete'])) {
    // Use the same URL for deletion
    $sql = "DELETE FROM images WHERE address = '$image_url'";
    if ($conn->query($sql) === TRUE) {
        // Delete the image file from the server as well
        if (file_exists($image['address'])) {
            unlink($image['address']);
            echo "<script>
                window.location.href = 'Profile.php';
            </script>";
            exit();
        }
        echo "<script>
            window.location.href = 'Profile.php';
        </script>";
        exit();
    } else {
        echo "Error deleting image: " . $conn->error;
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Image Detail</title>
    <link rel="stylesheet" href="CSS/Profile.css">
</head>
<body>
    <h1><?php echo htmlspecialchars($image['title']); ?></h1>
    <img src="<?php echo htmlspecialchars($image['address']); ?>" alt="<?php echo htmlspecialchars($image['title']); ?>">

    <form method="post">
        <button type="submit" name="delete">Delete Image</button>
    </form>

    <a href="Profile.php">Back to Profile</a>
</body>
</html>
