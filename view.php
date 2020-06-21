
<?php require_once('header.php'); ?>
      <h1> TuneShare</h1>
      <h2> Check Out The Music Shared By Our Community! </h2>
    <main>
    <?php
    try {
    //connect to our db 
    require_once('connect.php'); 

    //set up SQL statement 
    $sql = "SELECT * FROM songs;"; 

    //prepare the query 
    $statement = $db->prepare($sql);

    //execute 
    $statement->execute(); 

    //use fetchAll to store the results 
    $records = $statement->fetchAll(); 

    // echo out the top of the table 

    echo "<table class='table'><thead class='thead-dark'><th>First Name</th><th>Last Name</th><th>Genre</th><th>Location</th><th>Email</th><th>Age</th><th>Favourite Song</th><th> Delete</th><th> Edit </th></thead><tbody>";

    foreach ($records as $record) {
        echo "<tr><td>" . $record['first_name'] . "</td><td>" . $record['last_name'] . "</td><td>" . $record['genre'] . "</td><td>" . $record['location'] . "</td><td>" . $record['email'] . "</td><td>" . $record['age']. "</td><td>" . $record['favsong']. "<td><a href='delete.php?id=" . $record['user_id'] . "'> Delete </a></td><td><a href='index.php?id=" . $record['user_id'] . "'>Edit </a></td></tr>";
        }
     echo "</tbody></table>"; 

     $statement->closeCursor(); 
    }
    catch(PDOException $e) {
        $error_message = $e->getMessage(); 
        echo "<p> $error message </p>"; 
    }
    ?>
    </main>
    <?php require_once('footer.php'); ?>