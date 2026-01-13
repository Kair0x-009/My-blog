<?php
session_start();
require 'connection.php';

// Fetch latest blog posts
$sql = "SELECT p.id, p.title, p.slug, p.image, p.content, p.created_at, u.full_name AS author
        FROM post p
        JOIN users u ON p.user_id = u.user_id
        WHERE p.status = 1
        ORDER BY p.created_at DESC";

$result = mysqli_query($conn, $sql);
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
        <h1 class="mb-4 h2">Latest Blog Posts</h1>
        <div class="row g-4">
            <?php if (mysqli_num_rows($result) > 0) : ?>
                <?php while ($post = mysqli_fetch_assoc($result)) : ?>
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 shadow-sm">
                            <img src="uploads/post/<?= $post['image'] ?>" class="card-img-top" alt="<?= htmlspecialchars($post['title']) ?>">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title"><?= htmlspecialchars($post['title']) ?></h5>
                                <p class="card-text text-truncate"><?= strip_tags($post['content']) ?></p>
                                <p class="text-muted mb-2 mt-auto">
                                    By <?= htmlspecialchars($post['author']) ?> | <?= date('M d, Y', strtotime($post['created_at'])) ?>
                                </p>
                                <a href="post-detail.php?slug=<?= $post['slug'] ?>" class="btn btn-primary read-more mt-auto">Read More</a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else : ?>
                <div class="col-12">
                    <p class="text-center">No posts found.</p>
                </div>
            <?php endif; ?>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<?php
// Close DB connection
$conn->close();
?>