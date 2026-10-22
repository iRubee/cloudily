<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anteprima</title>
    <style>
        body
        {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 97svh;
            background: gray;
        }
        iframe
        {
            width: 90%;
            height: 95%;
        }
    </style>
</head>
<body>
    <iframe src="<?php echo './files/'.$_REQUEST['nome']?>" frameborder="0"></iframe>
</body>
</html>