<?php
namespace portfolio;

/**
 * OUr View Class.
 */
class BaseView
{
	/**
	 * Renders a view.
	 * 
	 * @param String The view.
	 * @param String (optional) The template active template.
	 * 
	 * @return Void Nothing.
	 */
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

		if (
			file_exists($header) &&
			!$this->view_is($view)
		) {
			require "views/$template/header.php";
		}

		require "views/$template/$view.php";

		if (
			file_exists($footer) &&
			!$this->view_is($view)
		) {
			require "views/$template/footer.php";
		}
	}
	
	public function view_is(string $view): bool
	{
		$views = [
			'login',
			'signup'
		];

		if (\in_array($view, $views)) {
			return true;
		}

		return false;
	}

	/* public function load(
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
	} */
}