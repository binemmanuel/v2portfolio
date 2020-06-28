<?php
/**
 * The template file for displaying the comment page
 * for the Admin theme.
 *
 * @author: Bin Emmanuel https://binemmanuel.com/#about
 * @link https://developers.binemmanuel.com/portfolio
 * @package Portfolio
 * @version 1.1
 * @since Admin 1.0
 */
 ?>

<!-- .flexbox .cta-btn-flex -->
<div class="flexbox cta-btn-flex">
    <h1>Comments</h1>
</div>
<!-- .flexbox .cta-btn-flex /-->

<!-- .project-header -->
<div class="project-header">
    <!-- .project-actions -->
    <div class="project-actions">
        <a href="">All (15)</a>
        <a href="">Mine (5)</a>
        <a href="">Pending (5)</a>
        <a href="">Approved (5)</a>
        <a href="">Trash (5)</a>
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
                <th>Author</th>
                <th>Comment</th>
                <th>In Response To</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="text-center">
                    <input type="checkbox" name="" />
                </td>
                <td class="clear">
                    John Doe

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
                <td>You've got the best designs</td>
                <td>Portfolio</td>
                <td>Published: 1 Jen, 2019</td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <th class="text-center">
                    <input type="checkbox" name="">
                </th>
                <th>Author</th>
                <th>Comment</th>
                <th>In Response To</th>
                <th>Date</th>
            </tr>
        </tfoot>
    </table>
    <!-- .table .table-100 .text-left .table-responsive /-->
</section>
<!-- .projects-panel /-->