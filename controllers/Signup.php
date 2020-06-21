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

        // Instantiate a SiteInfo Model Object.
        $model = (new $this->model);

        $this->view->render('signup', $this->info->admin_template);
    }


    public function not_found()
    {
		$this->view->render('404');
    }
}
