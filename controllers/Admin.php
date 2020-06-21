<?php
namespace controller;

use model\Category;
use model\Library;
use model\Project;
use model\Tag;
use model\User;
use model\SiteInfo;
use portfolio\BaseController;
use portfolio\Project as PortfolioProject;

use function portfolio\clean_data;

class Admin extends BaseController
{
    function __construct()
    {
        parent::__construct();

        $this->info = new SiteInfo;
        $this->info = $this->info->get();

        if (empty($this->info->admin_template)) {
            $this->info->admin_template = 'admin';
        }
        $this->admin_template = $this->info->admin_template;
    }

    public function get(): void
    {
        $this->view->render('/', $this->admin_template);
    }
    
    /** 
     * This method is responsibe for handling all
     * projects, tags and categories related stuffs 
     * 
     * @param String The action to be carried out.
     * @param Int The ID of the object to carry out an
     * operation on.
     */
    public function projects(
        string $action = null,
        int $id = null
    ): void
    {
        // switch based on an action.
        switch ($action) {
            case 'search':
                // Instantiate a Category Object.
                $this->model = new Project;

                // Sanitize the category's ID.
                $this->id = (int) clean_data($id);

                // Instantiate a Category Model Object.
                $model = (new $this->model);

                if (
                    $_SERVER['REQUEST_METHOD'] === 'POST' &&
                    !empty($_POST['async'])
                ) {
                    // Search for the data.
                    $this->view->response = $model->search($_POST);

                    // Render a projects page.
                    $this->view->load('search-projects', $this->admin_template);
                } else {
                    // Return a response to the view.
                    $this->view->response = $model->search($_POST);
                    
                    // Render a projects page.
                    $this->view->render('projects', $this->admin_template);
                }

                break;

            case 'category':
                // Instantiate a Category Object.
                $this->model = new Category;

                // Sanitize the category's ID.
                $this->id = (int) clean_data($id);

                // Instantiate a Category Model Object.
                $model = (new $this->model);

                // Check if a new Category was posted.
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    // Return a response to the view.
                    $this->view->form_response = $model->process_data($_POST);
                }

                // Return a response to the view.
                $this->view->categories = $model->get_all();
                
                // Render a category page.
                $this->view->render('category', $this->admin_template);

                break;
                
            case 'tags':
                // Instantiate a Tag Object.
                $this->model = new Tag;
                
                // Sanitize the tag's ID.
                $this->id = (int) clean_data($id);
                
                // Instantiate a Tag Model Object.
                $model = (new $this->model);
                
                // Return a response to the view.
                $this->view->response = $model->get($this->id);
                
                // Render a tag page.
                $this->view->render('tags', $this->admin_template);

                break;
            
            case 'add-new':
                // Instantiate a Project Object.
                $this->model = new Project;
                
                // Sanitize the projects's ID.
                $this->id = (int) clean_data($id);
                
                // Instantiate a Project Model Object.
                $model = (new $this->model);
                
                // Check if a new Project was posted.
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    // Return a response to the view.
                    $this->view->response = $model->process_data($_POST);

                    // Empty $_POST.
                    unset($_POST);
                }
                
                // Render an add new project page.
                $this->view->render('project-form', $this->admin_template);

                break;

            case 'edit':
                // Instantiate a Project Object.
                $this->model = new Project;
                
                // Sanitize the projects's ID.
                $this->id = (int) clean_data($id);
                
                // Instantiate a Project Model Object.
                $model = (new $this->model);

                // Check if an update is required.
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    // Return a response to the view.
                    $this->view->response = $model->update($_POST);
                    
                } else {
                    // Return a response to the view.
                    $this->view->response = $model->get($this->id);
                }

                // Render an edit project page.
                $this->view->render('project-form', $this->admin_template);

                break;
            
            case 'published':
                // Instantiate a Project Object.
                $this->model = new Project;
                
                // Sanitize the projects's ID.
                $this->id = (int) clean_data($id);
                
                // Instantiate a Project Model Object.
                $model = (new $this->model);

                // Resture a response.
                $this->view->response = $model->get_pulished();

                // Render a projects page.
                $this->view->render('projects', $this->admin_template);
                break;

            case 'trash':
                // Instantiate a Project Object.
                $this->model = new Project;
                
                // Sanitize the projects's ID.
                $this->id = (int) clean_data($id);
                
                // Instantiate a Project Model Object.
                $model = (new $this->model);

                // Resture a response.
                $this->view->response = $model->get_trash();

                // Render a projects page.
                $this->view->render('projects', $this->admin_template);
                break;

            case 'draft':
                // Instantiate a Project Object.
                $this->model = new Project;
                
                // Sanitize the projects's ID.
                $this->id = (int) clean_data($id);
                
                // Instantiate a Project Model Object.
                $model = (new $this->model);

                // Resture a response.
                $this->view->response = $model->get_draft();

                // Render a projects page.
                $this->view->render('projects', $this->admin_template);
                break;

            default:
                // Instantiate a Project Object.
                $model = $this->model = new Project;

                // Get all projects and send them to
                // the project view.
                $this->view->response = $model->get();
                
                // Render all projects page.
                $this->view->render('projects', $this->admin_template);

                break;
        }
    }

    public function library(
        string $action = null,
        string $id = null
    ): void
    {
        // Instantiate a Project Object.
        $model = $this->model = new Library;

        // Sanitize the projects's ID.
        $this->id = (int) clean_data($id);

        switch ($action) {
            case 'add-new':
                // Check if a file was posted for upload.
                if (
                    $_SERVER['REQUEST_METHOD'] === 'POST' &&
                    !empty($_FILES)
                ) {
                    $this->view->form_response = $model->save($_FILES);

                }
            break;

            case 'delete':
                // Check if a file was posted for upload.
                if ($_SERVER['REQUEST_METHOD'] === 'POST')
                {
                    $this->view->form_response = $model->delete($_POST);
                }

            case 'edit':
                // Check if a file was posted for upload.
                if ($_SERVER['REQUEST_METHOD'] === 'POST')
                {
                    $this->view->form_response = $model->edit($_POST);
                }

                break;
        }

        // Get all projects and send them to
        // the project view.
        $this->view->response = $model->get();

        // Render all projects page.
        $this->view->render('library', $this->admin_template);
    }

    public function testimonials(
        string $param = null,
        string $id = null
    ): void
    {
        $this->view->render('testimonials', $this->admin_template);
    }

    public function comments(
        string $param = null,
        string $id = null
    ): void
    {
        $this->view->render('comments', $this->admin_template);
    }

    public function chat(
        string $param = null,
        string $id = null
    ): void
    {
        $this->view->render('chat', $this->admin_template);
    }

    public function users(
        string $action = null,
        string $id = null
    ): void
    {
        // Instantiate a Category Object.
        $model = new User;

        switch ($action) {
            case 'search':
                // Instantiate a Category Object.
                $this->model = new User;

                // Sanitize the category's ID.
                $this->id = (int) clean_data($id);

                // Instantiate a Category Model Object.
                $model = (new $this->model);

                if (
                    $_SERVER['REQUEST_METHOD'] === 'POST' &&
                    !empty($_POST['async'])
                ) {
                    // Search for the data.
                    $this->view->response = $model->search($_POST);

                    // Render a projects page.
                    $this->view->load('search-users', $this->admin_template);
                } else {
                    // Return a response to the view.
                    $this->view->response = $model->search($_POST);
                    
                    // Render a projects page.
                    $this->view->render('users', $this->admin_template);
                }

                break;

            case 'edit':
                // Sanitize the category's ID.
                $this->id = (int) clean_data($id);

                // Get a users bt ID.
                $this->view->response = $model->get($this->id);

                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $this->view->update_response = $model->update($_POST);
                }
        
                // Render the page.
                $this->view->render('users-form', $this->admin_template);
                // echo bin2hex(random_bytes(5));

                break;

            case 'admins':
                // Sanitize the category's ID.
                $this->id = (int) clean_data($id);

                // Get a users bt ID.
                $this->view->response = $model->get_admins();

                // Render the page.
                $this->view->render('users', $this->admin_template);
                // echo bin2hex(random_bytes(5));

                break;
            
            case 'moderators':
                // Sanitize the category's ID.
                $this->id = (int) clean_data($id);

                // Get a users bt ID.
                $this->view->response = $model->get_moderators();

                // Render the page.
                $this->view->render('users', $this->admin_template);
                // echo bin2hex(random_bytes(5));

                break;
            
            case 'subscribers':
                // Sanitize the category's ID.
                $this->id = (int) clean_data($id);

                // Get a users bt ID.
                $this->view->response = $model->get_subscribers();

                // Render the page.
                $this->view->render('users', $this->admin_template);
                // echo bin2hex(random_bytes(5));

                break;

            default:
                // Get all users.
                $this->view->response = $model->get();
        
                // Render the page.
                $this->view->render('users', $this->admin_template);

                break;
        }
    }

    public function settings(
        string $action = null,
        string $id = null
    ): void
    {
        // Instantiate a Category Object.
        $info = new SiteInfo();

        switch ($action) {
            case 'edit':
                // Instantiate an object.
                $model = new SiteInfo;

                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    // Update Site Info.
                    $this->view->update_response = $model->update($_POST);
                }

                break;
        }
        // Get site info.
        $this->view->response = $info->get();

        // Display the page.
        $this->view->render('general-settings', $this->admin_template);
    }

    public function not_found(): void
    {
		  $this->view->render('404', $this->admin_template);
    }
}
