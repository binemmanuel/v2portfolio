<?php
namespace portfolio;

/**
 * Our Site Info class.
 * 
 * Author: Bin Emmanuel
 *
 * @link http://developers.zerabtech.com/portfolio
 *
 * @version 1.0
 */

// The tables name.
$table_name = 'me_site_info';

 class SiteInfo
 {
 	// Class properties.
	/**
	 *	@var int The Website's ID from the database.
	 */
	public $id;

	/**
	 *	@var string The title of the Website.
	 */
	public $title;

	/**
	 *	@var string The Website's tagline.
	 */
	public $tagline;

	/**
	 *	@var string The Website's address.
	 */
	public $site_address;

	/**
	 *	@var string The Website's address.
	 */
	public $email;

	/**
	 *	@var string Active template.
	 */
	public $template;

	/**
	 *	@var string Active admin template.
	 */
	public $admin_template;

	/**
	 *	@var string The default user role for new registrations.
	 */
	public $default_user_role;

	/**
	 *	@var string Allow new registration || not.
	 */
	public $allow_new_reg;
 	
 	function __construct(
 		int $id = NULL,
 		string $title = NULL,
 		string $tagline = NULL,
 		string $site_address = NULL,
 		string $email = NULL,
 		string $template = NULL,
 		string $admin_template = NULL,
 		string $default_user_role = NULL,
 		string $allow_new_reg = NULL)
 	{
 		if (!empty($id))
 			$this->id = (int) clean_data($id);

 		if (!empty($title))
 			$this->title = (string) clean_data($title);

 		if (!empty($tagline))
 			$this->tagline = (string) clean_data($tagline);

 		if (!empty($site_address))
 			$this->site_address = (string) clean_data($site_address);

 		if (!empty($email))
			$this->email = (string) clean_data($email);
			 
		if (!empty($template))
			$this->template = (string) clean_data($template);
			
		if (!empty($admin_template))
 			$this->admin_template = (string) clean_data($admin_template);

 		if (!empty($default_user_role))
 			$this->default_user_role = (string) clean_data($default_user_role);

 		if (!empty($allow_new_reg))
 			$this->allow_new_reg = (string) clean_data($allow_new_reg);
 	}

 	/**
     * Get the list of User objects in the database.
     * 
     * @param string The in which the data would be sorted.
     * @param int Offset.
     * @param int (Option) Numbers of rows to be retrieved (default = 2000000).
     * 
     * @return array of objects An array of objects of the users data.
     */ 
 	public static function fetch()
 	{
		// Instantiate a DB object.
		$db = new Database();

		// Prepare a statement.
		$sql = $db->prepare('SELECT * FROM me_site_info');

		//Check if there was an error.
		if (!empty($sql->error))
			die($sql->error);

		// Execute query.
		if ($sql->execute()) {
			// Bind result.
			$sql->bind_result(
				$id, 
				$title, 
				$tagline, 
				$address, 
				$email,
				$template,
				$admin_template,
				$default_user_role, 
				$allow_new_reg
			);

			// Initialize an empty array.
			$data = [];

			// Fetch and loop through data
			if ($sql->fetch()){
				return $site_info = new SiteInfo(
					$id, 
					$title, 
					$tagline, 
					$address, 
					$email,
					$template,
					$admin_template,
					$default_user_role, 
					$allow_new_reg
				);
			}
		}

		// Close statement.
		$sql->close();

		// Close connection.
		$db->close();

		return false;
 	}

 	/**
	 * The method that inserts the website's data (informations) into the database.
	 * 
	 * @return bool false || true if the website was created successfully.
	 */
 	public function insert(): bool
 	{
 		// Instantiate a DB object.
		$db = new Database();

		// Prepare a statement.
		$sql = $db->prepare(
			'INSERT INTO 
				me_site_info(
					title,
					tagline, 
					address, 
					email,
					template,
					admin_template,
					default_user_role, 
					allow_new_reg
				)
			VALUES(?, ?, ?, ?, ?, ?, ?, ?)'
		);

		// Bind Parameters.
		$sql->bind_param(
			'ssssss', 
			$this->title, 
			$this->tagline, 
			$this->site_address, 
			$this->email,
			$this->template,
			$this->admin_template,
			$this->default_user_role, 
			$this->allow_new_reg
		);

		if (!empty($sql->error))
			die($sql->error);

		// Execute query.
		if ($sql->execute())
			return true;

		// Close statement.
		$sql->close();

		// Close connection.
		$db->close();

 		// Return false by default.
 		return false;
 	}

 	/**
	 * The method that updates the website's data (informations) into the database.
	 * 
	 * @return Bool false || true if the website's data (information(s)) were updated successfully.
	 */
 	public function update(): bool
 	{
 		// check if the object id is set.
		if (empty($this->id))
			trigger_error('<strong>Site_info::update()</strong>: Attempt to update the Website\'s information Object without setting it\'s ID', E_USER_ERROR);

 		// Instantiate a DB object.
		$db = new Database();

		// Prepare a statement.
		$sql = $db->prepare(
			'UPDATE me_site_info
				SET
					title = ?,
					tagline = ?,
					address = ?,
					email = ?,
					default_user_role = ?,
					allow_new_reg = ?
				WHERE
					id = ?'
		);

		// Bind parameters.
		$sql->bind_param(
			'ssssssi',
			$this->title,
			$this->tagline,
			$this->site_address,
			$this->email,
			$this->default_user_role,
			$this->allow_new_reg,
			$this->id
		);

		if (!empty($sql->error))
			die($sql->error);

		// Execute query.
		if ($sql->execute())
			return true;

		// Close statement.
		$sql->close();

		// Close connection.
		$db->close();

 		// Return false by default.
 		return false;
 	}
 }