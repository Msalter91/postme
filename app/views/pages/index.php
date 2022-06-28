<?php require APPROOT . '/views/inc/header.php'; ?>

<h1>Hello
    <?php echo $data['title'] ?>
    <ul>
        <?php foreach($data['posts'] as $post) : ?>
            <li><?=$post->title ?></li>
        <?php endforeach ; ?>
    </ul>
</h1>

<?php require APPROOT . '/views/inc/footer.php'; ?>