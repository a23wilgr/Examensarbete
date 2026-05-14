<?php
    $host = "localhost";
    $user = "postgres";
    $password = "apollo";
    //$dbname = "articles_32k_postgre";
    //$dbname = "articles_64k_postgre";
    $dbname = "articles_96k_postgre";

    $results = "0";
    
    try {
        $pdo = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //echo "Connection OK";

        if (isset($_GET['searchTerm'])){

            $searchTerm = $_GET['searchTerm'];

            //LIKE-sökning
            // $getSearchTerm = "SELECT COUNT(*) FROM articles WHERE title ILIKE :searchTerm OR text ILIKE :searchTerm";
            // $searchTerm = "%" . $searchTerm . "%";

            //Fulltextsökning
            $getSearchTerm = "SELECT COUNT(*) FROM articles WHERE search_vector @@ plainto_tsquery('english', :searchTerm)"; 

            $stmt = $pdo->prepare($getSearchTerm);

            $stmt->bindParam(':searchTerm', $searchTerm);
            $stmt->execute();

            $results = $stmt->fetchColumn();
            
            // Small: “income”, “animal”, “machine”
            // Medium: “security”, “education”, “author”
            // Large: "health", “company”, “state”

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
    <link rel="stylesheet" href="stylesheet.css?1">
    <title>Examensarbete</title>
</head>
<body>
    <h1>Article search - PostgreSQL</h1>

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