<?php 
    session_abort();
    require_once '../config/config.php'
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
            margin-top: 20px;
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
        .links
        {
            width: 100%;
            font-size: 0.8rem;
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
            
                $username = $_REQUEST['username'];
                $password = $_REQUEST['password'];
                
                $query = "SELECT username, psw, ID_USER FROM users WHERE username = ?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("s", $username);
                $stmt->execute();
                $result = $stmt->get_result();
                
                if($result->num_rows == 1) {
                    $row = $result->fetch_assoc();
                    if(password_verify($password, $row['psw'])) 
                    {
                        $_SESSION['id'] = $row['ID_USER'];
                        header("Location: ../index.php");
                        exit(); 
                    } 
                    else 
                    {
                        echo "Password errata";
                    }
                } 
                else  
                {
                    echo "Utente non trovato";
                }
            
        }
    ?>
    <form action="" method="post">
        <h1>LOGIN</h1>
        
        <label for="username">Username:</label>
        <input type="text" name="username" placeholder="inserisci il tuo username" required>
        
        <label for="username">Password:</label>
        <input type="password" name="password" placeholder="inserisci la password" required style="margin-bottom: 10px;">
        <div class="links">
            <span>
                <a href="./ceazioneGuest.php">Entra come Guest</a>
            </span>
            <span>o</span>
            <span>
                <a href="./signup.php">Registrati ora!</a>
            </span>
            
        </div>  
        <button type="submit">Login</button>
    </form>

</body>
</html>