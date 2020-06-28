<?php
namespace portfolio;

/**
 * Class that handles post/project categories.
 */
class Tag {
	// Properties.

	/**
     *  @var int The Tag's ID from the database.
     */
    public $id;

    /**
     *  @var string The name of the Tag.
     */
    public $name;

    /**
     *  @var string The Tag's slug.
     */
    public $slug;

    /**
     *  @var string A short note about the Tag.
     */
    public $description;
	
	/**
	 * Sets the object's properties using the values in the supplied array.
	 * 
	 * @param assoc The property value
	 */
	function __construct(int $id = null, string $name = null, string $slug = null, $description = null)
	{
		if (!empty($id))
			$this->id = (int) clean_data($id);

		if (!empty($name))
			$this->name = (string) clean_data($name);

		if (!empty($slug))
			$this->slug = (string) clean_data($slug);
		
		if (!empty($description))
			$this->description = (string) clean_data($description);
	}

	/**
	 * Get a Tag object matching the given Tag ID.
	 * 
	 * @param int The Tag ID.
	 * @return Tag | false The Tag object or false if the record was not found or there was a problem.
	 */
	public function get()
	{
		// Instantiate a DB object.
		$db = new Database();

		// Check if the Tag object has an ID?.
		if (empty($this->id))
			trigger_error('<strong>Tag::get()</strong> Attempt to fetch a Tag object that doestn\'t have it\'s ID property set.', E_USER_ERROR);

		// Sanitize ID.
		$id = clean_data($this->id);

		// Prepare a Statement.
		$sql = $db->prepare(
			'SELECT 
				id,
				name,
				slug,
				description
			FROM
				me_tag
			WHERE
				id = ?'
		);

		// Bind parameter.
		$sql->bind_param('i', $id);

		$data = [];

		// Execute query.
		if ($sql->execute() === true) {
			// Bind result value.
			$sql->bind_result(
				$id,
				$name,
				$slug,
				$description
			);

			// Retrieve rows.
			if ($sql->fetch() === true) {
				// Return the data.
				$tag = new Tag(
					$id,
					$name,
					$slug,
					$description
				);

				array_push($data, $tag);
			}
				
		}
		
		// Close Statement.
		$sql->close();

		// close dbection.
		$db->close();

		// Return false by default.
		return false;
	}

	/**
	 * Get all (or a rang of) Tag objects in the database.
	 * 
	 * @param int Optional The number if rows to return (return all by default).
	 * @return string Optional column by which to order the categories (name by default in ASC order).
	 * @return False | Array
	 */	
	public static function get_all(int $offset = null, int $numOfRows = null)
	{
		// Instantiate a DB object.
		$db = new Database();

		// Set default parameters.		
		if (empty($numOfRows)) {
			$numOfRows = 1000000;
		}

		// Prepare a Statement.
		$sql = $db->prepare(
			'SELECT
				id,
				name,
				slug,
				description
			FROM 
				me_tag
			ORDER BY
				name ASC
			LIMIT 
				?, ?'
		);

		// Bind Parameters.
		$sql->bind_param(
			'ii',
			$offset,
			$numOfRows
		);

		$data = [];

		// Execute Query.
		if ($sql->execute() === true) {
			// Bind Result Value.
			$sql->bind_result(
				$id,
				$name,
				$slug,
				$description
			);

			// Retrieve rows.
			while ($sql->fetch() === true) {
				// Instantiate an Object.
				$tag = new Tag(
					$id,
					$name,
					$slug,
					$description
				);

				// Store an array of objects.
				array_push($data, $tag);
			}
		}

		// Close Statement.
		$sql->close();

		// close dbection.
		$db->close();

		return $data;
	}

	/**
	 *  Get the total number of rows.
	 */
	public static function count_rows(): int
	{
		// Instantiate a DB object.
		$db = new Database();

		// Prepare a Statement.
		$sql = $db->prepare('SELECT COUNT(*) as totalRows FROM me_tag');

		// Execute Query.
		if ($sql->execute() !== false) {
			// Bind the result to a variable.
			$sql->bind_result($total_rows);

			if ($sql->fetch() !== false) {

				return $total_rows;
			};
		}

		// Close Statement.
		$sql->close();

		// close dbection.
		$db->close();

		return 0;
	}

	/**
	 *	Inserts the current object into the database.
	 *	
	 *	@return false || true if the Tag object was inserted into the database successfully.
	 */
	public function insert(): bool
	{
		// Instantiate a DB object.
		$db = new Database();

		if (empty($this->description)) {
			// Prepare a Statement.
			$sql = $db->prepare('INSERT INTO me_tag(name, slug) VALUES(?, ?)');

			// Bind Parameters.
			$sql->bind_param('ss', $this->name, $this->slug);

		} else {
			// Prepare a Statement.
			$sql = $db->prepare('INSERT INTO me_tag(name, slug, description) VALUES(?, ?, ?)');

			// Bind Parameters.
			$sql->bind_param('sss', $this->name, $this->slug, $this->description);
		}
		
		// Execute.
		if ($sql->execute()) {
			return true;
		}

		// Close Statement.
		$sql->close();

		// close dbection.
		$db->close();

		// Return false by default.
		return false;
	}

	/**
	 *	Updates the current Tag object in the database.
	 *	
	 *	@return false | true if the Tag object was updated in the database successfully.
	 */
	public function update(): bool
	{
		// Instantiate a DB object.
		$db = new Database();

		// Check if the Tag object has an ID?.
		if (empty($this->id))
			trigger_error('<strong>Tag::insert()</strong> Attempt to insert a Tag object that doestn\'t it\'s ID property set.', E_USER_ERROR);

		// Prepare a Statement.
		if (!empty($this->name) && empty($this->description)) {
			// Prepare a Statement.
			$sql = $db->prepare('UPDATE me_tag SET name = ? WHERE id = ?');

			// Bind Parameters.
			$sql->bind_param('si', $this->name, $this->id);
		} elseif (empty($this->name) && !empty($this->description)) {
			// Prepare a Statement.
			$sql = $db->prepare('UPDATE me_tag SET description = ? WHERE id = ?');

			// Bind Parameters.
			$sql->bind_param('si', $this->description, $this->id);
		} else {
			// Prepare a Statement.
			$sql = $db->prepare('UPDATE me_tag SET name = ?, description = ? WHERE id = ?');

			// Bind Parameters.
			$sql->bind_param('ssi', $this->name, $this->description, $this->id);
		}

		// Execute.
		if ($sql->execute()) {
			return true;
		}

		// Close Statement.
		$sql->close();

		// close dbection.
		$db->close();

		// Return false by default.
		return false;
	}

	/**
	 *	Delete the current Tag object in the database.
	 *	
	 *	@return false | true if the Tag object was deleted from the database successfully.
	 */
	public function delete(): bool
	{
		// Instantiate a DB object.
		$db = new Database();

		// Check if the Tag object has an ID?.
		if (empty($this->id))
			trigger_error('<strong>Tag::insert()</strong> Attempt to delete a Tag object that doestn\'t it\'s ID property set.', E_USER_ERROR);

		// Prepare a Statement to delete the Tag.
		$sql = $db->prepare('DELETE FROM me_tag WHERE id = ? LIMIT 1');

		// Bind Parameters.
		$sql->bind_param('i', $this->id);

		// Execute.
		if ($sql->execute() === true) {
			return true;
		}

		// Close Statement.
		$sql->close();

		// close dbection.
		$db->close();

		// Return false by default.
		return false;
	}
}