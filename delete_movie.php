<?php

try {
    $db = new PDO('sqlite:movies.db');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $stmt = $db->prepare("DELETE FROM movies WHERE id = ?");
        $stmt->execute([$id]);
    }
    
    header("Location: index.php"); 
    exit; 
} catch (PDOException $e) {
    echo "Koneksi gagal: " . $e->getMessage();
}
?>
