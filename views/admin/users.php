<?php
/**
 * The template file for displaying the users page
 * for the Admin theme.
 *
 * @author: Bin Emmanuel https://binemmanuel.com/#about
 * @link https://developers.binemmanuel.com/portfolio
 * @package Portfolio
 * @version 1.1
 * @since Admin 1.0
 */

use function portfolio\clean_data;

$response = $this->response;
?>

<!-- .flexbox .cta-btn-flex -->
<div class="flexbox cta-btn-flex">
    <h1>Users</h1> <a href="<?= WEB_ROOT ?>admin/users/add-new" class="btn btn-body">Add New</a>
</div>
<!-- .flexbox .cta-btn-flex /-->

<!-- .project-header -->
<div class="project-header">
    <!-- .project-actions -->
    <div class="project-actions">
        <a href="">All (15)</a>
        <a href="">Admins (5)</a>
        <a href="">Moderator (5)</a>
        <a href="">Subscribers (5)</a>
    </div>
    <!-- .project-actions /-->

    <!-- .search-bar -->
    <div class="search-bar">
        <form action="" method="post">
            <input type="search" name="keyword" placeholder="Search" />
        </form>
    </div>
    <!-- .search-bar /-->
</div>
<!-- .project-header /-->

<!-- .projects-panel -->
<section class="projects-panel">
    <!-- .table .table-100 .text-left .table-responsive -->
    <table class="table table-100 text-left table-responsive">
        <thead>
            <tr>
                <th class="text-center">
                    <input type="checkbox" name="">
                </th>
                <th>Username</th>
                <th>Name</th>
                <th>Email</th>
                <th>Website</th>
                <th>Role</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($response as $user): ?>
                <tr>
                    <td class="text-center">
                        <input type="checkbox" name="" />
                    </td>
                    <td class="clear">
                        <a href="<?= WEB_ROOT ?>admin/users/edit/<?= $user->id ?>" class="dark-link">
                            <?= clean_data($user->username) ?>
                        </a>

                        <!-- .actions -->
                        <div class="actions">
                            <ul class="nav-list">
                                <li class="nav-item">
                                    <a href="<?= WEB_ROOT ?>admin/users/edit/<?= $user->id ?>" class="">
                                        Edit
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?= WEB_ROOT ?>admin/users/view/<?= $user->id ?>" class="">
                                        View
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?= WEB_ROOT ?>admin/users/delete/<?= $user->id ?>" class=" color-red">
                                        Delete
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <!-- .actions /-->
                    </td>
                    <td><?= clean_data($user->full_name) ?></td>
                    <td>
                        <a href="mailto:<?= clean_data($user->email) ?>" class="dark-link">
                            <?= clean_data($user->email) ?>
                        </a>
                    </td>
                    <td><?= clean_data($user->website) ?></td>
                    <td><?= clean_data($user->user_role) ?></td>
                    
                    <?php if(empty($user->active)): ?>
                        <td class="color-red">Inactive</td>

                    <?php else: ?>
                        <td class="color-active">Active</td>

                    <?php endif ?>
                </tr>
            <?php endforeach ?>
        </tbody>
        <tfoot>
            <tr>
                <th class="text-center">
                    <input type="checkbox" name="">
                </th>
                <th>Username</th>
                <th>Name</th>
                <th>Email</th>
                <th>Website</th>
                <th>Role</th>
                <th>Status</th>
            </tr>
        </tfoot>
    </table>
    <!-- .table .table-100 .text-left .table-responsive /-->
</section>
<!-- .projects-panel /-->