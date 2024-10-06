<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload</title>
    <link rel="stylesheet" href="CSS/Style.css">
    <link rel="stylesheet" href="CSS/Upload.css">
</head>
<body>

    <h1>Upload</h1>
    <form id="upload_form" method="POST" enctype="multipart/form-data" action="db_handle.php">
        <input type="file" name="file" id="file" required><br><br> <!-- Add breaks to move to new lines -->
        <input type="text" name="title" placeholder="Title" required><br><br> <!-- Break after Title input -->
        <input type="text" name="tags" placeholder="Tags (Space Seperated)" required><br><br> <!-- Break after Tags input -->
        <input type="submit" value="Upload" name="Upload_btn">
    </form>

</body>

</html>

