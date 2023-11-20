<?php 

class ImageHandler {

    public function validate_uploaded_image($temp_path, $new_path)
    {
        $allowed_mime_types = ['image/gif', 'image/jpeg', 'image/png'];
        $allowed_extensions = ['gif', 'jpg', 'png', 'jpeg'];

        $image_info = @getimagesize($temp_path);

        if ($image_info === false || !is_array($image_info)) {
            return false;
        }

        $mime_type = $image_info['mime'];
        $file_extension = strtolower(pathinfo($new_path, PATHINFO_EXTENSION));

        $extension_valid = in_array($file_extension, $allowed_extensions, true);
        $mime_type_valid = in_array($mime_type, $allowed_mime_types, true);

        return $extension_valid && $mime_type_valid;
    }



    public function upload_image($imageFile) {
        if ($imageFile['error'] !== UPLOAD_ERR_OK) {
            throw new Exception("File upload error: " . $imageFile['error']);
        }
    
        if (!$this->validate_uploaded_image($imageFile['tmp_name'], $imageFile['name'])) {
            throw new Exception("Invalid file format. Please upload a valid image file.");
        }
    
        $uploads_dir = 'uploads/images/';
        $image_filename = uniqid() . '_' . basename($imageFile['name']);
        $target_file = $uploads_dir . $image_filename;
    
        if (move_uploaded_file($imageFile['tmp_name'], "../".$target_file)) {
            return $target_file;
        } else {
            throw new Exception("Failed to move the uploaded file.");
        }
    }
    
}
?>