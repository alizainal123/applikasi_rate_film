
<?php
try {
    $db = new PDO('sqlite:movie_ratings.db');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $db->exec("CREATE TABLE IF NOT EXISTS movies (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        title TEXT NOT NULL,
        rating INTEGER NOT NULL CHECK(rating >= 1 AND rating <= 5)
    )");
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    exit();
}
?>
