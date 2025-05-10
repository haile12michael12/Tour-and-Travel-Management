<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= $title ?? 'Tour and Travel Management' ?></title>

<!-- Favicon -->
<link rel="shortcut icon" href="/assets/images/favicon.ico" type="image/x-icon">

<!-- CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
<link href="/assets/css/style.css" rel="stylesheet">

<!-- Additional CSS -->
<?php if (isset($additionalCss)): ?>
    <?php foreach ($additionalCss as $css): ?>
        <link href="<?= $css ?>" rel="stylesheet">
    <?php endforeach; ?>
<?php endif; ?> 