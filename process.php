
<?php require_once('header.php'); ?>
      <h1> TuneShare - Share Your Fave Tunes & Join The Community </h1>
    <main>
<?php

$first_name = filter_input(INPUT_POST, 'fname'); 
$last_name = filter_input(INPUT_POST, 'lname'); 
$genre = filter_input(INPUT_POST, 'genre'); 
$location = filter_input(INPUT_POST, 'location'); 
$email = filter_input(INPUT_POST, 'email'); 
$fav_song = filter_input(INPUT_POST, 'favsong'); 
$age = filter_input(INPUT_POST, 'age'); 

$id = null; 
$id = filter_input(INPUT_POST, 'user_id'); 

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

        //if we have an id, that means we are updating 
        if(!empty($id)) {
            $sql = "UPDATE songs SET first_name = :firstname, last_name = :lastname, genre = :genre, location = :location, email = :email, age = :age, favsong = :favsong WHERE user_id = :user_id;"; 
        }
        else { //this is a new tune we are adding to our app 
            // set up an SQL command to save the info 
            $sql = "INSERT INTO songs (first_name, last_name, genre, location, email, age, favsong) VALUES (:firstname, :lastname, :genre, :location, :email, :age, :favsong)";
        }
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

        //if we are updating, bind :user_id 
        if(!empty($id)) {
            $statement->bindParam(':user_id', $id); 
        }

        // execute the insert
        $statement->execute();
        
        // show message
        echo "<p> Song added! Thanks for sharing! </p>";
        
        // disconnecting
        $statement->closeCursor();
        
    }
    catch (PDOException $e) {
        $error_message = $e->getMessage();
        //show error message to user
        echo "<p> Sorry! We weren't able to process your submission at this time. We've alerted our admins and will let you know when things are fixed! </p> ";
        echo $error_message;
        echo " $id $first_name $last_name $genre $location $email $age $fav_song";
        //email app admin with error
        mail('jessicagilfillan@gmail.com', 'TuneShare Error', 'Error :' . $error_message);
    }
}
?>
   <a href="index.php" class="error-btn"> Back to Form </a>
    </main>
    <?php require_once('footer.php'); ?>