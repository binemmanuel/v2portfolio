<?php
// All Media files.
$response = $this->response;
?>

<?php foreach ($response as $media) : ?>
    <?php
    // Extract file type.
    $file_type = explode('/', $media->type);
    $file_type = $file_type[0];
    ?>

    <?php if ($file_type === 'image') : ?>
        <!-- .media-file -->
        <div class="media-file">
            <input type="hidden" id="id-<?= $media->id ?>" value="<?= $media->id ?>" />
            <input type="hidden" id="link-<?= $media->id ?>" value="<?= urldecode($media->link) ?>" />

            <img src="<?= WEB_ROOT . urldecode($media->link) ?>" alt="<?= $media->alt_text ?>" onclick="copy_url('<?= WEB_ROOT ?>', '#link-<?= $media->id ?>')" />

            <!-- .media-actions -->
            <div class="media-actions">
                <ul>
                    <!-- #activate_edit_modal -->
                    <li class="btn btn-body" id="activate_edit_modal" onclick="edit_media_modal(
                                '#id-'+ <?= $media->id ?>,
                                '#link-'+ <?= $media->id ?>,
                                edit_modal_form,
                                {
                                    web_root: '<?= WEB_ROOT ?>',
                                    name: '<?= urldecode($media->name) ?>',
                                    alt_text: '<?= $media->alt_text ?>',
                                    description: '<?= $media->description ?>',
                                    uploaded_by: '<?= $media->uploadedBy ?>',
                                    type: '<?= $media->type ?>'
                                }
                            )">
                        <a class="">Edit</a>
                    </li>
                    <!-- #activate_edit_modal /-->

                    <!-- #activate_delete_modal -->
                    <li class="btn btn-body btn-danger" id="activate_delete_modal" onclick="delete_media_modal(
                                '#id-<?= $media->id ?>',
                                '#link-<?= $media->id ?>',
                                delete_modal_form
                            )">
                        <a>Delete</a>
                    </li>
                    <!-- #activate_delete_modal /-->
                </ul>
            </div>
            <!-- .media-actions /-->
        </div>
        <!-- .media-file /-->

    <?php elseif ($file_type === 'video') : ?>
        <!-- .media-file -->
        <div class="media-file">
            <input type="hidden" id="id-<?= $media->id ?>" value="<?= $media->id ?>" />
            <input type="hidden" id="link-<?= $media->id ?>" value="<?= urldecode($media->link) ?>" />

            <video src="<?= WEB_ROOT . urldecode($media->link) ?>" onclick="copy_url('<?= WEB_ROOT ?>', '#link-<?= $media->id ?>')"></video>

            <!-- .media-actions -->
            <div class="media-actions">
                <ul>
                    <!-- #activate_edit_modal -->
                    <li class="btn btn-body" id="activate_edit_modal" onclick="edit_media_modal(
                                '#id-'+ <?= $media->id ?>,
                                '#link-'+ <?= $media->id ?>,
                                edit_modal_form,
                                {
                                    web_root: '<?= WEB_ROOT ?>',
                                    name: '<?= urldecode($media->name) ?>',
                                    alt_text: '<?= $media->alt_text ?>',
                                    description: '<?= $media->description ?>',
                                    uploaded_by: '<?= $media->uploadedBy ?>',
                                    type: '<?= $media->type ?>'
                                }
                            )">
                        <a class="">Edit</a>
                    </li>
                    <!-- #activate_edit_modal /-->

                    <!-- #activate_delete_modal -->
                    <li class="btn btn-body btn-danger" id="activate_delete_modal" onclick="delete_media_modal(
                                '#id-<?= $media->id ?>',
                                '#link-<?= $media->id ?>',
                                delete_modal_form
                            )">
                        <a>Delete</a>
                    </li>
                    <!-- #activate_delete_modal /-->
                </ul>
            </div>
            <!-- .media-actions -->
        </div>
        <!-- .media-file /-->
    <?php endif ?>
<?php endforeach ?>