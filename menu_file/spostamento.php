<?php
    require_once '../config/config.php';
    $file = $_REQUEST['id'];
    if(isset($_REQUEST['id_cartella'])) 
    {
        $id_cartella = $_REQUEST['id_cartella'];
        $query = "UPDATE files SET id_cartella = ? WHERE ID_FILES = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ii", $id_cartella, $file);
        $stmt->execute();
        header('Location: '. $_SERVER['HTTP_REFERER']);
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scegli una cartella</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="../css/variables.css">
    <style>
        body {
            margin: 0px 10px 10px 10px;
        }
        h2 {
            color: var(--primario);
            margin-bottom: 35px;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            font-size: 1.3rem;
        }
        th {
            padding: 50px 50px 0px 50px;
            margin-bottom: 50px;
            border-bottom: 1px solid var(--terziario);
            text-align: center;
        }
        td {
            text-align: center;
            padding-top: 25px;
        }
        a {
            color: var(--secondario);
            background: var(--primario);
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            cursor: pointer;
            text-decoration: none;
        }
    </style>
</head>
<body class="font">
    <h2>SCEGLI UNA CARTELLA</h2>
    <?php
        $query = "SELECT denominazione, ID_CARTELLA, users.ID_USER, condivisione FROM cartelle INNER JOIN users ON cartelle.id_user = users.ID_USER";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        $i = 0;
    ?>
    <table cellspacing="0">
        <tr>
            <th>#</th>
            <th>Denominazione</th>
            <th>Scelta</th>
        </tr>
    <?php

        while($row = $result->fetch_assoc()) {
            $query = "SELECT condivisione FROM files WHERE ID_FILES = $file";
            $stmt = $conn->prepare($query);
            $stmt->execute();
            $result2 = $stmt->get_result();
            $row2 = $result2->fetch_assoc();
            $condivisione_file = $row2['condivisione'];
            $file = $_REQUEST['id'];
            $nome = $row['denominazione'];
            $id_cartella = $row['ID_CARTELLA'];
            $condivisione_cartella = $row['condivisione'];
            if($condivisione_cartella == $condivisione_file)
            {
                $i++;
                echo 
                "<tr>
                    <td>$i</td>
                    <td>$nome</td>
                    <td><a href='?id_cartella=$id_cartella&id=$file'>Sposta</a></td>
                </tr>";

            }

        }
    ?>
    </table>
</body>
</html>