<?php
/**
 * The header of the Default Admin Theme 
 *
 * This is the template that displays all of the <head> section and everything up until <section class="main-section">
 *
 * @author: Bin Emmanuel https://binemmanuel.com/#about
 * @link https://developers.binemmanuel.com/portfolio
 * @package Portfolio
 * @version 1.1
 * @since Admin 1.0
 */
use portfolio\SiteInfo;

$site_info = new SiteInfo;
$site_info = (object) $site_info->fetch();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Admin | <?= $site_info->title ?></title>

        <link rel="shortcut icon" href="<?= WEB_ROOT ?>views\starlyon\assets\img\logo.png" />

        <!-- Custom CSS -->
        <link rel="stylesheet" href="<?= WEB_ROOT ?>views\admin\assets\css\style.css" />

        <!-- Loader -->
        <link rel="stylesheet" href="<?= WEB_ROOT ?>views\admin\assets\css\loader.css" />
        
        <!-- Font awesome -->
        <link rel="stylesheet" href="<?= WEB_ROOT ?>views\admin\assets\css\font-awesome.min.css" />
    </head>
    <body>
        <header>
            <!-- top-menu-bar -->
            <nav class="top-menu-bar">
                <div class="logo">
                    <a href="<?= WEB_ROOT ?>home" target="__blank"><i class="fa fa-home"></i> <?= $site_info->title ?></a>
                </div>
                <div class="menu-toggle"><i class="fa fa-bars"></i></div>

                <div class="flexbox">
                    <ul class="nav-list">
                        <li class="nav-item">
                            <a href="<?= WEB_ROOT ?>admin/chat" class="nav-link" >
                                <i class="fa fa-comments"></i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= WEB_ROOT ?>admin/projects/add-new" class="nav-link" >
                                <i class="fa fa-plus"></i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= WEB_ROOT ?>admin/projects/settings" class="nav-link" >
                                <i class="fa fa-cogs"></i>
                            </a>
                        </li>
                    </ul>

                    <ul class="nav-list user-icon">
                        <li class="nav-item">
                            <a href="#" class="nav-link" title="Bin Emmanuel">
                                <i class="fa fa-user"></i>
                            </a>

                            <ul class="dropdown">
                                <li class="nav-item">
                                    <a href="" class="nav-link">binemmanuel</a>
                                </li>
                                <li class="nav-item">
                                    <a href="" class="nav-link">Edit Account</a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?= WEB_ROOT ?>logout" class="nav-link">Log Out</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
            <!-- top-menu-bar /-->
        </header>
        <main>
            <!-- .flexbox .container -->
            <div class="flexbox container">
                <!-- .side-menu -->
                <div class="side-menu">
                    <!-- .nav-list -->
                    <ul class="nav-list">
                        <!-- .nav-item .side-nav-item -->
                        <li class="nav-item side-nav-item">
                            <a href="<?= WEB_ROOT ?>admin" class="nav-link">
                                <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                            </a>
                        </li>
                        <li class="nav-item side-nav-item">
                            <a href="<?= WEB_ROOT ?>admin/projects" class="nav-link">
                                <i class="fa fa-cubes"></i> <span>Projects</span>
                            </a>

                            <!-- .dropout -->
                            <ul class="dropout">
                                <li class="nav-item">
                                    <a href="<?= WEB_ROOT ?>admin/projects" class="drop-nav-link nav-link">All Projects</a>
                                    <a href="<?= WEB_ROOT ?>admin/projects/add-new" class="drop-nav-link nav-link">Add New</a>
                                    <a 
                                        href="<?= WEB_ROOT ?>admin/projects/category"
                                        class="drop-nav-link nav-link">Categories</a>
                                    <a href="<?= WEB_ROOT ?>admin/projects/tags"
                                    class="drop-nav-link nav-link">Tags</a>
                                </li>
                            </ul>
                            <!-- .dropout /-->
                        </li>
                        <li class="nav-item side-nav-item">
                            <a href="<?= WEB_ROOT ?>admin/library" class="nav-link">
                                <i class="fa fa-image"></i> <span>Media</span>
                            </a>

                            <!-- .dropout -->
                            <ul class="dropout">
                                <li class="nav-item">
                                    <a href="<?= WEB_ROOT ?>admin/library" class="drop-nav-link nav-link">Library</a>
                                    <a href="<?= WEB_ROOT ?>admin/library/add-new" class="drop-nav-link nav-link">Add New</a>
                                    <a href="<?= WEB_ROOT ?>admin/library/videos" class="drop-nav-link nav-link">Vidios</a>
                                    <a href="<?= WEB_ROOT ?>admin/library/images" class="drop-nav-link nav-link">Images</a>
                                </li>
                            </ul>
                            <!-- .dropout /-->
                        </li>
                        <li class="nav-item side-nav-item">
                            <a href="<?= WEB_ROOT ?>admin/testimonials" class="nav-link">
                                <i class="fa fa-thumb-tack"></i> <span>Testimonials</span>
                            </a>
                        </li>
                        <li class="nav-item side-nav-item">
                            <a href="<?= WEB_ROOT ?>admin/comments" class="nav-link">
                                <i class="fa fa-comment"></i> <span>Comments</span>
                            </a>
                        </li>
                        <li class="nav-item side-nav-item">
                            <a href="<?= WEB_ROOT ?>admin/chat" class="nav-link">
                                <i class="fa fa-comments"></i> <span>Chat</span>
                            </a>
                        </li>
                        <li class="nav-item side-nav-item">
                            <a href="<?= WEB_ROOT ?>admin/users" class="nav-link">
                                <i class="fa fa-users"></i> <span>Users</span>
                            </a>

                            <!-- .dropout -->
                            <ul class="dropout">
                                <li class="nav-item">
                                    <a href="<?= WEB_ROOT ?>admin/users" class="drop-nav-link nav-link">All Users</a>
                                    <a href="<?= WEB_ROOT ?>admin/users/add-new" class="drop-nav-link nav-link">Add New</a>
                                    <a href="<?= WEB_ROOT ?>admin/users/profile" class="drop-nav-link nav-link">Your Profile</a>
                                </li>
                            </ul>
                            <!-- .dropout /-->
                        </li>
                        <li class="nav-item side-nav-item">
                            <a href="<?= WEB_ROOT ?>admin/todo" class="nav-link">
                                <i class="fa fa-pencil"></i> <span>Todo</span>
                            </a>
                        </li>
                        <li class="nav-item side-nav-item">
                            <a href="<?= WEB_ROOT ?>admin/settings" class="nav-link">
                                <i class="fa fa-cogs"></i> <span>Settings</span>
                            </a>
                            
                            <!-- .dropout -->
                            <ul class="dropout">
                                <li class="nav-item">
                                    <a href="<?= WEB_ROOT ?>admin/settings" class="drop-nav-link nav-link">General</a>
                                    <a href="<?= WEB_ROOT ?>admin/settings/header-settings" class="drop-nav-link nav-link">Header</a>
                                    <a href="<?= WEB_ROOT ?>admin/settings/footer-settings" class="drop-nav-link nav-link">Footer</a>
                                    <a href="<?= WEB_ROOT ?>admin/settings/contact-settings" class="drop-nav-link nav-link">Menu</a>
                                    <a href="<?= WEB_ROOT ?>admin/settings/contact-settings" class="drop-nav-link nav-link">Contact</a>
                                </li>
                            </ul>
                            <!-- .dropout /-->
                        </li>
                        <li class="nav-item side-nav-item">
                            <a class="nav-link">
                                <i class="fa fa-arrow-circle-o-left"></i> <span>Collaps</span>
                            </a>
                        </li>
                        <!-- .nav-item .side-nav-item /-->
                    </ul>
                    <!-- .nav-list /-->
                </div>
                <!-- .side-menu /-->
                    <!-- .main-section -->
                    <section class="main-section">