        </main>
        <!-- .form-container /-->

        <footer>
            <script src="<?= WEB_ROOT ?>views/admin/assets/js/auth.js"></script>
            
            <?php use function portfolio\is_logged_in; ?>

            <?php if (is_logged_in() && $login_token->is_valid($_COOKIE['login-token'])): ?>
                <script>
                    window.location.href = '<?= WEB_ROOT ?>admin/';
                    
                </script>
            <?php endif ?>
        </footer>
    </body>
</html>