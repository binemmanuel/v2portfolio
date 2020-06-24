<?php
namespace portfolio;

function clean_data($data)
{
    return htmlspecialchars(trim($data));
}

function is_home_page($view)
{
    return ($view === 'index') ? true : false;
}

/**
 * Validate user role.
 * 
 * @return Bool true || false if the user role is not valid.
 */
function validate_role(string $role)
{
    // Convert to lowercase.
    $role = strtolower($role);

    // Create an array of roles.
    $valid_roles = [
        'administrator',
        'subscriber'
    ];

    if (in_array($role, $valid_roles)) {
        return true;
    }
    
    return false;
}

/**
 * Validate user role.
 * 
 * @return Array All valid user roles.
 */
function valid_roles(): array
{
    // Create an array of roles.
    return $valid_roles = [
        'administrator',
        'subscriber'
    ];
}

function get_ip(): string
{
    // Check if IP is from shared internet.
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = clean_data($_SERVER['HTTP_CLIENT_IP']);

    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = clean_data($_SERVER['HTTP_X_FORWARDED_FOR']);

    } else {
        $ip = clean_data($_SERVER['REMOTE_ADDR']);
        
    } 

    return $ip;
}

function is_logged_in()
{
    // Check if cookie is set.
    if (!empty($_COOKIE['login-token'])) {
        return true;
    }

    return false;
}

/**
 * Validate user role.
 * 
 * @return Bool true || false if the user role is not valid.
 */
function validate_acc_status(string $status)
{
    // Convert to lowercase.
    $status = strtolower($status);

    // Create an array of roles.
    $valid_status = [
        0,
        1
    ];

    if (in_array($status, $valid_status)) {
        return true;
    }
    
    return false;
}

/**
 * Validate user role.
 * 
 * @return Bool true || false if the user role is not valid.
 */
function validate_reg_option(string $option)
{
    // Convert to lowercase.
    $option = strtolower($option);

    // Create an array of roles.
    $valid_reg_option = [
        'yes',
        'no'
    ];

    if (in_array($option, $valid_reg_option)) {
        return true;
    }
    
    return false;
}