<?php
require_once './config/config.php';
require_once  './config/verificaLogin.php';

?>
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
    <h2 class="sottotitolo">I FILE CHE CERCHI...</h2>
    <section class="container">
        <?php
        if ($_REQUEST['from'] == 0) {
            $query = "SELECT users.ID_USER, users.username, 'file' AS tipo, files.ID_FILES AS id, files.denominazione, files.nome_file AS nome, files.data_creazione, files.condivisione FROM users INNER JOIN files ON users.ID_USER = files.id_user WHERE id_cartella IS NULL UNION ALL SELECT  users.ID_USER, users.username, 'cartella' AS tipo, cartelle.ID_CARTELLA AS id, cartelle.denominazione, '' AS nome, cartelle.data_creazione, cartelle.condivisione FROM users INNER JOIN cartelle ON cartelle.id_user = users.ID_USER ORDER BY data_creazione ASC;";
            $stmt = $conn->prepare($query);
            $stmt->execute();
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) {
                if ($row['condivisione'] == 1 || ($row['condivisione'] == 0 && $row['ID_USER'] == $_SESSION['id'])) {
        ?>
                    <div class="card" <?php if ($row['tipo'] == 'file') echo 'title = "' . $row['nome'] . '"' ?>>
                        <header class="card_info">
                            <?php
                            if ($row['condivisione'] == 1) {
                                echo '<i class="material-symbols-outlined tipo">group</i>';
                            } else {
                                echo '<i class="material-symbols-outlined tipo">lock</i>';
                            }
                            ?>
                            <h4 class="nome_file"><?php echo $row['denominazione'] ?></h4>
                            <i class="material-symbols-outlined azioni"
                                <?php
                                if ($row['tipo'] == 'file')
                                    echo 'onclick="menuFile(\'' . $row['nome'] . '\', \'' . $row['id'] . '\', event)"';
                                else
                                    echo 'onclick="menuCartella(\'' . $row['id'] . '\', event)"';

                                ?>>more_vert</i>
                        </header>
                        <div class="card_body" <?php if ($row['tipo'] == 'file') echo 'ondblclick="anteprima(\'' . $row['nome'] . '\')"'; ?>>
                            <?php
                            if ($row['tipo'] == 'file') {
                                if (str_ends_with($row['nome'], '.png') || str_ends_with($row['nome'], '.jpg'))
                                    echo '<img src="./files/' . $row['nome'] . '">';
                                else
                                    echo '<i class="material-symbols-outlined">draft</i>';
                            } else {
                                echo '<i class="material-symbols-outlined" ondblclick="anteprimaCartella(\'' . $row['id'] . '\')">folder_open</i>';
                            }
                            ?>
                        </div>
                        <footer>
                            creato da
                            <?php
                            if ($row['ID_USER'] == $_SESSION['id'])
                                echo 'te';
                            else
                                echo $row['username'];
                            ?>
                        </footer>
                    </div>
                <?php
                }
            }
        }
        if ($_REQUEST['from'] == 1) {
            if ($_SESSION['id'] == 'guest') {
                print(
                    '  
                        <div style="width: 400px; display: flex; flex-direction: column; align-items: center; position: absolute; top: 50%; left: 50%; transform: translateY(-50%); transform: translateX(-50%); text-align: center;">
                            <h3>ISCRIVITI PER AVERE I TUOI FILE PRIVATI!</h3>
                            <a href="./admin/signup.php" target = "_blank" class="iscriviti">Iscriviti</a>
                        </div>
                        '
                );
            }
            $query = "SELECT users.ID_USER, files.* FROM files INNER JOIN users ON users.ID_USER = files.id_user";
            $stmt = $conn->prepare($query);
            $stmt->execute();
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) {
                if ($row['ID_USER'] == $_SESSION['id']) {
                ?>
                    <div class="card" <?php echo 'title = "' . $row['nome_file'] . '"' ?>>
                        <header class="card_info">
                            <?php
                            if ($row['condivisione'] == 1) {
                                echo '<i class="material-symbols-outlined tipo">group</i>';
                            } else {
                                echo '<i class="material-symbols-outlined tipo">lock</i>';
                            }
                            ?>
                            <h4 class="nome_file"><?php echo $row['denominazione'] ?></h4>
                            <i class="material-symbols-outlined azioni" <?php echo 'onclick="menuFile(\'' . $row['nome_file'] . '\', \'' . $row['ID_FILES'] . '\', event)"'; ?>>more_vert</i>
                        </header>
                        <div class="card_body" <?php echo 'ondblclick="anteprima(\'' . $row['nome_file'] . '\')"' ?>>
                            <?php
                            if (str_ends_with($row['nome_file'], '.png') || str_ends_with($row['nome_file'], '.jpg'))
                                echo '<img src="./files/' . $row['nome_file'] . '">';
                            else
                                echo '<i class="material-symbols-outlined">draft</i>';
                            ?>
                        </div>
                        <footer>
                            creato da te
                        </footer>
                    </div>
                <?php
                }
            }
        }
        if ($_REQUEST['from'] == 2) {
            $query = "SELECT users.ID_USER, users.username, cartelle.* FROM cartelle INNER JOIN users ON users.ID_USER = cartelle.id_user WHERE cartelle.condivisione = 1";
            $stmt = $conn->prepare($query);
            $stmt->execute();
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) {
                ?>
                <div class="card">
                    <header class="card_info">
                        <i class="material-symbols-outlined tipo">group</i>
                        <h4 class="nome_file"><?php echo $row['denominazione'] ?></h4>
                        <i class="material-symbols-outlined azioni" <?php echo 'onclick="menuCartella(\'' . $row['ID_CARTELLA'] . '\', event)"'; ?>>more_vert</i>
                    </header>
                    <div class="card_body">
                        <?php
                        echo '<i class="material-symbols-outlined" ondblclick="anteprimaCartella(\'' . $row['ID_CARTELLA'] . '\')">folder_open</i>';
                        ?>
                    </div>
                    <footer>
                        creato da
                        <?php
                        if ($row['ID_USER'] == $_SESSION['id'])
                            echo 'te';
                        else
                            echo $row['username'];
                        ?>
                    </footer>
                </div>
            <?php
            }
        }
        if ($_REQUEST['from'] == 3) {
            $query = "SELECT users.*, files.* FROM files INNER JOIN users ON users.ID_USER = files.id_user WHERE files.condivisione = 1";
            $stmt = $conn->prepare($query);
            $stmt->execute();
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) {
            ?>
                <div class="card" <?php echo 'title = "' . $row['nome_file'] . '"' ?>>
                    <header class="card_info">
                        <i class="material-symbols-outlined tipo">group</i>
                        <h4 class="nome_file"><?php echo $row['denominazione'] ?></h4>
                        <i class="material-symbols-outlined azioni" <?php echo 'onclick="menuFile(\'' . $row['nome_file'] . '\', \'' . $row['ID_FILES'] . '\', event)"'; ?>>more_vert</i>
                    </header>
                    <div class="card_body" <?php echo 'ondblclick="anteprima(\'' . $row['nome_file'] . '\')"' ?>>
                        <?php
                        if (str_ends_with($row['nome_file'], '.png') || str_ends_with($row['nome_file'], '.jpg'))
                            echo '<img src="./files/' . $row['nome_file'] . '">';
                        else
                            echo '<i class="material-symbols-outlined">draft</i>';
                        ?>
                    </div>
                    <footer>
                        creato da
                        <?php
                        if ($row['ID_USER'] == $_SESSION['id'])
                            echo 'te';
                        else
                            echo $row['username'];
                        ?>
                    </footer>
                </div>
                <?php
            }
        }
        if ($_REQUEST['from'] == 4) {
            if ($_SESSION['id'] == 'guest') {
                print(
                    '  
                        <div style="width: 400px; display: flex; flex-direction: column; align-items: center; position: absolute; top: 50%; left: 50%; transform: translateY(-50%); transform: translateX(-50%); text-align: center;">
                            <h3>ISCRIVITI PER AVERE LE TUE CARTELLE PRIVATE!</h3>
                            <a target = "_blank" href="./admin/signup.php" class="iscriviti">Iscriviti</a>
                        </div>
                        '
                );
            }
            $query = "SELECT users.ID_USER, users.username, cartelle.* FROM cartelle INNER JOIN users ON users.ID_USER = cartelle.id_user";
            $stmt = $conn->prepare($query);
            $stmt->execute();
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) {
                if ($_SESSION['id'] == $row['ID_USER']) {
                ?>
                    <div class="card">
                        <header class="card_info">
                            <?php
                            if ($row['condivisione'] == 1) {
                                echo '<i class="material-symbols-outlined tipo">group</i>';
                            } else {
                                echo '<i class="material-symbols-outlined tipo">lock</i>';
                            }
                            ?>
                            <h4 class="nome_file"><?php echo $row['denominazione'] ?></h4>
                            <i class="material-symbols-outlined azioni" <?php echo 'onclick="menuCartella(\'' . $row['ID_CARTELLA'] . '\', event)"'; ?>>more_vert</i>
                        </header>
                        <div class="card_body">
                            <i class="material-symbols-outlined" <?php echo 'ondblclick="anteprimaCartella(\'' . $row['ID_CARTELLA'] . '\')"' ?>>folder_open</i>
                        </div>
                        <footer>
                            creato da
                            <?php
                            if ($row['ID_USER'] == $_SESSION['id'])
                                echo 'te';
                            else
                                echo $row['username'];
                            ?>
                        </footer>
                    </div>
        <?php
                }
            }
        }
        ?>
    </section>
    <div id="menuFile" class=menu>
        <ul>
            <li class="nonElimina"><a id="sposta" href="">Sposta in una cartella</a></li>
            <li class="nonElimina"><a id="condividi" href="">Condividi file</a></li>
            <li class="nonElimina"><a id="privatizza" href="">Rendi privato</a></li>
            <li class="nonElimina"><a id="scarica" href="" download>Scarica</a></li>
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