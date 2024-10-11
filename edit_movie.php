<?php

try {
    $db = new PDO('sqlite:movies.db');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $stmt = $db->prepare("SELECT * FROM movies WHERE id = ?");
        $stmt->execute([$id]);
        $movie = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$movie) {
            die("Film tidak ditemukan.");
        }
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        try {
            $title = $_POST['title'];
            $rating = $_POST['rating'];

            $stmt = $db->prepare("UPDATE movies SET title = ?, rating = ? WHERE id = ?");
            $stmt->execute([$title, $rating, $id]);
            header("Location: index.php"); 
            exit;
        } catch (Exception $e) {
            $error = "Terjadi kesalahan: " . $e->getMessage();
        }
    }
} catch (PDOException $e) {
    echo "Koneksi gagal: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Film</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Edit Film</h1>
        <?php if (isset($error)): ?>
            <div class="error"><?= $error ?></div>
        <?php endif; ?>
        <form action="" method="POST">
            <div class="form-group">
                <label for="title">Judul Film:</label>
                <input type="text" name="title" value="<?= htmlspecialchars($movie['title']) ?>" required>
            </div>
            <div class="form-group">
                <label for="rating">Rating Film (1-5):</label>
                <input type="number" name="rating" min="1" max="5" value="<?= htmlspecialchars($movie['rating']) ?>" required>
            </div>
            <button type="submit">Simpan Perubahan</button>
            <a href="index.php" class="back-button">Kembali</a>
        </form>
    </div>
</body>
</html>
