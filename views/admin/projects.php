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

use function portfolio\clean_data;

// All Projects.
$projects = $this->response->projects;

// Number of projects
$count = $this->response->counts;

// Store return page.
$_SESSION['return'] = 'projects';

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
        <a href="<?= WEB_ROOT ?>admin/projects/">All (<?= clean_data($count->all) ?>)</a>
        <a href="<?= WEB_ROOT ?>admin/projects/published">Published (<?= clean_data($count->published) ?>)</a>
        <a href="<?= WEB_ROOT ?>admin/projects/trash">Trash (<?= clean_data($count->trash) ?>)</a>
        <a href="<?= WEB_ROOT ?>admin/projects/draft">Draft (<?= clean_data($count->draft) ?>)</a>
    </div>
    <!-- .project-actions /-->

    <!-- .search-bar -->
    <div class="search-bar">
        <form action="<?= WEB_ROOT ?>/admin/projects/search" method="post">
            <input
                type="search"
                name="keyword"
                placeholder="Search"
                autocomplete="off"
                id="search-bar" />
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
                    <input type="checkbox" class="checkall">
                </th>
                <th>Title</th>
                <th>Author</th>
                <th>Status</th>
                <th>Category</th>
                <th>Tags</th>
            </tr>
        </thead>
        <tbody id="search-result">
            <?php foreach ($projects as $project): ?>
                <tr>
                    <td class="text-center">
                        <input type="checkbox" name="" class="select" />
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
                                    <?php if ($project->status !== 'trash'): ?>
                                        <a href="<?= WEB_ROOT ?>admin/projects/move-to-trash/<?= $project->id ?>" class="color-red">Move to Trash</a>

                                    <?php else: ?>
                                        <a
                                            class="color-red"
                                            onclick="delete_project_modal(
                                                '<?= $project->id ?>',

                                            )">Delete</a>

                                        <a href="<?= WEB_ROOT ?>admin/projects/move-to-published/<?= $project->id ?>" class="color-active">Plublish</a>

                                    <?php endif ?>
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
                    <input type="checkbox" class="checkall">
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

<!-- delete-modal -->
<div class="delete-modal">
    <form id="delete_modal_form" action="<?= WEB_ROOT ?>admin/projects/delete/" method="post">
        <input type="text" name='id' id="object_id" />

        <!-- .delete-modal-header .close-btn -->
        <div class="delete-modal-header close-btn">
            <h2>Delete File</h2>
            <i class="fa fa-times"></i>
        </div>
        <!-- .delete-modal-header .close-btn /-->

        <!-- .delete-modal-body -->
        <div class="delete-modal-body">
            <p>Are you sure you want to permanently delete the project?</p>
        </div>
        <!-- .delete-modal-body /-->

        <!-- .delete-modal-footer -->
        <div class="delete-modal-footer">
            <input class="btn close-btn btn-secondary" type="submit" value="No" />
            <input class="btn text-danger" type="submit" value="Permanently Delete" />
        </div>
        <!-- .delete-modal-footer /-->
    </form>
</div>
<!-- delete-modal /-->


<script>
    window.onload = () => {
        const search_bar = $('#search-bar')

        search_bar.addEventListener('keyup', (event) => {
            let keyword = search_bar.value
        
            const ajax = new Ajax(
                'post',
                '<?= WEB_ROOT ?>/admin/projects/search',
                '#search-result',
                `keyword=${keyword}&async=true`
            )
        })
    }
</script>