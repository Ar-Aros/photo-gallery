<?php include 'includes/config.php'; ?>
<?php include 'includes/header.php'; ?>

<h1 class="mb-4">Uploaded Images</h1>

<div class="row">
<?php
$stmt = $pdo->query("SELECT * FROM images ORDER BY upload_date DESC");
while ($row = $stmt->fetch()):
?>
    <div class="col-md-4 mb-4">
        <div class="card">
            <img src="assets/images/<?php echo htmlspecialchars($row['filename']); ?>" class="card-img-top" alt="Image">
            <div class="card-body">
                <h5 class="card-title"><?php echo htmlspecialchars($row['title']); ?></h5>
                <p class="card-text"><small class="text-muted">Uploaded on <?php echo $row['upload_date']; ?></small></p>
            </div>
        </div>
    </div>
<?php endwhile; ?>
</div>

<?php include 'includes/footer.php'; ?>
