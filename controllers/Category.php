<?php
namespace controller;

use model\Category as ModelCategory;
use portfolio\BaseController;

use function portfolio\clean_data;

class Category extends BaseController
{
    function __construct()
    {
		parent::__construct();
    }

    public function edit(int $id)
    {
        // Instantiate a Category Model Object.
        $this->model = new ModelCategory;

        // Sanitize the projects's ID.
        $this->id = (int) clean_data($id);

        // Instantiate a Project Model Object.
        $model = (new $this->model);

        // Check if the user posted an update.
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->view->update_form_response = $model->update($_POST);
        }

        // Check if the Category's ID is set.
        if (!empty($this->id)) {
            // Return a response to the view.
            $this->view->form_response = $model->get($this->id);
        }

        // Get all categories then
        // return them as a response to the view.
        $this->view->categories = $model->get_all();

        // Render a category page.
        $this->view->render('category', 'admin');
    }

    public function not_found()
    {
		$this->view->render('404');
    }
}
