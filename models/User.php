<?php
namespace model;

use portfolio\BaseModel;
use portfolio\User as PortfolioUser;
use portfolio\UserInfo;
use stdClass;

use function portfolio\clean_data;
use function portfolio\validate_acc_status;
use function portfolio\validate_role;

class User extends BaseModel
{
    function __construct()
    {
        parent::__construct();
    }

    public function get(int $id = null)
    {
        $user = new PortfolioUser;
        
        if (!empty($id)) {
            $response = $user->get($id);
        } else {
            $response = $user->get_all('all');
        }

        return $response;
    }

    public function update(array $data): object
    {
        $response = new stdClass;
    
        // validate email
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $response->error = true;
            $response->message = 'Invalid email address.';
            $response->type = 'email';
            $response->filled_data = [
                'id' => $data['id'],
                'first_name' => $data['first-name'],
                'last_name' => $data['last-name'], 
                'email' => $data['email'],
                'website' => $data['website'],
                'status' => $data['status'],
                'bio' => $data['bio']
            ];
        } elseif (
            !empty($data['website']) &&
            !filter_var($data['website'], FILTER_VALIDATE_URL)
        ) {
            $response->error = true;
            $response->message = 'Invalid web address.';
            $response->type = 'website';
            $response->filled_data = [
                'id' => $data['id'],
                'first_name' => $data['first-name'],
                'last_name' => $data['last-name'], 
                'email' => $data['email'],
                'website' => $data['website'],
                'status' => $data['status'],
                'bio' => $data['bio']
            ];
        } elseif (
            !empty($data['user_role']) &&
            !validate_role($data['user_role'])
        ) {
            $response->error = true;
            $response->message = 'Invalid user role.';
            $response->type = 'user-role';
            $response->filled_data = [
                'id' => $data['id'],
                'first_name' => $data['first-name'],
                'last_name' => $data['last-name'], 
                'email' => $data['email'],
                'website' => $data['website'],
                'status' => $data['status'],
                'bio' => $data['bio']
            ];
        } elseif (
            !is_numeric($data['status']) ||
            !validate_acc_status($data['status'])
        ) {
            $response->error = true;
            $response->message = 'Invalid account status.';
            $response->type = 'user-role';
            $response->filled_data = [
                'id' => $data['id'],
                'first_name' => $data['first-name'],
                'last_name' => $data['last-name'], 
                'email' => $data['email'],
                'website' => $data['website'],
                'status' => $data['status'],
                'bio' => $data['bio']
            ];
        } else {
            // Instantiate a user object.
            $user = new PortfolioUser;
            $user_info = new UserInfo();

            // Set data.
            $user->set_id((int) clean_data($data['id']));
            $user->set_email((string) clean_data($data['email']));
            $user->set_status((int) clean_data($data['status']));
            $user->set_user_role((string) clean_data($data['user_role']));

            if (empty($data['password'])) {
                $user->set_password((string) $user->get_password());
            } else {
                $data['password'] = password_hash(trim($data['password']), PASSWORD_DEFAULT);
                $user->set_password($data['password']);
            }

             // Check if first and last name is set.
            $data['first-name'] = (!empty($data['first-name'])) ? clean_data($data['first-name']) : '';
            $data['last-name'] = (!empty($data['last-name'])) ? clean_data($data['last-name']) : '';

            // Set full name.
            $data['full-name'] = $data['first-name'] .' '. $data['last-name'];

            $user_info->set_id((int) clean_data($data['id']));
            $user_info->set_full_name((string) clean_data($data['full-name']));
            $user_info->set_website((string) clean_data($data['website']));
            $user_info->set_bio((string) clean_data($data['bio']));

            if ($user_info->has_data()) {
                if ($user_info->update() && $user->update()) {
                    $response->error = false;
                    $response->message = 'Updated Successfully.';
                    $response->type = '';
                    $response->filled_data = [
                        'id' => $data['id'],
                        'first_name' => $data['first-name'],
                        'last_name' => $data['last-name'], 
                        'email' => $data['email'],
                        'website' => $data['website'],
                        'status' => $data['status'],
                        'user_role' => $data['user_role'],
                        'bio' => $data['bio']
                    ];
                };
            } else {
                if ($user_info->save() && $user->update()) {
                    $response->error = false;
                    $response->message = 'Updated Successfully.';
                    $response->type = '';
                    $response->filled_data = [
                        'id' => $data['id'],
                        'first_name' => $data['first-name'],
                        'last_name' => $data['last-name'], 
                        'email' => $data['email'],
                        'website' => $data['website'],
                        'status' => $data['status'],
                        'user_role' => $data['user_role'],
                        'bio' => $data['bio']
                    ];
                };
            }
        }

        return $response;
    }
}
