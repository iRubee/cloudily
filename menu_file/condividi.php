<?php
    require_once '../config/config.php';
    require_once './verificaLogin.php';
    
    if(isset($_REQUEST['id'])) {
        $query = "SELECT condivisione, id_user FROM files WHERE ID_FILES = ".$_REQUEST['id'];
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        if($row['condivisione'] == 0 && $row['id_user'] == $_SESSION['id']) 
        {
            $row['condivisione'] = 1;
            $query = "UPDATE files SET condivisione = ".$row['condivisione']." WHERE ID_FILES = ".$_REQUEST['id'];
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
    $stmt->close();
    $conn->close();
?>