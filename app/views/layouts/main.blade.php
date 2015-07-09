<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="initial-scale=1.0, user-scalable=no">
<meta name="description" content="">
<meta name="author" content="">
<link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}">
<meta property="fb:app_id" content="612396988819496" />
<meta property="og:locale" content="th_TH" />
@section('og')

<meta property="og:image" content="{{ asset('assets/images/teebadgun_logo_128.png') }}" /> 
<meta property="og:url" content="{{Request::url()}}" /> 
<meta property="og:title" content="ตีแบดกันดอทคอม เพราะเราเข้าใจคนเล่นแบดมินตัน" />
<meta property="og:description" content="ร่วมสร้างสรรค์สังคมแบดมินตันที่ดี แบ่งปันความรู้ ข้อมูล ข่าวสาร
พิพากย์วิจารณ์อย่างสร้างสรรค์ เพื่อเป็นส่วนหนึ่งในการพัฒนาวงการแบดมินตันไทย" />

@show
<title>@yield('title', 'ตีแบดกันดอทคอม')</title>

<!-- Bootstrap core CSS -->

<link href="{{ asset('assets/css/bootstrap.css') }}" rel="stylesheet">
<link href="{{ asset('assets/css/teebadgun.css') }}" rel="stylesheet">
<link href='http://fonts.googleapis.com/css?family=Roboto:400,500,700,900,300,100' rel='stylesheet' type='text/css'>
<link href="{{ asset('assets/css/font-awesome.css') }}" rel="stylesheet">
<link href="{{ asset('assets/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/css/bootstrap-formhelpers.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/css/font-awesome.min.css') }}" rel="stylesheet">

<script src="{{ asset('assets/js/jquery.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap-formhelpers.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap-datetimepicker.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
<script src="js/html5shiv.js"></script>
<script src="js/respond.min.js"></script>
<![endif]-->
@section('script')
@show
@section('style')
@show
</head>

<body>
<div id="fb-root"></div>
<script>
  window.fbAsyncInit = function() {
    // init the FB JS SDK
    FB.init({
      appId      : '612396988819496',                        // App ID from the app dashboard
      status     : true,                                 // Check Facebook Login status
      xfbml      : true,                                  // Look for social plugins on the page
      cookie	:true
    });

    // Additional initialization code such as adding Event Listeners goes here
  };

  // Load the SDK asynchronously
  (function(){
     // If we've already installed the SDK, we're done
     if (document.getElementById('facebook-jssdk')) {return;}

     // Get the first script element, which we'll use to find the parent node
     var firstScriptElement = document.getElementsByTagName('script')[0];

     // Create a new script element and set its id
     var facebookJS = document.createElement('script'); 
     facebookJS.id = 'facebook-jssdk';

     // Set the new script's source to the source of the Facebook JS SDK
     facebookJS.src = '//connect.facebook.net/en_US/all.js';

     // Insert the Facebook JS SDK into the DOM
     firstScriptElement.parentNode.insertBefore(facebookJS, firstScriptElement);
   }());
function loginFB(){
	FB.login(function(response) {
   if (response.authResponse) {
     console.log('กำลังดึงข้อมูลจาก Facebook');
     FB.api('/me', function(response) {
       location.href='{{ route('fbsignin') }}';
     });
   } else {
     console.log('User cancelled login or did not fully authorize.');
     location.href='{{ route('home') }}';
   }
  // location.href='{{ route('home') }}';
 },{scope: 'email,publish_actions,publish_stream'});
	
}

function connectFB(){
  FB.login(function(response) {
   if (response.authResponse) {
     console.log('กำลังดึงข้อมูลจาก Facebook');
     FB.api('/me', function(response) {
       location.href='{{ route('fbconnect') }}';
     });
   } else {
     console.log('User cancelled login or did not fully authorize.');
     location.href='{{ route('home') }}';
   }
  // location.href='{{ route('home') }}';
 },{scope: 'email,publish_actions,publish_stream'});
}


function showBadge(id,name,desc){

  var content="<div class='userbadge'>"+
  "<img src='{{route('home')}}/assets/images/badge/"+id+".png' />"+
  "<h2>ขอแสดงความยินดีคุณได้รับเหรียญ '"+name+"'</h2>"+
  "<p>"+desc+"</p>"+
  "</div>";
  bootbox.alert(content, function() {
  });
}
function inviteFriends(){
  /*FB.ui({method: 'apprequests',
        message: 'มาเข้าร่วมสังคมนักกีฬาแบดมินตันที่คุณเป็นเจ้าของกันเถอะ'
    }, function(request,to){

      console.log(to);

    });*/



    FB.ui({
        method: 'send',
        message: 'มาเข้าร่วมสังคมนักกีฬาแบดมินตันที่คุณเป็นเจ้าของกันเถอะ',
       // filters: ['app_non_users'],
       link: 'http://www.teebadgun.com',
        title: 'ส่งคำเขิญหาเพื่อนของคุณ'
    });


}

</script>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&appId=612396988819496&version=v2.0";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>


<div class="tb_nav">
<div class="navbar-header">
<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
<span class="icon-bar"></span>
<span class="icon-bar"></span>
<span class="icon-bar"></span>
</button>
<a class="navbar-brand" href="{{ route('home') }}"><img  src="{{ asset('assets/images/teebadgun_logo_s.png'); }}" /></a>
</div>
<div class="collapse navbar-collapse">
<ul class="nav navbar-nav">
@section('menu')
<li class="active"><a href="{{ route('where') }}">ตีที่ไหน</a></li>
<li><a href="{{ route('forums') }}">เว็บบอร์ด</a></li>
<li><a href="{{ route('news') }}">ข่าว</a></li>
<li><a href="{{ route('article') }}">บทความ</a></li>
<li><a href="{{ route('announcement') }}">รายการแข่งขัน</a></li>
@if (Auth::user())
<li><a href="{{ route('profile') }}">ส่วนตัว</a></li>
@endif
<li><a href="{{ route('about') }}">เกี่ยวกับเรา</a></li>

@show
</ul>
<div class='login-info'>
@if (Auth::user())
    
    <p class='user-info'>
      <div class="btn-group">
      <button type="button" class="btn btn-info btn-xs">{{ Auth::user()->firstname }} {{ Auth::user()->lastname }}</button>
      <button type="button" class="btn btn-info btn-xs dropdown-toggle" data-toggle="dropdown">
        <span class="caret"></span>
        <span class="sr-only">Toggle Dropdown</span>
      </button>
      <ul class="dropdown-menu" role="menu">
        <li><a href="{{ route('useredit',array(Auth::user()->id)) }}"><span class="glyphicon glyphicon-edit"></span> แก้ไขข้อมูลส่วนตัว</a></li>
        <li class="divider"></li>
        <li><a href="{{ route('gymadd') }}"  ><span class="glyphicon glyphicon-plus"> เพิ่มคอร์ทแบดมินตัน</a></li>
        <li><a href="{{ route('addteam') }}"  ><span class="glyphicon glyphicon-plus"> เพิ่มทีมแบดมินตัน</a></li>
        <li><a href="{{ route('logout') }}" ><span class="glyphicon glyphicon-log-out"> ออกจากระบบ</a></li>
      </ul>
    </div>
     <button onclick='inviteFriends();' class="btn btn-primary btn-xs"><i class="fa fa-facebook-square fa-lg"></i> ชวนเพื่อน</button>
   </p>
@else
  <a href='{{ action('UserController@login'); }}' class='' >เข้าสู่ระบบ</a>
  <button onclick="loginFB();" class='btn btn-primary btn-xs' ><i class="fa fa-facebook-square fa-lg"></i> Facebook Signin</button>
  <buton onclick='window.location.href="{{ action('UserController@signup'); }}"' class="btn btn-success btn-xs"><span class="glyphicon glyphicon-user"></span> สมัครสมาชิก</button>
@endif
</div>
</div><!--/.nav-collapse -->

</div>

<div class="container">

@section('content')

@show

</div><!-- /.container -->

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->

<script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/bootbox.min.js') }}"></script>
<script>
(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
ga('create', 'UA-XXXXXX-XX', 'example.com');
ga('require', 'displayfeatures');
ga('send', 'pageview');
</script>
</body>
</html>
