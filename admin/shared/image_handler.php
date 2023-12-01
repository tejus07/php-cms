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

    public function resize_image($source_path, $target_path, $max_width, $max_height) {

        list($original_width, $original_height, $type) = getimagesize($source_path);
    
        $ratio = $original_width / $original_height;
        $new_width = $max_width;
        $new_height = $max_height;
    
        if ($new_width / $new_height > $ratio) {
            $new_width = $new_height * $ratio;
        } else {
            $new_height = $new_width / $ratio;
        }
    
        $new_image = imagecreatetruecolor($new_width, $new_height);
    
        $source_image = $this->create_image_from_type($type, $source_path);
    
        imagecopyresampled($new_image, $source_image, 0, 0, 0, 0, $new_width, $new_height, $original_width, $original_height);
        $this->save_image_by_type($type, $new_image, $target_path);
    
        imagedestroy($new_image);
        imagedestroy($source_image);
    }
    
    private function create_image_from_type($type, $source_path) {
        switch ($type) {
            case IMAGETYPE_JPEG:
                return imagecreatefromjpeg($source_path);
            case IMAGETYPE_PNG:
                return imagecreatefrompng($source_path);
            case IMAGETYPE_GIF:
                return imagecreatefromgif($source_path);
            default:
                throw new Exception('Unsupported image format');
        }
    }
    
    private function save_image_by_type($type, $image, $target_path) {
        switch ($type) {
            case IMAGETYPE_JPEG:
                imagejpeg($image, $target_path, 90);
                break;
            case IMAGETYPE_PNG:
                imagepng($image, $target_path, 9);
                break;
            case IMAGETYPE_GIF:
                imagegif($image, $target_path);
                break;
        }
    }


    public function upload_image($imageFile, $resize = true, $max_width = 400, $max_height = 250) {
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
            if ($resize) {
                echo "in here";
                $this->resize_image("../".$target_file, "../".$target_file, $max_width, $max_height);
            }
            return $target_file;
        } else {
            throw new Exception("Failed to move the uploaded file.");
        }
    }
    
}
?>