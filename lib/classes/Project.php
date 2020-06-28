<?php
namespace portfolio;

/**
 * The class responsible for handling porjects.
 * 
 * Author: Bin Emmanuel
 *
 * @link http://developers.zerabtech.com/portfolio
 *
 * @version 1.0
 */
class Project
{
	/**
	 *	@var int The Project's ID from the database.
	 */
	public $id;

	/**
	 *	@var string The Project's title.
	 */
	public $title;

	/**
	 *	@var string The Content of the project.
	 */
	public $content;

	/*
	 *	@var string A Summary of the project.
	 */
	public $summary;

	/**
	 *	@var string A Project's author.
	 */
	public $author;

	/*
	 *	@var string The Project's featured image.
	 */
	public $featured_image;

	/*
	 *	@var string The Project's status.
	 */
	public $status;

	/**
	 *	@var string Comment status.
	 */
	public $comment_status;

	/**
	 *	@var string The number of comments the project has.
	 */
	public $comment_count;

	/**
	 *	@var string When the project was added.
	 */
	public $posted_on;

	function __construct(
		int $id = null,
		string $title = null,
		string $content = null,
		string $summary = null,
		string $author = null,
		string $featured_image = null,
		string $status = null,
		string $comment_status = null,
		string $comment_count = null,
		string $posted_on = null
	)
	{
		/*
		 * Store the data if they are not empty.
		 */
		if (!empty($id))
			$this->id = clean_data($id);

		if (!empty($title))
			$this->title = clean_data($title);

		if (!empty($content))
			$this->content = $content;

		if (!empty($summary))
			$this->summary = clean_data($summary);

		if (!empty($author))
			$this->author = clean_data($author);

		if (!empty($featured_image))
			$this->featured_image = clean_data($featured_image);

		if (!empty($status))
			$this->status = clean_data($status);

		if (!empty($comment_status))
			$this->comment_status = clean_data(strtolower($comment_status));

		if (!empty($comment_count))
			$this->comment_count = clean_data($comment_count);

		if (!empty($posted_on))
			$this->posted_on = clean_data($posted_on);
	}

	/**
	 * This method fetches a Project by it's ID.
	 * 
	 * @param int The Project's ID.
	 * @return The Project || an error message if the Project wasn't found or there was a problem.
	 */
	public function get(): object
	{
		// Instantiate a DB object.
		$db = new Database();

		// Sanitize ID.
		$id = (int) clean_data($this->id);

		// Prepare a statement.
		$stmt = $db->prepare('SELECT id, title, content, summary, author, featured_image, status, comment_status, comment_count, posted_on FROM me_project WHERE id = ?');

		// Bind Parameter.
		$stmt->bind_param('i', $id);

		// Execute.
		if ($stmt->execute()) {
			// Bind result value.
			$stmt->bind_result($id, $title, $content, $summary, $author, $featured_image, $status, $comment_status, $comment_count, $posted_on);

			// Retrieve rows.
			if ($stmt->fetch()) {
				// Return an Oject of the project.
				return new Project($id, $title, $content, $summary, $author, $featured_image, $status, $comment_status, $comment_count, $posted_on);
			}
			
		}

		return false;
	}

	/**
	 * This method fetches Projects by status.
	 * 
	 * @param String The status.
	 * @return Array A list of the Projects.
	 */
	public function get_by_status(string $status): array
	{
		// Instantiate a DB object.
		$db = new Database();

		// Sanitize the status.
		$status = (string) clean_data($status);

		// Prepare a statement.
		$stmt = $db->prepare(
			'SELECT
				id,
				title,
				content,
				summary,
				author,
				featured_image,
				status,
				comment_status,
				comment_count,
				posted_on
			FROM
				me_project
			WHERE
				status = ?
			ORDER BY id DESC'
		);

		// Bind Parameter.
		$stmt->bind_param('s', $status);

		// Execute.
		if ($stmt->execute()) {
			// Bind result value.
			$stmt->bind_result(
				$id,
				$title,
				$content,
				$summary,
				$author,
				$featured_image,
				$status,
				$comment_status,
				$comment_count,
				$posted_on
			);

			// Initialize an empty array.
			$projects = [];

			// Retrieve rows.
			while ($stmt->fetch()) {
				// Instantiate a Project Object.
				$project = new Project;

				// Return an Oject of the project.
				$project->id = $id;
				$project->title = $title;
				$project->content = $content;
				$project->summary = $summary;
				$project->author = $author;
				$project->featured_image = $featured_image;
				$project->status = $status;
				$project->comment_status = $comment_status;
				$project->comment_count = $comment_count;
				$project->posted_on = $posted_on;

				array_push($projects, $project);
			}
			
		}

		return $projects;
	}

	/**
	 * Return All project Object.
	 * 
	 * @param string The column to fetch data from.
	 * @param int Where to start fetching from.
	 * @param int Where to stop the fetch
	 * 
	 * @return The Projects || false if there was a problem.
	 */
	public function get_all(
		string $column = 'all',
		int $offset = NULL,
		int $num_rows = 2000000
	): array
	{
		// Instantiate a DB object.
		$db = new Database();

		// Sanitize input.
		$num_rows = (int) clean_data($num_rows);

		// Sanitize input.
		$offset = (int) clean_data($offset);
		
		if (strtolower($column) === 'all') {
			// Prepare a statement.
			$stmt = $db->prepare('SELECT id, author, title, content, summary, featured_image, status, comment_status, comment_count, posted_on FROM me_project ORDER BY posted_on DESC LIMIT ?, ?');

			// Bind Parameters.
			$stmt->bind_param('ii', $offset, $num_rows);
		} else {
			// Sanitize input.
			$column = (string) clean_data($column);

			// Prepare a statement.
			$stmt = $db->prepare('SELECT id, author, title, content, summary, featured_image, status, comment_status, comment_count, posted_on FROM me_project WHERE status = ? ORDER BY posted_on DESC LIMIT ? ,?');
			
			// Bind Parameters.
			$stmt->bind_param('sii', $column, $offset, $num_rows);
		}

		// Initialize an empty array.
		$data = [];

		// Execute.
		if ($stmt->execute()) {
			// Bind result value.
			$stmt->bind_result($id, $author, $title, $content, $summary, $featured_image, $status, $comment_status, $comment_count, $posted_on);

			// Retrieve rows.
			while ($stmt->fetch()) {
				// Instantiate an Object.
				$projects = new Project($id, $title, $content, $summary, $author, $featured_image, $status, $comment_status, $comment_count, $posted_on);
				
				// Store an array of objects.
				array_push($data, $projects);
			}
		}

		// Close Statement.
		$stmt->close();
		
		// Close dbection.
		$db->close();

		return $data;
	}

	/**
	 *  Get the total number of rows.
	 */
	public static function get_total_row(): int
	{
		// Instantiate a DB object.
		$db = new Database();

		// Prepare a Statement.
		$stmt = $db->prepare('SELECT COUNT(*) as totalRows FROM me_project');

		// Execute Query.
		if ($stmt->execute()) {
			// Bind the result to a variable.
			$stmt->bind_result($totalRows);

			if ($stmt->fetch()) {

				return $totalRows;
			};
		}

		return 0;

		// Close Statement.
		$stmt->close();

		// Close dbection.
		$db->close();
	}

	/**
	 * This method counts projects by status.
	 * 
	 * @param String The status.
	 * @return Int The number of projects.
	 */
	public static function count_rows(string $column = NULL): int
	{
		// Instantiate a DB object.
		$db = new Database();

		// Store column name.
		$column = (string) clean_data($column);

		if (empty($column)) {
			// Prepare a Statement.
			$stmt = $db->prepare('SELECT COUNT(*) FROM me_project');
		} else {
			// Prepare a Statement.
			$stmt = $db->prepare('SELECT COUNT(*) FROM me_project WHERE status = ?');

			// Bind parameter.
			$stmt->bind_param('s', $column);
		}

		// Execute Query.
		$stmt->execute();

		// Bind the result to a variable.
		$stmt->bind_result($count);

		// Fetch data.
		$stmt->fetch();
		
		// Close Statement.
		$stmt->close();

		// Close dbection.
		$db->close();

		return $count;
	}

	public static function search(string $keyword)
	{
		// Instantiate a DB object.
		$db = new Database();

		$keyword = clean_data('%'. $keyword .'%');

		// Prepare a statement.
		$stmt = $db->prepare(
			'SELECT
				*
			FROM
				me_project
			WHERE
				title
			LIKE
				?'
		);

		// Bind parameter.
		$stmt->bind_param('s', $keyword);

		$stmt->execute();

		// Bind result.
		$stmt->bind_result(
			$id,
			$author,
			$title,
			$content,
			$summary,
			$featured_image,
			$status,
			$comment_status,
			$comment_count,
			$posted_on
		);

		// Initialize an empty array.
		$data = [];
		
		while ($stmt->fetch()) {
			// Instantiate an Object.
			$projects = new Project(
				$id,
				$title,
				$content,
				$summary,
				$author,
				$featured_image,
				$status,
				$comment_status,
				$comment_count,
				$posted_on
			);

			// Store an array of objects.
			array_push($data, $projects);

		}
		

		// Close Statement.
		$stmt->close();

		// close dbection.
		$db->close();

		return $data;
	}

	/**
	 *  Get the total number of rows a.
	 *  
	 *  @return int The number of a specific column || 0.
	 */
	/*public static function count_rows(string $column): int
	{
		// Instantiate a DB object.
		$db = new Database();

		// Prepare a Statement.
		$stmt = $db->prepare('SELECT COUNT(*) as total_rows FROM me_project');

		// Execute Query.
		if ($stmt->execute()) {
			// Bind the result to a variable.
			$stmt->bind_result($total);

			if ($stmt->fetch()) {
				return $total;
			};
		}

		return 0;

		// Close Statement.
		$stmt->close();

		// Close dbection.
		$db->close();
	}*/

	/**
	 *	Inserts the current object into the database.
	 *	
	 *	@return false || true if the Project object was inserted into the database successfully.
	 */
	public function save(): int
	{
		// Instantiate a DB object.
		$db = new Database();

		// Prepare a Statement.
		$stmt = $db->prepare(
			'INSERT INTO
				me_project(
					title,
					content,
					summary,
					author,
					featured_image,
					comment_status
				)
			VALUES(?, ?, ?, ?, ?, ?)'
		);

		// Bind Parameters.
		$stmt->bind_param(
			'ssssss',
			$this->title,
			$this->content,
			$this->summary,
			$this->author,
			$this->featured_image,
			$this->comment_status
		);
		
		// Execute.
		$stmt->execute();

		// Store return values.
		$stmt->store_result();
		
		// Get last inserted ID
		$last_id = $stmt->insert_id;

		// Close Statement.
		$stmt->close();

		// Close dbection.
		$db->close();
		
		// Return false by default.
		return $last_id;
	}

	/**
	 *	Updates the project.
	 *	
	 *	@return Bool false || True if the Project was updated successfully.
	 */
	public function update(): bool
	{
		if (empty($this->id))
			trigger_error('<strong>Project::update()</strong> Attempt to update a Project object that doestn\'t have it\'s ID property set.', E_USER_ERROR);

		// Instantiate a DB object.
		$db = new Database();

		// Prepare a Statement.
		$stmt = $db->prepare(
			'UPDATE me_project SET
				title = ?,
				content = ?,
				featured_image = ?,
				comment_status = ?
			WHERE
				id = ?'
		);

		// Bind Parameters.
		$stmt->bind_param(
			'ssssi',
			$this->title,
			$this->content,
			$this->featured_image,
			$this->comment_status,
			$this->id
		);
		
		// Execute.
		if ($stmt->execute()) {
			return true;
		}

		
		// Close Statement.
		$stmt->close();
		
		// Close db connection.
		$db->close();
		
		// Return false by default.
		return false;
	}

	/**
	 *	Inserts the current object into the database.
	 *	
	 *	@return false || true if the Project object was updated successfully.
	 */
	public function to_trash(): bool
	{
		if (empty($this->id))
			trigger_error('<strong>Project::update()</strong> Attempt to update a Project object that doestn\'t have it\'s ID property set.', E_USER_ERROR);

		// Instantiate a DB object.
		$db = new Database();

		// Prepare a Statement.
		$stmt = $db->prepare('UPDATE me_project SET status = ? WHERE id = ?');

		// Bind Parameters.
		$stmt->bind_param('si', $this->status, $this->id);
		
		// Execute.
		if ($stmt->execute()) {
			return true;
		}

		// Return false by default.
		return false;

		// Close Statement.
		$stmt->close();

		// Close dbection.
		$db->close();
	}

	/**
	 *	Inserts the current object into the database.
	 *	
	 *	@return false || true if the Project object was updated successfully.
	 */
	public function edit_status(): bool
	{
		if (empty($this->id))
			trigger_error('<strong>Project::update()</strong> Attempt to update a Project object that doestn\'t have it\'s ID property set.', E_USER_ERROR);

		// Instantiate a DB object.
		$db = new Database();

		// Prepare a Statement.
		$stmt = $db->prepare('UPDATE me_project SET status = ? WHERE id = ?');

		// Bind Parameters.
		$stmt->bind_param('si', $this->status, $this->id);
		
		// Execute.
		if ($stmt->execute()) {
			return true;
		}

		// Return false by default.
		return false;

		// Close Statement.
		$stmt->close();

		// Close dbection.
		$db->close();
	}
}