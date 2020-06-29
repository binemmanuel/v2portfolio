        </main>
        <!-- .form-container /-->

        <footer>
            <script type="module" src="<?= WEB_ROOT ?>views/admin/assets/js/auth.js"></script>
            
            <?php
            use portfolio\LoginToken;
            use function portfolio\is_logged_in;

            $login_token = new LoginToken()
            ?>

            <?php if (is_logged_in() && $login_token->is_valid($_COOKIE['login-token'])): ?>
                <script>
                    window.location.href = '<?= WEB_ROOT ?>admin/';
                    
                </script>
            <?php endif ?>
        </footer>
    </body>
</html>