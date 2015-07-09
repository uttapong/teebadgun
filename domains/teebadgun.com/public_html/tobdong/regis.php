
<!DOCTYPE html>
<html lang="en">
  <head>

<?php
  $servername = "localhost";
  $username = "teebadgu_db";
  $password = "lT0tCQbA";

  // Create connection
  $conn = new mysqli($servername, $username, $password,'teebadgu_db');

  // Check connection
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  } 

  if(isset($_GET['name'])){
    $q="insert into tobdong_member (name,color,rank,regis_time,fbid) values('{$_REQUEST['name']}','{$_REQUEST['color']}','{$_REQUEST['rank']}',now(),'{$_REQUEST['fbid']}');"; //some instruction
    //echo $q;
    $c=mysqli_query($conn,$q) or die(mysqli_error($DBlink)." Q=".$q);
  }
  //echo "Connected successfully";
?>


    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>แอพ จับสลากสี Tobdong 2014</title>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <!-- Bootstrap core CSS -->
   <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap-theme.min.css">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script> 

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
    .html{
    font-size: 80%;
    }
    </style>

   
  </head>

  <body>


    <div class="container">
      <div class="header">
        <nav>
          <ul class="nav nav-pills pull-right">
            <li role="presentation" class="active"><a href="#">Home</a></li>
            <li role="presentation"><a href="#">About</a></li>
            <li role="presentation"><a href="#">Contact</a></li>
          </ul>
        </nav>
        <h3 class="text-muted">ตบโด่งแบดมินตันแอพ</h3>
      </div>
      <?php
      $color=$_REQUEST['color'];
      if($color=='green')$color='เขียว';
      if($color=='blue')$color='ฟ้า';
      if($color=='yellow')$color='เหลือง';
      if($color=='pink')$color='ชมพู';

      ?>

      <div class="jumbotron">
        <h1>ขอแสดงความยินดีคุณได้อยู่สี : <?=$color;?></h1>
        
        <p>
        <a class="btn btn-lg btn-success" href="#" role="button"  onclick="window.location.href='index.php';">กลับหน้าแรก</a>
        </p>
      </div>

      <div class="color list">
        
      </div>

      <footer class="footer">
        <p>&copy; Company 2014</p>
      </footer>

    </div> <!-- /container -->




    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
