<?php
/**
 * The template file for displaying the category page
 * for the Admin Theme.
 * 
 * @author: Bin Emmanuel https://binemmanuel.com/#about
 * @link https://developers.binemmanuel.com/portfolio
 * @package Portfolio
 * @version 1.1
 * @since Admin 1.0
 */
$categories = $this->categories;

if (!empty($this->form_response)) {
    $form_response = $this->form_response;
}

if (!empty($this->update_form_response)) {
    $update_form_response = $this->update_form_response;
    unset($form_response);
}
?>

<!-- .flexbox .cta-btn-flex -->
<div class="flexbox cta-btn-flex">
    <h1>Categories</h1>
</div>
<!-- .flexbox .cta-btn-flex /-->

<!-- .flexbox -->
<div class="category">
    <!-- .category-form -->
    <div class="category-form">
        <?php if (!empty($form_response->error)): ?>
            <p class="alert alert-error"> <?= $form_response->message ?></p>

        <?php elseif (!empty($form_response->message)): ?>
            <p class="alert alert-success"> <?= $form_response->message ?></p>

        <?php elseif (!empty($update_form_response->error)): ?>
            <p class="alert alert-success"> <?= $update_form_response->error ?></p>

        <?php elseif (!empty($update_form_response->message)): ?>
            <p class="alert alert-success"> <?= $update_form_response->message ?></p>

        <?php endif ?>

        <form method="post"
        <?php if (!empty($form_response->id)): ?>
            action="<?= WEB_ROOT ?>category/edit/<?= $form_response->id ?>"

        <?php else: ?>
            action="<?= WEB_ROOT ?>admin/projects/category"

        <?php endif ?>>
            <?php if (!empty($form_response->id)): ?>
                <input type="hidden" name="id" value="<?= $form_response->id ?>" />
            <?php endif ?>
            
            <div class="form-input">
                <input type="text" name="name" placeholder="Name" 
                <?php if (!empty($form_response->name)): ?>
                    value="<?= $form_response->name ?>"

                <?php endif ?>/>
                <span>The name is how it appears on your site.</span>
            </div>

            <div class="form-input">
                <input type="text" name="slug" placeholder="slug" 
                <?php if (!empty($form_response->slug)): ?>
                    value="<?= $form_response->slug ?>"
                    
                <?php endif ?>/>
                <span>
                    The “slug” is the URL-friendly version of the name. It is usually all lowercase and contains only letters, numbers, and hyphens.
                </span>
            </div>

            <div class="form-input">
                <textarea name="description" placeholder="Description" cols="30" rows="10"><?php if (!empty($form_response->description)): ?><?= $form_response->description ?><?php endif ?></textarea>
                <span>
                    The description is not prominent by default.
                </span>
            </div>

            <?php if (!empty($form_response->id)): ?>
                <input type="submit" value="Update" class="btn btn-body" />
            
            <?php else: ?>
                <input type="submit" value="Add Category" class="btn btn-body" />

            <?php endif ?>
        </form>
    </div>
    <!-- .category-form /-->

    <!-- .category-listing -->
    <div class="category-listing">
        <!-- .category-header -->
        <div class="category-header">
            <!-- .search-bar -->
            <div class="search-bar">
                <form action="" method="post">
                    <input type="search" name="keyword" placeholder="Search" />
                </form>
            </div>
            <!-- .search-bar /-->
        </div>
        <!-- .category-header /-->

        <!-- .categorys-panel -->
        <section class="categories-panel">
            <!-- .table .table-100 .text-left .table-responsive -->
            <table class="table table-100 text-left table-responsive">
                <thead>
                    <tr>
                        <th class="text-center">
                            <input type="checkbox" name="">
                        </th>
                        <th>Name</th>
                        <th>Slug</th>
                        <th>Description</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($categories as $category): ?>
                        <tr>
                            <td class="text-center">
                                <input type="checkbox" name="" />
                            </td>
                            <td class="clear">
                                <?= $category->name ?>

                                <!-- .actions -->
                                <div class="actions">
                                    <ul class="nav-list">
                                        <li class="nav-item"><a href="<?= WEB_ROOT ?>category/edit/<?= $category->id ?>" class="">Edit</a></li>
                                        <li class="nav-item"><a href="" class="">View</a></li>
                                        <li class="nav-item"><a href="" class=" color-red">Delete</a></li>
                                    </ul>
                                </div>
                                <!-- .actions /-->
                            </td>
                            <td>
                                <?php if (empty($category->slug)): ?>
                                    ---
                                <?php else: ?>
                                    <?= $category->slug ?>
                                <?php endif ?>
                            </td>
                            <td>
                                <?php if (empty($category->description)): ?>
                                    ---
                                <?php else: ?>
                                    <?= $category->description ?>
                                <?php endif ?>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th class="text-center">
                            <input type="checkbox" name="">
                        </th>
                        <th>Name</th>
                        <th>Slug</th>
                        <th>Description</th>
                    </tr>
                </tfoot>
            </table>
            <!-- .table .table-100 .text-left .table-responsive /-->
        </section>
        <!-- .categorys-panel /-->
    </div>
    <!-- .category-listing /-->
</div>
<!-- .flexbox /-->