<?php require APPROOT . '/views/inc/header.php'; ?>
<a href="<?= URLROOT?>/posts" class="btn btn-light">Back <i class="fa fa-backward"></i> </a>
<h1><?=$data['post']->title ?></h1>

<div class="bg-secondary text-white p-2 mb-3">
    <p>Written By <?= $data['user']->name?> on <?=$data['post']->created_at ?> </p>
</div>

<p>
    <?= $data['post']->body ?>
</p>

<?php
if($data['post']->user_id == $_SESSION['user_id']) : ?>
<hr>
    <a href="<?= URLROOT?>/posts/edit/<?=$data['post']->id?>" class="btn btn-dark">Edit</a>
<form class="float-end" action="<?=URLROOT?>/posts/delete/<?=$data['post']->id?>" method="post">
    <input type="submit" value="delete" class="btn btn-danger">
</form>

<?php endif; ?>

<div class="container text-center">

</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>
