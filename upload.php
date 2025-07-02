<?php include 'includes/config.php'; ?>
<?php include 'includes/header.php'; ?>

<h1 class="mb-4">Upload New Image</h1>

<?php
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? '';
    $image = $_FILES['image'] ?? null;

    if ($image && $image['error'] === 0) {
        if ($image['size'] <= 5000000) {
            $ext = pathinfo($image['name'], PATHINFO_EXTENSION);
            $filename = uniqid() . '.' . $ext;
            $destination = 'assets/images/' . $filename;

            if (move_uploaded_file($image['tmp_name'], $destination)) {
                $stmt = $pdo->prepare("INSERT INTO images (title, description, filename) VALUES (?, ?, ?)");
                $stmt->execute([$title, $description, $filename]);
                $message = '<div class="alert alert-success">Image uploaded successfully!</div>';
            } else {
                $message = '<div class="alert alert-danger">Failed to move uploaded file.</div>';
            }
        } else {
            $message = '<div class="alert alert-danger">File is too large. Max 5MB allowed.</div>';
        }
    } else {
        $message = '<div class="alert alert-danger">Please upload a valid image.</div>';
    }
}
?>

<?php echo $message; ?>

<form method="POST" enctype="multipart/form-data">
    <div class="mb-3">
        <label class="form-label">Title</label>
        <input type="text" name="title" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Description</label>
        <textarea name="description" class="form-control"></textarea>
    </div>
    <div class="mb-3">
        <label class="form-label">Image File</label>
        <input type="file" name="image" class="form-control" accept="image/*" required>
    </div>
    <button type="submit" class="btn btn-primary">Upload</button>
</form>

<?php include 'includes/footer.php'; ?>
