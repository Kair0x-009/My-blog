<?php 
$server = 'localhost';
$user = 'root';
$password = '';
$databaseName = 'blog_db';
$port = 3307 ;
$conn = mysqli_connect($server , $user , $password , $databaseName , $port);
if(!$conn){
    echo "Connection failed" ;
}
else {
    // echo "Connected Successfully";
}
?>


