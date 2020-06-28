<?php
namespace portfolio;

// Include our Library Class.
use portfolio\User_Info;
use stdClass;

/**
 * User class
 */
class User{
    // Properties.

    /**
     *  @var Int The User's ID from the database.
     */
    private $id;

    /**
     *  @var String The User's username.
     */
    private $username;

    /**
     *  @var String The User's password.
     */
    private $password;

    /**
     *  @var String The User's email.
     */
    private $email;

    /**
     *  @var String The User's user role.
     */
    private $user_role;

    /**
     *  @var Int Account status.
     */
    private $active;

    /**
     *  @var String Account activation token.
     */
    private $token;

    /**
     *  @var String Reset token.
     */
    private $resetToken;

    /**
     *  @var String The date the user account was created.
     */
    private $createdOn;

    /**
     *  @var Int The User's ID from the database.
     */
    private $user_id;

    /**
     *  @var String The User's full name.
     */
    private $full_name;

    /**
     *  @var String The User's website.
     */
    private $website;

    /**
     *  @var String The User's biography.
     */
    private $bio;

    /**
     *  @var String The date the data was modified.
     */
    private $modified_on;


    function __construct(
        int $id = NULL,
        string $username = NULL,
        string $password = NULL,
        string $email = NULL,
        string $user_role = NULL,
        int $active = NULL,
        string $token = NULL,
        string $resetToken = NULL,
        string $createdOn = NULL,
        int $user_id = NULL,
        string $full_name = NULL,
        string $website = NULL,
        string $bio = NULL,
        string $modified_on = NULL
        ) {  
        /*
         * Store the data if they are not empty.
         */
        if (!empty($id))
            $this->id = (int) $id;

        if (!empty($username))
            $this->username = clean_data($username);

        if (!empty($password))
            $this->password = clean_data($password);

        if (!empty($email))
            $this->email = clean_data($email);
        
        if (!empty($user_role))
            $this->user_role = clean_data($user_role);

        if (!empty($active))
           $this->active = clean_data($active);

        if (empty($token)) {
            // Generate random nums
            $rand_num = (string) Mt_rand(1000, 9999);

            $token = $rand_num;

            $this->token = (string) clean_data($token);
        } else
           $this->token = (string) clean_data($token);

        if (!empty($resetToken))
           $this->resetToken = clean_data($resetToken);

        if (!empty($createdOn))
            $this->createdOn = clean_data($createdOn);

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
        $this->id = clean_data($id);
    }

    /**
     * Set Username.
     * 
     * @param String The username.
     */
    public function set_username(string $username)
    {
        $this->username = clean_data($username);
    }

    /**
     * Set Email.
     * 
     * @param String The user's email.
     */
    public function set_email(string $email)
    {
        $this->email = clean_data($email);
    }

    /**
     * Set user role.
     * 
     * @param String The user's Role.
     */
    public function set_user_role(string $user_role)
    {
        $this->user_role = clean_data($user_role);
    }

    /**
     * Set Account Status.
     * 
     * @param Int The user's account status.
     */
    public function set_status(int $status)
    {
        $this->active = clean_data($status);
    }

    /**
     * Set Password.
     * 
     * @param Int The user's password.
     */
    public function set_password(string $password)
    {
        $this->password = clean_data($password);
    }
    /**
     *  Get the username from the database.
     *
     *  @param String The username to be verified.
     * 
     *  @return Bool false || true if the username already exist.
     */
    public static function exist(string $username) : bool
    {
        // Instantiate a DB object.
        $db = new Database();
        
		// Check connection
        if ($db->error)
            die("<span style='border-left: 5px solid #f00;'><strong>Error</strong>: Couldn't establish a connection." . $db->error . "</span>");

        // Prepare a Statement.
        $stmt = $db->prepare('SELECT username FROM me_users WHERE username = ? LIMIT 1');

        // Bind Parameter.
        $stmt->bind_param('s', $username);

        // Execute.
        $stmt->execute();

        // Store return values.
        $stmt->store_result();

        // Store the number of rows.
        $num_rows = $stmt->num_rows();

        // Close Statement.
        $stmt->close();

        // Close Connection.
        $db->close();

        return (bool) $num_rows;
    }

    /**
     *  Get the email from the database.
     *
     *  @return false || true if the email already exit.
     */
    public static function checkEmail(string $email) : bool
    {
        // Instantiate a DB object.
		$db = new Database();

        // Check connection
        if ($db->error)
            die("<span style='border-left: 5px solid #f00;'><strong>Error</strong>: Couldn't establish a connection." . $db->error . "</span>");

        // Prepare a Statement.
        $stmt = $db->prepare("SELECT email FROM me_users WHERE email = ? LIMIT 1");

        // Bind Parameter.
        $stmt->bind_param('s', $email);

        // Execute.
        $stmt->execute();

        // Store return values.
        $stmt->store_result();

        // Store the number of rows.
        $num_rows = $stmt->num_rows();

        // Close Statement.
        $stmt->close();

        // Close Connection.
        $db->close();

        return (bool) $num_rows;
    }

    /**
     *	Get the user's password from the database.
     *
     *	@return Array User's data.
     */
    public static function is_active(string $username): bool
    {
		// Instantiate a DB object.
		$db = new Database();

        // Sanitize data.
        $username = clean_data($username);

		// Prepare a statement.
        $sql = $db->prepare(
            'SELECT
                active
            FROM
                me_users
            WHERE
                username = ?'
        );

        // Bind Parameter.
        $sql->bind_param('s', $username);

        // Execute.
        $sql->execute();
        
        // Bind result value.
        $sql->bind_result($account_status);

        // Fetch data.
        $sql->fetch();

        // Close Statement.
        $sql->close();

        // Close Connections.
        $db->close();

        return (bool) $account_status;
    }

	/**
     * Verify the user.
     *
     * @param String The username.
     * @param String The user's password.
     * @return Array User's data.
     */
    public static function verify_pass(
        string $username,
        string $password
    )
    {
		// Instantiate a DB object.
		$db = new Database();

        // Sanitize data.
        $username = clean_data($username);

		// Prepare a statement.
        $sql = $db->prepare(
            'SELECT
                id,
                password,
                userRole,
                active
            FROM
                me_users 
            WHERE
                username = ?'
        );

        // Bind Parameter.
        $sql->bind_param('s', $username);

        // Execute.
        $sql->execute();

        // Bind result value.
        $sql->bind_result(
            $id,
            $db_password,
            $user_role,
            $status
        );

        // Retrieve rows.
        $sql->fetch();

        if (strtolower($user_role) === 'subscriber') {
            header('Location: '. WEB_ROOT);
            exit;

        } elseif (
            password_verify($password, $db_password)

        ) {
            return $id;
        }

        // Close Statement.
        $sql->close();

        // Close Connections.
        $db->close();

        return false;
    }

	/**
     *	Creates the User account.
     *	
     *	@return Bool true||false.
     */
    public function create_account() : bool 
    {
		// Instantiate a DB object.
		$db = new Database();

        // Prepare a Statement.
        $sql = $db->prepare(
            'INSERT INTO
                me_users(
                    username,
                    password,
                    email,
                    userRole,
                    token
                )
            VALUES(?, ?, ?, ?, ?)'
        );

        // Bind Parameters.
        $sql->bind_param(
            'ssssi',
            $this->username,
            $this->password,
            $this->email,
            $this->user_role,
            $this->token
        );

		// Execute query.
        if ($sql->execute())
            return true;

        // Close Statement.
        $sql->close();
        
        // Close Connection.
        $db->close();

        return false;
    }

    /**
     *  Updates the current User's object to the database.
     *  
     *  @return Bool true||false.
     */
    public function update(): bool
    {
        // Instantiate a DB object.
		$db = new Database();

        // Prepare a Statement.
        $sql = $db->prepare(
            'UPDATE
                me_users
            SET
                password = ?,
                email = ?,
                userRole = ?,
                active = ?
            WHERE
                id = ?'
        );

        // Bind parameters.
        $sql->bind_param(
            'sssii',
            $this->password,
            $this->email,
            $this->user_role,
            $this->active,
            $this->id
        );

        // Execute query.
        if ($sql->execute()) {
            return true;
        }

        // Close Statement.
        $sql->close();
        
        // Close Connection.
        $db->close();

        return false;
    }

    /**
     *	Gets a user's password by ID.
     *	
     *	@return String The user's password.
     */
    public function get_password(): string
    {
		// Instantiate a DB object.
		$db = new Database();

		// Prepare & Bind param
        $stmt = $db->prepare(
            'SELECT
                password
            FROM
                me_users
            WHERE
                id = ?'
        );

        // Bind parameters.
        $stmt->bind_param('i', $this->id);

		// Execute query & Check if it was successful.
        $stmt->execute();

        // Bind result value.
        $stmt->bind_result($password);

        // Fetch
        $stmt->fetch();
        
        // Set the password.
        $this->password = $password;
        
        // Close Statement.
        $stmt->close();

        // Close Connection.
        $db->close();

        return $password;
    }

	/**
     *	Fetch the current User object's token and status.
     *	
     *	@return Array || NULL if the user record wasn't found.
     */
    public function getToken()
    {
		// Instantiate a DB object.
		$db = new Database();

		// Prepare & Bind param
        $sql = "SELECT active, token FROM bank_users WHERE username = '$this->username'";

		// Execute query & Check if it was successful.
        $result = $db->query($sql);

        if ($result->num_rows == 1) {
            if ($row = $result->fetch_assoc()) {
				// Store user's data
                $userData = [
                    'status' => $row['active'],
                    'token' => $row['token']
                ];
                return $userData;
            }
        }
        
        // Close Statement.
        $sql->close();

        // Close Connection.
        $db->close();

        return false;
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
    public static function get_all(string $column = NULL, int $offset = NULL, int $num_rows = NULL)
    {
        // Instantiate a DB object.
        $db = new Database();
        
        // Initialize an array.
        $data = [];

        // Sanitize data.
        if (isset($column))
            $column = clean_data($column);

        if (isset($order))
            $order = (string) clean_data($order);
        else
            $order = 'username';

        if (isset($offset))
            $offset = (int) clean_data($offset);
        else
            $offset = 0;

        if (isset($num_rows))
            $num_rows = (int) clean_data($num_rows);
        else
            $num_rows = 2000000;

        if (strtolower($column) === 'all') {
            $sql = $db->prepare(
                'SELECT
                    `me_users`.`id`,
                    `me_users`.`username`,
                    `me_users`.`email`,
                    `me_users_info`.`full_name`,
                    `me_users_info`.`website`,
                    `me_users`.`userRole`, 
                    `me_users`.`active`, 
                    `me_users`.`createdOn` 
                FROM
                    me_users_info
                right JOIN 
                    me_users
                ON
                    `me_users_info`.`user_id` = `me_users`.`id`
                ORDER BY
                    ? ASC
                LIMIT 
                    ?, ?'
            );

            // Bind parameters.
            $sql->bind_param(
                'sii',
                $order,
                $offset,
                $num_rows
            );
        } else {
            $sql = $db->prepare(
                'SELECT
                    `me_users`.`id`,
                    `me_users`.`username`,
                    `me_users`.`email`,
                    `me_users_info`.`full_name`,
                    `me_users_info`.`website`,
                    `me_users`.`userRole`,
                    `me_users`.`active`,
                    `me_users`.`createdOn`
                FROM
                    me_users_info
                right JOIN
                    me_users
                ON
                    `me_users_info`.`user_id` = `me_users`.`id`
                WHERE
                    userRole = ?
                ORDER BY
                    ? ASC
                LIMIT
                    ?, ?'
            );

            // Bind parameters.
            $sql->bind_param(
                'ssii',
                $column,
                $order,
                $offset,
                $num_rows
            );
        }

        // Execute.
        if ($sql->execute()) {

            // Bind result.
            $sql->bind_result(
                $id,
                $username,
                $email,
                $full_name,
                $website,
                $user_role,
                $active,
                $created_on
            );

            // Fetch and loop thought the data.
            while ($sql->fetch()) {
                // Instantiate an object.
                $user = new User;

                // Set data
                $user->id = $id;
                $user->username = $username;
                $user->email = $email;
                $user->full_name = $full_name;
                $user->website = $website;
                $user->user_role = $user_role;
                $user->active = $active;
                $user->created_on = $created_on;

                // Get the user data.
                $user_data = $user->get_profile();

                // Create an array of arrays
                array_push($data, $user_data);
            }

        }
        
        // Close Statement.
        $sql->close();
        
        // Close Connection.
        $db->close();

        return $data;
    }

    /**
     * Get the list of User objects in the database.
     * 
     * @return an array of arrays of the users data.
     */
    public function get_profile(): object
    {
        // Instantiate an Object.
        $user = new stdClass;

        // Set data.
        $user->id = $this->id;
        $user->username = $this->username;
        $user->email = $this->email;
        $user->full_name =$this->full_name;
        $user->website =$this->website;
        $user->user_role =$this->user_role;
        $user->active = $this->active;
        $user->created_on = (!empty($this->created_on)) ? $this->created_on : '';

        return $user;
    }

	/**
     * Gets a user by ID.
     * 
     * @param Int The user's ID.
     */
    public function get(int $id)
    {
        // Raise an exception is the user id wasn' 
        if (empty($id))
            trigger_error("<strong>User::get()</strong>: Attempt to fetch a User object that doesn't have it's ID property set.", E_USER_ERROR);

		// Instantiate a DB object.
		$db = new Database();

        // Prepare a Statement.
        $sql = $db->prepare(
            'SELECT
                `me_users`.`id`,
                `me_users`.`username`,
                `me_users`.`password`,
                `me_users`.`email`,
                `me_users`.`userRole`,
                `me_users`.`active`,
                `me_users_info`.`full_name`,
                `me_users_info`.`website`,
                `me_users_info`.`profile_pic`,
                `me_users_info`.`bio`
            FROM
                me_users_info
            right JOIN
                me_users
            ON
                `me_users_info`.`user_id` = `me_users`.`id`
            WHERE
                `me_users`.`id` = ?'
        );

        // Bind Parameters.
        $sql->bind_param('i', $id);

        // Execute.
        $sql->execute();

        // Bind result values.
        $sql->bind_result(
            $id,
            $username,
            $password,
            $email,
            $user_role,
            $active,
            $full_name,
            $website,
            $profile_pic,
            $bio
        );

        $user = new stdClass;

        // Get data.
        if ($sql->fetch()) {
            // Split Full Name.
            $full_name = explode(' ', $full_name);
            $first_name = (!empty($full_name[0])) ?  $full_name[0] : null;
            $last_name = (!empty($full_name[1])) ?  $full_name[1] : null;

            // Set data.
            $user->id = $id;
            $user->username = $username;
            $user->password = $password;
            $user->email = $email;
            $user->user_role = $user_role;
            $user->active = $active;
            $user->first_name = $first_name;
            $user->last_name = $last_name;
            $user->website = $website;
            $user->profile_pic = $profile_pic;
            $user->bio = $bio;
        }
        
        // Close Statement.
        $sql->close();
        
        // Close Connection.
        $db->close();
        
        return $user;
    }

    /**
     *  Get the total number of rows a.
     *  
     *  @return int The number of a specific column || 0.
     */
    public static function count_rows(string $column = NULL): int
    {
        // Instantiate a DB object.
		$db = new Database();

        // Store column name.
        $column = (string) clean_data($column);

        if (empty($column)) {
            // Prepare a Statement.
            $sql = $db->prepare('SELECT COUNT(*) as total_rows FROM me_users');
        } else {
            // Prepare a Statement.
            $sql = $db->prepare('SELECT COUNT(*) as totalRows FROM me_users WHERE userRole = ?');

            // Bind parameter.
            $sql->bind_param('s', $column);
        }

        // Execute Query.
        if ($sql->execute()) {
            // Bind the result to a variable.
            $sql->bind_result($total);

            if ($sql->fetch()) {
                return $total;
            };
        }

        return 0;

        // Close Statement.
        $sql->close();

        // Close Connection.
        $db->close();
    }

     /**
     *  The method that changes user's status (active).
     *  
     *  @param  int The ID of the user object we want to activate || deactivate.
     *  @param int The status.
     *  
     *  @return bool false || true if the account status was updated successfully.
     */
    public static function change_acc_status(int $id, int $status): int
    {
        // Instantiate a DB object.
		$db = new Database();

        // Sanitize data.
        $id = (int) clean_data($id);
        $status = (int) clean_data($status);

        // Prepare a Statement.
        $sql = $db->prepare('UPDATE me_users SET active = ? WHERE id = ?');

        // Bind parameter.
        $sql->bind_param('ii', $status, $id);

        // Execute Query.
        if ($sql->execute())
            if (empty($status))
                return 0;

        // Close Statement.
        $sql->close();

        // Close Connection.
        $db->close();

        return 1;
    }

    public static function search(string $keyword)
    {
        // Instantiate a DB object.
		$db = new Database();

        $keyword = clean_data('%'. $keyword .'%');

        // Prepare a statement.
        $sql = $db->prepare(
            'SELECT
                `me_users`.`id`,
                `me_users`.`username`,
                `me_users`.`email`,
                `me_users`.`userRole`,
                `me_users`.`active`,
                `me_users_info`.`full_name`,
                `me_users_info`.`website`,
                `me_users_info`.`bio`
            FROM
                me_users_info
            right JOIN
                me_users
            ON
                `me_users_info`.`user_id` = `me_users`.`id`
            WHERE
                `me_users`.`username`
            LIKE
                ?'
        );

        // Bind parameter.
        $sql->bind_param('s', $keyword);

        // Execute.
        $sql->execute();

        // Bind result.
        $sql->bind_result(
            $id,
            $username,
            $email,
            $user_role,
            $active,
            $full_name,
            $website,
            $bio
        );

        // Initialize an array.
        $data = [];

        // Fetch and loop thought the data.
        while ($sql->fetch()) {
            // Instantiate an object.
            $user = new User;
            $user->id = $id;
            $user->username = $username;
            $user->email = $email;
            $user->user_role = $user_role;
            $user->active = $active;
            $user->full_name = $full_name;
            $user->website = $website;

            // Get the user data.
            $user_data = $user->get_profile();

            // Create an array of arrays
            array_push($data, $user_data);
        }

        // Close Statement.
        $sql->close();
        
        // close connection.
        $db->close();
        
        return $data;
    }

    /**
     * The method that deletes a user account.
     * 
     * @param int The user's ID.
     * 
     * @return bool false || true if the user account was deleted successfully.
     */
    public static function delete(int $id): bool
    {
        // Instantiate a DB object.
		$db = new Database();

        if (empty($id))
            trigger_error("<strong>User::delete()</strong>: Attempt to delete a User object that doesn't have it's ID property set.", E_USER_ERROR);

        // Sanitize data.
        $id = clean_data($id);

        // Prepare a Statement.
        $sql = $db->prepare('DELETE FROM me_users WHERE id = ? LIMIT 1');

        // Bind Parameter.
        $sql->bind_param('i', $id);

        // Execute.
        if ($sql->execute())
            return true;
        
        else
            die($sql->error);

        // Close statement.
        $sql->close();

        // Close connection.
        $db->close();

        return false;
    }
} // End of file.