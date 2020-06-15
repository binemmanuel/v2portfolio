<?php
namespace portfolio;

/**
 * OUr View Class.
 */
class BaseView
{
	
	function __construct()
	{
	}

	public function render(
		string $view, 
		string $template = 'starlyon'
	): void
	{
		switch ($view) {
			case '/':
				$view = 'index';
				break;
		}
		$header = "views/$template/header.php";
		$footer = "views/$template/footer.php";

		if (file_exists($header)) {
			require "views/$template/header.php";
		}
		require "views/$template/$view.php";

		if (file_exists($footer)) {
			require "views/$template/footer.php";
		}
	}

	public function load(
		string $view, 
		string $template = 'starlyon'
	): void
	{
		switch ($view) {
			case '/':
				$view = 'index';
				break;
		}

		require "views/$template/$view.php";
	}
}