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
?>