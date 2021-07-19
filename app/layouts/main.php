<!DOCTYPE html>
<html lang="en">

<head>
  <title>Questions And Answers</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="<?php echo _PUBLIC ?>/css/LoginSignup.css">
  <link rel="stylesheet" type="text/css" href="<?php echo _WEB_ROOT ?>/css/style.css">
</head>

<body>
  <?php
  require_once("./app/views/header-footer/header.phtml");
  require_once   "./app/views/" . $data["View"] . ".php";
  require_once("./app/views/header-footer/footer.phtml");
  ?>

</body>

</html>