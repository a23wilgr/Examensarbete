<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="stylesheet.css">
    <title>Examensarbete</title>
</head>
<body>
    <h1>Article search</h1>

    <form action="search_mysql.php" method="GET">
        <input type="text" name="searchTerm" placeholder="Search...">
        <button type="submit">Search</button>
    </form>

    <div id="displayResults">
        <?php
            session_start();

            if (isset($_SESSION['results'])) {

                $results = $_SESSION['results'];

                if ($results) {
                    foreach ($results as $row) {
                        echo "<h3>" . $row['title'] . "</h3>";
                        echo "<p>" . $row['text'] . "</p>";
                    }
                } else {
                    echo "no results found"; 
                }
            }
        ?>
    </div>

</body>
</html>