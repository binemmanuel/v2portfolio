<?php
namespace portfolio;

/**
 * Our menu class.
 * 
 * Author: Bin Emmanuel
 *
 * @link http://developers.zerabtech.com/portfolio
 *
 * @version 1.0
 */
class Menu
{
	// Class properties.
	/**
	 *	@var int The menu's ID from the database.
	 */
	public $id;

	/**
	 *	@var string The name of the menu.
	 */
	public $name;

	/**
	 *	@var int The menu's parent ID.
	 */
	public $parent;

	/**
	 *	@var string The menu's link.
	 */
	public $link;


	/**
	 *	@var string The menu's location.
	 */
	public $location;
	
	function __construct(int $id = NULL, string $name = NULL, int $parent = NULL, string $link = NULL, string $location = NULL)
	{
		if (!empty($id))
			$this->id = clean_data($id);

		if (!empty($name))
			$this->name = (string) clean_data($name);

		if (!empty($parent))
			$this->parent = clean_data($parent);
		else
			$this->parent = (int) clean_data($parent);

		if (!empty($link))
			$this->link = clean_data($link);

		if (!empty($location))
			$this->location = clean_data($location);
	}

	/**
	 * The method that fetches out menu from the database.
	 */
	public static function fetch(string $location, bool $loop = NULL)
	{	
		// Instantiate a DB object.
		$db = new Database();

		// Check if $location is empty.
		if (empty($location)){
			// Prepare a statement to fetch all menu.
			$sql = $db->prepare(
				'SELECT 
					id,
					name,
					parent,
					link,
					icon 
				FROM 
					me_frontend_menu'
			);

		} else {
			// Change case (make ever word Uper);
			$location = (string) ucwords($location);

			// Prepare a statement based on the locations specified.
			$sql = $db->prepare(
				'SELECT
					id,
					name,
					parent,
					link
				FROM
					me_frontend_menu
				WHERE 
					location = ?
					ORDER BY id ASC'
			);

			// Bind Parameters.
			$sql->bind_param('s', $location);
		}
		
		// Execute.
		$sql->execute();

		// Bind result values
		$sql->bind_result(
			$id, 
			$name, 
			$parent, 
			$link
		);

		// Instantiate an empty array.
		$data = [];

		// Loop through the data.
		while ($sql->fetch()) {
			// Create an array containing the menu items.
			$menu = [
				'id' => $id,
				'name' => $name,
				'parent_id' => $parent,
				'link' => $link
			];

			$data[$menu['parent_id']][] = $menu;
		}
		
		if ($loop) {
			// Instantiate an object.
			$menu = new menu();

			// Loop through the menu items.
			$menu->loop_menu($data);
		} else {
			// Close Statement.
			$sql->close();

			// close connection.
			$db->close();

			return $data;
		}

		return false;
	}

	/**
	 * The function that loops through our menu.
	 * 
	 * @param array An array containing the menu.
	 * @param int The menus parent's ID.
	 */
	function loop_menu(array $menu = NULL, int $parent_id = 0)
	{
		if (!empty($menu[$parent_id])) { ?>
			<ul>
				<?php // Loop through.
				foreach ($menu[$parent_id] as $items): ?>
					<li class="nav-item">
						<a href="<?= $items['link'] ?>"><?= $items['name']; ?></a>
						
						<?php $loop_menu = new menu() // Instantiate an object. ?>

						<?= $loop_menu->loop_menu($menu, $items['id']) // Loop through the menu items. ?>
					</li>
				<?php endforeach ?>
			</ul>
		<?php }
	}

	/**
	 * The method that fetches a menu object from the database by it's ID.
	 * 
	 * @param int The Object's ID.
	 * 
	 * @return false || the menu.
	 */
	public static function get_menu_by_id(int $id)
	{
		// check if the object id is set.
		if (empty($id))
			trigger_error('<strong>menu::get_menu_by_id()</strong>: Attempt to fetch an Menu Object that doesn\'t have it\'s ID set', E_USER_ERROR);

		// Instantiate a DB object.
		$db = new Database();

		// Prepare a statement.
		$sql = $db->prepare('SELECT id, name, parent, link, location FROM me_frontend_menu WHERE id = ?');

		// Bind parameter.
		$sql->bind_param('i', $id);

		// Execute.
		$sql->execute();

		// Bind result value.
		$sql->bind_result($id, $name, $parent, $link, $location);

		// Instantiate an empty array.
		$data = [];

		// Fetch the data.
		if ($sql->fetch()) {
			// Create an array containing the menu items.
			$menu = [
				'id' => $id,
				'name' => $name,
				'parent_id' => $parent,
				'link' => $link,
				'location' => $location
			];

			$data[$menu['parent_id']][] = $menu;

			return $data;
		}

		// Close Statement.
		$sql->close();

		// close connection.
		$db->close();

		return false;
	}

	/**
	 *  Get the total number of rows.
	 */
	public static function count_rows($column): int
	{	
		// Sanitize data.
		$column = (string) clean_data($column);

		// Instantiate a DB object.
		$db = new Database();

		// Prepare a Statement.
		$sql = $db->prepare('SELECT COUNT(*) as totalRows FROM me_frontend_menu WHERE location = ?');

		// Bind parameter.
		$sql->bind_param('s', $column);

		// Execute Query.
		if ($sql->execute()) {
			// Bind the result to a variable.
			$sql->bind_result($total_rows);

			if ($sql->fetch()) {

				return $total_rows;
			};
		}

		// Close Statement.
		$sql->close();

		// close connection.
		$db->close();

		return 0;
	}

	/**
	 * The method that fetches the name of a menu object from the database by it's ID.
	 * 
	 * @param int The Object's ID.
	 * 
	 * @return false || the name of the menu.
	 */
	public static function get_menu_name_by_id(int $id)
	{
		// check if the object id is set.
		if (empty($id))
			trigger_error('<strong>Menu::get_menu_name_by_id()</strong>: Attempt to fetch an Menu Object that doesn\'t have it\'s ID set', E_USER_ERROR);

		// Instantiate a DB object.
		$db = new Database();

		// Prepare a statement.
		$sql = $db->prepare('SELECT name FROM me_frontend_menu WHERE id = ?');

		// Bind parameter.
		$sql->bind_param('i', $id);

		// Execute.
		$sql->execute();

		// Bind result value.
		$sql->bind_result($name);

		// Instantiate an empty array.
		$data = [];

		// Fetch the data.
		if ($sql->fetch()) {
			// Create an array containing the menu items.
			return $name;
		}

		// Close Statement.
		$sql->close();

		// close connection.
		$db->close();

		return false;
	}

	/**
	 * The method that creates a new menu item.
	 * 
	 * @return bool false || true if the menu was created successfully.
	 */
	public function insert(): bool
	{
		// Instantiate a DB object.
		$db = new Database();

		// Prepare a statement.
		$sql = $db->prepare('INSERT INTO me_frontend_menu(name, parent, link, location) VALUES(?, ?, ?, ?)');

		// Bind parameters.
		$sql->bind_param('siss', $this->name, $this->parent, $this->link, $this->location);

		// Execute.
		if ($sql->execute())
			return true;
		

		// Close Statement.
		$sql->close();

		// close connection.
		$db->close();

		return false;
	}

	/**
	 * The method that updates the an admin menu object.
	 * 
	 * @return bool false || true if the changes were made successfully.
	 */
	public function update(): bool
	{
		// check if the object id is set.
		if (empty($this->id))
			trigger_error('<strong>Admin_menu::update()</strong>: Attempt to edit an Admin Menu Object that doesn\'t have it\'s ID set', E_USER_ERROR);

		// Instantiate a DB object.
		$db = new Database();

		// Prepare a statement.
		$sql = $db->prepare('UPDATE me_frontend_menu SET name = ?, parent = ?, link = ?, location = ? WHERE id = ?');

		// Bind parameters.
		$sql->bind_param('sissi', $this->name, $this->parent, $this->link, $this->location, $this->id);

		// Execute.
		if ($sql->execute()) {
			return true;
		}

		// Close statement.
		$sql->close();

		// Close connection.
		$db->close();

		return false;
	}

	/**
	 * The method that deletes a menu object from our database.
	 * 
	 * @return bool false || true if the admin menu object was deleted successfully.
	 */
	public function delete(): bool
	{
		// check if the object id is set.
		if (empty($this->id))
			trigger_error('<strong>Admin_menu::delete()</strong>: Attempt to delete an Admin Menu Object that doesn\'t have it\'s ID set', E_USER_ERROR);

		// Instantiate a DB object.
		$db = new Database();

		// Prepare a statement.
		$sql = $db->prepare('DELETE FROM me_frontend_menu WHERE id = ? LIMIT 1');

		// Bind parameters.
		$sql->bind_param('i', $this->id);

		// Execute.
		if ($sql->execute()) {
			return true;
		}

		// Close statement.
		$sql->close();

		// Close connection.
		$db->close();

		return false;
	}
}