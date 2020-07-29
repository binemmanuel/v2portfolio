<?php

namespace portfolio;

use portfolio\Database;

use function portfolio\clean_data;

/**
 * The class responsible to handle media files.
 * 
 * Author: Bin Emmanuel
 *
 * @link http://developers.zerabtech.com/portfolio
 *
 * @version 1.0
 */
class Library
{
	// Class properties.
	/**
	 *	@var int The file's ID from the database.
	 */
	public $id;

	/**
	 *	@var string The name of the file.
	 */
	public $name;

	/**
	 *	@var string The link to the file.
	 */
	public $link;

	/**
	 *	@var string The file's cation.
	 */
	public $caption;

	/**
	 *	@var string The file's Alt Text.
	 */
	public $alt_text;

	/**
	 *	@var string The file's Description.
	 */
	public $description;

	/**
	 *	@var string The type of file.
	 */
	public $type;

	/**
	 *	@var string The name of the person that made the upload.
	 */
	public $uploaded_by;

	/**
	 *	@var int The date the file was uploaded.
	 */
	public $uploadedOn;

	function __construct(int $id = null, string $name = null, string $link = null, string $caption = null, string $alt_text = null, string $description = null, string $type = null, string $uploaded_by = null, string $uploadedOn = null)
	{
		/*
		 * Store the data if they are not empty.
		 */
		if (!empty($id))
			$this->id = (int) clean_data($id);

		if (empty($name)) {
			// Split the link.
			$split_URL = explode('/', $link);

			// Count and store.
			$count = (count($split_URL) - 1);

			// Store the file name.
			$this->name = clean_data($split_URL[$count]);
		} else {
			// Store the file name.
			$this->name = clean_data($name);
		}

		if (!empty($link))
			$this->link = clean_data($link);

		if (!empty($caption))
			$this->caption = clean_data($caption);

		if (!empty($alt_text))
			$this->alt_text = clean_data($alt_text);

		if (!empty($description))
			$this->description = clean_data($description);

		if (!empty($type))
			$this->type = clean_data($type);

		if (!empty($uploaded_by))
			$this->uploadedBy = clean_data($uploaded_by);

		if (!empty($uploadedOn))
			$this->uploadedOn = clean_data($uploadedOn);
	}

	/**
	 * This method fetches a media file by it's ID.
	 * 
	 * @param int The media's ID.
	 * @return The Media file || an error message if the media file wasn't found or there was a problem.
	 */
	public static function get(int $id = null)
	{
		// Instantiate a DB object.
		$db = new Database();

		// Sanitize ID.
		$id = clean_data($id);

		// Prepare a statement.
		$stmt = $db->prepare('SELECT * FROM me_library WHERE id = ?');

		// Bind Parameter.
		$stmt->bind_param('i', $id);

		// Execute.
		if ($stmt->execute()) {
			// Bind result value.
			$stmt->bind_result($id, $name, $link, $caption, $alt_text, $description, $type, $uploaded_by, $uploadedOn);

			// Retrieve rows.
			if ($stmt->fetch()) {
				// Return an Oject of the media file.
				return new Library($id, $name, $link, $caption, $alt_text, $description, $type, $uploaded_by, $uploadedOn);
			}
		}

		// Close Statement.
		$stmt->close();

		// close connection.
		$db->close();

		return false;
	}

	/**
	 * Return All media objects.
	 * 
	 * @return The Media files || false if there was a problem.
	 */
	public static function get_all(string $type = NULL)
	{
		// Instantiate a DB object.
		$db = new Database();

		if (
			empty($type) ||
			strtolower($type) === 'all'
		) {
			// Prepare a statement.
			$stmt = $db->prepare('SELECT * FROM me_library ORDER BY id DESC');
		} else {
			$type = "%{$type}%";

			// Prepare a statement.
			// $stmt = $db->prepare('SELECT * FROM me_library WHERE type like ? ORDER BY id DESC');
			$stmt = $db->prepare('SELECT * FROM me_library WHERE type like ? ORDER BY id DESC');

			// Bind Parameter.
			$stmt->bind_param('s', $type);
		}

		// Initialize an empty array.
		$data = [];

		// Execute.
		$stmt->execute();

		// Bind result value.
		$stmt->bind_result($id, $name, $link, $caption, $alt_text, $description, $type, $uploaded_by, $uploadedOn);

		// Retrieve rows.
		while ($stmt->fetch()) {
			// Instantiate an Object.
			$media_files = new Library;

			// Set data.
			$media_files->id = $id;
			$media_files->name = $name;
			$media_files->link = $link;
			$media_files->caption = $caption;
			$media_files->alt_text = $alt_text;
			$media_files->description = $description;
			$media_files->type = $type;
			$media_files->uploaded_by = $uploaded_by;
			$media_files->uploadedOn = $uploadedOn;

			// Store an array of objects.
			array_push($data, $media_files);
		}

		// Get the total number of categories that matched the criteria.
		$totalRows = Library::getTotalRow();

		// Close Statement.
		$stmt->close();

		// close connection.
		$db->close();

		return $data;
	}

	/**
	 *  Get the total number of rows.
	 */
	public static function getTotalRow(): int
	{
		// Instantiate a DB object.
		$db = new Database();

		// Prepare a Statement.
		$stmt = $db->prepare('SELECT COUNT(*) as totalRows FROM me_library');

		// Execute Query.
		if ($stmt->execute()) {
			// Bind the result to a variable.
			$stmt->bind_result($totalRows);

			if ($stmt->fetch()) {
				return $totalRows;
			};
		}

		// Close Statement.
		$stmt->close();

		// close connection.
		$db->close();

		return 0;
	}

	public static function search(string $keyword)
	{
		// Instantiate a DB object.
		$db = new Database();

		$keyword = clean_data("%{$keyword}%");

		// Prepare a statement.
		$stmt = $db->prepare('SELECT * FROM me_library WHERE name LIKE ? ORDER BY id DESC');

		// Bind parameter.
		$stmt->bind_param('s', $keyword);

		if ($stmt->execute()) {
			// Bind result.
			$stmt->bind_result($id, $name, $link, $caption, $alt_text, $description, $type, $uploaded_by, $uploadedOn);

			// Initialize an empty array.
			$data = [];

			while ($stmt->fetch()) {
				// Instantiate an Object.
				$search = new Library($id, $name, $link, $caption, $alt_text, $description, $type, $uploaded_by, $uploadedOn);

				// Store an array of objects.
				array_push($data, $search);
			}

			return $data;
		}

		// Close Statement.
		$stmt->close();

		// close connection.
		$db->close();

		return false;
	}

	/**
	 *	Uploads the file.
	 *	 
	 *	@param string The file name.
	 *	@param string The link to the file.
	 *	@param string The type of file.
	 *	@param string The description of the file.
	 *	@return false || true if the Library object was inserted into the database successfully.
	 */
	public function upload(): bool
	{
		// Instantiate a DB object.
		$db = new Database();

		// Prepare a Statement.
		$stmt = $db->prepare(
			'INSERT INTO 
				me_library(
					name,
					link, 
					type,
					description,
					uploadedBy
				)
			VALUES(?, ?, ?, ?, ?)'
		);

		// Bind Parameters.
		$stmt->bind_param(
			'sssss',
			$this->name,
			$this->link,
			$this->type,
			$this->description,
			$this->uploaded_by
		);

		// Execute.
		if ($stmt->execute()) {
			return true;
		}

		// Close Statement.
		$stmt->close();

		// close connection.
		$db->close();

		// Return false by default.
		return false;
	}

	/**
	 *	Update the the current object.
	 *	
	 *	@return false || true if the object was updated successfully.
	 */
	public function update(): bool
	{
		if (empty($this->id))
			trigger_error('<strong>Library::update()</strong>: Attempt to update a Media Object that doesn\'t have it\'s ID set', E_USER_ERROR);

		// Instantiate a DB object.
		$db = new Database();
		// Prepare a Statement.
		$stmt = $db->prepare(
			'UPDATE
				me_library
			SET
				name = ?,
				caption = ?,
				altText = ?,
				description = ?
			WHERE
				id = ?'
		);

		// Bind Parameters.
		$stmt->bind_param(
			'ssssi',
			$this->name,
			$this->caption,
			$this->alt_text,
			$this->description,
			$this->id
		);

		if ($stmt->execute()) {
			return true;
		}

		// Close Statement.
		$stmt->close();

		// close connec

		return false;
	}

	/*
	 *	Delete the current Media file object in the database.
	 */
	public function delete()
	{
		// Instantiate a DB object.
		$db = new Database();

		// Check if the Media's ID is given.
		if (empty($this->id))
			trigger_error('<strong>Library::delete()</strong>: Attempt to delete a Media Object file that doesn\'t have it\'s ID set', E_USER_ERROR);

		// Prepare a Statement.
		$stmt = $db->prepare('DELETE FROM me_library WHERE id = ? LIMIT 1');

		// Bind parameter.
		$stmt->bind_param('i', $this->id);

		if ($stmt->execute()) {
			return true;
		}

		// Close Statement.
		$stmt->close();

		// Close Connection.
		$db->close();

		// Return false by default.
		return false;
	}
} // End of file.