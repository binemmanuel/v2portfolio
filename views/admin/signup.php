<?php
// Set page title.

use function portfolio\valid_roles;

$page_title = 'Signup';

// Include auth header file
include 'auth-header.php';
?>
            <form action="<?= WEB_ROOT ?>signup/auth" method="post">
                <?php if (!empty($response->error)): ?>
                    <!-- .alert alert-error -->
                    <p class="alert alert-error"><?= $response->message ?></p>
                    <!-- .alert alert-error /-->

                <?php elseif (empty($response->error) && !empty($response->message)): ?>
                    <!-- .alert alert-error -->
                    <p class="alert alert-success"><?= $response->message ?></p>
                    <!-- .alert alert-error /-->

                <?php endif ?>

                <!-- .form-input -->
                <div class="form-input">
                    <input
                        class="input"
                        type="text"
                        name="username"
                        autocomplete="off"
                        required
                        <?php if (!empty($response->filled_data->username)): ?>
                            value="<?= $response->filled_data->username ?>"

                        <?php else: ?>
                            autofocus

                        <?php endif ?> />

                    <label class="label" for="username">
                        <span class="label-text">Username</span>
                    </label>
                </div>
                <!-- .form-input /-->

                <!-- .form-input -->
                <div class="form-input">
                    <input
                        class="input"
                        type="email"
                        name="email"
                        autocomplete="off"
                        required
                        <?php if (!empty($response->filled_data->email)): ?>
                            value="<?= $response->filled_data->email ?>"

                        <?php else: ?>
                            autofocus

                        <?php endif ?> />

                    <label class="label" for="email">
                        <span class="label-text">Email</span>
                    </label>
                </div>
                <!-- .form-input /-->

                <?php $valid_roles = valid_roles() // Get all valid roles ?>

                <!-- .form-input -->
                <div class="form-input">
                    <select class="input" name="user-role" id="" require>
                        <?php foreach($valid_roles as $valid_role): ?>
                            <option value="<?= $valid_role ?>"><?= $valid_role ?></option>

                        <?php endforeach ?>
                    </select>

                    <label class="label" for="email">
                        <span class="label-text">User role</span>
                    </label>
                </div>
                <!-- .form-input /-->

                <!-- .form-input -->
                <div class="form-input">
                    <input
                        class="input"
                        type="password"
                        name="password"
                        required
                        <?php if (empty($response->filled_data->password)): ?>
                            autofocus

                        <?php endif ?> />

                    <label class="label" for="password">
                        <span class="label-text">Password</span>
                    </label>
                </div>
                <!-- .form-input /-->

                <!-- .form-input -->
                <div class="form-input">
                    <input
                        class="input"
                        type="password"
                        name="confirm-password"
                        required
                        <?php if (empty($response->filled_data->username)): ?>
                            autofocus

                        <?php endif ?> />

                    <label class="label" for="confirm-password">
                        <span class="label-text">Confirm Password</span>
                    </label>
                </div>
                <!-- .form-input /-->

                <!-- .form-input -->
                <div class="btn-container">
                    <a href="<?= WEB_ROOT ?>login/">Already have an account?</a>

                    <input
                        class="btn btn-main"
                        type="submit"
                        value="Signup" />
                </div>
                <!-- .form-input /-->
            </form>

            <?php if (isset($this->response->error) && !$this->response->error): ?>
                <script>
                    window.location.href = '<?= WEB_ROOT ?>login/';
                    
                </script>
            <?php endif ?>

<?php include 'auth-footer.php' // Include auth footer file ?>