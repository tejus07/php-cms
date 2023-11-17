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
?>