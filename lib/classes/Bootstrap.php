<?php
namespace portfolio;

use controller\Home as Home;
use controller\adminin;

/**
 * Our Bootstrap Class.
 */
class Bootstrap
{
	/**
     *  @var String The requested page with/without an action.
     */
    public $url;
	
	function __construct()
	{
		if (!empty($_GET['url'])) {
			// Sanitize the url.
			$this->url = clean_data($_GET['url']);
			
			// Split URL.
			$this->url = explode('/', $this->url);

			// Check if the controller is not mentioned.
			if (empty($this->url[0]))
				(new Home())->get();

			// Store the file name.
			$file_name = './controllers'. DIRECTORY_SEPARATOR . ucwords($this->url[0]).".php";

			// Set the class name.
			$ct_name = 'controller\\' .ucwords($this->url[0]);

			// Check if the file exist.
			if (!file_exists($file_name)) {
				// Take user to 404 page.
				(new Home())->not_found();

			} elseif (
				strtolower($this->url[0]) !== 'login' &&
				strtolower($this->url[0]) !== 'signup'
			) {
				// Instantiate an Object.
				$controller = new $ct_name();

				// Check if an action was mentioned.
				if (empty($this->url[1])){
					// Get data.
					$controller->get();

				} else {
					// Sanitize data.
					$action = clean_data($this->url[1]);
					$param = (!empty($this->url[2])) ? clean_data($this->url[2]) : null;
					$id = (!empty($this->url[3])) ? clean_data($this->url[3]) : null;

					// Check if an action was mentioned.
					if (method_exists($controller, $action)) {
						/**
						 * Perform task. 
						 * $controller is the controller (class).
						 * $action; // is the action (method).
						 */
						$controller->$action($param, $id);
					} else {
						$controller->not_found();
					}
				}
			} else {
				// Instantiate an Object.
				$controller = new $ct_name();
				
				if (empty($this->url[1])) {
					$action = $this->url[0];
					
					$controller->$action();
				} else {
					$action = clean_data($this->url[1]);
					// Perform an action.
					$controller->$action();
				}
			}


		} else{
			(new Home())->get();
		}
	}
}