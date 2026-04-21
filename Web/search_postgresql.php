<?php
    $host = "localhost";
    $dbname = "articles_32k_postgre";
    $user = "postgres";
    $password = "apollo";
    
    try {
        $pdo = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //echo "Connection OK";

        $searchTerm = $_GET['searchTerm'];

        //LIKE-sökning
        $getSearchTerm = "SELECT * FROM articles WHERE title ILIKE :searchTerm OR text LIKE :searchTerm";

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