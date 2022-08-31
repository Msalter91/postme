<?php
require APPROOT . '/views/inc/header.php'; ?>
<div class="container text-center">
    <div class="card card-body mx-auto md-6">
        <div class="card-body mx-auto md-6">
            <h2>Register for an account</h2>
            <?= $errors['name_error'];
            $formKey = new FormKey();?>
            <form action="<?= URLROOT ?>/user/users/register" method="post">
                <?php $formKey->outputKey(); ?>
                <div class="mb-3">
                    <label for="name" class="form-label ">Name<sup>*</sup></label>
                    <input type="text" class="form-control
                <?= (!empty($errors['name_error'])) ? 'is-invalid' : '' ?>" id="name" name="name"
                           value="<?= $data->getName() ?>">
                    <span class=invalid-feedback"">
                <?= $errors['name_error'] ?>
                </span>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email<sup>*</sup></label>
                    <input type="email" class="form-control
                <?= (!empty($errors['email_error'])) ? "is-invalid" : "" ?>" id="email" name="email"
                           value="<?= $data->getEmail() ?>">
                    <span class="invalid-feedback"><?= $errors['email_error'] ?></span>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label ">Password<sup>*</sup></label>
                    <input type="password" class="form-control
                <?= (!empty($errors['password_error'])) ? "is-invalid" : "" ?>" id="password" name="password">
                    <span class="invalid-feedback">
                        <?= (!empty($errors['password_error'])) ? "Password invalid" : "" ?>
                    </span>
                </div>
                <div class="mb-3">
                    <label for="confirm_password" class="form-label ">Confirm your password<sup>*</sup></label>
                    <input type="password" class="form-control
                <?= (!empty($errors['confirm_password_error'])) ? "is-invalid" : "" ?>" id="confirm_password"
                           name="confirm_password">
                    <span class="invalid-feedback">
                        <?= (!empty($errors['confirm_password_error'])) ? "Password confirmation invalid" : "" ?>
                    </span>
                </div>
                <div class="row">
                    <div class="col">
                        <input type="submit" value="Register" class="btn btn-success btn block">
                    </div>

                    <div class="col">
                        <a href="<?= URLROOT ?>/user/users/login" class="btn btn-light btn-block">Have an account?
                            Login</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


<?php
require APPROOT . '/views/inc/footer.php'; ?>

