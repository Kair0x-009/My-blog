<?php
session_start();
require 'connection.php';

//LOGIN CHECK
if (!isset($_SESSION['isLogin']) == true) {
    header("Location: login.php");
    exit;
}

$categorySql = "SELECT * FROM categories";
$result = mysqli_query($conn, $categorySql);

//FORM SUBMIT
if (isset($_POST['save'])) {

    // Fetch values
    $title   = trim($_POST['title']);
    $slug    = trim($_POST['slug']);
    $content = trim($_POST['content']);
    $category = trim($_POST['category'] ?? '');
    $image   = $_FILES['image'];

    $status    = 1;
    $createdAt = date('Y-m-d H:i:s');
    $userId    = $_SESSION['userId'];

    //VALIDATION
    if (empty($title)) {
        $message = "Title is required.";
        $msgType = "danger";
    } elseif (empty($slug)) {
        $message = "Slug is required.";
        $msgType = "danger";
    } elseif (empty($slug)) {
        $message = "Slug is required.";
        $msgType = "danger";
    } elseif (empty($category)) {
        $message = "Category is required.";
        $msgType = "danger";
    } elseif ($image['error'] == 4) {
        $message = "Image is required.";
        $msgType = "danger";
    } else {

        //IMAGE VALIDATION
        $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
        $maxSize = 2 * 1024 * 1024; // 2MB

        if (!in_array($image['type'], $allowedTypes)) {
            $message = "Only JPG, JPEG and PNG images are allowed.";
            $msgType = "danger";
        } elseif ($image['size'] > $maxSize) {
            $message = "Image size must be less than 2MB.";
            $msgType = "danger";
        } else {

            //IMAGE UPLOAD
            $imageName = time() . "_" . basename($image['name']);
            $targetDir = "uploads/post/";
            $targetFile = $targetDir . $imageName;

            if (move_uploaded_file($image['tmp_name'], $targetFile)) {

                // Escape values
                $title   = mysqli_real_escape_string($conn, $title);
                $slug    = mysqli_real_escape_string($conn, $slug);
                $content = mysqli_real_escape_string($conn, $content);

                //INSERT QUERY
                $sql = "INSERT INTO post
                        (title, slug, image, content, status, created_at, user_id, category_id)
                        VALUES 
                        ('$title', '$slug', '$imageName', '$content', '$status', '$createdAt', '$userId', '$category')";

                if ($conn->query($sql) === TRUE) {
                    $message = "Post Created Successfully.";
                    $msgType = "success";
                } else {
                    $message = "Database Error: " . $conn->error;
                    $msgType = "danger";
                }
            } else {
                $message = "Image upload failed.";
                $msgType = "danger";
            }
        }
    }
}
// Close DB connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post Category</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <?php include 'include/navbar.php'; ?>

    <div class="container my-5">
        <div class="row">
            <?php include 'include/sidebar.php'; ?>
            <div class="col-lg-9">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h3>Create Post</h3>
                    <a href="post-list.php" class="btn btn-primary">All Post</a>
                </div>
                <?php if (!empty($message)) { ?>
                    <div class="alert alert-<?= $msgType ?>">
                        <?= $message ?>
                    </div>
                <?php } ?>
                <div class="card">
                    <div class="card-body">
                        <form action="post-create.php" method="post" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="title">Title</label>
                                <input type="text" class="form-control" name="title" placeholder="Post Title">
                            </div>
                            <div class="mb-3">
                                <label for="slug">Slug</label>
                                <input type="text" class="form-control" name="slug" placeholder="Post Slug">
                            </div>
                            <div class="mb-3">
                                <label for="content">Content</label>
                                <textarea name="content" cols="30" rows="10" class="form-control"></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="category">Category</label>
                                <select name="category" class="form-select">
                                    <option value="">Select Category</option>
                                    <?php while ($category = mysqli_fetch_assoc($result)) { ?>
                                        <option value="<?= $category['ID']; ?>">
                                            <?= htmlspecialchars($category['name']); ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="image">Image</label>
                                <input type="file" class="form-control" name="image" placeholder="Post Image">
                            </div>
                            <input type="submit" value="Save" class="btn btn-primary" name="save">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>