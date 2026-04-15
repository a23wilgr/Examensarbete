<?php
    $servername = "localhost";
    $username = "root";
    $password = "root123";
    $db_name = "articles_32k_mysql";

    try {
        $pdo = new PDO('mysql:host='.$servername.';dbname='.$db_name, $username, $password);

        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        echo "Connection OK";

    }
    catch(PDOException $error) {
        echo "Connection failed: " . $error->getMessage();
    }
?>