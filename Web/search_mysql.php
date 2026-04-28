<?php
    $host = "localhost";
    $user = "root";
    $password = "root123";
    $dbname = "articles_96k_mysql";

    $results = "";

    try {
        $pdo = new PDO('mysql:host='.$host.';dbname='.$dbname, $user, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

        $articlePerPage = 50;
        $offset = ($page - 1) * $articlePerPage;

        if (isset($_GET['searchTerm'])){

            
            $searchTerm = $_GET['searchTerm'];
            
            /*LIKE-sökning*/
            // $getSearchTerm = "SELECT title, text, url, source FROM articles WHERE title LIKE :searchTerm OR text LIKE :searchTerm LIMIT $articlePerPage OFFSET $offset";
            // $searchTerm = "%" . $searchTerm . "%";

            /*Fulltext-sökning*/
            $getSearchTerm = "SELECT title, text, url, source  FROM articles 
            WHERE MATCH(title, text) AGAINST(:searchTerm IN NATURAL LANGUAGE MODE)
            LIMIT $articlePerPage OFFSET $offset";

            $stmt = $pdo->prepare($getSearchTerm);
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
    <link rel="stylesheet" href="stylesheet.css?">
    <title>Examensarbete</title>
</head>
<body>
    <h1>Article search - MySQL</h1>

    <div id='searchBox'>
        <form method="GET">
        <input type="text" name="searchTerm" placeholder="Search...">
        <button type="submit">Search</button>
    </form>
    </div>

    <div id="displayResults">
        <?php

            if ($results) {
                foreach ($results as $row) {
                    echo "<div class='articleDiv'>";
                    echo "<h3>" .
                    htmlspecialchars($row['title']) .
                    " - " .
                    "<a href='" . htmlspecialchars($row['url']) . "' target='_blank'>" .
                    htmlspecialchars($row['source']) .
                    "</a>" .
                    "</h3>";
                    // echo "<p>" . htmlspecialchars(substr($row['text'], 0, 500)) . "...</p>";
                    echo "<p>" . $row['text'] . "</p>";
                    echo "</div>";
                }
            } else {
                echo "No results found"; 
            }

            echo "<br>";
            echo "<div id='pagination'>";
                if(isset($searchTerm)){
                    if ($page > 1) {
                        echo "<a class='pageButton' href='?searchTerm=" . urlencode($searchTerm) . "&page=" . ($page - 1) . "'>Previous</a> ";
                    }

                    echo "<a class='pageButton' href='?searchTerm=" . urlencode($searchTerm) . "&page=" . ($page + 1) . "'>Next</a>";
                }
            echo "</div>";
        ?>
    </div>

</body>
</html>