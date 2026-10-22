<?php
    require_once '../config/config.php';
    require_once './verificaLogin.php';

    if(isset($_REQUEST['id']))
    {
        $query = "SELECT condivisione FROM cartelle WHERE ID_CARTELLA = ".$_REQUEST['id'];
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        
        $query = "UPDATE files SET id_cartella = NULL WHERE id_cartella = ".$_REQUEST['id'];
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $stmt->close();
        
        $query = "DELETE FROM cartelle WHERE ID_CARTELLA = ".$_REQUEST['id'];
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $stmt->close();
        $conn->close();
       
        header('Location: '. $_SERVER['HTTP_REFERER']);
    }
?>