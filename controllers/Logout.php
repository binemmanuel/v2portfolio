<?php
namespace controller;

use portfolio\LoginToken;

use function portfolio\clean_data;

class Logout
{   
    /**
     * Destroys cookie.
     * 
     * @return Void Nothing.
     */
    public function logout()
    {
        // Instantiate a Login Token Object.
        $login_token = new LoginToken;

        // Check if login token is set.
        $token = (!empty($_COOKIE['login-token'])) ? clean_data($_COOKIE['login-token']) : '';
        
        // Set token.
        $login_token->set_token($token);

        // Get the user's ID.
        $user_id = $login_token->get_user_id();

        // Set user ID.
        $login_token->set_user($user_id);

        // Delete login token.
        if ($login_token->delete()) {
            header('Location: '. WEB_ROOT .'login/');
            exit;
        }
    }
	
}
