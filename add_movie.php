<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $rating = $_POST['rating'];

    $stmt = $db->prepare("INSERT INTO movies (title, rating) VALUES (:title, :rating)");
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':rating', $rating);
    $stmt->execute();

    header('Location: index.php');
}
?>
