<?php
// Set page title.
$page_title = 'Login';

// Include auth header file
include 'auth-header.php';
?>
            <!-- .logo -->
            <div class="logo">
                <img
                    src="<?= WEB_ROOT ?>views\starlyon\assets\img\logo.png"
                    alt="logo" />
            </div>
            <!-- .logo /-->

            <form action="<?= WEB_ROOT ?>login/auth" method="post">
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
                        type="password"
                        name="password"
                        required />

                    <label class="label" for="password">
                        <span class="label-text">Password</span>
                    </label>
                </div>
                <!-- .form-input /-->

                <!-- .form-input -->
                <div class="btn-container">
                    <a href="<?= WEB_ROOT ?>signup/">Don't have an account?</a>

                    <input
                        class="btn btn-main"
                        type="submit"
                        value="Login" />
                </div>
                <!-- .form-input /-->
            </form>

            <!-- <?php if (isset($this->response->error) && !$this->response->error): ?>
                <script>
                    window.location.href = '<?= WEB_ROOT ?>admin/';
                    
                </script>
            <?php endif ?> -->

<?php include 'auth-footer.php' // Include auth footer file ?>