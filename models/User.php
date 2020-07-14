<?php

namespace model;

use portfolio\BaseModel;
use portfolio\LoginToken;
use portfolio\User as PortfolioUser;
use portfolio\UserInfo;
use stdClass;

use function portfolio\clean_data;
use function portfolio\get_ip;
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

    /**
     * Process user signup form data.
     * 
     * @param Array The user's data.
     * @return Object A response.
     */
    public function login(array $data): object
    {
        if (empty($data['username'])) {
            $this->response->error = true;
            $this->response->message = 'Please enter your username.';
            $this->response->type = 'username';

            $this->response->filled_data = new stdClass;

            $this->response->filled_data->username = clean_data($data['username']);
        } elseif (empty($data['password'])) {
            $this->response->error = true;
            $this->response->message = 'Please enter a password.';
            $this->response->type = 'password';

            $this->response->filled_data = new stdClass;

            $this->response->filled_data->username = clean_data($data['username']);
        } elseif (empty($this->user::exist(clean_data($data['username'])))) {
            $this->response->error = true;
            $this->response->message = 'Incorrect username or password.';
            $this->response->type = 'username and password';

            $this->response->filled_data = new stdClass;

            $this->response->filled_data->username = clean_data($data['username']);
        } elseif (!$this->user::is_active(clean_data($data['username']))) {
            $this->response->error = true;
            $this->response->message = 'Sorry! Your account is inactive,';
            $this->response->message .= ' please contect an <a class="alert-link" href="mailto:textme@binemmanuel.com">admin</a> to activate your account.';
            $this->response->type = 'account status';

            $this->response->filled_data = new stdClass;

            $this->response->filled_data->username = clean_data($data['username']);
        } else {
            $user_id = $this->user::verify_pass(
                clean_data($data['username']),
                clean_data($data['password'])
            );

            if (!$user_id) {
                $this->response->error = true;
                $this->response->message = 'Incorrect username or password.';
                $this->response->type = 'username and password';

                $this->response->filled_data = new stdClass;

                $this->response->filled_data->username = clean_data($data['username']);
            } else {
                // Generate Login token.
                $login_token = new LoginToken(
                    bin2hex(random_bytes(10)),
                    $user_id,
                    get_ip()
                );

                // Delete prev login token.
                $login_token->delete($user_id);

                // Save token.
                if ($login_token->save()) {
                    \setcookie(
                        'login-token',
                        $login_token->get_token(),
                        time() + 1640,
                        '/'
                    );

                    $this->response->error = false;
                    $this->response->message = 'Logedin Successfully.';
                    $this->response->type = '';

                    header('Location: ' . WEB_ROOT . 'admin/');
                    exit;
                }
            }
        }

        return $this->response;
    }

    /**
     * Process user signup form data.
     * 
     * @param Array The user's data.
     * @return Object A response.
     */
    public function signup(array $data): object
    {
        if (empty($data['username'])) {
            $this->response->error = true;
            $this->response->message = 'Please enter your username.';
            $this->response->type = 'username';

            $this->response->filled_data = new stdClass;

            $this->response->filled_data->username = $data['username'];
            $this->response->filled_data->email = $data['email'];
            $this->response->filled_data->user_role = $data['user-role'];
        } elseif ($this->user->exist(clean_data($data['username']))) {
            $this->response->error = true;
            $this->response->message = 'The user name you entered already exists.';
            $this->response->type = 'username';

            $this->response->filled_data = new stdClass;

            $this->response->filled_data->username = $data['username'];
            $this->response->filled_data->email = $data['email'];
            $this->response->filled_data->user_role = $data['user-role'];
        } elseif (empty($data['email'])) {
            $this->response->error = true;
            $this->response->message = 'Please enter your email address.';
            $this->response->type = 'email';

            $this->response->filled_data = new stdClass;

            $this->response->filled_data->username = $data['username'];
            $this->response->filled_data->email = $data['email'];
            $this->response->filled_data->user_role = $data['user-role'];
        } elseif ($this->user::emailExist(clean_data($data['email']))) {
            $this->response->error = true;
            $this->response->message = 'The email address has already been registered by another user.';
            $this->response->type = 'email';

            $this->response->filled_data = new stdClass;

            $this->response->filled_data->username = $data['username'];
            $this->response->filled_data->email = $data['email'];
            $this->response->filled_data->user_role = $data['user-role'];
        } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $this->response->error = true;
            $this->response->message = 'Please enter a valid email address.';
            $this->response->type = 'email';

            $this->response->filled_data = new stdClass;

            $this->response->filled_data->username = $data['username'];
            $this->response->filled_data->email = $data['email'];
            $this->response->filled_data->user_role = $data['user-role'];
        } elseif (empty($data['password'])) {
            $this->response->error = true;
            $this->response->message = 'Please enter a password.';
            $this->response->type = 'password';

            $this->response->filled_data = new stdClass;

            $this->response->filled_data->username = $data['username'];
            $this->response->filled_data->email = $data['email'];
            $this->response->filled_data->user_role = $data['user-role'];
        } elseif (strlen($data['password']) < 6) {
            $this->response->error = true;
            $this->response->message = 'Password too short.';
            $this->response->message .= ' Enter at least 6 or more characters.';
            $this->response->type = 'password';

            $this->response->filled_data = new stdClass;

            $this->response->filled_data->username = $data['username'];
            $this->response->filled_data->email = $data['email'];
            $this->response->filled_data->user_role = $data['user-role'];
        } elseif (empty($data['confirm-password'])) {
            $this->response->error = true;
            $this->response->message = 'Please conform your password.';
            $this->response->type = 'confirm-password';

            $this->response->filled_data = new stdClass;

            $this->response->filled_data->username = $data['username'];
            $this->response->filled_data->email = $data['email'];
            $this->response->filled_data->user_role = $data['user-role'];
        } elseif ($data['confirm-password'] !== $data['password']) {
            $this->response->error = true;
            $this->response->message = 'Sorry! The retyped password doesn\'t match';
            $this->response->message .= ' your password';
            $this->response->type = 'confirm-password';

            $this->response->filled_data = new stdClass;

            $this->response->filled_data->username = $data['username'];
            $this->response->filled_data->email = $data['email'];
            $this->response->filled_data->user_role = $data['user-role'];
        } else {
            $user = $this->user;

            // Set data.
            $user->set_username(clean_data($data['username']));
            $user->set_email(clean_data($data['email']));
            $user->set_user_role(clean_data($data['user-role']));
            $user->set_password(\password_hash($data['password'], PASSWORD_DEFAULT));

            if ($user->create_account()) {
                $this->response->error = false;
                $this->response->message = 'Signup Successfully.';
                $this->response->type = '';
            }
        }

        return $this->response;
    }

    public function update(array $data): object
    {
        // validate email
        if (empty($data['username'])) {
            $this->response->error = true;
            $this->response->message = 'Username can not be empty.';
            $this->response->type = 'username';
            $this->response->filled_data = [
                'id' => $data['id'],
                'first_name' => $data['first-name'],
                'last_name' => $data['last-name'],
                'email' => (empty($data['new-email'])) ? $data['old-email'] : $data['new-email'],
                'website' => $data['website'],
                'status' => $data['status'],
                'bio' => $data['bio']
            ];
        } elseif (
            empty($data['new-email']) ||
            empty($data['old-email'])
        ) {
            $this->response->error = true;
            $this->response->message = 'Email can not be empty.';
            $this->response->type = 'email';
            $this->response->filled_data = [
                'id' => $data['id'],
                'first_name' => $data['first-name'],
                'last_name' => $data['last-name'],
                'email' => (empty($data['new-email'])) ? $data['old-email'] : $data['new-email'],
                'website' => $data['website'],
                'status' => $data['status'],
                'bio' => $data['bio']
            ];
        } elseif (
            !filter_var($data['old-email'], FILTER_VALIDATE_EMAIL) ||
            !filter_var($data['new-email'], FILTER_VALIDATE_EMAIL)
        ) {
            $this->response->error = true;
            $this->response->message = 'Invalid email address.';
            $this->response->type = 'email';
            $this->response->filled_data = [
                'id' => $data['id'],
                'first_name' => $data['first-name'],
                'last_name' => $data['last-name'],
                'email' => (empty($data['new-email'])) ? $data['old-email'] : $data['new-email'],
                'website' => $data['website'],
                'status' => $data['status'],
                'bio' => $data['bio']
            ];
        } elseif (
            !empty($data['website']) &&
            !filter_var($data['website'], FILTER_VALIDATE_URL)
        ) {
            $this->response->error = true;
            $this->response->message = 'Invalid web address.';
            $this->response->type = 'website';
            $this->response->filled_data = [
                'id' => $data['id'],
                'first_name' => $data['first-name'],
                'last_name' => $data['last-name'],
                'email' => (empty($data['new-email'])) ? $data['old-email'] : $data['new-email'],
                'website' => $data['website'],
                'status' => $data['status'],
                'bio' => $data['bio']
            ];
        } elseif (
            !empty($data['user_role']) &&
            !validate_role($data['user_role'])
        ) {
            $this->response->error = true;
            $this->response->message = 'Invalid user role.';
            $this->response->type = 'user-role';
            $this->response->filled_data = [
                'id' => $data['id'],
                'first_name' => $data['first-name'],
                'last_name' => $data['last-name'],
                'email' => (empty($data['new-email'])) ? $data['old-email'] : $data['new-email'],
                'website' => $data['website'],
                'status' => $data['status'],
                'bio' => $data['bio']
            ];
        } elseif (
            !is_numeric($data['status']) ||
            !validate_acc_status($data['status'])
        ) {
            $this->response->error = true;
            $this->response->message = 'Invalid account status.';
            $this->response->type = 'user-role';
            $this->response->filled_data = [
                'id' => $data['id'],
                'first_name' => $data['first-name'],
                'last_name' => $data['last-name'],
                'email' => (empty($data['new-email'])) ? $data['old-email'] : $data['new-email'],
                'website' => $data['website'],
                'status' => $data['status'],
                'bio' => $data['bio']
            ];
        } else {
            // Instantiate a user object.
            $user_info = new UserInfo();

            // Set data.
            $this->user->set_id((int) clean_data($data['id']));
            $this->user->set_status((int) clean_data($data['status']));
            $this->user->set_user_role((string) clean_data($data['user_role']));

            if (empty($data['password'])) {
                $this->user->set_password((string) $this->user->get_password());
            } else {
                $data['password'] = password_hash(trim($data['password']), PASSWORD_DEFAULT);
                $this->user->set_password($data['password']);
            }

            // Check if email changed.
            if ($data['new-email'] !== $data['old-email']) {
                //  Check if the email address already exists.
                if ($this->user::emailExist(clean_data($data['new-email']))) {
                    $this->response->error = true;
                    $this->response->message = 'The email address has already been registered by another user.';
                    $this->response->type = 'email';

                    $this->response->filled_data = [
                        'id' => $data['id'],
                        'first_name' => $data['first-name'],
                        'last_name' => $data['last-name'],
                        'email' => $data['old-email'],
                        'website' => $data['website'],
                        'status' => $data['status'],
                        'bio' => $data['bio']
                    ];
                } else {
                    $data['email'] = (empty($data['new-email'])) ? clean_data($data['old-email']) : clean_data($data['new-email']);
                    $this->user->set_email((string) $data['email']);

                    // Check if first and last name is set.
                    $data['first-name'] = (!empty($data['first-name'])) ? clean_data($data['first-name']) : '';
                    $data['last-name'] = (!empty($data['last-name'])) ? clean_data($data['last-name']) : '';

                    // Set full name.
                    $data['full-name'] = $data['first-name'] . ' ' . $data['last-name'];

                    $user_info->set_id((int) clean_data($data['id']));
                    $user_info->set_full_name((string) clean_data($data['full-name']));
                    $user_info->set_website((string) clean_data($data['website']));
                    $user_info->set_bio((string) clean_data($data['bio']));

                    if ($user_info->has_data()) {
                        if (
                            $user_info->update() &&
                            $this->user->change_email() &&
                            $this->user->change_password() &&
                            $this->user->change_status() &&
                            $this->user->change_role()
                        ) {
                            $this->response->error = false;
                            $this->response->message = 'Updated Successfully.';
                            $this->response->type = '';
                            $this->response->filled_data = [
                                'id' => $data['id'],
                                'first_name' => $data['first-name'],
                                'last_name' => $data['last-name'],
                                'email' => (empty($data['new-email'])) ? $data['old-email'] : $data['new-email'],
                                'website' => $data['website'],
                                'status' => $data['status'],
                                'user_role' => $data['user_role'],
                                'bio' => $data['bio']
                            ];
                        }
                    } else {
                        if (
                            $user_info->save() &&
                            $this->user->change_email() &&
                            $this->user->change_password() &&
                            $this->user->change_status() &&
                            $this->user->change_role()
                        ) {
                            $this->response->error = false;
                            $this->response->message = 'Updated Successfully.';
                            $this->response->type = '';
                            $this->response->filled_data = [
                                'id' => $data['id'],
                                'first_name' => $data['first-name'],
                                'last_name' => $data['last-name'],
                                'email' => (empty($data['new-email'])) ? $data['old-email'] : $data['new-email'],
                                'website' => $data['website'],
                                'status' => $data['status'],
                                'user_role' => $data['user_role'],
                                'bio' => $data['bio']
                            ];
                        }
                    }
                }
            } else {
                // Use the old password.
                // $this->user->set_email((string) clean_data($data['old-email']));

                // Check if first and last name is set.
                $data['first-name'] = (!empty($data['first-name'])) ? clean_data($data['first-name']) : '';
                $data['last-name'] = (!empty($data['last-name'])) ? clean_data($data['last-name']) : '';

                // Set full name.
                $data['full-name'] = $data['first-name'] . ' ' . $data['last-name'];

                $user_info->set_id((int) clean_data($data['id']));
                $user_info->set_full_name((string) clean_data($data['full-name']));
                $user_info->set_website((string) clean_data($data['website']));
                $user_info->set_bio((string) clean_data($data['bio']));

                if ($user_info->has_data()) {
                    if (
                        $user_info->update() &&
                        $this->user->change_password() &&
                        $this->user->change_status() &&
                        $this->user->change_role()
                    ) {
                        $this->response->error = false;
                        $this->response->message = 'Updated Successfully.';
                        $this->response->type = '';
                        $this->response->filled_data = [
                            'id' => $data['id'],
                            'first_name' => $data['first-name'],
                            'last_name' => $data['last-name'],
                            'email' => (empty($data['new-email'])) ? $data['old-email'] : $data['new-email'],
                            'website' => $data['website'],
                            'status' => $data['status'],
                            'user_role' => $data['user_role'],
                            'bio' => $data['bio']
                        ];
                    }
                } else {
                    if (
                        $user_info->save() &&
                        $this->user->change_password() &&
                        $this->user->change_status() &&
                        $this->user->change_role()
                    ) {
                        $this->response->error = false;
                        $this->response->message = 'Updated Successfully.';
                        $this->response->type = '';
                        $this->response->filled_data = [
                            'id' => $data['id'],
                            'first_name' => $data['first-name'],
                            'last_name' => $data['last-name'],
                            'email' => (empty($data['new-email'])) ? $data['old-email'] : $data['new-email'],
                            'website' => $data['website'],
                            'status' => $data['status'],
                            'user_role' => $data['user_role'],
                            'bio' => $data['bio']
                        ];
                    }
                }
            }
        }

        return $this->response;
    }
}
