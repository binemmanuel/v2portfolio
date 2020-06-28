<?php
$response = $this->response->users;

if (!empty($this->update_response)) {
    $update_response = $this->update_response;
    $update_response->filled_data['username'] = $response->username;
    unset($response);
}
?>

<!-- .flexbox .cta-btn-flex -->
<div class="flexbox cta-btn-flex">
    <h1>User Profile</h1>
</div>
<!-- .flexbox .cta-btn-flex /-->

<!-- .flexbox -->
<div class="user">
    <!-- .user-form -->
    <div class="user-form">
        <?php if (!empty($response->error)): ?>
            <p class="alert alert-error"> <?= $response->message ?></p>

        <?php elseif (!empty($response->message)): ?>
            <p class="alert alert-success"> <?= $response->message ?></p>

        <?php elseif (!empty($update_response->error)): ?>
            <p class="alert alert-error"> <?= $update_response->message ?></p>

        <?php elseif (!empty($update_response->message)): ?>
            <p class="alert alert-success"> <?= $update_response->message ?></p>

        <?php endif ?>

        <form method="POST"
        <?php if (!empty($response->id)): ?>
            action="<?= WEB_ROOT ?>admin/users/edit/<?= $response->id ?>"

        <?php elseif (!empty($update_response->filled_data['id'])): ?>
            action="<?= WEB_ROOT ?>admin/users/edit/<?= $update_response->filled_data['id'] ?>"

        <?php else: ?>
            action="<?= WEB_ROOT ?>admin/users/add-new ?>" 
        
        <?php endif ?>>
            <?php if (!empty($response->id)): ?>
                <input type="hidden" name="id" value="<?= $response->id ?>" />
            
            <?php elseif (!empty($update_response->filled_data['id'])): ?>
                <input type="hidden" name="id" value="<?= $update_response->filled_data['id'] ?>" />

            <?php endif ?>
            
            <h2 class="no-m">Name</h2>
            <div class="form-input">
                <input
                    type="text"
                    name="username" 
                    placeholder="Name"
                    disabled

                    <?php if (!empty($update_response->filled_data['username'])): ?>
                        value="<?= $update_response->filled_data['username'] ?>"

                    <?php elseif (!empty($response->username)): ?>
                        value="<?= $response->username ?>"

                    <?php endif ?>/>
                <span>Username can not be changed</span>
            </div>

            <div class="form-input">
                <input
                    type="text"
                    name="first-name" 
                    placeholder="First Name"
                    <?php if (!empty($update_response->filled_data['first_name'])): ?>
                        value="<?= $update_response->filled_data['first_name'] ?>"
                    
                    <?php elseif (!empty($response->first_name)): ?>
                        value="<?= $response->first_name ?>"

                    <?php endif ?>/>
            </div>

            <div class="form-input">
                <input
                    type="text"
                    name="last-name" 
                    placeholder="Last Name"
                    <?php if (!empty($update_response->filled_data['last_name'])): ?>
                        value="<?= $update_response->filled_data['last_name'] ?>"

                    <?php elseif (!empty($response->last_name)): ?>
                        value="<?= $response->last_name ?>"

                    <?php endif ?>/>
            </div>

            <h2>Contact</h2>
            <div class="form-input">
                <input
                    type="email"
                    name="email" 
                    placeholder="Email"
                    <?php if (!empty($update_response->filled_data['email'])): ?>
                        value="<?= $update_response->filled_data['email'] ?>"

                    <?php elseif (!empty($response->email)): ?>
                        value="<?= $response->email ?>"

                    <?php endif ?>/>
            </div>

            <div class="form-input">
                <input
                    type="text"
                    name="website"
                    placeholder="Website" 
                    <?php if (!empty($update_response->filled_data['website'])): ?>
                        value="<?= $update_response->filled_data['website'] ?>"

                    <?php elseif (!empty($response->website)): ?>
                        value="<?= $response->website ?>"
                        
                    <?php endif ?>/>

                <span>Web address should start with "https://" or "http://"</span>
            </div>

            <h2>Account Management</h2>
            <div class="form-input">
                <select name="user_role">
                    <?php if (
                        strtolower($update_response->filled_data['user_role']) === 'administrator' ||
                        strtolower($response->user_role) === 'administrator'
                    ): ?>
                        <option value="administrator">Administrator</option>
                        <option value="subscriber">Subscriber</option>

                    <?php else: ?>
                        <option value="subscriber">Subscriber</option>
                        <option value="administrator">Administrator</option>

                    <?php endif ?>
                </select>
            </div>

            <div class="form-input">
                <select name="status">
                    <?php if (
                        !empty($update_response->filled_data['status']) ||
                        !empty($response->active)
                    ): ?>
                        <option class="text-active" value="1">Active</option>
                        <option class="text-danger" value="0">Inactive</option>

                    <?php else: ?>
                        <option class="text-danger" value="0">Inactive</option>
                        <option class="text-success" value="1">Active</option>

                    <?php endif ?>
                </select>
            </div>

            <div class="form-input">
             <input
                    type="password"
                    name="password"
                    placeholder="Change Password" />
            </div>

            <h2>About yourself</h2>
            <div class="form-input">
                <textarea name="bio" placeholder="Bio" cols="30" rows="10"><?php if (!empty($response->bio)): ?><?= $response->bio ?><?php elseif (!empty($update_response->filled_data['bio'])): ?><?= $update_response->filled_data['bio'] ?><?php endif ?></textarea>
            </div>

            <?php if (
                !empty($update_response->filled_data['id']) ||
                !empty($response->id)
            ): ?>
                <input type="submit" value="Update" class="btn btn-body" />
            
            <?php else: ?>
                <input type="submit" value="Add user" class="btn btn-body" />

            <?php endif ?>
        </form>
    </div>
    <!-- .user-form /-->
</div>
<!-- .flexbox /-->