<?php require_once('header.php'); ?>
      <h1> TuneShare</h1>
      <h2>Share Your Fave Tunes & Join The Community </h2>
    <?php
    //initialize variables 
    $id = null; 
    $firstname = null;
    $lastname = null; 
    $location = null; 
    $genre = null; 
    $age = null; 
    $email = null; 
    $favsong = null; 

    if(!empty($_GET['id']) && (is_numeric($_GET['id']))) {
      //grab the id from url
      $id = filter_input(INPUT_GET, 'id');
      //connect to the database 
      require_once('connect.php'); 
      //set up our query 
      $sql = "SELECT * FROM songs WHERE user_id = :user_id;"; 
      //prepare our statement
      $statement = $db->prepare($sql); 
      //bind 
      $statement->bindParam(':user_id', $id); 
      //execute 
      $statement->execute(); 
      //use fetchAll to store 
      $records = $statement->fetchAll(); 
      //to loop through, use a foreach loop 
      foreach($records as $record) : 
      $firstname = $record['first_name']; 
      $lastname = $record['last_name']; 
      $genre = $record['genre'];
      $age = $record['age'];  
      $location = $record['location']; 
      $email = $record['email']; 
      $favsong = $record['favsong']; 
      endforeach; 
      //close the db connection 
      $statement->closeCursor(); 
    }
    ?>
    <main>
      <p> Looking for new songs to add to your work at home playlist? Join our community and share with other music lovers! </p>
      <form action="process.php" method="post">
        <!-- add hidden input with user id if editing -->
        <input type="hidden" name="user_id" value="<?php echo $id;?>">
        <label for="fname"> Your First Name  </label>
        <input type="text" name="fname" class="form-control" id="fname" value="<?php echo $firstname; ?>">
        <label for="lname"> Your Last Name  </label>
        <input type="text" name="lname" class="form-control" id="lname" value="<?php echo $lastname; ?>">
        <label for="genre"> Your Favourite Genre  </label>
        <input type="text" name="genre" class="form-control" id="genre" value="<?php echo $genre; ?>">
        <label for="location"> Your Location </label>
        <input type="text" name="location" class="form-control" id="location" value="<?php echo $location; ?>">
        <label for="location"> Your Age </label>
        <input type="number" name="age" class="form-control" id="age" value="<?php echo $age; ?>">
        <label for="email"> Your Email </label>
        <input type="text" name="email" class="form-control" id="email" value="<?php echo $email; ?>">
        <label for="favsong"> What are you listening to on repeat?  </label>
        <input type="text" name="favsong" class="form-control" id="favsong" value="<?php echo $favsong;?>">
        <input type="submit" name="submit" value="Send & Share" class="btn">
      </form>
    </main>
<?php require_once('footer.php'); ?>