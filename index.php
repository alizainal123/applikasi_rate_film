<?php

try {
    $db = new PDO('sqlite:movies.db');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
   
    $db->exec("CREATE TABLE IF NOT EXISTS movies (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        title TEXT NOT NULL,
        rating INTEGER NOT NULL CHECK (rating BETWEEN 1 AND 5)
    )");

   
    $movies = $db->query("SELECT * FROM movies")->fetchAll(PDO::FETCH_ASSOC);

    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        try {
            $title = $_POST['title'];
            $rating = $_POST['rating'];

           
            $stmt = $db->prepare("INSERT INTO movies (title, rating) VALUES (?, ?)");
            $stmt->execute([$title, $rating]);
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
    <title>Movie Ratings</title>
</head>
<head>
    <title>Aplikasi Rating Film</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Movie Rating</h1>
        </header>
        <div class="form-container">
            <h2>Tambah Film Baru</h2>
            <?php if (isset($error)): ?>
                <div style="color: red;"><?= $error ?></div>
            <?php endif; ?>
            <form action="" method="POST">
                <div class="form-group">
                    <label for="title">Judul Film:</label>
                    <input type="text" name="title" placeholder="Masukkan Judul Film" required>
                </div>
                <div class="form-group">
                    <label for="rating">Rating (1-5):</label>
                    <input type="number" name="rating" min="1" max="5" placeholder="Masukkan Rating" required>
                </div>
                <button type="submit">Tambah Film</button>
            </form>
        </div>

    
        <h2>Daftar Film</h2>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Judul Film</th>
                        <th>Rating Film</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($movies as $movie): ?>
                    <tr>
                        <td><?= htmlspecialchars($movie['title']) ?></td>
                        <td><?= htmlspecialchars($movie['rating']) ?></td>
                        <td>
                            <a href="edit_movie.php?id=<?= $movie['id'] ?>" class="edit">Edit</a> | 
                            <a href="delete_movie.php?id=<?= $movie['id'] ?>" class="delete" onclick="return confirm('Yakin Ingin menghapus Judul Film Ini?')">Hapus</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
