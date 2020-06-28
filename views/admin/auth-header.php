<?php

use controller\Admin;
use portfolio\SiteInfo;

$app = new SiteInfo;
$app = (object) $app->fetch();

if (!empty($this->response)) {
    $response = $this->response;
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title><?= "$page_title ! $app->title" ?></title>

        <link rel="shortcut icon" href="<?= WEB_ROOT ?>views/starlyon/assets/img/logo.png" />

        <!-- Custom CSS -->
        <link rel="stylesheet" href="<?= WEB_ROOT ?>views/admin/assets/css/auth-style.css">
    </head>
    <body>
        <!-- .form-container -->
        <main class="form-container">
            <!-- .logo -->
            <div class="logo">
                <a href="<?= WEB_ROOT ?>login/">
                    <img
                        src="<?= WEB_ROOT ?>views/starlyon/assets/img/logo.png"
                        alt="logo" />
                </a>
            </div>
            <!-- .logo /-->