<?php
    $host = "localhost";
    $user = "postgres";
    $password = "apollo";
    $dbname = "articles_32k_postgre";
    //$dbname = "articles_64k_postgre";
    //$dbname = "articles_96k_postgre";

    $results = "";
    
    try {
        $pdo = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //echo "Connection OK";

        if (isset($_GET['searchTerm'])){

            $searchTerm = $_GET['searchTerm'];

            //LIKE-sökning
            //$getSearchTerm = "SELECT * FROM articles WHERE title ILIKE :searchTerm OR text ILIKE :searchTerm";

            //Fulltextsökning
            // $getSearchTerm = "SELECT * FROM articles 
            WHERE to_tsvector('english', title || ' ' || text) @@ plainto_tsquery('english', :searchTerm)"; 

            $stmt = $pdo->prepare($getSearchTerm);

            $searchTerm = $searchTerm . "%";

            $stmt->bindParam(':searchTerm', $searchTerm);
            $stmt->execute();

            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    <link rel="stylesheet" href="stylesheet.css">
    <title>Examensarbete</title>
</head>
<body>
    <h1>Article search - PostgreSQL</h1>

    <form method="GET">
        <input type="text" name="searchTerm" placeholder="Search...">
        <button type="submit">Search</button>
    </form>

    <div id="displayResults">
        <?php
        
            if ($results) {
                foreach ($results as $row) {
                    echo "<h3>" . $row['title'] . "</h3>";
                    echo "<p>" . $row['text'] . "</p>";
                }
            } else {
                echo "no results found"; 
            }
        ?>
    </div>

</body>
</html>