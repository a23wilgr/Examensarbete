<?php
    $host = "localhost";
    $user = "root";
    $password = "root123";
    //$dbname = "articles_32k_mysql";
    //$dbname = "articles_64k_mysql";
    $dbname = "articles_96k_mysql";

    $results = "0";

    try {
        $pdo = new PDO('mysql:host='.$host.';dbname='.$dbname, $user, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if (isset($_GET['searchTerm'])){

            $searchTerm = $_GET['searchTerm'];
            
            /*LIKE-sökning*/
            // $getSearchTerm = "SELECT COUNT(*) FROM articles WHERE title LIKE :searchTerm OR text LIKE :searchTerm";
            // $searchTerm = "%" . $searchTerm . "%";

            /*Fulltext-sökning*/
            $getSearchTerm = "SELECT COUNT(*) FROM articles WHERE MATCH(title, text) AGAINST(:searchTerm IN NATURAL LANGUAGE MODE)";

            $stmt = $pdo->prepare($getSearchTerm);


            $stmt->bindParam(':searchTerm', $searchTerm);
            $stmt->execute();

            $results = $stmt->fetchColumn();
        }
    }
    
    catch(PDOException $error) {
        echo "Connection failed: " . $error->getMessage();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="stylesheet.css?v1">
    <title>Examensarbete</title>
</head>
<body>
    <h1>Article search - MySQL</h1>

    <div id="searchBox">
        <form method="GET">
            <input type="text" name="searchTerm" placeholder="Search...">
            <button type="submit">Search</button>
        </form>
    </div>

    <div id="displayResults"> 
        <h3>
            Number of results:
        </h3>
    </div>

    <div id="countResults">
        <?php 
            echo ($results)
        ?> 
    </div>

</body>
</html>