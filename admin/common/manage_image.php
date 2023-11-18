<?php 

class Manage_image {

    private $imageFile = null;

    public function __construct() {
    }
    public function file_is_an_image($temporary_path, $new_path)
    {
        $allowed_mime_types = ['image/gif', 'image/jpeg', 'image/png'];
        $allowed_file_extensions = ['gif', 'jpg', 'png', 'jpeg'];

        $actual_file_info = getimagesize($temporary_path);
        if ($actual_file_info === false) {
            return false;
        }

        $actual_mime_type = $actual_file_info['mime'];
        $actual_file_extension = pathinfo($new_path, PATHINFO_EXTENSION);

        $file_extension_is_valid = in_array($actual_file_extension, $allowed_file_extensions);
        $mime_type_is_valid = in_array($actual_mime_type, $allowed_mime_types);

        return $file_extension_is_valid && $mime_type_is_valid;
    }


    public function get_image_url($imageFile) {

        if ($imageFile['error'] === UPLOAD_ERR_OK) {
            
            if ($this->file_is_an_image($imageFile['tmp_name'], $imageFile['name'])) {
                $uploads_dir = 'uploads/images/';
                $image_filename = uniqid() . '_' . basename($imageFile['name']);
                $target_file = $uploads_dir . $image_filename;
                
                if (move_uploaded_file($imageFile['tmp_name'], "../".$target_file)) {
                    return $target_file;
                } else {
                    throw new Exception("Failed to move the uploaded file.");
                }
            } else {
                throw new Exception("Invalid file format. Please upload a valid image file.");
            }
        }
    }
}
?>