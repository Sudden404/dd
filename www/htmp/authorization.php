<?php
    include("path.php");
    include("app/controllers/users.php");
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Bootstrap demo</title>
  <!--    bootstrap CSS-->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
  <!--    Front Awesome-->
  <script src="https://kit.fontawesome.com/16953c2eae.js" crossorigin="anonymous"></script>

  <!--    Custom Styling-->
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>

<?php include("app/include/header.php"); ?>

<div class="container reg_form">
  <form class="row justify-content-md-center" method="post" action="authorization.php">
    <h2>Authorization form</h2>
      <div class="mb-3 col-12 col-md-4 err">
          <p><?=$errMsg?></p>
      </div>
      <div class="w-100"></div>
    <div class="mb-3 col-12 col-md-4">
      <label for="exampleInputLogin" class="form-label">Login</label>
      <input name ="login" value="<?=$login?>" type="text" class="form-control" id="exampleInputLogin">
    </div>
    <div class="w-100"></div>
    <div class="mb-3 col-12 col-md-4">
      <label for="exampleInputPassword1" class="form-label">Password</label>
      <input name ="password" type="password" class="form-control" id="exampleInputPassword1">
    </div>
    <div class="w-100"></div>
    <div class="w-100"></div>
    <div class="mb-3 col-12 col-md-4">
      <button type="submit" class="btn btn-primary" name ="log-button" >Sing in</button>
      <a href="registration.php">Create Account</a>
    </div>
  </form>
</div>

</body>
</html>
