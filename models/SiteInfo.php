<?php
namespace model;

use portfolio\BaseModel;
use portfolio\SiteInfo as PortfolioSiteInfo;
use stdClass;

use function portfolio\clean_data;
use function portfolio\validate_reg_option;
use function portfolio\validate_role;

class SiteInfo extends BaseModel
{
    function __construct()
    {
        parent::__construct();
    }

    public function get(int $id = null)
    {
        $info = new PortfolioSiteInfo;
        
        $response = $info->fetch();

        return $response;
    }

    public function update(array $data): object
    {
        $response = new stdClass;
        $response->filled_data = new stdClass;

        if (empty($data['title'])) {
            // store an error message.
            $response->error = true;
            $response->message = 'You need to enter a title.';
            $response->type = 'title';
            $response->filled_data ->title = $data['title'];
            $response->filled_data ->tagline = $data['tagline'];
            $response->filled_data ->site_address = $data['site_address'];
            $response->filled_data ->email = $data['email'];
            $response->filled_data ->default_user_role = $data['default_user_role'];
            $response->filled_data ->allow_new_reg = $data['allow_new_reg'];

        } elseif (empty($data['tagline'])) {
            // store an error message.
            $response->error = true;
            $response->message = 'Enter at least a short note about this website.';
            $response->type = 'tagline';
            $response->filled_data ->title = $data['title'];
            $response->filled_data ->tagline = $data['tagline'];
            $response->filled_data ->site_address = $data['site_address'];
            $response->filled_data ->email = $data['email'];
            $response->filled_data ->default_user_role = $data['default_user_role'];
            $response->filled_data ->allow_new_reg = $data['allow_new_reg'];

        } elseif (empty($data['site_address'])) {
            // store an error message.
            $response->error = true;
            $response->message = 'The web address to your website is required.';
            $response->type = 'site_address';
            $response->filled_data ->title = $data['title'];
            $response->filled_data ->tagline = $data['tagline'];
            $response->filled_data ->site_address = $data['site_address'];
            $response->filled_data ->email = $data['email'];
            $response->filled_data ->default_user_role = $data['default_user_role'];
            $response->filled_data ->allow_new_reg = $data['allow_new_reg'];

        } elseif (!filter_var($data['site_address'], FILTER_VALIDATE_URL)) {
            // store an error message.
            $response->error = true;
            $response->message = 'Invaid web address.';
            $response->type = 'site_address';
            $response->filled_data ->title = $data['title'];
            $response->filled_data ->tagline = $data['tagline'];
            $response->filled_data ->site_address = $data['site_address'];
            $response->filled_data ->email = $data['email'];
            $response->filled_data ->default_user_role = $data['default_user_role'];
            $response->filled_data ->allow_new_reg = $data['allow_new_reg'];

        } elseif (empty($data['email'])) {
            // store an error message.
            $response->error = true;
            $response->message = 'Please enter your email address.';
            $response->type = 'email';
            $response->filled_data ->title = $data['title'];
            $response->filled_data ->tagline = $data['tagline'];
            $response->filled_data ->site_address = $data['site_address'];
            $response->filled_data ->email = $data['email'];
            $response->filled_data ->default_user_role = $data['default_user_role'];
            $response->filled_data ->allow_new_reg = $data['allow_new_reg'];

        } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            // store an error message.
            $response->error = true;
            $response->message = 'Invalid email address.';
            $response->type = 'email';
            $response->filled_data ->title = $data['title'];
            $response->filled_data ->tagline = $data['tagline'];
            $response->filled_data ->site_address = $data['site_address'];
            $response->filled_data ->email = $data['email'];
            $response->filled_data ->default_user_role = $data['default_user_role'];
            $response->filled_data ->allow_new_reg = $data['allow_new_reg'];

        } elseif (
            !empty($data['default_user_role']) &&
            !validate_role($data['default_user_role'])
        ) {
            // store an error message.
            $response->error = true;
            $response->message = 'Invalid user role.';
            $response->type = 'default_user_role';
            $response->filled_data ->title = $data['title'];
            $response->filled_data ->tagline = $data['tagline'];
            $response->filled_data ->site_address = $data['site_address'];
            $response->filled_data ->email = $data['email'];
            $response->filled_data ->default_user_role = $data['default_user_role'];
            $response->filled_data ->allow_new_reg = $data['allow_new_reg'];

        }  elseif (
            !empty($data['allow_new_reg']) &&
            !validate_reg_option($data['allow_new_reg'])
        ) {
            // store an error message.
            $response->error = true;
            $response->message = clean_data($data['allow_new_reg']) .' is not a valid option for Allow New Registrations';
            $response->type = 'allow_new_reg';
            $response->filled_data ->title = $data['title'];
            $response->filled_data ->tagline = $data['tagline'];
            $response->filled_data ->site_address = $data['site_address'];
            $response->filled_data ->email = $data['email'];
            $response->filled_data ->default_user_role = $data['default_user_role'];
            $response->filled_data ->allow_new_reg = $data['allow_new_reg'];

        } else {
            // Instantiate a Site Info object.
            $info = new PortfolioSiteInfo;

            // Set data.
            $info->id = (int) 1;
            $info->title = (string) clean_data($data['title']);
            $info->tagline = (string) clean_data($data['tagline']);
            $info->site_address = (string) clean_data($data['site_address']);
            $info->email = (string) clean_data($data['email']);
            $info->default_user_role = (string) clean_data($data['default_user_role']);
            $info->allow_new_reg = (string) clean_data($data['allow_new_reg']);

            // Make the update.
            if ($info->update()) {
                // store an success message.
                $response->error = false;
                $response->message = 'Updated Successfully.';
                $response->type = null;
                $response->filled_data ->title = $data['title'];
                $response->filled_data ->tagline = $data['tagline'];
                $response->filled_data ->site_address = $data['site_address'];
                $response->filled_data ->email = $data['email'];
                $response->filled_data ->default_user_role = $data['default_user_role'];
                $response->filled_data ->allow_new_reg = $data['allow_new_reg'];
            }
        
        }

        return $response;
    }
}
