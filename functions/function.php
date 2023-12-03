<?php
function redirect($location = Null)
{
    if ($location != Null) {
        echo "<script>
                window.location='{$location}'
            </script>";
    } else {
        echo 'error location';
    }

}

function logout()
{
    session_start();
    session_destroy();
    header("Location: login.php");
    exit();
}

function file_is_an_image($temporary_path, $new_path)
{
    $allowed_mime_types = ['image/gif', 'image/jpeg', 'image/png'];
    $allowed_file_extensions = ['gif', 'jpg', 'png', 'jpeg'];

    $actual_file_info = getimagesize($temporary_path);
    if ($actual_file_info === false) {
        return false;
    }

    $actual_file_extension = pathinfo($new_path, PATHINFO_EXTENSION);
    $actual_mime_type = $actual_file_info['mime'];

    $file_extension_is_valid = in_array($actual_file_extension, $allowed_file_extensions);
    $mime_type_is_valid = in_array($actual_mime_type, $allowed_mime_types);

    return $file_extension_is_valid && $mime_type_is_valid;
}

function generateLink($link, $search, $sortOrder, $brandFilter = '', $page = 1)
{
    $link .= '?';

    // Check if search parameter is present
    $hasSearch = !empty($search);

    // Add search parameter if available
    if ($hasSearch) {
        $link .= 'search=' . urlencode($search);
    }

    // Add sort parameter
    $link .= '&sort=' . $sortOrder;

    // Add brand filter parameter if available
    if (!empty($brandFilter)) {
        $link .= '&brandFilter=' . $brandFilter;
    }

    // Add pagination parameter
    $link .= '&page=' . $page;

    return $link;
}

function upload_image($imageFile, $resize = true, $max_width = 400, $max_height = 250)
{
    echo var_dump($imageFile);
    if ($imageFile['error'] !== UPLOAD_ERR_OK) {
        throw new Exception("File upload error: " . $imageFile['error']);
    }

    if (!validate_uploaded_image($imageFile['tmp_name'], $imageFile['name'])) {
        throw new Exception("Invalid file format. Please upload a valid image file.");
    }

    $uploads_dir = 'uploads/';
    $image_filename = uniqid() . '_' . basename($imageFile['name']);
    $target_file = $uploads_dir . $image_filename;

    if (move_uploaded_file($imageFile['tmp_name'], "../" . $target_file)) {
        if ($resize) {
            echo "in here";
            resize_image("../" . $target_file, "../" . $target_file, $max_width, $max_height);
        }
        return $target_file;
    } else {
        throw new Exception("Failed to move the uploaded file.");
    }
}

function resize_image($source_path, $target_path, $max_width, $max_height)
{

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

    $source_image = create_image_from_type($type, $source_path);

    imagecopyresampled($new_image, $source_image, 0, 0, 0, 0, $new_width, $new_height, $original_width, $original_height);
    save_image_by_type($type, $new_image, $target_path);

    imagedestroy($new_image);
    imagedestroy($source_image);
}

function create_image_from_type($type, $source_path)
{
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

function save_image_by_type($type, $image, $target_path)
{
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

function validate_uploaded_image($temp_path, $new_path)
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

function validateDate($date, $format = 'Y-m-d')
{
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) === $date;
}

function validateString($value, $min = 1, $max = INF)
{
    $value = trim($value);
    return strlen($value) >= $min && strlen($value) <= $max;
}

?>