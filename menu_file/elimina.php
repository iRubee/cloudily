<?php
    require_once '../config/config.php';
    require_once './verificaLogin.php';
    
    $file = $_REQUEST['id'];
    $query = "SELECT id_user FROM files WHERE ID_FILES = '$file'";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    if($row['id_user'] == $_SESSION['id'])
    {

        $query = "SELECT * FROM files WHERE ID_FILES = '$file'";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $nome = $row['nome_file'];
        $percorso = "../files/$nome";
        if(unlink($percorso))
        {
            $query = "DELETE FROM files WHERE ID_FILES = '$file'";
            $stmt = $conn->prepare($query);
            $stmt->execute();
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