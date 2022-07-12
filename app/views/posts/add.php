<?php
require APPROOT . '/views/inc/header.php'; ?>
    <a href="<?= URLROOT ?>/posts" class="btn btn-light">Back <i class="fa fa-backward"></i> </a>
    <div class="container text-center">
        <div class="card">
            <div class="card-body md-6">
                <h2>Add a new post</h2>
                <p>Create a new post</p>
                <form action="<?= URLROOT ?>/post/index/add" method="post">
                    <div class="mb-3">
                        <label for="title" class="form-label ">Title<sup>*</sup></label>
                        <input type="text" class="form-control
                <?= (!empty($errors['title_error'])) ? "is-invalid" : "" ?>" id="title" name="title"
                               value="<?= $data->getTitle() ?>">
                        <span class="invalid-feedback"><?= $errors['title_error'] ?></span>
                    </div>
                    <div class="mb-3">
                        <label for="body" class="form-label ">Body<sup>*</sup></label>
                        <textarea name="body"
                                  class="form-control <?= (!empty($errors['body_error'])) ? "is-invalid" : "" ?>"
                                  id="body"><?= $data->getBody() ?></textarea>
                        <span class="invalid-feedback"><?= $errors['body_error'] ?></span>
                    </div>
                    <div class="row">
                        <div class="col">
                            <input type="submit" value="submit" class="btn btn-success btn-block">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php
require APPROOT . '/views/inc/footer.php'; ?>