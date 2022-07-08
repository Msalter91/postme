<?php require APPROOT . '/views/inc/header.php'; ?>
<?php flash('post_message')?>
<div class="row">
    <div class="col md-6">
        <h1>Posts</h1>
    </div>
    <div class="col md-6">
        <a href="<?= URLROOT ?>/post/index/add" class="btn btn-primary pull-right">
            <i class="fa-solid fa-pencil"></i> Add post
        </a>
    </div>
</div>
<?php foreach($data['posts'] as $posts) :?>
    <div class="card card-body mb-3">
        <h4 class="card-title">
            <?=htmlspecialchars($posts->title) ?>
        </h4>
        <div class="bg-light p-2 mb-3">
            Written by <?= htmlspecialchars($posts->name) ?> on <?= htmlspecialchars($posts->postsCreated) ?>
        </div>
        <p class="card-text"><?= htmlspecialchars($posts->body) ?></p>
        <a href="<?= URLROOT ?>/post/index/show/<?=htmlspecialchars($posts->postId)?>" class="btn btn-dark">More</a>
    </div>

<?php endforeach; ?>

<?php require APPROOT . '/views/inc/footer.php'; ?>


