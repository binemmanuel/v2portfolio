<?php
namespace portfolio;

/**
 * Class that handles post/project categories.
 */
class Category {
	// Properties.

	/**
     *  @var int The Category's ID from the database.
     */
    public $id;

    /**
     *  @var string The name of the Category.
     */
    public $name;

    /**
     *  @var string The Category's slug.
     */
    public $slug;

    /**
     *  @var string A short note about the Category.
     */
    public $description;
	
	/**
	 * Sets the object's properties using the values in the supplied array.
	 * 
	 * @param assoc The property value
	 */
	function __construct(
		int $id = null,
		string $name = null,
		string $slug = null,
		string $description = null
	)
	{
		if (!empty($id))
			$this->id = (int) clean_data($id);

		if (!empty($name))
			$this->name = (string) strtolower(clean_data($name));

		if (!empty($slug))
			$this->slug = (string) clean_data($slug);

			if (!empty($description))
			$this->description = (string) clean_data($description);
	}

	public function make_slug(string $name)
	{
		return $this->slug = (string) str_replace(' ', '-', $name);
	}

	/**
	 * Get a Category object matching the given Category ID.
	 * 
	 * @param int The Category ID.
	 * @return Category | false The Category object or false if the record was not found or there was a problem.
	 */
	public function get()
	{
		// Instantiate a DB object.
		$db = new Database();

		// Sanitize ID.
		$id = clean_data($this->id);

		// Prepare a Statement.
		$stmt = $db->prepare('SELECT id, name, slug, description FROM me_category WHERE id = ?');

		// Bind parameter.
		$stmt->bind_param('i', $this->id);

		$category = new Category();

		// Execute query.
		if ($stmt->execute() === true) {
			// Bind result value.
			$stmt->bind_result($id, $name, $slug, $description);

			// Retrieve rows.
			if ($stmt->fetch() === true) {
				// Return the data.
				$category->id = $id ;
				$category->name = $name ;
				$category->slug = $slug ;
				$category->description = $description ;
			}
				
		}
		
		// Close Statement.
		$stmt->close();

		// close dbection.
		$db->close();

		// Return false by default.
		return $category;
	}

	/**
	 * Get all categories that a project belongs to..
	 * 
	 * @param Int The Projects ID.
	 * @return Category The Category list of categories.
	 */
	public function get_project_cat(int $project): array
	{
		// Instantiate a DB object.
		$db = new Database();

		// Check if the category object has an ID?.
		
		// Sanitize ID.
		$project = clean_data($project);

		// Prepare a Statement.
		$stmt = $db->prepare(
			'SELECT
				category
			FROM
				me_project_category
			WHERE project = ?'
		);

		// Bind parameter.
		$stmt->bind_param('i', $project);

		// Execute query.
		$stmt->execute();

		// Bind result value.
		$stmt->bind_result($category);

		// Instantiate an empty array.
		$data = [];

		// Retrieve rows.
		while ($stmt->fetch()) {
			// Instantiate a Category Object.
			$category_obj = new Category();

			// Set data.
			$category_obj->id = $category;

			// Create an array of categories.
			array_push($data, $category_obj);
		}
		
		// Close Statement.
		$stmt->close();

		// close dbection.
		$db->close();

		// Return false by default.
		return $data;
	}

	/**
	 * Get all (or a rang of) Category objects in the database.
	 * 
	 * @param int Optional The number if rows to return (return all by default).
	 * @return string Optional column by which to order the categories (name by default in ASC order).
	 * @return Array A list of all categories. 
	 */	
	public static function get_all(int $offset, int $numOfRows)
	{
		// Instantiate a DB object.
		$db = new Database();

		// Set default parameters.		
		if (empty($numOfRows)) {
			$numOfRows = 1000000;
		}

		// Prepare a Statement.
		$stmt = $db->prepare('SELECT id, name, slug, description FROM me_category ORDER BY name ASC LIMIT ?, ?');

		// Bind Parameters.
		$stmt->bind_param('ii', $offset, $numOfRows);

		$data = [];

		// Execute Query.
		if ($stmt->execute() === true) {
			// Bind Result Value.
			$stmt->bind_result($id, $name, $slug, $description);

			// Retrieve rows.
			while ($stmt->fetch() === true) {
				// Instantiate an Object.
				$category = new Category($id, $name, $slug, $description);

				// Store an array of objects.
				array_push($data, $category);
			}
		}
		
		// Close Statement.
		$stmt->close();
		
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
		$stmt = $db->prepare('SELECT COUNT(*) as totalRows FROM me_category');

		// Execute Query.
		if ($stmt->execute() !== false) {
			// Bind the result to a variable.
			$stmt->bind_result($total_rows);

			if ($stmt->fetch() !== false) {

				return $total_rows;
			};
		}

		// Close Statement.
		$stmt->close();

		// close dbection.
		$db->close();

		return 0;
	}

	/**
	 *	Saves a new Category.
	 *	
	 *	@return Bool false || true if the Category saved successfully.
	 */
	public function save()
	{
		// Instantiate a DB object.
		$db = new Database();

		if (empty($this->description)) {
			// Prepare a Statement.
			$stmt = $db->prepare('INSERT INTO me_category(name, slug) VALUES(?, ?)');

			// Bind Parameters.
			$stmt->bind_param('ss', $this->name, $this->slug);

		} else {
			// Prepare a Statement.
			$stmt = $db->prepare('INSERT INTO me_category(name, slug, description) VALUES(?, ?, ?)');

			// Bind Parameters.
			$stmt->bind_param('sss', $this->name, $this->slug, $this->description);
		}
		
		// Execute.
		$stmt->execute();

		// Store return values.
		$stmt->store_result();
		
		// Get last inserted ID
		$last_id = $stmt->insert_id;

		// Close Statement.
		$stmt->close();

		// close dbection.
		$db->close();

		// Return false by default.
		return $last_id;
	}

	/**
	 *	Inserts the current object into the database.
	 *	@var Int The category's ID. 
	 *	@var Int The project's ID. 

	 *	@return Bool false || true if the Project was added to the category.
	 */
	public function add_project(
		int $category,
		int $project
	): bool
	{
		// Instantiate a DB object.
		$db = new Database();
		
		// Prepare a Statement.
		$stmt = $db->prepare(
			'INSERT INTO
				me_project_category(
					category,
					project
				)
			VALUES(?, ?)'
		);

		// Bind Parameters.
		$stmt->bind_param(
			'ss',
			$category,
			$project
		);
		
		// Execute.
		if ($stmt->execute()) {
			return true;
		};

		// Close Statement.
		$stmt->close();

		// close dbection.
		$db->close();

		// Return false by default.
		return false;
	}

	/**
     *  Check if a category already exists.
	 *	@var Int The category's ID. 
	 *	@var Int The project's ID. 
	 
     *  @return false || true if the category already exists.
     */
	public function is_project_added(
		int $category,
		int $project
	): bool
	{
        // Instantiate a DB object.
		$db = new Database();

        // Prepare a Statement.
		$stmt = $db->prepare(
			'SELECT
				id
			FROM 
				me_project_category
			WHERE
				category = ?
			AND 
				project = ?
			LIMIT 1'
	
		);

		// Bind Parameter.
        $stmt->bind_param(
			'ii',
			$category,
			$project
		);

        // Execute.
		$stmt->execute();
		
		// Bind the result value.
		$stmt->bind_result($id);

        $stmt->fetch();

        // Close Statement.
        $stmt->close();

        // Close dbection.
        $db->close();

        return (bool) $id;
	}
	
	/**
	 *	Delete the current Category object in the database.
	 *	
	 *	@return false | true if the Category object was deleted from the database successfully.
	 */
	public function remove_project(
		array $cat_ids,
		int $proejct_id
	): bool
	{
		// Instantiate a DB object.
		$db = new Database();

		// Query
		$query = 
		'DELETE FROM
				me_project_category
			WHERE';

		// Sanitize the project ID.
		$proejct_id = clean_data(stripslashes($proejct_id));

		if (!empty($cat_ids)) {
			// Loop though the category IDs.
			for ($i = 0; $i < count($cat_ids); $i++) { 
				// Sanitize the Category IDs.
				$cat_ids[$i] = clean_data(stripslashes($cat_ids[$i]));
				
				// Add "category <> $cat_ids[$i]" to query.
				$query .= " category <> $cat_ids[$i]";

				// Check if it isn't the last $cat_ids
				if ($i !== (count($cat_ids) - 1)) {
					// Add "AND" if it's not the last $cat_ids
					$query .= ' AND';
					
				} else {
					// Add "LIMIT 1" if it's the last $cat_ids
					$query .= " AND project = $proejct_id LIMIT 1";
					
				}
			}
		} else {
			$query .= " project = $proejct_id";
		}

		// Prepare an SQL Statementy.
		$stmt = $db->prepare($query);

		// // Execute.
		if ($stmt->execute()) {
			return true;
		}

		// Close Statement.
		$stmt->close();

		// close dbection.
		$db->close();

		// Return false by default.
		return false;
	}

	/**
	 *	Updates the current Category object in the database.
	 *	
	 *	@return false | true if the Category object was updated in the database successfully.
	 */
	public function update(): bool
	{
		// Instantiate a DB object.
		$db = new Database();

		// Prepare a Statement.
		$stmt = $db->prepare(
			'UPDATE
				me_category
			SET
				name = ?,
				slug = ?,
				description = ?
			WHERE
				id = ?'
		);

		// Bind Parameters.
		$stmt->bind_param(
			'sssi',
			$this->name,
			$this->slug,
			$this->description,
			$this->id
		);

		// Execute.
		if ($stmt->execute()) {
			return true;
		}

		// Close Statement.
		$stmt->close();

		// close dbection.
		$db->close();

		// Return false by default.
		return false;
	}
	
	/**
     *  Check if a category already exists.
	 *	@var String The category. 
	 
     *  @return false || true if the category already exists.
     */
	public function exists(string $name): int
	{
        // Instantiate a DB object.
		$db = new Database();

        // Prepare a Statement.
		$stmt = $db->prepare(
			'SELECT
				id
			FROM 
				me_category
			WHERE
				name = ?
			LIMIT 1'
	
		);

		// Bind Parameter.
        $stmt->bind_param('s', $name);

        // Execute.
		$stmt->execute();
		
		// Bind the result value.
		$stmt->bind_result($id);

        $stmt->fetch();

        // Close Statement.
        $stmt->close();

        // Close dbection.
        $db->close();

        return (int) $id;
    }

	/**
	 *	Delete the current Category object in the database.
	 *	
	 *	@return false | true if the Category object was deleted from the database successfully.
	 */
	public function delete(): bool
	{
		// Instantiate a DB object.
		$db = new Database();

		// Check if the category object has an ID?.
		if (empty($this->id))
			trigger_error('<strong>Category::insert()</strong> Attempt to delete a Category object that doestn\'t it\'s ID property set.', E_USER_ERROR);

		// Prepare a Statement to delete the category.
		$stmt = $db->prepare('DELETE FROM me_category WHERE id = ? LIMIT 1');

		// Bind Parameters.
		$stmt->bind_param('i', $this->id);

		// Execute.
		if ($stmt->execute() === true) {
			return true;
		}

		// Close Statement.
		$stmt->close();

		// close dbection.
		$db->close();

		// Return false by default.
		return false;
	}
}