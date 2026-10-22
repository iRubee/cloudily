<?php
    require_once '../config/config.php';
    require_once './verificaLogin.php';

    if(isset($_REQUEST['id']))
    {
        $file = $_REQUEST['id'];
        $query = "SELECT id_user FROM files WHERE ID_FILES = '$file'";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        if($row['id_user'] == $_SESSION['id'])
        {
            $query = "UPDATE files SET id_cartella = NULL WHERE id_user = ".$row['id_user'];
            $stmt = $conn->prepare($query);
            $stmt->execute();
            $stmt->close();
            header('Location: '. $_SERVER['HTTP_REFERER']);
            exit();
        }
        else
        {
            header('Location: '. $_SERVER['HTTP_REFERER']);
            exit();
        }
    }
    else
    {
        header('Location: '. $_SERVER['HTTP_REFERER']);
        exit();
    }
?>