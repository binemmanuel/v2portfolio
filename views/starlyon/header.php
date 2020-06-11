<?php
/**
 * The header of the Default StarLyon Theme 
 *
 * This is the template that displays all of the <head> section and everything up until <main>
 *
 * @author: Bin Emmanuel https://binemmanuel.com/#about
 * @link https://developers.binemmanuel.com/theme/starlyon
 * @package Portfolio
 * @version 1.0
 * @since StarLyon 1.0
 */

use portfolio\SiteInfo;
use function portfolio\is_home_page;

$site_info = new SiteInfo;
$site_info = $site_info->fetch();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>
            <?php if (!empty($site_info->title)): ?>
                <?= $site_info->title ?>

            <?php else: ?>
                Bin Emmanuel

            <?php endif ?>
        </title>

        <meta name="description" content="I'm a Full Web Developer from Abuja, Nigeria. I build high performance, scalable, mobile responsive and secure Web Applications that moves" />

        <meta name=”robots” content="index, follow" />

        <link rel="shortcut icon" type="image/png" href="assets\img\logo.PNG" />

        <!-- Font awesome -->
        <link rel="stylesheet" href="<?= CSS_PATH ?>font-awesome.min.css" />

        <!-- Custom Style -->
        <link rel="stylesheet" href="<?= CSS_PATH ?>style.css" />

        <!-- Scroll reveal  CDN -->
        <!-- <script src="https://unpkg.com/scrollreveal"></script> -->
    </head>
    <body class="">
        <header data-page="home">
            <!-- .header-container -->
            <div class="header-container">
                <div class="logo-container">
                    <!-- .logo -->
                    <a href="home" class="logo">
                        <?= $site_info->title ?>
                        <!-- <img src="assets/img/logo.PNG" alt="" /> -->
                    </a>
                    <!-- .logo /-->
                </div>
                <?php include 'menu.php'; ?>
            </div>
            <!-- .header-container /-->

           <?php if (is_home_page($view)): ?>
                 <!-- .banner -->
                <div class="banner">
                    <div class="banner-content">
                        <h1>Full-Stack Web Developer</h1>
                        
                        <p>
                            <?= $site_info->tagline ?>
                        </p>

                        <div class="text-right">
                            <a href="<?= WEB_ROOT ?>home#contact" class="btn btn-main">Get in touch</a>
                        </div>
                    </div>
                </div>
                <!-- .banner /-->
           <?php endif ?>

            <!-- .notifications -->
            <div class="notifications"></div>
            <!-- .notifications /-->
        </header>
        <main>