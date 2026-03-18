<?php
$mysqli = new mysqli("mysql", "root", "P@ssw0rd", "newsdb");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    $content = $_POST['content'] ?? '';

    $uploadDir = __DIR__ . '/uploads/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $image1Name = "";
    $image2Name = "";

    if (!empty($_FILES['image1']['name'])) {
        $image1Name = time() . "_1_" . basename($_FILES['image1']['name']);
        move_uploaded_file($_FILES['image1']['tmp_name'], $uploadDir . $image1Name);
    }

    if (!empty($_FILES['image2']['name'])) {
        $image2Name = time() . "_2_" . basename($_FILES['image2']['name']);
        move_uploaded_file($_FILES['image2']['tmp_name'], $uploadDir . $image2Name);
    }

    $stmt = $mysqli->prepare("INSERT INTO news (title, content, image1, image2) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $title, $content, $image1Name, $image2Name);

    if ($stmt->execute()) {
        $message = "News added successfully!";
    } else {
        $message = "Error: " . $stmt->error;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Add News</title>
</head>
<body>
    <h1>Add News</h1>
    <p><a href="index.php">Back to News List</a></p>

    <?php if ($message): ?>
        <p><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data">
        <p>
            Title:<br>
            <input type="text" name="title" required style="width: 400px;">
        </p>

        <p>
            Content:<br>
            <textarea name="content" rows="8" cols="60" required></textarea>
        </p>

        <p>
            Image 1:<br>
            <input type="file" name="image1" accept="image/*">
        </p>

        <p>
            Image 2:<br>
            <input type="file" name="image2" accept="image/*">
        </p>

        <p>
            <button type="submit">Save</button>
        </p>
    </form>
</body>
</html>
