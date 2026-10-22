<?php
    require_once '../config/config.php';
    require_once './verificaLogin.php';

    if(isset($_REQUEST['id'])) {
        $query = "SELECT condivisione FROM cartelle WHERE ID_CARTELLA = ".$_REQUEST['id'];
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        if($row['condivisione'] == 1) 
        {
            $row['condivisione'] = 0;
            $query = "UPDATE cartelle SET condivisione = ".$row['condivisione']." WHERE ID_CARTELLA = ".$_REQUEST['id'];
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