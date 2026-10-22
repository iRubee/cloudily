<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Risultati della tua ricerca</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="./css/home.css">
</head>
<body class="font">
    <h2 class="sottotitolo">RISULTATI</h2>
    <section class="container">
    <?php
        require_once './config/config.php';
        require_once './config/verificaLogin.php';
        $ricerca = $_REQUEST['search'];
        $query = "SELECT users.ID_USER, users.username, 'file' AS tipo, files.ID_FILES AS id, files.denominazione, files.nome_file AS nome, files.data_creazione, files.condivisione FROM users INNER JOIN files ON users.ID_USER = files.id_user UNION ALL SELECT  users.ID_USER, users.username, 'cartella' AS tipo, cartelle.ID_CARTELLA AS id, cartelle.denominazione, '' AS nome, cartelle.data_creazione, cartelle.condivisione FROM users INNER JOIN cartelle ON cartelle.id_user = users.ID_USER ORDER BY data_creazione ASC;";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        while($row = $result->fetch_assoc())
        {
            if(($row['condivisione'] == 1 || ($row['condivisione'] == 0 && $row['ID_USER'] == $_SESSION['id'])) && (str_contains(strtolower($row['denominazione']),strtolower($ricerca))))
            {
            ?>
                <div class="card" <?php if($row['tipo'] == 'file') echo 'title = "'.$row['nome'].'"'?>>
                    <header class="card_info">
                        <?php
                            if($row['condivisione'] == 1)
                            {
                                echo '<i class="material-symbols-outlined tipo">group</i>';
                            }
                            else
                            {
                                echo '<i class="material-symbols-outlined tipo">lock</i>';
                            }
                        ?>
                        <h4 class="nome_file"><?php echo $row['denominazione']?></h4>
                        <i class="material-symbols-outlined azioni" 
                        <?php 
                            if($row['tipo'] == 'file') 
                                echo 'onclick="menuFile(\''.$row['nome'].'\', \''.$row['id'].'\', event)"';
                            else 
                                echo 'onclick="menuCartella(\''.$row['id'].'\', event)"';
                            
                        ?>>more_vert</i>
                    </header>
                    <div class="card_body" <?php if($row['tipo'] == 'file') echo 'ondblclick="anteprima(\''.$row['nome'].'\')"';?>>
                        <?php
                            if($row['tipo'] == 'file')
                            {
                                if(str_ends_with($row['nome'], '.png') || str_ends_with($row['nome'], '.jpg'))
                                    echo '<img src="./files/'.$row['nome'].'">';
                                else
                                    echo '<i class="material-symbols-outlined">draft</i>';
                            }
                            else
                            {
                                echo '<i class="material-symbols-outlined" ondblclick="anteprimaCartella(\''.$row['id'].'\')">folder_open</i>';
                            }
                        ?>
                    </div>
                    <footer>
                        creato da
                       <?php 
                            if($row['ID_USER'] == $_SESSION['id']) 
                                echo 'te';
                            else
                                echo $row['username'];
                        ?>
                    </footer>
                </div>
            <?php
            }
        }
    ?>
    </section>
    <div id="menuFile" class=menu>
        <ul>
            <li class="nonElimina"><a id="sposta" href="" >Sposta in una cartella</a></li>
            <li class="nonElimina"><a id="condividi" href="">Condividi file</a></li>
            <li class="nonElimina"><a id="privatizza" href="">Rendi privato</a></li>
            <li class="nonElimina"><a href="" id="scarica" download>Scarica</a></li>
            <li class="elimina"><a id="elimina" href="">Elimina file</a></li>
        </ul>
    </div>
    <div id="menuCartella" class=menu>
        <ul>
            <li class="nonElimina"><a id="condividi1" href="">Condividi cartella</a></li>
            <li class="nonElimina"><a id="privatizza1" href="">Rendi privata</a></li>
            <li class="elimina"><a id="elimina1" href="">Elimina Cartella</a></li>
        </ul>
    </div>
    <script src="./js/anteprima.js"></script>
    <script class="pc" src="./js/menu.js"></script>
</body>
</html>