<?php
namespace controller;

use portfolio\SiteInfo;
use portfolio\BaseController;
use model\User;
use function portfolio\clean_data;

class Signup extends BaseController
{
    function __construct()
    {
		parent::__construct();

		$this->info = new SiteInfo;
		$this->info = $this->info->fetch();

		if (empty($this->info->admin_template)) {
            $this->info->admin_template = 'admin';
        }

		$this->model = new User;
	}
	
	public function signup()
	{
		$this->view->response = null;
		$this->view->render('signup', $this->info->admin_template);
	}

	public function auth()
	{
		// Instantiate a User Model Object.
		$model = ($this->model);
		
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			// process for data.
			$this->view->response = $model->signup($_POST);
		}

		$this->view->render('signup', $this->info->admin_template);
	}

    public function not_found()
    {
		$this->view->render('404');
    }
}
