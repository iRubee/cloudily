<?php
    session_abort();
    require_once '../config/config.php'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - cloudily</title>
    <style>
        @import url(../css/variables.css);
        body
        {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }
        form
        {
            display: flex;
            flex-direction: column;
            background: var(--secondario);
            width: 30%;
            border-radius: 20px;
            padding: 20px;
            box-shadow: 20px 20px 15px -3px rgba(0,0,0,0.1);
        }
        h1
        {
            color: var(--primario);
            margin-bottom: 30px;
            text-align: center;
        }
        button
        {
            color: var(--secondario);
            background: var(--primario);
            border: none;
            font-size: 1.3rem;
            width: 150px;
            height: 35px;
            border-radius: 5px;
            margin-top: 10px;
            cursor: pointer;
        }
        input
        {
            margin: 5px 0px 20px 0px;
            height: 30px;
            border: none;
            border-bottom: 2px solid var(--primario);
            outline: none;

        }
        a
        {
            text-decoration: none;
            color: var(--primario);
            
        }
        a:hover
        {
            text-decoration: underline;
        }
        @media (max-width: 779px) {
            form
            {
                width: 80%;
            }
        }
    </style>
</head>
<body class="font">
    <?php
        
        if(isset($_REQUEST['password'])) 
        {
            $nome = $_REQUEST['nome'];
            $cognome = $_REQUEST['cognome'];
            $email = $_REQUEST['email'];
            $username = $_REQUEST['username'];
            $password = $_REQUEST['password'];
            $confermaPassword = $_REQUEST['conferma_password'];

            if($password == $confermaPassword) 
            {
                $passwordCriptata = password_hash($password, PASSWORD_DEFAULT);
                $ruolo_user = 1;
                $query = "INSERT INTO users (username, psw, ruolo_user, nome, cognome, email) VALUES (?,?,?,?,?,?)";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("ssdsss", $username, $passwordCriptata, $ruolo_user, $nome, $cognome, $email);
                $stmt->execute();
                $stmt->close();
                $conn->close();
                header("Location: ./index.php");
            } 
            else 
            {
                echo "Le password non sono uguali";
            }
        }
    ?>

    <form action="" method="post">
        <h1>SIGNUP</h1>

        <label for="nome">Nome:</label>
        <input type="text" name="nome" placeholder="inserisci il tuo nome" required>

        <label for="cognome">Cognome:</label>
        <input type="text" name="cognome" placeholder="inserisci il tuo congnome" required>
        
        <label for="email">Email:</label>
        <input type="email" name="email" placeholder="inserisci la tua email" required>
        
        <label for="username">Username:</label>
        <input type="text" name="username" placeholder="inserisci uno username" required>
        
        <label for="username">Password:</label>
        <input type="password" name="password" placeholder="crea una password" required>
        
        <label for="username">Conferma password:</label>
        <input type="password" name="conferma_password" placeholder="inserisci la password" required>
        
        <p>Sei già iscritto? <span><a href="./">Accedi!</a></span></p>
        
        <button type="submit">Registrati</button>
    </form>

</body>
</html>