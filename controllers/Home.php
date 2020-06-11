<?php
namespace controller;

use portfolio\BaseController;
use portfolio\SiteInfo;

class Home extends BaseController
{
    function __construct()
    {
		parent::__construct();
	  
		$this->info = new SiteInfo;
		$this->info = $this->info->fetch();
    }

    public function get()
    {
		

		$this->view->render('/', $this->info->template);
    }

    public function not_found()
    {
		$this->view->render('404');
    }
}
