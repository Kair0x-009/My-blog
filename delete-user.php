<?php
session_start();
require 'connection.php';
$userID = $_GET['id'];
$sql = "DELETE FROM users WHERE user_id = '$userID'";
$results = mysqli_query($conn ,$sql);

if (mysqli_num_rows($results)>0) {
    $row = mysqli_fetch_assoc($results);
    if ($row['user_id']== $_SESSION['userId']) {
        header("Location: users-list.php");
        exit();
    }

    $delete = "DELETE FROM users WHERE id = userID'";
    if (mysqli_query($conn,$delete)===TRUE) {
        header("Location: users-list.php");
    }
}else {
    echo "User Not Found";
}
?>