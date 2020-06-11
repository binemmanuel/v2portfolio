<?php

use portfolio\Menu;

$menu = new Menu;

// Fetch all menu.
$menus = $menu->fetch('top menu');

?>

<!-- .main-menu -->
<nav class="main-menu">
    <!-- .menu-toggle -->
    <div class="menu-toggle">
        <i class="fa fa-bars"></i>
        <i class="fa fa-times"></i>
    </div>
    <!-- .menu-toggle /-->

    <!-- .nav-list -->
    <menu class="nav-list">
        <!-- social-menu -->
        <nav class="social-menu">
            <menu class="nav-list">
                <li class="nav-item">
                    <a href="#" class="nav-link facebook" target="_blank">
                        <i class="fa fa-facebook"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link github" target="_blank">
                        <i class="fa fa-github"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link linkedin" target="_blank">
                        <i class="fa fa-linkedin"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link youtube" target="_blank">
                        <i class="fa fa-youtube"></i>
                    </a>
                </li>
            </menu>
        </nav>
        <!-- social-menu /-->

        <!-- .nav-item -->
        <?php foreach ($menus[0] as $menu): ?>
            <li class="nav-item"><a href="<?= $menu['link'] ?>" class="nav-link"><?= $menu['name'] ?></a></li>
        <?php endforeach ?>
        <!-- .nav-item /-->
        </menu>
    <!-- .nav-list /-->
</nav>
<!-- .main-menu /-->