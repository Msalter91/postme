<?php
require APPROOT . '/views/inc/header.php'; ?>
<div class="container text-center">
    <div class="card">
        <div class="card-body mx-auto md-6">
            <?php
            flash('register_success');
            $formKey = new FormKey();
            ?>
            <h2>Login</h2>
            <?= $errors['form_key_error'] ?>
            <form action="<?= URLROOT ?>/user/Users/login" method="post">
                <div class="mb-3">
                    <?php $formKey->outputKey(); ?>
                    <label for="email" class="form-label ">Email<sup>*</sup></label>
                    <input type="email" class="form-control
                <?= (!empty($errors['email_error'])) ? "is-invalid" : "" ?>" id="email" name="email"
                           value="<?= $data->getEmail() ?>">
                    <span class="invalid-feedback"><?= $errors['email_error'] ?></span>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label ">Password<sup>*</sup></label>
                    <input type="password" class="form-control
                <?= (!empty($errors['password_error'])) ? "is-invalid" : "" ?>" id="password" name="password">
                    <span class="invalid-feedback"><?= (!empty($errors['password_error'])) ? "Password invalid" : "" ?></span>
                </div>
                <div class="col">
                    <input type="submit" value="Login" class="btn btn-success btn block">
                </div>
            </form>
        </div>

    </div>
</div>


<?php
require APPROOT . '/views/inc/footer.php'; ?>

