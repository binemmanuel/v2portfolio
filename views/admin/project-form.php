<?php
/**
 * The template file for displaying the add new project
 * page for the Admin theme.
 * This template is also used for edit project page.
 * 
 * @author: Bin Emmanuel https://binemmanuel.com/#about
 * @link https://developers.binemmanuel.com/portfolio
 * @package Portfolio
 * @version 1.1
 * @since Admin 1.0
 */

use model\Category;
use portfolio\Category as PortfolioCategory;

use function portfolio\clean_data;
?>

<!-- .flexbox .cta-btn-flex -->
<div class="flexbox cta-btn-flex">
    <?php if (!empty($this->response)): // Check if there is a response. ?>
        <?php $response = $this->response; ?>
        <h1>Edit Project</h1>
    
    <?php else: ?>
        <h1>Add New Project</h1>
        
    <?php endif ?>
</div>
<!-- .flexbox .cta-btn-flex /-->

<!-- .add-project-panel -->
<section class="add-project-panel">
    <?php if (!empty($response->error)): ?>
        <p class="alert alert-error" style="margin-top: 5.5rem"> <?= $response->message ?></p>

    <?php elseif (!empty($response->message)): ?>
        <p class="alert alert-success" style="margin-top: 5.5rem"> <?= $response->message ?></p>

    <?php endif ?>

    <form method="post"
        <?php if (empty($response->id)): ?>
            action="add-new"

        <?php else: ?>
            action="<?= WEB_ROOT ?>admin/projects/edit/<?= $response->id ?>"
        
        <?php endif ?>>
        <div class="form">
            <!-- .form-input -->
            <div class="form-input">
                <input type="text" name="title" placeholder="Enter title here"
                <?php if (!empty($response->filled_data['title'])): ?>
                    value="<?= $response->filled_data['title'] ?>"

                <?php elseif (!empty($response->title)): ?>
                    value="<?= $response->title ?>"

                <?php endif ?>/>
            </div>
            <!-- .form-input /-->

            <!-- .form-input -->
            <div class="form-input">
                <textarea id="description" name="description" cols="30" rows="10"  onkeydown="count_desc(description, count)"><?php if (!empty($response->filled_data['description'])): ?><?= $response->filled_data['description'] ?><?php elseif (!empty($response->content)): ?><?= $response->content?><?php endif ?></textarea>
            </div>
            <!-- .form-input /-->

            <p class="word_count">Word count: <span class="count" id="count">0</span></p>
        </div>

        <!-- .side-bar -->
        <div class="side-bar">
            <!-- .side-bar-panel -->
            <div class="side-bar-panel">
                <h2>Publish</h2>

                <!-- .sidebar-panel-content -->
                <div class="sidebar-panel-content flexbox">
                    <a href="">Move to Trash</a>

                    <?php if (empty($response->id)): ?>
                        <input type="submit" name="status" value="Publish" class="btn btn-body" />
                      
                    <?php else: ?>
                        <input type="hidden" name="id" value="<?= $response->id ?>" />
                        <input type="submit" name="status" value="Update" class="btn btn-body" />

                    <?php endif ?>
                </div>
                <!-- .sidebar-panel-content /-->
            </div>
            <!-- .side-bar-panel /-->

            <!-- .side-bar-panel -->
            <div class="side-bar-panel">
                <h2>Category</h2>
                
                <?php
                // Instantiate a Category Object.
                $category = new Category();

                // Get all categories.
                $categories = $category->get_all();

                if (!empty($response->id)) {
                    $projects_category = new PortfolioCategory();

                    $projects_categories = $projects_category->get_project_cat($response->id);
                    
                    // Instantiate an empty array.
                    $projects_cats = [];

                    foreach ($projects_categories as $projects_category) {
                        // Get all the categories the project belongs to.
                        array_push($projects_cats, $category->get($projects_category->id)->name);
                                
                    }
                }
                ?>

                <!-- .sidebar-panel-content -->
                <div class="sidebar-panel-content list-categories">
                    <?php foreach ($categories as $category): ?>
                        <div>
                            <input
                                type="checkbox"
                                name="categories[]"
                                value="<?= strtolower($category->name) ?>"
                                class="text-capitalize"

                                <?php if (!empty($projects_cats)): ?>
                                    <?php foreach ($projects_cats as $projects_cat): ?>
                                        <?php if ($category->name === $projects_cat): ?>
                                            checked
                                        <?php endif ?>
                                    <?php endforeach ?>
                                <?php endif ?>/>
                                
                                <?= $category->name ?>
                        </div>
                    <?php endforeach ?>
                </div>
                <!-- .sidebar-panel-content /-->
            </div>
            <!-- .side-bar-panel /-->

            <!-- .side-bar-panel -->
            <div class="side-bar-panel">
                <h2>Featured Image</h2>

                <?php if (!empty($response->filled_data['featured-image']) &&
                    filter_var($response->filled_data['featured-image'], FILTER_VALIDATE_URL)): ?>
                    <div class="feature-image">
                        <img src="<?= $response->filled_data['featured-image'] ?>" alt="feature image">
                    </div>

                <?php elseif (!empty($response->featured_image)): ?>
                    <div class="feature-image">
                        <img src="<?=$response->featured_image ?>" alt="feature image">
                    </div>

                <?php endif ?>

                <!-- .sidebar-panel-content -->
                <div class="sidebar-panel-content">
                    <input type="text" name="featured-image" placeholder="Paste image link here"
                    <?php if (!empty($response->filled_data['featured-image'])): ?>
                        value="<?= $response->filled_data['featured-image'] ?>"

                    <?php elseif (!empty($response->featured_image)): ?>
                        value="<?= $response->featured_image ?>"

                    <?php endif ?> />
                </div>
                <!-- .sidebar-panel-content /-->
            </div>
            <!-- .side-bar-panel /-->

            <!-- .side-bar-panel -->
            <div class="side-bar-panel">
                <h2>Comment Setting</h2>
                
                <!-- .sidebar-panel-content -->
                <div class="sidebar-panel-content">
                    <input type="checkbox" name="comments" 
                    
                    <?php if (
                        !empty($response->filled_data['comment']) &&
                        $response->filled_data['comment'] !== 'close'
                    ): ?>
                        checked

                    <?php elseif (
                        !empty($response->comment_status) &&
                        $response->comment_status !== 'close'
                    ): ?>
                        checked

                    <?php endif ?>/>

                    <span>Open project to comments</span>
                </div>
                <!-- .sidebar-panel-content /-->
            </div>
            <!-- .side-bar-panel /-->
        </div>
        <!-- .side-bar /-->
    </form>
</section>
<!-- .add-project-panel /-->

<script>
    let description = document.querySelector('#description')
    let word_count = document.querySelector('#count')
    
    setInterval(() => {
        count_desc(description, word_count)
        
    }, 1000)

    function count_desc(description, word_count) {
        let words = description.value.split(' ')

        let word_list = []

        words.forEach(word => {
            if (word !== ''){
                word_list.push(word)
            }
        })
        
        word_count.innerText = word_list.length
    }
</script>