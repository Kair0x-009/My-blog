<?php
session_start();
require 'connection.php';

$postSlug = $_GET['slug'];

// Fetch Single blog posts
$sql = "SELECT p.id, p.title, p.slug, p.image, p.content, p.created_at, u.full_name AS author
        FROM post p
        JOIN users u ON p.user_id = u.user_id
        WHERE p.status = 1 AND p.slug = '$postSlug'";

$result = mysqli_query($conn, $sql);
if(mysqli_num_rows($result)==0){
header("Location : blog.php");
exit;
}

$post = mysqli_fetch_assoc($result);


?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Blog - Latest Posts</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .card-img-top {
            height: 200px;
            object-fit: cover;
        }

        .card-title {
            font-size: 1.25rem;
            font-weight: 600;
        }

        .card-text {
            font-size: 0.95rem;
        }

        .read-more {
            text-decoration: none;
        }

        .read-more:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>

    <?php include 'include/navbar.php'; ?>

    <div class="container py-5">
        <h1 class="mb-4 h2"><?= $post['title'] ?></h1>
        <div class="row g-4">
            <p>
                <span>Author:<i><strong><?= $post['author'] ?></strong></i></span>
                ||
                <span><?= $post['created_at'] ?></span>
                <img class="card-img-top card h-100" src="uploads/post/<?= $post['image'] ?>" alt="">
            </p>
            <hr>
            <p>
               <marquee behavior="" direction=""> <h3><?= $post['content'] ?></h3>
                </marquee>
            </p>
            <hr>
            <div class="mt-3">
                <h5>
                    Comments
                </h5>
                <form action="" method="post">
                    <textarea name="comment" id="" rows="5" placeholder="Your comment goes here..." class="form-control"></textarea>
            <button class="btn btn-primary mt-1"type="submit">Post Comment</button></form>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<?php
// Close DB connection
$conn->close();
?>