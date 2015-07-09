
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

<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
    .html{
    font-size: 80%;
    }
    .color{
      border-radius: 5px;
      padding: 15px;
      color: #fff;
    }
    .userblock{
    	float: left;
    	width: 98%;
    	margin-top: 8px;
    	font-size: 12px !important;
    }
    </style>

    <script>
    var currentrank='p';
      window.fbAsyncInit = function() {
        FB.init({
          appId      : '612396988819496',
          xfbml      : true,
          version    : 'v2.1'
        });
      };

      (function(d, s, id){
         var js, fjs = d.getElementsByTagName(s)[0];
         if (d.getElementById(id)) {return;}
         js = d.createElement(s); js.id = id;
         js.src = "//connect.facebook.net/en_US/sdk.js";
         fjs.parentNode.insertBefore(js, fjs);
       }(document, 'script', 'facebook-jssdk'));

  <?php

$q="select count(id) as avai_c from tobdong_member where color='green' and rank='c';"; //some instruction
$c=mysqli_query($conn,$q) or die(mysqli_error($DBlink)." Q=".$q);
$r=$c->fetch_row();
$c_green=$r[0];
$q="select count(id) as avai_c from tobdong_member where color='blue' and rank='c';"; //some instruction
$c=mysqli_query($conn,$q) or die(mysqli_error($DBlink)." Q=".$q);
$r=$c->fetch_row();
$c_blue=$r[0];
$q="select count(id) as avai_c from tobdong_member where color='pink' and rank='c';"; //some instruction
$c=mysqli_query($conn,$q) or die(mysqli_error($DBlink)." Q=".$q);
$r=$c->fetch_row();
$c_pink=$r[0];
$q="select count(id) as avai_c from tobdong_member where color='yellow' and rank='c';"; //some instruction
$c=mysqli_query($conn,$q) or die(mysqli_error($DBlink)." Q=".$q);
$r=$c->fetch_row();
$c_yellow=$r[0];


$q="select count(id) as avai_c from tobdong_member where color='green' and rank='p';"; //some instruction
$c=mysqli_query($conn,$q) or die(mysqli_error($DBlink)." Q=".$q);
$r=$c->fetch_row();
$p_green=$r[0];
$q="select count(id) as avai_c from tobdong_member where color='blue' and rank='p';"; //some instruction
$c=mysqli_query($conn,$q) or die(mysqli_error($DBlink)." Q=".$q);
$r=$c->fetch_row();
$p_blue=$r[0];
$q="select count(id) as avai_c from tobdong_member where color='pink' and rank='p';"; //some instruction
$c=mysqli_query($conn,$q) or die(mysqli_error($DBlink)." Q=".$q);
$r=$c->fetch_row();
$p_pink=$r[0];
$q="select count(id) as avai_c from tobdong_member where color='yellow' and rank='p';"; //some instruction
$c=mysqli_query($conn,$q) or die(mysqli_error($DBlink)." Q=".$q);
$r=$c->fetch_row();
$p_yellow=$r[0];

$q="select count(id) as avai_c from tobdong_member where color='green' and rank='s';"; //some instruction
$c=mysqli_query($conn,$q) or die(mysqli_error($DBlink)." Q=".$q);
$r=$c->fetch_row();
$s_green=$r[0];
$q="select count(id) as avai_c from tobdong_member where color='blue' and rank='s';"; //some instruction
$c=mysqli_query($conn,$q) or die(mysqli_error($DBlink)." Q=".$q);
$r=$c->fetch_row();
$s_blue=$r[0];
$q="select count(id) as avai_c from tobdong_member where color='pink' and rank='s';"; //some instruction
$c=mysqli_query($conn,$q) or die(mysqli_error($DBlink)." Q=".$q);
$r=$c->fetch_row();
$s_pink=$r[0];
$q="select count(id) as avai_c from tobdong_member where color='yellow' and rank='s';"; //some instruction
$c=mysqli_query($conn,$q) or die(mysqli_error($DBlink)." Q=".$q);
$r=$c->fetch_row();
$s_yellow=$r[0];



?>

      //var all_c=6;
     // var all_p=8;
      //var all_s=2;

      var all_c=4;
      var all_p=5;
      var all_s=2;

      var q_green_c=all_c-<?=$c_green;?>;
      var q_green_p=all_p-<?=$p_green;?>;
      var q_green_s=all_s-<?=$s_green;?>;

      var q_blue_c=all_c-<?=$c_blue;?>;
      var q_blue_p=all_p-<?=$p_blue;?>;
      var q_blue_s=all_s-<?=$s_blue;?>;

      var q_pink_c=all_c-<?=$c_pink;?>;
      var q_pink_p=all_p-<?=$p_pink;?>;
      var q_pink_s=all_s-<?=$s_pink;?>;

      var q_yellow_c=all_c-<?=$c_yellow;?>;
      var q_yellow_p=all_p-<?=$p_yellow;?>;
      var q_yellow_s=all_s-<?=$s_yellow;?>;

    /*  Array.min = function( array ){
    		return Math.min.apply( Math, array );
		};

		var min_c=Array.min([q_green_c,q_blue_c,q_pink_c,q_yellow_c]);
		var min_p=Array.min([q_green_p,q_blue_p,q_pink_p,q_yellow_p]);
		var min_s=Array.min([q_green_s,q_blue_s,q_pink_s,q_yellow_s]);

		function toText(){

		}*/

		Array.prototype.fill = function(val,times){
    for (var i = 0; i < times; i++){
        this.push(val);
    }
    return this;
};

      function randomColor(rank){
        var available=[];
        if(rank=='c'){
          if(q_green_c>0)available.fill('green',q_green_c);
          if(q_blue_c>0)available.fill('blue',q_blue_c);
          if(q_pink_c>0)available.fill('pink',q_pink_c);
          if(q_yellow_c>0)available.fill('yellow',q_yellow_c);


        }

        if(rank=='p'){
          if(q_green_p>0)available.fill('green',q_green_p);
          if(q_blue_p>0)available.fill('blue',q_blue_p);
          if(q_pink_p>0)available.fill('pink',q_pink_p);
          if(q_yellow_p>0)available.fill('yellow',q_yellow_p);
        }

        if(rank=='s'){
          if(q_green_s>0)available.fill('green',q_green_s);
          if(q_blue_s>0)available.fill('blue',q_blue_s);
          if(q_pink_s>0)available.fill('pink',q_pink_s);
          if(q_yellow_s>0)available.fill('yellow',q_yellow_s);
        }
        console.log(available);

        var random = available[Math.floor(Math.random()*available.length)];
        console.log(random);
        return random;

      }
      function fblogin(){
        console.log('current'+currentrank);
        var color=randomColor(currentrank);
        if(color==undefined){alert('ขออภัยเกินโควต้ามือนี้แล้ว'); return false;}
        console.log(color);
         FB.login(function(response) {
         if (response.authResponse) {
           console.log('Welcome!  Fetching your information.... ');
           FB.api('/me', function(response) {
            console.log(response);
            
            var strurl="regis.php?name="+encodeURIComponent(response.name)+"&fbid="+response.id+"&rank="+currentrank+"&color="+color;
            console.log(strurl);
             window.location.href=strurl;
           });
         } else {
           console.log('User cancelled login or did not fully authorize.');
         }
       });
      }

      function setRank(rank){
        currentrank=rank;
      }

      function randomText(){
      	
         var color=randomColor(currentrank);
         if(color==undefined){alert('ขออภัยเกินโควต้ามือนี้แล้ว'); return false;}
         var name=$('#nametext').val();
         if(name==""){alert('กรุณากรอกชื่อ'); return false;}
        var strurl="regis.php?name="+encodeURIComponent(name)+"&fbid=000&rank="+currentrank+"&color="+color;
         console.log("color :"+color);
         window.location.href=strurl;
      }
    </script>
  </head>

  <body>


    <div class="container">
      <div class="header">
        <nav>
         
        </nav>
        <h3 class="text-muted">ตบโด่งแบดมินตันแอพ</h3>
      </div>

      <div class="jumbotron">
        <h2>Tobdong Annual Games 2014</h2>
        <img style="float:right;margin-left: 40px;" src="throphy.png" />
        <p class="lead">ทีมตบโด่งจะจัดทำการแข่งขันกีฬาสี ณ คอร์ทแบด Lynx Arena โดยจะทำการแบ่งเป็นทั้งหมด 4 สีได้แก่ สีชมพู ฟ้า เขียว เหลือง 
และจะแบ่งเป็นสีละ 8 คู่แข่งแบบ 2 เซตพบกันทั้งหมดทุกสี
และมีรางวัลสำหรับสีที่ชนะเลิศ
ขอให้นักกีฬา และเชียร์ลีดเดอร์เตรียมตัวให้พร้อม แล้วพบกันในวันเสาร์ที่ 20 ธค 2557 นี้เวลา เวลา 17.00 ณ โดยประมาณ
</p>
<p></p>
<p>ปล. เรามีจับสลากของขวัญ <i class="fa fa-lg fa-gift"></i> ขั้นต่ำอยู่ที่ 300 บาทครับ</p>
        <p>
        <a class="btn btn-lg btn-success" href="#" role="button" data-toggle="modal" onclick="setRank('c');" data-target="#myModal" >จับสลากมือ C</a>
        <a class="btn btn-lg btn-success" href="#" role="button" data-toggle="modal" onclick="setRank('p');" data-target="#myModal">จับสลากมือ P</a>
        <a class="btn btn-lg btn-success" href="#" role="button" data-toggle="modal" onclick="setRank('s');" data-target="#myModal">จับสลากมือ S</a>
        </p>
      </div>

      <div class="color list">
        <?
        $q="select * from tobdong_member where color='green' order by rank asc;"; //some instruction
        $c=mysqli_query($conn,$q) or die(mysqli_error($DBlink)." Q=".$q);

        ?>
        <div class="row">
        <div class="col-xs-12">
        		<script>window.scrollback = {"room":"tobdong","form":"canvas","minimize":false};(function(d,s,h,e){e=d.createElement(s);e.async=1;e.src=(location.protocol === "https:" ? "https:" : "http:") + "//scrollback.io/client.min.js";d.getElementsByTagName(s)[0].parentNode.appendChild(e);}(document,"script"));</script>
        </div>
        </div>
        <div class="row">

        <div class="color col-xs-3" style="background-color:#15B256;"><h1>สีเขียว (<?=mysqli_num_rows($c);?>)</h1>
        
          <?php while($row=$c->fetch_row()){ 

          	echo "<div class='userblock'>";
            if($row[6]!='000')echo "<img src='https://graph.facebook.com/".$row[6]."/picture?type=square' width='32' /> ";
            else echo "<img src='noimage.jpg' width='32' /> ";
            echo urldecode($row[1])." <span class='label label-danger'>{$row[3]}</span>";
            echo "</div>";
        }
          ?>
       
        </div>

        <?
        $q="select * from tobdong_member where color='blue' order by rank asc;;"; //some instruction
        $c=mysqli_query($conn,$q) or die(mysqli_error($DBlink)." Q=".$q);

        ?>
        <div class="color  col-xs-3" style="background-color:#2399C9;"><h1>สีฟ้า (<?=mysqli_num_rows($c);?>)</h1>
       
          <?php while($row=$c->fetch_row()){
          	echo "<div class='userblock'>";
          	if($row[6]!='000')echo "<img src='https://graph.facebook.com/".$row[6]."/picture?type=square' width='32' /> ";
          	else echo "<img src='noimage.jpg' width='32' /> ";
          echo urldecode($row[1])." <span class='label label-danger'>{$row[3]}</span>";
      	echo "</div>";}
          ?>
       
        </div>

        <?
        $q="select * from tobdong_member where color='pink' order by rank asc;;"; //some instruction
        $c=mysqli_query($conn,$q) or die(mysqli_error($DBlink)." Q=".$q);

        ?>
        <div class="color  col-xs-3" style="background-color:#C06AAA;"><h1>สีชมพู (<?=mysqli_num_rows($c);?>)</h1>
        <p>
          <?php while($row=$c->fetch_row()){ 
          	echo "<div class='userblock'>";
          	if($row[6]!='000')echo "<img src='https://graph.facebook.com/".$row[6]."/picture?type=square' width='32' /> ";
          	else echo "<img src='noimage.jpg' width='32' /> ";
          echo urldecode($row[1])." <span class='label label-danger'>{$row[3]}</span>";
          echo "</div>";}
          ?>
        </p>
        </div>

        <?
        $q="select * from tobdong_member where color='yellow' order by rank asc;;"; //some instruction
        $c=mysqli_query($conn,$q) or die(mysqli_error($DBlink)." Q=".$q);

        ?>
        <div class="color  col-xs-3" style="background-color:#C4A10E;"><h1>สีเหลือง (<?=mysqli_num_rows($c);?>)</h1>
        <p>
          <?php while($row=$c->fetch_row()){ 
          	echo "<div class='userblock'>";
          	if($row[6]!='000')echo "<img src='https://graph.facebook.com/".$row[6]."/picture?type=square' width='32' /> ";
          	else echo "<img src='noimage.jpg' width='32' /> ";
          echo urldecode($row[1])." <span class='label label-danger'>{$row[3]}</span>";
          echo "</div>";}
          ?>
        </p>
        </div>

        </div>

      </div>

      <footer class="footer">
        <p>&copy; Tobdong Badminton Team 2014</p>
      </footer>

    </div> <!-- /container -->


<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">เลือกวิธีลงทะเบียน</h4>
      </div>
      <div class="modal-body">
        <p>ล๊อกอินโดยเฟสบุ๊ค <button type="button" onclick="fblogin();" class="btn btn-primary"><i class="fa fa-lg fa-facebook"></i> Facebook</button> <br /><br />หรือ กรอกชื่อ <input type="text"  id="nametext"  maxlength="20" /> <button onclick="randomText()" type="button" class="btn btn-primary">จับสลาก</button></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">ยกเลิก</button>
      </div>
    </div>
  </div>
</div>

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
