<?php
    session_start();
    $_SESSION['id'] = 'guest';
    header('Location: ../index.php');
?>