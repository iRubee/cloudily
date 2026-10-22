<?php
    if(empty($_SESSION['id']))
    {
        header("Location:../admin/index.php");
    }
?>