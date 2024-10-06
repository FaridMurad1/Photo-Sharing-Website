<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: Index.php');
    exit();
}
?>

<!doctype html>
<html class="profile">
<head>
    <?php include 'db_handle.php'; ?>
    <title>Profile</title>
    <link rel="stylesheet" href="CSS/Profile.css">
</head>
<body>
    <header id="Header">
        <nav>
            <ul>
                <li><a href="Index.php">Logo</a></li>
                <li class="profile-menu" onclick=showSidebar()><a>Profile</a></li>
            </ul>
        </nav>
        <div id="sidebarContainerProfile" class="sidebar-container-profile">
            <nav>
                <ul class="sidebar">
                    <li onclick=closeSidebar()>
                        <a><svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24">
                            <path d="m256-200-56-56 224-224-224-224 56-56 224 224 224-224 56 56-224 224 224 224-56 56-224-224-224 224Z"/>
                        </svg></a>
                    </li>
                    <li><a href="Settings.php">Settings</a></li>
                    <li><a href="logout.php">Logout</a></li> <!-- Logout link -->
                </ul>
            </nav>
        </div>

        <script src="Script.js"></script>
    </header>
    <!-- Show User name -->
    <h1><?php echo $_SESSION['name']; ?></h1>

    <main>
        <div class="user-image-grid" id="userImageGrid">
            <!-- Images will be dynamically loaded here -->
        </div>
    </main>

    <footer>
        <p>© 2024 Photo Sharing</p>
    </footer>
</body>
</html>
