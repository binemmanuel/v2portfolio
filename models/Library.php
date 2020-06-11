<?php
namespace model;

use portfolio\BaseModel;
use portfolio\Library as PortfolioLibrary;
use stdClass;

use function portfolio\clean_data;

class Library extends BaseModel
{
    function __construct()
    {
        parent::__construct();
    }

    public function get(int $id = null)
    {
        $media = new PortfolioLibrary($id);
        
        $response = $media->get_all();

        return $response;
    }

    public function edit(array $data): object
    {
        // Instantiate an Object.
        $response = new stdClass;

        $library = new PortfolioLibrary();
        $library->id = (int) (!empty($data['id'])) ? clean_data($data['id']) : null;
        $library->name = (string) (!empty($data['name'])) ? clean_data($data['name']) : null;
        $library->caption = (string) (!empty($data['caption'])) ? clean_data($data['caption']) : null;
        $library->alt_text = (string) (!empty($data['alt-text'])) ? clean_data($data['alt-text']) : null;
        $library->description = (string) (!empty($data['description'])) ? clean_data($data['description']) : null;

        // Update the file
        if ($library->update()) {
            // Store success message.
            $response->error = false;
            $response->message = "Upldated successfully.";
            $response->error_type = null;
        }
        
        return $response;
    }

    public function delete(array $data): object
    {
        // Instantiate an Object.
        $response = new stdClass;

        $library = new PortfolioLibrary();
        $library->id = (int) (!empty($data['id'])) ? clean_data($data['id']) : null;

        // Delete the file
        if (file_exists(urldecode($data['file']))) {
            if ($library->delete() && unlink(urldecode($data['file']))) {
                // Store success message.
                $response->error = false;
                $response->message = "Deleted successfully.";
                $response->error_type = null;
            }
        }
        return $response;
    }

    public function save(array $data): object
    {
        // Instantiate an Object.
        $response = new stdClass;

        if (
            empty($data['name']) &&
            empty($data['files'])
        ) {
            // Store an error message.
            $response->error = true;
            $response->message = 'No file was selected to be uploaded.';
            $response->error_type = 'upload';
        } else {
            // Uploaded By.
            $uploaded_by = 'Bin Emmanuel'; // Chenge this.

            // Tmp file name.
            $tmp_file_name = clean_data($data['files']['tmp_name']);

            $file_extension = strtolower(pathinfo($data['files']['name'], PATHINFO_EXTENSION));

            // Store the file name.
            $file_name = "[binemmanul.com]_". md5(uniqid() . strtolower($data['files']['name'])) .'.'. $file_extension; // add a prefix to the file name.

            // Validate file.
            if ($this->is_image($file_name)) {
                // Target directory.
                $target_dir = IMAGE_PATH;
                
                // Where is store the file.
                $target_file = $target_dir . basename(clean_data($file_name));

                // Store the file type.
                $file_type = clean_data('image/'. $this->file_type($file_name));

                // Upload the file.
                if (!$this->upload_file(
                    $tmp_file_name,
                    $target_file,
                    $file_type,
                    $uploaded_by
                )) {
                    // Store an error message.
                    $response->error = true;
                    $response->message = "Sorry, something went wrong when trying to upload the file. $file_name";
                    $response->error_type = 'upload';
                } else {
                    // Store success message.
                    $response->error = false;
                    $response->message = "File uploaded successfully. $file_name";
                    $response->error_type = null;
                }
                
            } elseif ($this->is_video($file_name)) {
                // Target directory.
                $target_dir = VIDEO_PATH;

                // Where is store the file.
                $target_file = $target_dir . basename(clean_data($file_name));
                
                // Store the file type.
                $file_type = clean_data('video/'. $this->file_type($file_name));

                // Upload the file.
                if (!$this->upload_file(
                    $tmp_file_name,
                    $target_file,
                    $file_type,
                    $uploaded_by
                )) {
                    // Store an error message.
                    $response->error = true;
                    $response->message = "Sorry, something went wrong when trying to upload the file. $file_name";
                    $response->error_type = 'upload';
                } else {
                    // Store success message.
                    $response->error = false;
                    $response->message = "File uploaded successfully. $file_name";
                    $response->error_type = null;
                }

            } elseif ($this->is_zip($file_name)) {
                // Target directory.
                $target_dir = ZIP_PATH;

                // Where is store the file.
                $target_file = $target_dir . basename(clean_data($file_name));
                
                // Store the file type.
                $file_type = clean_data('application/'. $this->file_type($file_name));

                // Upload the file.
                if (!$this->upload_file(
                    $tmp_file_name,
                    $target_file,
                    $file_type,
                    $uploaded_by
                )) {
                    // Store an error message.
                    $response->error = true;
                    $response->message = "Sorry, something went wrong when trying to upload the file. $file_name";
                    $response->error_type = 'upload';
                } else {
                    // Store success message.
                    $response->error = false;
                    $response->message = "File uploaded successfully. $file_name";
                    $response->error_type = null;
                }

            } else {
                // Store an error message.
                $response->error = true;
                $response->message = 'Invalid file type';
                $response->error_type = 'upload';
            }
        }

        return $response;
    }

    /**
     * The function for checking file type if it's an image.
     * 
     * @param string The File name.
     * 
     * @return bool Returns false || true if the file is an image.
     */
    public function is_image(string $file_name): bool
    {
        // Store the target directory and target file.
        $target_file = basename($file_name);

        // Store the image types we want.
        $valid_file_type = [
            'jpeg',
            'jpg',
            'png',
            'gif'
        ];

        // Store file type.
        $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check the file type.
        if (in_array($file_type, $valid_file_type) === true) {
            return true;
        }

        return false;
    }

    /**
     * The function for checking file type it's a video.
     * 
     * @param string The File name.
     * 
     * @return bool Returns false || true if the file is a video.
     */
    public function is_video(string $file_name): bool
    {
        // Store the target directory and target file.
        $target_file = basename($file_name);

        // Store the image types we want.
        $valid_file_type = [
            'avi',
            'mkv',
            'wmv',
            '3gp',
            'mp4'
        ];

        // Store file type.
        $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check the file type.
        if (in_array($file_type, $valid_file_type) === true) {
            return true;
        }

        return false;
    }

    /**
     * The function for checking file type it's a zip file.
     * 
     * @param string The File name.
     * 
     * @return bool Returns false || true if the file is a zip file.
     */
    public function is_zip(string $file_name): bool
    {
        // Store the target directory and target file.
        $target_file = basename($file_name);

        // Store the image types we want.
        $valid_file_type = ['zip'];

        // Store file type.
        $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check the file type.
        if (in_array($file_type, $valid_file_type) === true) {
            return true;
        }

        return false;
    }

    /**
     * The function for checking file type it's an audio.
     * 
     * @param string The File name.
     * 
     * @return bool Returns false || true if the file is a audio.
     */
    public function is_audio(string $file_name): bool
    {
        // Store the target directory and target file.
        $target_file = basename($file_name);

        // Store the image types we want.
        $valid_file_type = ['mp3'];

        // Store file type.
        $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check the file type.
        if (in_array($file_type, $valid_file_type) === true) {
            return true;
        }

        return false;
    }

    /**
	 * The function that gets file type of a given file.
	 * 
	 * @param string The File name.
	 * 
	 * @return string Returns the file type.
	 */
	public function file_type(string $file_name): string
	{
		// Store the target directory and target file.
		$target_file = basename($file_name);

		// Store file type.
		$file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

		// Return the file type.
		return $file_type;
    }
    
    /**
     * The function that gets file type of a given file.
     * 
     * @param String The File's name tem name.
     * @param String Upload directory.
     * @param String The file type.
     * @param String The uploader.
     * 
     * @return Bool false || true if th file was uploaded successfully.
     */
    public function upload_file(
        string $tmp_file_name, 
        string $target_file, 
        string $file_type, 
        string $uploaded_by
    ): bool
    {
        // Instantiate an Object.
        $library = new PortfolioLibrary;
        $library->link = (string) urlencode(clean_data($target_file));
        $library->type = (string) clean_data($file_type);
        $library->description = '';
        $library->uploaded_by = (string) clean_data($uploaded_by);

        // Upload file if there are no errors
        // Then store file data.
        if (
            move_uploaded_file($tmp_file_name, $target_file) &&
            $library->upload()) {
            return true;
        }

        return false;
    }
}
