<?php
namespace portfolio;

class LoginToken
{
    /**
     * @var String The login token.
     */
    private $token;

    /**
     * @var Int The user's ID.
     */
    private $user;

    /**
     * @var String The user's IP.
     */
    private $ip;

    function __construct(
        string $token = null,
        int $user = null,
        string $ip = null
    )
    {
        if (!empty($token)) {
            $this->set_token($token);
        }

        if (!empty($user)) {
           $this->set_user($user);
        }

        if (!empty($ip)) {
            $this->set_ip($ip);
         }

        // Database connection.
        $this->db = new Database;
    }

    public function get_token(): string
    {
        return $this->token;
    }

    public function set_token(string $token)
    {
        $this->token = (string) $token;
    }

    public function set_user(int $user)
    {
        $this->user = (int) $user;
    }

    public function set_ip(string $ip)
    {
        $this->ip = (string) $ip;
    }

    public function save(): bool
    {
        // Prepare an SQL statement.
        $stmt = $this->db->prepare(
            'INSERT INTO
                me_login_token(
                    token,
                    user,
                    ip
                )
            VALUES(?, ?, ?)'
        );

        // Bind parameters.
        $stmt->bind_param(
            'sis',
            $this->token,
            $this->user,
            $this->ip
        );

        // Execute the query.
        if ($stmt->execute()) {
            return true;
        }

        // Close connection and statement.
        $stmt->close();
        $this->db->close();

        return false;
    }

    /**
     *	Gets a user's ID by login token.
     *	
     *	@return Int The user's ID.
     */
    public function get_user_id(): int
    {
		// Instantiate a DB object.
		$db = new Database();

		// Prepare & Bind param
        $stmt = $db->prepare(
            'SELECT
                user
            FROM
                me_login_token
            WHERE
                token = ?'
        );

        // Bind parameters.
        $stmt->bind_param('s', $this->token);

		// Execute query & Check if it was successful.
        $stmt->execute();

        // Bind result value.
        $stmt->bind_result($user);

        // Fetch
        $stmt->fetch();
        
        // Close Statement.
        $stmt->close();

        // Close Connection.
        $db->close();

        return (int) $user;
    }

    /**
     * Delete login token
     */
    public function delete(): bool
    {
        echo $this->user;
        
        // Prepare an SQL statement.
        $stmt = $this->db->prepare(
            'DELETE FROM
                me_login_token
            WHERE
                user = ?'
        );

        // Bind parameters.
        $stmt->bind_param(
            'i',
            $this->user
        );

        // Execute the query.
        if ($stmt->execute()) {
            return true;
        }

        // Close connection and statement.
        $stmt->close();
        $this->db->close();

        return false;
    }

    /**
     * Checks if login token is a valid one.
     * 
     * @param String The login token.
     * @return Bool False or True if the login token is valid.
     */
    public function is_valid(string $token): bool
    {
        // Prepare an SQL statement.
        $stmt = $this->db->prepare(
            'SELECT
                ip
            FROM
                me_login_token
            WHERE
                token = ?
            '
        );

        // Bind parameters.
        $stmt->bind_param(
            's', $token
        );

        // Execute the query.
        $stmt->execute();

        // Bind result value.
        $stmt->bind_result($ip);

        // Fetch data.
        $stmt->fetch();
    
        if ($ip === get_ip()) {
            return true;
        }

        // Close connection and statement.
        $stmt->close();
        $this->db->close();

        return false;
    }
}
