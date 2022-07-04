<?php require APPROOT . '/views/inc/header.php'; ?>

<div class="row">
    <div class="col md-6">
        <h1>Posts</h1>
    </div>
    <div class="col md-6">
        <a href="<?= URLROOT ?>/posts/add" class="btn btn-primary pull-right">
            <i class="fa-solid fa-pencil"></i> Add post
        </a>
    </div>
</div>
<?php foreach($data['posts'] as $posts) :?>
    <div class="card card-body mb-3">
        <h4 class="card-title">
            <?=$posts->title ?>
        </h4>
        <div class="bg-light p-2 mb-3">
            Written by <?= $posts->name ?> on <?= $posts->postsCreated ?>
        </div>
        <p class="card-text"><?= $posts->body ?></p>
        <a href="<?= URLROOT ?>/posts/show/<?=$posts->postId?>" class="btn btn-dark">More</a>
    </div>

<?php endforeach; ?>

<?php require APPROOT . '/views/inc/footer.php'; ?>


