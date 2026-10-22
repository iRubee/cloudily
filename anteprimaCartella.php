<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./css/home.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
</head>
<body class="font">
    <h2 class="sottotitolo">DENTRO LA TUA CARTELLA...</h2>
    <section class="container">
        <?php
            require_once './config/config.php';
            require_once './config/verificaLogin.php';

            if(isset($_REQUEST['id']))
            {
                $id_cartella = $_REQUEST['id'];
                $query = "SELECT files. *, users.* FROM files INNER JOIN users ON users.ID_USER = files.id_user WHERE id_cartella = ?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("i", $id_cartella);
                $stmt->execute();
                $result = $stmt->get_result();
                while($row = $result->fetch_assoc())
                {
                    ?>
                        <div class="card" <?php echo 'title = "'.$row['nome_file'].'"' ?>>
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
                                <i class="material-symbols-outlined azioni" <?php echo 'onclick="menuFile(\''.$row['nome_file'].'\', \''.$row['ID_FILES'].'\', event)"';?>>more_vert</i>
                            </header>
                            <div class="card_body" <?php echo 'onclick="anteprima(\''.$row['nome_file'].'\')"'?>>
                                <?php
                                    if(str_ends_with($row['nome_file'], '.png') || str_ends_with($row['nome_file'], '.jpg'))
                                        echo '<img src="./files/'.$row['nome_file'].'">';
                                    else
                                        echo '<i class="material-symbols-outlined">draft</i>';
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
            <li class="nonElimina"><a href="" id="togli">Togli dalla cartella</a></li>
            <li class="elimina"><a id="elimina" href="">Elimina file</a></li>
        </ul>
    </div>
    <script src="./js/anteprima.js"></script>
    <script src="./js/menu.js"></script>
</body>
</html>