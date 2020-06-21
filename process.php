
<!DOCTYPE html>
<html lang="en"> 
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>COMP1006 - Week 4 - Let's Connect </title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Piedra&family=Quicksand&display=swap" rel="stylesheet">
    <!-- Compiled and minified JavaScript -->
    <link href="main.css" rel="stylesheet">
  </head>
  <body>
    <div class="container">
    <header>
      <h1> TuneShare - Share Your Fave Tunes & Join The Community </h1>
    </header>
    <main>
        <?php

//create variables to store form data
$first_name = filter_input(INPUT_POST, 'fname');
$last_name = filter_input(INPUT_POST, 'lname');
$genre = filter_input(INPUT_POST, 'genre');
$location = filter_input(INPUT_POST, 'location');
$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
$age = filter_input(INPUT_POST, 'age', FILTER_VALIDATE_INT);
$fav_song = filter_input(INPUT_POST, 'favsong');

//set up a flag variable

$ok = true;


//validate
// first name and last name not empty

if (empty($first_name) || empty($last_name)) {
    echo "<p class='error'>Please provide both first and last name! </p>";
    $ok = false;
}

//genre not empty
if (empty($genre)) {
    echo "<p class='error'>Please provide your favourite genre!</p>";
    $ok = false;
}

//location not empty
if (empty($location)) {
    echo "<p class='error'>Please tell us where you are located!!</p>";
    $ok = false;
}

//fav song not empty
if (empty($fav_song)) {
    echo "<p class='error'>Please tell us what you are listening to!</p>";
    $ok = false;
}

//email not empty and proper format
if (empty($email) || $email === false) {
    echo "<p class='error'>Please include your email in the proper format!</p>";
    $ok = false;
}

//age not empty and proper format
if (empty($age) || $age === false) {
    echo "<p class='error'>Please tell us how old you are! Numbers only!</p>";
    $ok = false;
}

//if form validates, try to connect to database and add info

if ($ok === true) {
    try {

        // connecting to the database
        require_once('connect.php');

        // set up an SQL command to save the info 
        $sql = "INSERT INTO songs (first_name, last_name, genre, location, email, age, favsong) VALUES (:firstname, :lastname, :genre, :location, :email, :age, :favsong)";
        
       /*$first_name_escape = $db->quote($first_name);
      $last_name_escape = $db->quote($last_name);
      $genre_escape = $db->quote($genre);
      $email_escape = $db->quote($email);

$location_escape = $db->quote($location);
$age_escape = $db->quote($age);
$fav_song_escape = $db->quote($fav_song);*/




        //$sql = "INSERT INTO songs (first_name, last_name, genre, location, email, age, favsong) VALUES ($first_name_escape, $last_name_escape, $genre_escape, $location_escape, $email_escape, $age_escape, $fav_song_escape);";


        // Call the prepare method of the PDO object to prepare the query and return a PDOstatement object
        $statement = $db->prepare($sql);

        //fill the placeholders with the 8 input variables using bindParam method 
        $statement->bindParam(':firstname', $first_name);
        $statement->bindParam(':lastname', $last_name);
        $statement->bindParam(':genre', $genre);
        $statement->bindParam(':location', $location);
        $statement->bindParam(':email', $email);
        $statement->bindParam(':age', $age);
        $statement->bindParam(':favsong', $fav_song); 

        // execute the insert
        $statement->execute();

        //dynamic statement
        //$add_data = $db->exec($sql); 

        // show message
        echo "<p> Song added! Thanks for sharing! </p>";

        // disconnecting
       $statement -> closeCursor();
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        //show error message to user
        echo "<p> Sorry! We weren't able to process your submission at this time. We've alerted our admins and will let you know when things are fixed! </p> ";
        echo $error_message;
        //email app admin with error
        mail('jessicagilfillan@gmail.com', 'TuneShare Error', 'Error :'. $error_message);
    }
}
?>
    <a href="index.php" class="error-btn"> Back to Form </a>
    </main>
    <footer>
      <p> &copy; 2020 TuneShare </p>
    </footer>
   </div><!--end container-->
  </body>
</html>