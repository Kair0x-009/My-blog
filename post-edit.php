<?php
session_start();
require 'connection.php';

// LOGIN CHECK
if (!isset($_SESSION['isLogin']) == true) {
    header("Location: login.php");
    exit;
}

// CHECK ID
if (!isset($_GET['id'])) {
    header("Location: post-list.php");
    exit;
}

$id = $_GET['id'];

$categorySql = "SELECT * FROM categories";
$result = mysqli_query($conn, $categorySql);

// FETCH POST DATA
$postSql = "SELECT * FROM post WHERE id = '$id'";
$postResult = $conn->query($postSql);

$postResult = mysqli_query($conn, $postSql);

if (mysqli_num_rows($postResult) == 0) {
    header("Location: post-list.php");
    exit;
}

$post = mysqli_fetch_assoc($postResult);

// FORM SUBMIT
if (isset($_POST['update'])) {

    // Fetch values
    $title   = trim($_POST['title']);
    $slug    = trim($_POST['slug']);
    $content = trim($_POST['content']);
    $category = trim($_POST['category'] ?? '');
    $image   = $_FILES['image'];

    // VALIDATION
    if (empty($title)) {
        $message = "Title is required.";
        $messageType = "danger";
    } elseif (empty($slug)) {
        $message = "Slug is required.";
        $messageType = "danger";
    } elseif (empty($category)) {
        $message = "Category is required.";
        $messageType = "danger";
    } elseif (empty($content)) {
        $message = "Content is required.";
        $messageType = "danger";
    } else {

        // Escape values
        $title   = mysqli_real_escape_string($conn, $title);
        $slug    = mysqli_real_escape_string($conn, $slug);
        $content = mysqli_real_escape_string($conn, $content);
        $category = mysqli_real_escape_string($conn, $category);

        // IMAGE CHECK (OPTIONAL)
        if ($image['error'] == 4) {
            // UPDATE WITHOUT IMAGE
            $sql = "UPDATE post SET 
                        title = '$title',
                        slug = '$slug',
                        content = '$content',
                        category_id = '$category'
                    WHERE id = '$id'";

            if (mysqli_query($conn, $sql) === TRUE) {
                $message = "Post Updated Successfully.";
                $messageType = "success";
            } else {
                $message = "Database Error: " . $conn->error;
                $messageType = "danger";
            }
        } else {

            // IMAGE VALIDATION
            $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
            $maxSize = 2 * 1024 * 1024;

            if (!in_array($image['type'], $allowedTypes)) {
                $message = "Only JPG, JPEG and PNG images are allowed.";
                $messageType = "danger";
            } elseif ($image['size'] > $maxSize) {
                $message = "Image size must be less than 2MB.";
                $messageType = "danger";
            } else {

                // IMAGE UPLOAD
                $imageName = time() . "_" . basename($image['name']);
                $targetDir = "uploads/post/";
                $targetFile = $targetDir . $imageName;

                if (move_uploaded_file($image['tmp_name'], $targetFile)) {

                    // OPTIONAL: delete old image
                    if (!empty($post['image']) && file_exists($targetDir . $post['image'])) {
                        unlink($targetDir . $post['image']);
                    }

                    // UPDATE WITH IMAGE
                    $sql = "UPDATE post SET 
                                title = '$title',
                                slug = '$slug',
                                content = '$content',
                                category_id = '$category',
                                image = '$imageName'
                            WHERE id = '$id'";

                    if (mysqli_query($conn, $sql) === TRUE) {
                        $message = "Post Updated Successfully.";
                        $messageType = "success";
                    } else {
                        $message = "Database Error: " . $conn->error;
                        $messageType = "danger";
                    }
                } else {
                    $message = "Image upload failed.";
                    $messageType = "danger";
                }
            }
        }
    }

    // REFRESH DATA AFTER UPDATE
    $postResult = mysqli_query($conn, $postSql);
    $post = mysqli_fetch_assoc($postResult);
}
// Close DB connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Post</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <?php include 'include/navbar.php'; ?>

    <div class="container my-5">
        <div class="row">
            <?php include 'include/sidebar.php'; ?>
            <div class="col-lg-9">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h3>Edit Post</h3>
                    <a href="post-list.php" class="btn btn-primary">All Post</a>
                </div>

                <?php if (!empty($message)) { ?>
                    <div class="alert alert-<?= $messageType ?>">
                        <?= $message ?>
                    </div>
                <?php } ?>

                <div class="card">
                    <div class="card-body">
                        <form method="post" enctype="multipart/form-data">

                            <div class="mb-3">
                                <label>Title</label>
                                <input type="text" class="form-control" name="title"
                                    value="<?= $post['title'] ?>">
                            </div>

                            <div class="mb-3">
                                <label>Slug</label>
                                <input type="text" class="form-control" name="slug"
                                    value="<?= $post['slug'] ?>">
                            </div>

                            <div class="mb-3">
                                <label>Content</label>
                                <textarea name="content" rows="8"
                                    class="form-control"><?= $post['content'] ?></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="category">Category</label>
                                <select name="category" class="form-select">
                                    <option value="">Select Category</option>
                                    <?php while ($category = mysqli_fetch_assoc($result)) { ?>
                                        <option value="<?= $category['ID']; ?>" <?= $post['category_id'] == $category['ID'] ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($category['name']); ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label>Current Image</label><br>
                                <img src="uploads/post/<?= $post['image'] ?>" width="120">
                            </div>

                            <div class="mb-3">
                                <label>New Image (Optional)</label>
                                <input type="file" class="form-control" name="image">
                            </div>

                            <button type="submit" name="update" class="btn btn-success">
                                Update
                            </button>

                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>