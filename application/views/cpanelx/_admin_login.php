<!DOCTYPE html>
<!--[if lt IE 7]> <html class="lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]> <html class="lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]> <html class="lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> 
<html lang="en"> <!--<![endif]-->
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title>Login</title>
  <link rel="shortcut icon" href="<?php echo base_url('assets/images/favicon.ico'); ?>">
  <link rel="stylesheet" href="<?php echo site_url('assets/css/admin/css/style.css'); ?>">
  <style type="text/css">
  #error-display li{
	color:#ff5555;
}</style>
</head>
<body>
  <section class="container"><div align="center"><img class="resize" src="../assets/images/SplashMerapi.png"/></div>
    <div class="login">
      <h1>Login to newMerapi v.1 </h1>
      <form method="post" action="<?php echo base_url('cpanelx/_main_security/auth/'.$cpsess['cpsess.key']);?>">
        <p><input id="username" type="text" name="username" value="" placeholder="Username"></p>
        <p><input id="password" type="password" name="password" value="" placeholder="Password"></p>
        <p class="remember_me">
          <label>
            <input type="checkbox" name="remember_me" id="remember_me">
            Remember me on this computer
          </label>
        </p>
        <p class="submit"><input type="submit" name="commit" value="Login"></p>
      </form>  
    </div>

    <div class="login-help">
      <p>User Agent: <?php echo $_SERVER['HTTP_USER_AGENT'];?></p>
    </div>
  </section>
</body>
</html>