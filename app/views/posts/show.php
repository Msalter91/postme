<?php require APPROOT . '/views/inc/header.php'; ?>
<a href="<?= URLROOT?>/posts" class="btn btn-light">Back <i class="fa fa-backward"></i> </a>
<h1><?=$data->getTitle() ?></h1>

<div class="bg-secondary text-white p-2 mb-3">
    <p>Written By <?= htmlspecialchars('User Placeholder')?> on <?=htmlspecialchars($data->getCreatedAt()) ?> </p>
</div>

<p>
    <?= htmlspecialchars($data->getBody()) ?>
</p>

<a href="<?= URLROOT?>/post/index/createXML/<?= $data->getId()?>" class="btn btn-info float-end">Dowload as XML</a>

<?php
if ($data->getUserId() == $_SESSION['user_id']) : ?>
<hr>
    <a href="<?= URLROOT?>/post/index/edit/<?= $data->getId()?>" class="btn btn-dark">Edit</a>
<form class="float-end" action="<?=URLROOT?>/post/index/delete/<?=$data->getId()?>" method="post">
    <input type="submit" value="delete" class="btn btn-danger">
</form>

<?php endif; ?>

<div class="container text-center">

</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>
