<?php
require_once './config/config.php';
require_once './config/verificaLogin.php';

if(isset($_REQUEST['nome']) && isset($_FILES['file']))
{
    $nome = $_REQUEST['nome'];
    $fileTemporaneo = $_FILES['file']['tmp_name'];
    $file = $_FILES['file']['name'];
    $percorso = './files/'. $file;
    $scelta = $_REQUEST['scelta'];

    if(move_uploaded_file($fileTemporaneo, $percorso))
    {
        $data = date("Y-m-d");
        $id_utente = (int)$_SESSION['id'];
        $query = "INSERT INTO files (denominazione, nome_file, id_user, data_creazione, condivisione) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssiss", $nome, $file, $id_utente, $data, $scelta);
        if($stmt->execute())
        {
            echo '<h2 style="position:absolute; top: 20px; left: 200px">operazione andata a buon fine</h2>';
        }
        else
        {
            echo '<h2 style="position:absolute; top: 20px; left: 200px">operazione non andata a buon fine</h2>';
        }
        $stmt->close();
        $conn->close();
    }
    else
    {
        echo '<h2 style="position:absolute; top: 20px; left: 200px">operazione non andata a buon fine</h2>';
    } 
}

if(isset($_REQUEST['cartella']))
{
    $cartella = $_REQUEST['cartella'];
    $scelta = $_REQUEST['scelta_cartella'];
    $data = date("Y-m-d");
    $id_utente = (int)$_SESSION['id'];

    $query = "INSERT INTO cartelle (denominazione, id_user, data_creazione, condivisione) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($query);

    $stmt->bind_param("siss", $cartella, $id_utente, $data, $scelta);
    if($stmt->execute())
    {
        echo '<h2 style="position:absolute; top: 20px; left: 200px">operazione andata a buon fine</h2>';
    }
    else
    {
        echo '<h2 style="position:absolute; top: 20px; left: 200px">operazione non andata a buon fine</h2>';
    }
    $stmt->close();
}

if(isset($_REQUEST['from']) && $_REQUEST['from'] == 0)
{
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/aggiungi.css">
    <title>Aggiungi un file</title>
</head>
<body class="font">
    <form action="" enctype="multipart/form-data" method="POST">
        <h1>Aggiungi un file</h1>
        
        <label for="nome">Nome file:</label>
        <input type="text" name="nome" placeholder="Inserisci il nome del file" required>
        
        <label for="file">File:</label>
        <input type="file" name="file" required>
        
        <label for="scelta">Vuoi condividere il file?</label>
        <select name="scelta" required>
            <option selected value="0">No</option>
            <option value="1">Sì</option>
        </select>
        
        <a href="./index.php">Torna alla pagina principale</a>

        <button type="submit">Inserisci file</button>
    </form>
</body>
</html>
<?php
}
else
{
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aggiungi una cartella</title>
    <link rel="stylesheet" href="./css/aggiungi.css">
</head>
<body class="font">
    <form action="" method="POST">
        <h1>Crea una cartella</h1>
        
        <label for="nome">Nome cartella:</label>
        <input type="text" name="cartella" placeholder="Inserisci il nome del file" required>
        
        <label for="scelta">Vuoi condividere il file?</label>
        <select name="scelta_cartella" required>
            <option selected value="0">No</option>
            <option value="1">Sì</option>
        </select>
        
        <a href="./index.php">Torna alla pagina principale</a>

        <button type="submit">Inserisci file</button>
    </form>
</body>
</html>
<?php
}
?>
