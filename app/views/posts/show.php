<?php require APPROOT . '/views/inc/header.php'; ?>
<a href="<?= URLROOT?>/posts" class="btn btn-light">Back <i class="fa fa-backward"></i> </a>
<h1><?=$data['title'] ?></h1>

<div class="bg-secondary text-white p-2 mb-3">
    <p>Written By <?= htmlspecialchars('User Placeholder')?> on <?=htmlspecialchars($data['created_at']) ?> </p>
</div>

<p>
    <?= htmlspecialchars($data['body']) ?>
</p>

<?php
if($data['user_id'] == $_SESSION['user_id']) : ?>
<hr>
    <a href="<?= URLROOT?>/post/index/edit/<?=$data['id']?>" class="btn btn-dark">Edit</a>
<!--Make sure this is secure!-->
<form class="float-end" action="<?=URLROOT?>/post/index/delete/<?=$data['post']->id?>" method="post">
    <input type="submit" value="delete" class="btn btn-danger">
</form>

<?php endif; ?>

<div class="container text-center">

</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>
