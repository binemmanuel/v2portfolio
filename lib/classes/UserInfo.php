<?php
namespace portfolio;

/**
 * User Info class
 */
/**
 * 
 */
class UserInfo extends User
{
	/**
     *  @var int The ID of the data.
     
    private $id;*/

    /**
     *  @var int The User's ID from the database.
     */
    private $user_id;

    /**
     *  @var string The User's full name.
     */
    private $full_name;

    /**
     *  @var string The User's website.
     */
    private $website;

    /**
     *  @var string The User's biography.
     */
    private $bio;

    /**
     *  @var string The date the data was modified.
     */
    private $modified_on;
	
	function __construct(/*int $id = NULL, */int $user_id = NULL, string $full_name = NULL, string $website = NULL, string $bio = NULL, string $modified_on = NULL)
	{
		/*if (!empty($id))
			$this->id = clean_data($id);*/

		if (!empty($user_id))
			$this->user_id = clean_data($user_id);

		if (!empty($full_name))
			$this->full_name = clean_data($full_name);

		if (!empty($website))
			$this->website = clean_data($website);

		if (!empty($bio))
			$this->bio = clean_data($bio);

		if (!empty($modified_on))
			$this->modified_on = clean_data($modified_on);

    }
    
    /**
     * Set ID.
     * 
     * @param Int The user's ID.
     */
    public function set_id(int $id)
    {
        $this->user_id = clean_data($id);
    }

    /**
     * Set Full Name.
     * 
     * @param String The user's Full Name.
     */
    public function set_full_name(string $full_name)
    {
        $this->full_name = clean_data($full_name);
    }

    /**
     * Set Website.
     * 
     * @param String The user's Website.
     */
    public function set_website(string $website)
    {
        $this->website = clean_data($website);
    }

    /**
     * Set Bio.
     * 
     * @param String The user's Bio.
     */
    public function set_bio(string $bio)
    {
        $this->bio = clean_data($bio);
    }

	/**
     *	Saves User's data to the database.
     *	
     *	@return Bool true||false.
     */
	public function save(): bool
	{
		// Instantiate a DB object.
		$db = new Database();

        // Prepare a Statement.
        $stmt = $db->prepare("INSERT INTO me_users_info(user_id , full_name, website, bio) VALUES(?, ?, ?, ?)");

        // Bind Parameters.
        $stmt->bind_param('ssss', $this->user_id, $this->full_name, $this->website, $this->bio);

		// Execute query.
        $result = $stmt->execute();

		// Check if query was successful.
        if ($result == true) {
            return true;
        }
        // Close Statement.
        $stmt->close();
        
        // Close Connection.
        $db->close();

		return false;
	}

    /**
     *  Updates the current User's object in the database.
     *  
     *  @return Bool false || true if the user data was updated successfully.
     */
    public function update(): bool
    {
        // Instantiate a DB object.
		$db = new Database();

        // Prepare a Statement.
        $stmt = $db->prepare('UPDATE me_users_info SET full_name = ?, website = ?, bio = ? WHERE user_id = ?');

        // Bind Parameters.
        $stmt->bind_param('sssi', $this->full_name, $this->website, $this->bio, $this->user_id);

        // Execute query.
        if ($stmt->execute()) {
            return true;
        }

        // Close Statement.
        $stmt->close();
        
        // Close Connection.
        $db->close();

        return false;
    }

    /**
     * Check if user data already exist.
     * 
     * @param int The user's ID.
     * 
     * @return bool false || true of the user data exist.
     */
    public function has_data(): bool
    {
        // Instantiate a DB object.
		$db = new Database();

        // Prepare a statement.
        $stmt = $db->prepare('SELECT id from me_users_info WHERE user_id = ? LIMIT 1');

        // Bind parameter.
        $stmt->bind_param('i', $this->user_id);

        // Execute.
        $stmt->execute();

        // Check if the data exist, then return true if it does.
        if ($stmt->fetch()) {
            return true;
        }

        // Return false by default.
        return false;
    }

    /**
     * The method that sets the profile picture of a User Object.
     * 
     * @param int The User Object's ID.
     * @param string A link to the profile picture.
     *
     * @return bool false || true if the profile picture was set successfully.
     */
    public static function set_profile_pic(int $id, string $profile_pic): bool
    {
        if (empty($id))
            trigger_error('<strong>User_info::has_data()</strong>: Attempt to check if a User\'s object has it\'s data store in database without it\'s ID property set.', E_USER_ERROR);
        
        // Instantiate a DB object.
		$db = new Database();

        // Sanitize data.
        $id = (int) clean_data($id);
        $profile_pic = (string) clean_data($profile_pic);

        // Prepare a statement.
        $stmt = $db->prepare('UPDATE me_users_info SET profile_pic = ? WHERE user_id = ?');

        // Bind parameter.
        $stmt->bind_param('si', $profile_pic, $id);

        // Execute.
        if ($stmt->execute())
            return true;

        // Close statement.
        $stmt->close();

        // Close connection.
        $db->close();

        return false;
    }
}