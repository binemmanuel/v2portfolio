<?php

/**
 * The footer of the Default StarLyon Theme
 *
 * Contains the closing section.main-section and all after.
 *
 * @author: Bin Emmanuel https://binemmanuel.com/#about
 * @link https://developers.binemmanuel.com/theme/starlyon
 * @package Portfolio
 * @version 1.0
 * @since StarLyon 1.0
 */

use portfolio\SiteInfo;

$app = new SiteInfo;
$app = (object) $app->fetch();
?>
</main>
<footer>
    <span>Copyright &copy; <a href="<?= WEB_ROOT ?>"><?= $app->title ?></a> 2015 - <?= date('Y') ?></span>

    <div class="back-to-top">
        <a href="#"><i class="fa fa-chevron-up"></i></a>
    </div>

    <div class="cookie-note">
        <p>I use cookies to ensure that I give you the best experience on me website. If you continue to use this site I will assume that you are happy with it.</p>
        <a class="btn btn-close">Close</a>
    </div>

    <!-- Custom scripts -->
    <script src="<?= JS_PATH ?>client-rect.js"></script>
    <script src="<?= JS_PATH ?>main.js"></script>
    <script src="<?= JS_PATH ?>slider.js"></script>
    <script src="<?= JS_PATH ?>notification.js"></script>
</footer>
</body>

</html>