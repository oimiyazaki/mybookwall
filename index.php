<?php 
    // Start session
    session_start();

  // function, actions, header
  include ("functions.php");
  include ("actions.php");  
  // include("functionsJs.php");
  include ("views/header.php");


  // If a session exist, redirect to sign up/ log in page
  if (array_key_exists("username", $_SESSION)) {

    // if p is set
    if (isset($_GET["p"])) {

      // if add a book page
      if ($_GET["p"] == "addabook") {

        include ("views/add-a-book.php");

      // if p is anything else, go to hompage
      } else {

        include ("views/home.php");

      }

    } else {

      include ("views/home.php");

    }

  } else {

    include ("views/loginSignup.php");

  }

  // footer
  include ("views/footer.php");


  

    ?>

