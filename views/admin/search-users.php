<?php
use function portfolio\clean_data;

// Get all users.
$response = $this->response->users;
?>


<?php foreach ($response as $user): ?>
    <tr>
        <td class="text-center">
            <input type="checkbox" name="" />
        </td>
        <td class="clear">
            <a href="<?= WEB_ROOT ?>admin/users/edit/<?= $user->id ?>" class="dark-link">
                <?= clean_data($user->username) ?>
            </a>

            <!-- .actions -->
            <div class="actions">
                <ul class="nav-list">
                    <li class="nav-item">
                        <a href="<?= WEB_ROOT ?>admin/users/edit/<?= $user->id ?>" class="">
                            Edit
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= WEB_ROOT ?>admin/users/view/<?= $user->id ?>" class="">
                            View
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= WEB_ROOT ?>admin/users/delete/<?= $user->id ?>" class=" color-red">
                            Delete
                        </a>
                    </li>
                </ul>
            </div>
            <!-- .actions /-->
        </td>
        <td><?= clean_data($user->full_name) ?></td>
        <td>
            <a href="mailto:<?= clean_data($user->email) ?>" class="dark-link">
                <?= clean_data($user->email) ?>
            </a>
        </td>
        <td>
            <a href="<?= clean_data($user->website) ?>" target="__blank" class="dark-link">
                <?= clean_data($user->website) ?>
            </a>
        </td>
        <td><?= clean_data($user->user_role) ?></td>
        
        <?php if(empty($user->active)): ?>
            <td class="color-red">Inactive</td>

        <?php else: ?>
            <td class="color-active">Active</td>

        <?php endif ?>
    </tr>
<?php endforeach ?>