<!DOCTYPE html>
<html lang="en">
<head>
    <?php include __DIR__ . '/partials/meta.php'; ?>
</head>
<body>
    <?php include __DIR__ . '/partials/header.php'; ?>

    <!-- Main Content -->
    <main>
        <?php include __DIR__ . '/partials/alerts.php'; ?>
        <?= $content ?>
    </main>

    <?php include __DIR__ . '/partials/footer.php'; ?>
    <?php include __DIR__ . '/partials/scripts.php'; ?>
</body>
</html> 