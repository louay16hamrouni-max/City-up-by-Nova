<!DOCTYPE html><html lang="en"><head><?php require __DIR__.'/partials/head.php'; ?></head>
<body class="admin-page">
<?php require __DIR__.'/partials/sidebar.php'; ?>
<div class="admin-shell">
<?php require __DIR__.'/partials/header.php'; ?>
<main class="admin-main"><?php echo $content; ?></main>
<?php require __DIR__.'/partials/footer.php'; ?>
</div>
<?php require __DIR__.'/partials/scripts.php'; ?>
</body></html>
