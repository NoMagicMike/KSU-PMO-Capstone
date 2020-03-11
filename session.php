<?php
   include('pmo_functions.php');
   session_start();
   //grabbing username
   $user_check = $_SESSION['login_user'];
   $ses_sql = mysqli_query($db,"select username from admin where username = '$user_check' ");
   $row = mysqli_fetch_array($ses_sql,MYSQLI_ASSOC);
   $login_session = $row['username'];

   $adminQuery = mysqli_query($db, "SELECT user_admin FROM users WHERE username = '$username'");
   $row2 = mysqli_fetch_array($adminQuery,MYSQLI_ASSOC);
   $login_session = $row2['user_admin'];

   $_SESSION["secretword"] = "ABC123" ;
   $_SESSION["theme"] = "purple" ;
   $login_session = "yeehaw";
   // $adminCheck = $row['user_admin'];
   // $_SESSION["Test1"] = "Test";
   // $_SESSION["Test2"] = $row['user_admin'];

   if(!isset($_SESSION['login_user'])){
      header("location:login.php");
      die();
   }
?>
