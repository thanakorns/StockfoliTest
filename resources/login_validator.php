<?php
  $passErr = $emailErr = "";
  $email = $password = "";

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
     if (empty($_POST["email"])) {
       $emailErr = "Email is required";
     } 
     else {
          $email = test_input($_POST["email"]);
          if (!preg_match("/^[a-zA-Z ]*$/",$email)) {
              $emailErr = "Only letters and white space allowed"; 
          }
      }
     
      if (empty($_POST["password"])) {
          $passErr = "Password is required";
      } 
      else {
          $password = test_input($_POST["password"]);
      }

  }

  function test_input($data) {
     $data = trim($data);
     $data = stripslashes($data);
     $data = htmlspecialchars($data);
     return $data;
  }