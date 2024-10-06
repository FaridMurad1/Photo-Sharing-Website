<?php

include 'connect.php';

// Start the session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


if(isset($_POST['Register_btn'])){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password = md5($password);

    $checkEmail= "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($checkEmail);
    if($result->num_rows > 0){
        echo "<script>
            alert('Email already exists');
            setTimeout(function() {
            window.location.href = 'Index.php'; // Redirect after 200ms
            }, 200); // 200 ms = 0.2 seconds delay
            </script>";
        exit();
    }
    else{
        $sql = "INSERT INTO users (Username, email, password) VALUES ('$name', '$email', '$password')";
        if($conn->query($sql) === TRUE){
            echo "Registration Successful";
            header('Location: Index.php');
        }
        else{
            // echo "Error: ".$sql."<br>".$conn->error;
            echo "<script>
            alert('Registration failed');
            setTimeout(function() {
            window.location.href = 'Index.php'; // Redirect after 200ms
            }, 200); // 200 ms = 0.2 seconds delay
            </script>";
        }
        exit();

    }   
}

if (isset($_POST['Login_btn'])) {
    $email = $_POST['email'];
    $password = md5($_POST['password']);

    $sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        session_start();
        $row = $result->fetch_assoc();

        // Set session variables after successful login
        $_SESSION['user_id'] = $row['Id'];
        $_SESSION['email'] = $row['email'];
        $_SESSION['name'] = $row['Username'];

        // Instead of redirecting, refresh the current page or dynamically update the UI
        echo "<script>
                alert('Login successful');
                // window.location.reload(); 
              </script>";
              header('Location: Index.php');
        exit();
    } else {
        echo "<script>
        alert('Login failed');
        setTimeout(function() {
          window.location.href = 'Index.php'; // Redirect after 200ms
        }, 200); // 200 ms = 0.2 seconds delay
        </script>";
    }
}

// Handle file upload
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // session_start();

    // File Upload Handling
    if (isset($_POST['title']) && isset($_POST['tags']) && isset($_FILES['file'])) {
        $title = $_POST['title'];
        $tags = $_POST['tags'];
        $uploadDir = 'images/';

        if ($_FILES['file']['error'] == 0) {
            $fileName = basename($_FILES['file']['name']);
            $targetFilePath = $uploadDir . $fileName;

            $allowedTypes = ['jpg', 'png', 'jpeg', 'gif'];
            $fileType = pathinfo($fileName, PATHINFO_EXTENSION);

            if (!in_array($fileType, $allowedTypes)) {
                echo "<script>
                        alert('Invalid file type.');
                        setTimeout(function() {
                            window.location.href = 'Index.php'; // Redirect after 200ms
                        }, 200); // 200 ms = 0.2 seconds delay
                      </script>";
                exit();
            }

            if (move_uploaded_file($_FILES['file']['tmp_name'], $targetFilePath)) {
                $sql = "INSERT INTO images (title, address, uploader, tags, count) VALUES ('$title', '$targetFilePath', '" . $_SESSION['email'] . "', '$tags', 0)";
                if ($conn->query($sql) === TRUE) {
                    header('Location: Index.php');
                    exit(); // Ensure no further processing occurs
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            } else {
                echo "Error during file upload.";
                echo "<script>
                        alert('Invalid file type.');
                        setTimeout(function() {
                            window.location.href = 'Index.php'; // Redirect after 200ms
                        }, 200); // 200 ms = 0.2 seconds delay
                      </script>";
                exit();
            }
        }
    }

    // Edit Username
    if (isset($_POST['saveUsername']) && isset($_POST['username'])) {
        $newUsername = $_POST['username'];
        $sql = "UPDATE users SET Username='$newUsername' WHERE email='" . $_SESSION['email'] . "'";
        if ($conn->query($sql) === TRUE) {
            // Update the session variable
            $_SESSION['name'] = $newUsername;
            
            echo "Username updated successfully";
            echo "<script>
                setTimeout(function() {
                alert('Username updated successfully');
                window.location.href = 'Index.php'; // Redirect after 200ms
                }, 200); // 200 ms = 0.2 seconds delay
            </script>";
            header('Location: Profile.php');
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
            echo "<script>
                setTimeout(function() {
                alert('Username update failed');
                window.location.href = 'Index.php'; // Redirect after 200ms
                }, 200); // 200 ms = 0.2 seconds delay
            </script>";
            header('Location: Profile.php');
            exit();
        }
    }

    // Edit Password
    if (isset($_POST['savePassword'])) {
        $oldPassword = md5($_POST['oldPassword']);
        $newPassword = md5($_POST['password']);
        $confirmPassword = md5($_POST['confirmPassword']);

        $sql = "SELECT * FROM users WHERE email='" . $_SESSION['email'] . "' AND password='$oldPassword'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            if ($newPassword == $confirmPassword) {
                $sql = "UPDATE users SET password='$newPassword' WHERE email='" . $_SESSION['email'] . "'";
                if ($conn->query($sql) === TRUE) {
                    echo "Password updated successfully";
                    echo "<script>
                        setTimeout(function() {
                        alert('Password updated successfully');
                        window.location.href = 'Profile.php'; // Redirect after 200ms
                        }, 200); // 200 ms = 0.2 seconds delay
                    </script>";
                    header('Location: Profile.php');
                    exit();
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                    echo "<script>
                        setTimeout(function() {
                        alert('Password update failed');
                        window.location.href = 'Settings.php'; // Redirect after 200ms
                        }, 200); // 200 ms = 0.2 seconds delay
                    </script>";
                    header('Location: Settings.php');
                    exit(); 
                }
            } else {
                echo "Passwords do not match";
                echo "<script>
                    setTimeout(function() {
                    alert('Passwords do not match');
                    window.location.href = 'Settings.php'; // Redirect after 200ms
                    }, 200); // 200 ms = 0.2 seconds delay
                </script>";
                header('Location: Settings.php');
                exit();
            }
        } else {
            echo "Incorrect old password";
            echo "<script>
                setTimeout(function() {
                alert('Incorrect old password');
                window.location.href = 'Settings.php'; // Redirect after 200ms
                }, 200); // 200 ms = 0.2 seconds delay
            </script>";
            header('Location: Settings.php');
            exit();
        }
    }
}


// Fetch Image from Database for specific user

// Initialize the userImagesData array
$userImagesData = []; 

// Check if the user is logged in
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id']; // Get the logged-in user's ID

    // Fetch images uploaded by the current user
    $sql = "SELECT * FROM images WHERE uploader = (SELECT email FROM users WHERE Id = '$user_id')";
    $result = $conn->query($sql);

    // Prepare the image data
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $userImagesData[] = [
                'url' => $row['address'],
                'title' => $row['title'],
            ];
        }
    }
} else {
    // Optionally, you can handle the case when the user is not logged in
    // $userImagesData remains an empty array
}

// Pass image data to JavaScript
echo '<script>';
echo 'const userImagesData = ' . json_encode($userImagesData) . ';'; // Pass user image data to JavaScript
// Uncomment below for debugging in the browser console
// echo 'console.log(userImagesData);'; 
echo '</script>';


// // Fetch image data from the database

$sql = "SELECT * FROM images";
$result = $conn->query($sql);

// Store image data in a PHP array to send to JavaScript
$imageData = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $imageData[] = [
            'url' => $row['address'],
            'title' => $row['title'],
            'tags' => $row['tags'],
        ];
    }
}

// Pass the image data to JavaScript via JSON encoding
echo '<script>';
echo 'const imageData = ' . json_encode($imageData) . ';';
// echo 'console.log(imageData);'; // Add this for debugging
// echo 'console.log(imageData[0].tags);'; // Add this for debugging
echo '</script>';

?>

