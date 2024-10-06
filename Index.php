<?php
// session_start();

// Check if the user is logged in and show/hide specific menu items dynamically
$loggedIn = isset($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html class="photo-sharing">
    <head>
        <?php include 'db_handle.php'; ?>
        <title>Photo Sharing</title>
        <link rel="stylesheet" href="CSS/Style.css">
        <link rel="stylesheet" href="CSS/Login.css">
    </head>
    <body>        
        <header id="Header">
            <nav>
                <ul>
                    <li><a href="Index.php">Logo</a></li>

                    <?php if (!isset($_SESSION['user_id'])): ?>
                        <!-- Show login and register links if not logged in -->
                        <li class="hideOnMobile"><a href="#" id="loginLink">Login</a></li>
                        <li class="hideOnMobile"><a href="#" id="registerLink">Register</a></li>
                    <?php endif; ?>

                    <?php if (isset($_SESSION['user_id'])): ?>
                        <!-- Show upload and profile links if logged in -->
                        <li class="hideOnMobile"><a href="#" id="uploadLink">Upload</a></li>
                        <li class="hideOnMobile"><a href="Profile.php">Profile</a></li>
                    <?php endif; ?>

                    <li class="menu-button" onclick="showSidebar()">
                        <a href="#">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24">
                                <path d="M120-240v-80h720v80H120Zm0-200v-80h720v80H120Zm0-200v-80h720v80H120Z"/>
                            </svg>
                        </a>
                    </li>
                </ul>   
            </nav>

            <div id="sidebarContainer" class="sidebar-container">
                <nav>
                    <ul class="sidebar">
                        <li onclick="closeSidebar()">
                            <a href="#">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24">
                                    <path d="m256-200-56-56 224-224-224-224 56-56 224 224 224-224 56 56-224 224 224 224-56 56-224-224-224 224Z"/>
                                </svg>
                            </a>
                        </li>

                        <?php if (!isset($_SESSION['user_id'])): ?>
                            <li><a href="#" id="loginLinkSidebar">Login</a></li>
                            <li><a href="#" id="registerLinkSidebar">Register</a></li>
                        <?php endif; ?>
                        
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <li><a href="#" id="uploadLinkSidebar">Upload</a></li>
                            <li><a href="Profile.php">Profile</a></li>
                        <?php endif; ?>
                    </ul>
                </nav>
            </div>


            <!-- Modal structure -->
            <div id="modal" class="modal">
                <div id="modal-content" class="modal-content">
                    <span class="close-btn">&times;</span>
                    <!-- Content will be loaded dynamically -->
                </div>
            </div>
            <!-- Download Modal -->
            <div id="downloadModal" class="modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <div id="modalContent"></div> <!-- Content will be loaded here -->
                </div>
            </div>
        </header>

        <!-- Search Box -->
        

        <!-- Photo area -->
        <main>
            <div class="searchContainer">
                <form method="POST" action="db_handle.php" id="searchForm"> 
                    <input type="text" name ="Search" placeholder="Search..." required>
                    <button type="submit" name="Search_btn" onclick="search()">Search</button>
                </form>
            </div>
            <div class="image-grid" id="imageGrid">
                <!-- Images will be dynamically loaded here -->
            </div>
    
            <!-- Load More Button -->
            <button id="loadMoreButton">Load More</button>
        </main>

        <footer>
            <p>© 2024 Photo Sharing</p>
        </footer>
        <script src="Script.js"></script>
    </body>
</html>
