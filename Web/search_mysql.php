<?php
    $servername = "localhost";
    $username = "root";
    $password = "root123";
    $db_name = "articles_32k_mysql";

    try {
        $pdo = new PDO('mysql:host='.$servername.';dbname='.$db_name, $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //echo "Connection OK";

        $searchTerm = $_GET['searchTerm'];
        
        /*LIKE-sökning*/
        //$getSearchTerm = "SELECT * FROM articles WHERE title LIKE :searchTerm OR text LIKE :searchTerm";

        /*Fulltext-sökning*/
        $getSearchTerm = "SELECT * FROM articles WHERE MATCH(title, text) AGAINST(:searchTerm IN BOOLEAN MODE)";

        $stmt = $pdo->prepare($getSearchTerm);

        $searchTerm = $searchTerm . "%";

        $stmt->bindParam(':searchTerm', $searchTerm);
        $stmt->execute();

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        /*Skickar vidare resultaten till index.php - sidan med sökruta samt resultat*/
        session_start();

        $_SESSION['results'] = $results;
        header("Location: index.php");
        exit;

    }
    catch(PDOException $error) {
        echo "Connection failed: " . $error->getMessage();
    }
?>