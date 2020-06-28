<?php
/**
 * The template file for displaying the media page
 * for the Admin theme.
 *
 * @author: Bin Emmanuel https://binemmanuel.com/#about
 * @link https://developers.binemmanuel.com/portfolio
 * @package Portfolio
 * @version 1.1
 * @since Admin 1.0
 */

$response = $this->response;

if (!empty($this->form_response)) {
    $form_response = $this->form_response;
}
?>

<!-- .flexbox .cta-btn-flex -->
<div class="flexbox cta-btn-flex">
    <h1>Library</h1><a class="btn btn-body uploader-toggler">Add New</a>
</div>
<!-- .flexbox .cta-btn-flex /-->

<?php if (!empty($form_response->error)): ?>
    <p class="alert alert-error" style="margin-top: 5.5rem"> <?= $form_response->message ?></p>

<?php elseif (!empty($form_response->message)): ?>
    <p class="alert alert-success" style="margin-top: 5.5rem"> <?= $form_response->message ?></p>

<?php endif ?>

<!-- .media-uploader -->
<div class="media-uploader" id="modal">
    <div class="media-uploader-header close-btn">
        <i class="fa fa-times"></i>
    </div>
    <form action="<?= WEB_ROOT ?>admin/library/add-new" method="post" enctype="multipart/form-data">
        <div class="form-input">
            <input type="file" name="files" />
        </div>

        <div class="form-input">
            <input type="submit" value="Upload" class="btn btn-body" />
        </div>
    </form>
    <small>Maximum upload file size: 2 MB.</small>
</div>
<!-- .media-uploader /-->

<!-- .library-header -->
<div class="library-header">
    <!-- .library-actions -->
    <div class="library-actions">
        <select name="" id="">
            <option>All media items</option>
            <option>Images</option>
            <option>Videos</option>
            <option>Audios</option>
        </select>
    </div>
    <!-- .library-actions /-->

    <!-- .search-bar -->
    <div class="search-bar">
        <form action="" method="post">
            <input type="search" name="keyword" placeholder="Search" />
        </form>
    </div>
    <!-- .search-bar /-->
</div>
<!-- .library-header /-->

<!-- .library-panel -->
<section class="library-panel">
    <?php foreach ($response as $media): ?>
        <?php
        // Extract file type.
        $file_type = explode('/', $media->type);
        $file_type = $file_type[0];
        ?>

        <?php if ($file_type === 'image'): ?>
            <!-- .media-file -->
            <div class="media-file">
                <input type="hidden" id="id-<?= $media->id ?>" value="<?= $media->id ?>" />
                <input type="hidden" id="link-<?= $media->id ?>" value="<?= urldecode($media->link) ?>" />
                
                <img
                    src="<?= WEB_ROOT . urldecode($media->link) ?>"
                    alt="<?= $media->alt_text ?>"
                    onclick="copy_url('<?= WEB_ROOT ?>', '#link-<?= $media->id ?>')"/>

                <!-- .media-actions -->
                <div class="media-actions">
                    <ul>
                        <!-- #activate_edit_modal -->
                        <li class="btn btn-body"
                            id="activate_edit_modal"
                            onclick="edit_media_modal(
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
                        <li class="btn btn-body btn-danger"
                            id="activate_delete_modal"
                            onclick="delete_media_modal(
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
        
        <?php elseif ($file_type === 'video'): ?>
            <!-- .media-file -->
            <div class="media-file">
                <input type="hidden" id="id-<?= $media->id ?>" value="<?= $media->id ?>" />
                <input type="hidden" id="link-<?= $media->id ?>" value="<?= urldecode($media->link) ?>" />
                
                <video 
                    src="<?= WEB_ROOT . urldecode($media->link) ?>"
                    onclick="copy_url('<?= WEB_ROOT ?>', '#link-<?= $media->id ?>')"></video>

                <!-- .media-actions -->
                <div class="media-actions">
                    <ul>
                        <!-- #activate_edit_modal -->
                        <li class="btn btn-body"
                            id="activate_edit_modal"
                            onclick="edit_media_modal(
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
                        <li class="btn btn-body btn-danger"
                            id="activate_delete_modal"
                            onclick="delete_media_modal(
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
</section>
<!-- .library-panel /-->

<!-- delete-modal -->
<div class="delete-modal">
    <form id="delete_modal_form" action="<?= WEB_ROOT ?>admin/library/delete/" method="post">
        <input type="hidden" name='id' id="object_id" />
        <input type="hidden" name='file' id="object_link" />

        <!-- .delete-modal-header .close-btn -->
        <div class="delete-modal-header close-btn">
            <h2>Delete File</h2>
            <i class="fa fa-times"></i>
        </div>
        <!-- .delete-modal-header .close-btn /-->

        <!-- .delete-modal-body -->
        <div class="delete-modal-body">
            <p>Are you sure you want to permanently delete the file?</p>
        </div>
        <!-- .delete-modal-body /-->

        <!-- .delete-modal-footer -->
        <div class="delete-modal-footer">
            <input class="btn close-btn btn-secondary" type="submit" value="No" />
            <input class="btn text-danger" type="submit" value="Permanently Delete" />
        </div>
        <!-- .delete-modal-footer /-->
    </form>
</div>
<!-- delete-modal /-->

<!-- .edit-modal -->
<div class="edit-modal">
    <!-- .edit-model-header -->
    <div class="edit-modal-header">
        <h2>File Details</h2>

        <div class="navigator">
            <ul>
                <li><i class="fa fa-chevron-left"></i></li>
                <li><i class="fa fa-chevron-right"></i></li>
                <li class="close-btn"><i class="fa fa-times"></i></li>
            </ul>
        </div>
    </div>
    <!-- .edit-model-header /-->

    <!-- .edit-modal-body -->
    <div class="edit-modal-body">
        <!-- .edit-modal-file -->
        <div class="edit-modal-file"></div>
        <!-- .edit-modal-file -->

        <!-- .edit-modal-file-detail -->
        <div class="edit-modal-file-detail">
            <form action="<?= WEB_ROOT ?>admin/library/edit" method="POST" id="edit_modal_form" >
                <input type="hidden" name='id' id="edit_object_id" />
                <input type="hidden" name='file' id="edit_object_link" />

                <div>
                    <label for="">File Name</label>
                    <input type="text" name="name" id="name"/>
                </div>
                <div>
                    <label for="">Alternative Text</label>
                    <input type="text" name="alt-text" id="alt_text"/>
                </div>
                <div>
                    <label for="">Description</label>
                    <textarea name="description" id="description" cols="30" rows="10"></textarea>
                </div>
                <div>
                    <label for="">Uploaded By</label>
                    <input type="text" name="author" id="author" disabled />
                </div>
                <div>
                    <label for="">Link</label>
                    <input type="text" name="link" id="link" disabled />
                </div>
                <div class="edit-modal-actions">
                    <ul>
                        <li><a 
                            class="text-danger"
                            id="activate_delete_modal"
                            onclick="delete_media_modal(
                                '#edit_object_id',
                                '#edit_object_link',
                                delete_modal_form
                            )">Delete Permanently</a></li>
                        <li>
                                <input type="submit" class="btn btn-body" value="Save" />
                        </li>
                    </ul>
                </div>
            </form>
        </div>
        <!-- .edit-modal-file-detail -->
    </div>
    <!-- .edit-modal-body /-->
</div>
<!-- .edit-modal /-->

<script>
    const uploader_toggler = document.querySelector('.uploader-toggler')
    body = document.querySelector('body')

    uploader_toggler.addEventListener('click', (event) => {
        body.classList.toggle('show-uploader')   
    })
</script>