<?php
require APPROOT . '/views/inc/header.php'; ?>

<h1>
    <?php
    echo $data['title'] ?>
</h1>
<br>
<p><?= $data['description'] ?></p>
<p><?= APP_VERSION ?></p>

<?php
require APPROOT . '/views/inc/footer.php'; ?>
