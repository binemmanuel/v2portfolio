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

        // Instantiate a User Object.
        $this->user = new PortfolioUser;

        // Instantiate an std Object.
        $this->response = new stdClass;

        // Instantiate an std Object.
        $counts = new stdClass;

        // Count all user.
        $counts->all = $this->user->count_rows();
        $counts->administrators = $this->user->count_rows('administrator');
        $counts->moderators = $this->user->count_rows('moderator');
        $counts->subscribers = $this->user->count_rows('subscriber');

        $this->response->counts = $counts;
    }

    public function get(int $id = null)
    {
        if (!empty($id)) {
            $this->response->users = $this->user->get($id);
        } else {
            $this->response->users = $this->user->get_all('all');
        }

        return $this->response;
    }

    public function get_admins()
    {
        $this->response->users = $this->user->get_all('administrator');

        return $this->response;
    }

    public function get_moderators()
    {
        
        $this->response->users = $this->user->get_all('moderator');

        return $this->response;
    }

    public function get_subscribers()
    {
        
        $this->response->users = $this->user->get_all('subscriber');

        return $this->response;
    }

    public function search(array $data)
    {        
        $keyword = (!empty($data['keyword'])) ? clean_data($data['keyword']) : '';
        
        $this->response->users = $this->user->search($keyword);

        return $this->response;
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
                $user_info = new UserInfo();

            // Set data.
            $this->user->set_id((int) clean_data($data['id']));
            $this->user->set_email((string) clean_data($data['email']));
            $this->user->set_status((int) clean_data($data['status']));
            $this->user->set_user_role((string) clean_data($data['user_role']));

            if (empty($data['password'])) {
                $this->user->set_password((string) $this->user->get_password());
            } else {
                $data['password'] = password_hash(trim($data['password']), PASSWORD_DEFAULT);
                $this->user->set_password($data['password']);
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
                if ($user_info->update() && $this->user->update()) {
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
                if ($user_info->save() && $this->user->update()) {
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
