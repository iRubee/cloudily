<?php
    session_start();
    require_once  './config/verificaLogin.php';

?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/index.css">
    <title>Home - Cloudily</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
</head>
<body class="font">
    <header>
        <div class="logo">
            <h1>CLOUDILY</h1>
        </div>
        <div class="search">
            <input type="text" placeholder="Cerca..." id="cerca" class="search-bar">
            <button class="material-symbols-outlined search-button" id="search-button">search</button>
        </div>
        <div id="profile">
            <img src="./images/profile.svg" alt="profile">
        </div>
    </header>
    
    <div class="search_mobile">
            <input type="text" placeholder="Cerca..." id="cerca1" class="search-bar">
            <button class="material-symbols-outlined search-button" id="search-button1">search</button>
    </div>

    <div class="pagina">
        <aside>
            <img src="./images/allinea.svg" id="espansione">
            <ul>
                <li class="active disactive1" onclick="attiva(1)"><a href="./home.php?from=0" target="iframe"><i class="material-symbols-outlined" style="font-size: 2rem;">home</i><p>Home</p></li></a>
                <li class="disactive2"><a href="./home.php?from=1" onclick="attiva(2)" target="iframe"><i class="material-symbols-outlined" style="font-size: 2rem;">description</i><p>I tuoi file</p></li></a>
                <li class="disactive3"><a href="./home.php?from=2" onclick="attiva(3)" target="iframe"><i class="material-symbols-outlined" style="font-size: 2rem;">folder_shared</i><p>Cartelle condivise</p></li></a>
                <li class="disactive4"><a href="./home.php?from=3" onclick="attiva(4)" target="iframe"><i class="material-symbols-outlined" style="font-size: 2rem;">public</i><p>File condivisi</p></li></a>
                <li class="disactive5"><a href="./home.php?from=4" onclick="attiva(5)" target="iframe"><i class="material-symbols-outlined" style="font-size: 2rem;">folder_open</i><p>Le tue Cartelle</p></li></a>
            </ul>
        </aside>
        <main>
            <iframe src="./home.php?from=0" frameborder="0" name="iframe" id="iframe"></iframe>
        </main>
    </div>
    <?php
        if($_SESSION['id'] != 'guest')
        {
    ?> 

        <button class="aggiungi material-symbols-outlined" id="note">note_add</button>
        <button class="aggiungi material-symbols-outlined" id="folder">create_new_folder</button>
        <button class="aggiungi" id="add">+</button>
    <?php } ?>
    <script src="./js/navbar.js"></script>
    <script src="./js/add_button.js"></script>
    <script src="./js/searchbar.js"></script>
</body>
</html>