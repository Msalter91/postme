<?php
require APPROOT . '/views/inc/header.php'; ?>
    <div class="p-5 mb-4 bg-light rounded-3 text-center">
        <div class="container">
            <h1><?php
                echo $data['title'] ?></h1>
            <p class="lead"><?= $data['description'] ?></p>
        </div>
    </div>
<?php
require APPROOT . '/views/inc/footer.php'; ?>