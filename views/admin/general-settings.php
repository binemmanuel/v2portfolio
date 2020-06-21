<?php
/**
 * The template file for displaying the settings page
 * for the Admin theme.
 *
 * @author: Bin Emmanuel https://binemmanuel.com/#about
 * @link https://developers.binemmanuel.com/portfolio
 * @package Portfolio
 * @version 1.1
 * @since Admin 1.0
 */


if (!empty($this->update_response)) {
    $update_response = $this->update_response;
} else {
    $response = $this->response;
}
?>

<!-- .flexbox .cta-btn-flex -->
<div class="flexbox cta-btn-flex">
    <h1>Settings</h1>
</div>
<!-- .flexbox .cta-btn-flex /-->

<!-- .flexbox -->
<div class="settings">
    <!-- .settings-form -->
    <div class="settings-form">
        <?php if (!empty($response->error)): ?>
            <p class="alert alert-error"> <?= $response->message ?></p>

        <?php elseif (!empty($response->message)): ?>
            <p class="alert alert-success"> <?= $response->message ?></p>

        <?php elseif (!empty($update_response->error)): ?>
            <p class="alert alert-error"> <?= $update_response->message ?></p>

        <?php elseif (!empty($update_response->message)): ?>
            <p class="alert alert-success"> <?= $update_response->message ?></p>

Psite        <?php endif ?>

        <form method="post"
            <?php if (empty($update_response)): ?>
                action="<?= WEB_ROOT ?>admin/settings/edit"

            <?php else: ?>
                action="<?= WEB_ROOT ?>admin/settings/edit"

            <?php endif ?>>
            <!-- .form-input -->
            <div class="form-input">
                <input type="text" name="title" placeholder="Site Name" class="no-m" 
                <?php if (!empty($update_response->filled_data->title)): ?>
                    value="<?= $update_response->filled_data->title ?>"
                
                <?php elseif (!empty($response->title)): ?>
                    value="<?= $response->title ?>"
                    
                <?php endif ?>/>
            </div>
            <!-- .form-input /-->

            <!-- .form-input -->
            <div class="form-input">
                <textarea name="tagline" placeholder="Tagline" cols="30" rows="10"><?php if (!empty($update_response->filled_data->tagline)): ?><?= $update_response->filled_data->tagline ?><?php elseif (!empty($response->tagline)): ?><?= $response->tagline ?><?php endif ?></textarea>
                <span>
                    In a few words, explain what this site is about.
                </span>
            </div>
            <!-- .form-input /-->

            <!-- .form-input -->
            <div class="form-input">
                <input type="text" name="site_address" placeholder="Site Address (URL)" 
                <?php if (!empty($update_response->filled_data->site_address)): ?>
                    value="<?= $update_response->filled_data->site_address ?>"

                <?php elseif (!empty($response->site_address)): ?>
                    value="<?= $response->site_address ?>"
                    
                <?php endif ?>/>
            </div>
            <!-- .form-input /-->

            <!-- .form-input -->
            <div class="form-input">
                <input type="text" name="email" placeholder="Email Address"
                <?php if (!empty($update_response->filled_data->email)): ?>
                    value="<?= $update_response->filled_data->email ?>"

                <?php elseif (!empty($response->email)): ?>
                    value="<?= $response->email ?>"
                    
                <?php endif ?>/>
                <span>
                This address is used for admin purposes. If you change this we will send you an email at your new address to confirm it. The new address will not become active until confirmed.
                </span>
            </div>
            <!-- .form-input /-->

            <!-- .form-input -->
            <div class="form-input flexbox">
                <div>
                    <label for="default_user_role">Default User Role</label>
                    <select name="default_user_role">
                        <?php if (
                            (
                                !empty($response->default_user_role) &&
                                strtolower($response->default_user_role) === 'administrator'
                            ) ||
                            (
                                !empty($update_response->filled_data->default_user_role) &&
                                strtolower($update_response->filled_data->default_user_role) === 'administrator'
                            )
                        ): ?>
                            <option value="administrator">Administrator</option>
                            <option value="subscriber">Subscriber</option>

                        <?php elseif (
                            (
                                !empty($update_response->filled_data->default_user_role) &&
                                strtolower($update_response->filled_data->default_user_role) === 'subscriber'
                            ) ||
                            (
                                !empty($response->default_user_role) &&
                                strtolower($response->default_user_role) === 'subscriber'
                            )
                        ): ?>
                            <option value="subscriber">Subscriber</option>
                            <option value="administrator">Administrator</option>
                        <?php endif ?>
                    </select>
                </div>
                <div>
                    <label for="allow_new_reg">Allow New Registrations</label>
                    <select name="allow_new_reg" id="">
                        <?php if (
                            (
                                !empty($update_response->filled_data->allow_new_reg) &&
                                strtolower($update_response->filled_data->allow_new_reg) === 'yes'
                            ) ||
                            (
                                !empty($response->allow_new_reg) &&
                                strtolower($response->allow_new_reg) === 'yes'
                            )
                        ): ?>
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>

                        <?php elseif (
                            (
                                !empty($update_response->filled_data->allow_new_reg) &&
                                strtolower($update_response->filled_data->allow_new_reg) === 'no'
                            ) ||
                            (
                                !empty($response->allow_new_reg) &&
                                strtolower($response->allow_new_reg) === 'no'
                            )
                        ): ?>
                            <option value="No">No</option>
                            <option value="Yes">Yes</option>
                        <?php endif ?>
                    </select>
                </div>
            </div>
            <!-- .form-input /-->

            <input type="submit" value="Save" class="btn btn-body" />
        </form>
    </div>
    <!-- .settings-form /-->

    <!-- .other-settings -->
    <div class="other-settings">
        <!-- .settings-header -->
        <div class="settings-header">
            <!-- .search-bar -->
            <div class="search-bar">
                <form action="" method="post">
                    <input type="search" name="keyword" placeholder="Search" />
                </form>
            </div>
            <!-- .search-bar /-->
        </div>
        <!-- .settings-header /-->

        <!-- .settingss-panel -->
        <section class="categories-panel"> 

        </section>
        <!-- .settingss-panel /-->
    </div>
    <!-- .other-settings /-->
</div>
<!-- .flexbox /-->