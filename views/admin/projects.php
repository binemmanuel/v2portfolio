<?php
/**
 * The template file for displaying the projets page
 * for the Admin theme.
 *
 * @author: Bin Emmanuel https://binemmanuel.com/#about
 * @link https://developers.binemmanuel.com/portfolio
 * @package Portfolio
 * @version 1.1
 * @since Admin 1.0
 */

// All Projects.
$projects = $this->projects;
?>

<!-- .flexbox .cta-btn-flex -->
<div class="flexbox cta-btn-flex">
    <h1>Projects</h1> <a href="<?= WEB_ROOT ?>admin/projects/add-new" class="btn btn-body">Add New</a>
</div>
<!-- .flexbox .cta-btn-flex /-->

<!-- .project-header -->
<div class="project-header">
    <!-- .project-actions -->
    <div class="project-actions">
        <a href="">All (15)</a>
        <a href="">Published (5)</a>
        <a href="">Trash (5)</a>
        <a href="">Draft (5)</a>
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
                <th>Title</th>
                <th>Author</th>
                <th>Status</th>
                <th>Category</th>
                <th>Tags</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($projects as $project): ?>
                <tr>
                    <td class="text-center">
                        <input type="checkbox" name="" />
                    </td>
                    <td class="clear">
                        <a href="<?= WEB_ROOT ?>admin/projects/edit/<?= $project->id ?>" class="dark-link"><?= $project->title ?></a>

                        <!-- .actions -->
                        <div class="actions">
                            <ul class="nav-list">
                                <li class="nav-item">
                                    <a href="<?= WEB_ROOT ?>admin/projects/edit/<?= $project->id ?>">Edit</a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?= WEB_ROOT ?>home#<?= $project->id ?>" target="__blank">View</a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?= WEB_ROOT ?>admin/projects/delete/<?= $project->id ?>" class="color-red">Delete</a>
                                </li>
                            </ul>
                        </div>
                        <!-- .actions /-->
                    </td>
                    <td><?= $project->author ?></td>
                    <td><?= $project->status ?></td>
                    <td>---</td>
                    <td>---</td>
                </tr>
            <?php endforeach ?>
        </tbody>
        <tfoot>
            <tr>
                <th class="text-center">
                    <input type="checkbox" name="">
                </th>
                <th>Title</th>
                <th>Author</th>
                <th>Status</th>
                <th>Category</th>
                <th>Tags</th>
            </tr>
        </tfoot>
    </table>
    <!-- .table .table-100 .text-left .table-responsive /-->
</section>
<!-- .projects-panel /-->