<?php
namespace controller;

use model\Contact as ModelContact;
use portfolio\BaseController;

class Contact extends BaseController
{
    
    function __construct()
    {
        parent::__construct();
        $this->model = new ModelContact();
      
    }

    public function get()
    {
        $this->view->render('/', 'starlyon');
    }

    public function send()
    {
        if (empty($_POST)) {
            $this->view->render('404');
            
        } else {
            $model = (new $this->model);
            $response = $model->send($_POST);

            $_SESSION['response'] = (!empty($response)) ? $response : [
                'error' => true,
                'message' => 'Please fill in the form.',
                'type' => 'unknown'
            ];

            header('Location:'. WEB_ROOT .'home#contact');
            exit;
        }

        $this->view->render('home');
    }

    public function not_found()
    {
		$this->view->render('404');
    }
}
