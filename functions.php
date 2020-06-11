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