<?php
$mysqli = new mysqli("mysql", "root", "P@ssw0rd", "newsdb");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$result = $mysqli->query("SELECT * FROM news ORDER BY id DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>News App</title>
</head>
<body>
    <h1>News App</h1>
    <p><a href="add.php">Add News</a></p>

    <?php while ($row = $result->fetch_assoc()): ?>
        <hr>
        <h2><?php echo htmlspecialchars($row['title']); ?></h2>
        <p><?php echo nl2br(htmlspecialchars($row['content'])); ?></p>

        <?php if (!empty($row['image1'])): ?>
            <div>
                <img src="uploads/<?php echo htmlspecialchars($row['image1']); ?>" width="300">
            </div>
        <?php endif; ?>

        <?php if (!empty($row['image2'])): ?>
            <div>
                <img src="uploads/<?php echo htmlspecialchars($row['image2']); ?>" width="300">
            </div>
        <?php endif; ?>

        <small><?php echo $row['created_at']; ?></small>
    <?php endwhile; ?>
</body>
</html>
