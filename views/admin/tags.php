<?php
/**
 * The template file for displaying the tag page
 * for the Admin theme.
 *
 * @author: Bin Emmanuel https://binemmanuel.com/#about
 * @link https://developers.binemmanuel.com/portfolio
 * @package Portfolio
 * @version 1.1
 * @since Admin 1.0
 */

$tags = $this->response;
?>

<!-- .flexbox .cta-btn-flex -->
<div class="flexbox cta-btn-flex">
    <h1>Tags</h1>
</div>
<!-- .flexbox .cta-btn-flex /-->

<!-- .flexbox -->
<div class="tag">
    <!-- .tag-form -->
    <div class="tag-form">
        <form action="" method="post">
            <div class="form-input">
                <input type="text" name="" placeholder="Name" />
                <span>The name is how it appears on your site.</span>
            </div>

            <div class="form-input">
                <input type="text" name="slug" placeholder="slug" />
                <span>
                    The “slug” is the URL-friendly version of the name. It is usually all lowercase and contains only letters, numbers, and hyphens.
                </span>
            </div>

            <div class="form-input">
                <textarea name="description" placeholder="Description" cols="30" rows="10"></textarea>
                <span>
                    The description is not prominent by default.
                </span>
            </div>

            <input type="submit" value="Add tag" class="btn btn-body" />
        </form>
    </div>
    <!-- .tag-form /-->

    <!-- .tag-listing -->
    <div class="tag-listing">
        <!-- .tag-header -->
        <div class="tag-header">
            <!-- .search-bar -->
            <div class="search-bar">
                <form action="" method="post">
                    <input type="search" name="keyword" placeholder="Search" />
                </form>
            </div>
            <!-- .search-bar /-->
        </div>
        <!-- .tag-header /-->

        <!-- .tags-panel -->
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
                    <?php foreach ($tags as $tag): ?>
                        <tr>
                            <td class="text-center">
                                <input type="checkbox" name="" />
                            </td>
                            <td class="clear">
                                <?= $tag->name ?>

                                <!-- .actions -->
                                <div class="actions">
                                    <ul class="nav-list">
                                        <li class="nav-item"><a href="" class="">Edit</a></li>
                                        <li class="nav-item"><a href="" class="">View</a></li>
                                        <li class="nav-item"><a href="" class=" color-red">Delete</a></li>
                                    </ul>
                                </div>
                                <!-- .actions /-->
                            </td>
                            <td><?= $tag->slug ?></td>
                            <td>
                                <?php if (empty($tag->description)): ?>
                                    ---
                                <?php else: ?>
                                    <?= $tag->description ?>
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
        <!-- .tags-panel /-->
    </div>
    <!-- .tag-listing /-->
</div>
<!-- .flexbox /-->