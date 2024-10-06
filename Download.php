<?php
session_start();
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Download</title>
        <link rel="stylesheet" href="./CSS/Download.css">
    </head>
    <body>
        <div class="downloadContainer">
            <h2>Download</h2>
            <div class="wrapper">
                <div class="editor-panel">
                    <div class="filter">
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <label class="title">Filters</label>
                        <?php endif; ?>
                        <div class="option">
                            <?php if (isset($_SESSION['user_id'])): ?>
                                <button class="active">Brightness</button>
                                <button>Saturation</button>
                                <button>Inversion</button>
                                <button>Grayscale</button>
                            <?php endif; ?>
                        </div>
                        <div class="slider">
                            <?php if (isset($_SESSION['user_id'])): ?>
                                <div class="filter-info">
                                    <p class="name">Brightness</p>
                                    <p class="value">100%</p>
                                </div>
                            <?php endif; ?>
                            <!-- Hide the slider if user not logged in -->
                            <?php if (isset($_SESSION['user_id'])): ?>
                                <input type="range" min="0" max="200" value="100" class="slider" id="brightness">
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="rotate">
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <label for="" class="title">Rotate & Flip</label>
                        <?php endif; ?>
                        <div class="option">
                            <!--Check if the user is logged in and show/hide specific menu items dynamically -->
                            <?php if (isset($_SESSION['user_id'])): ?>
                                <button>rot-left</button>
                                <button>rot-right</button>
                                <button>ref-ver</button>
                                <button>ref-hor</button>
                            <?php endif; ?>
                        </div>
                    </div>                   
                </div>
                <div class="preview-img">
                    <!-- Image will be loaded here dynamically via JavaScript -->
                    <img id="downloadImage" src="" alt="Download Image" />
                </div>
            </div>
            <div class="controls">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <button class="btn" id="reset">Reset</button>
                <?php endif; ?>
                <button class="btn" id="download">Download</button>

                <div class="save">
                </div>
            </div>
        </div>
    </body>
    <script src="./Script.js"></script>
</html>