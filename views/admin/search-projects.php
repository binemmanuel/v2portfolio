<?php
// All Projects.
$projects = $this->response->projects;
?>

<?php foreach ($projects as $project): ?>
    <tr>
        <td class="text-center">
            <input type="checkbox" name="" />
        </td>
        <td class="clear">
            <a href="<?= WEB_ROOT ?>admin/projects/edit/<?= $project->id ?>" class="dark-link"><?= $project->title ?></a>

            <!-- .actions -->
            <div class="actions">
                <ul class="nav-list">
                    <li class="nav-item">
                        <a href="<?= WEB_ROOT ?>admin/projects/edit/<?= $project->id ?>">Edit</a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= WEB_ROOT ?>home#<?= $project->id ?>" target="__blank">View</a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= WEB_ROOT ?>admin/projects/delete/<?= $project->id ?>" class="color-red">Delete</a>
                    </li>
                </ul>
            </div>
            <!-- .actions /-->
        </td>
        <td><?= $project->author ?></td>
        <td><?= $project->status ?></td>
        <td>---</td>
        <td>---</td>
    </tr>
<?php endforeach ?>