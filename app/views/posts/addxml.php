<?php
require APPROOT . '/views/inc/header.php'; ?>
<a href="<?= URLROOT ?>/post/index/add" class="btn btn-light">Back <i class="fa fa-backward"></i> </a>
<a href="<?= URLROOT ?>/posts" class="btn btn-info float-end">Add post with Text <i class="fa fa-file"></i> </a>
<div class="container text-center">
    <div class="card">
        <div class="card-body md-6">
            <h2>Posting with XML</h2>
            <?php foreach ($errors as $error): ?>
                <?= $error ?>
            <?php endforeach; ?>
            <div class="container">
                <div class="row">
                    <div class="col">
                        Download our XML Template
                        <a href="<?= URLROOT ?>/post/index/downloadTemplate" class="btn btn-info">
                            <i class="fa fa-file"></i>
                        </a>
                    </div>
                    <div class="col">
                        <form method="post" action="<?= URLROOT ?>/post/index/validateXML" enctype="multipart/form-data">
                            <input type="file" name="file" id="'file">
                            <button type="submit">Upload your XML File</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
require APPROOT . '/views/inc/footer.php'; ?>
