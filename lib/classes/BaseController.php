<?php
namespace portfolio;

abstract class BaseController
{
	public function __construct(){
		$this->view = new BaseView();
	}

	public function loadModel($modal) {
		$path = 'models'. DIRECTORY_SEPARATOR.$modal.'_model.php';
		
		if (file_exists($path)) {
			require 'models'. DIRECTORY_SEPARATOR . $modal . '.php';
			
			$model_name = ucfirst($modal)."_Model";
			
			$this->model = new $model_name();
		}
	}
}