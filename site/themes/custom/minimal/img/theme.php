<?php define('THEMEPATH', 'themes/beeldbank/'); ?>
<!doctype html>
<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!-- Consider adding an manifest.appcache: h5bp.com/d/Offline -->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width,initial-scale=1">

  <title>demo.brand-portal.nl</title>

  <link rel="stylesheet" href="<?php echo THEMEPATH; ?>js/mylibs/jquery-ui/jquery-ui-1.8.16.custom.css">
  <link rel="stylesheet" href="<?php echo THEMEPATH; ?>css/style.css">

  <script src="<?php echo THEMEPATH; ?>js/libs/modernizr-2.0.6.min.js"></script>

</head>

<body>

  <div id="container" class="clearfix">
  
    <header>
        
      <ul id="navigation-menu">
        <li><a href="#">Handboek</a></li>
        <li><a href="#">Beeldbank</a></li>
      </ul>
      <ul id="user-menu">
        <li><a href="#">Eigenschappen</a></li>
        <li>Ingelogd als:&nbsp;&nbsp;<a href="#">Demo</a></li>
      </ul>
      
    </header>
    
	<div id="sub-menu">
		<div id="paging">
		</div>
	</div>
	
    <div id="left">
		<div id="logo"><img src="img/logo.png" alt=""></div>
		
		<div id="categories-menu">
			<ul>
				<li>Mens</li>
					<ul>
						<li>Man</li>
						<li>Vrouw</li>
					</ul>
				<li>Dier</li>
			</ul>
		</div>
		
	</div>
    
  </div> <!--! end of #container -->


  <!-- JavaScript at the bottom for fast page loading -->

  <!-- Grab Google CDN's jQuery, with a protocol relative URL; fall back to local if offline -->
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
  <script>window.jQuery || document.write('<script src="<?php echo THEMEPATH; ?>js/libs/jquery-1.6.2.min.js"><\/script>')</script>


  <!-- scripts concatenated and minified via ant build script-->
  <script defer src="<?php echo THEMEPATH; ?>js/plugins.js"></script>
  <script defer src="<?php echo THEMEPATH; ?>js/script.js"></script>
  <!-- end scripts-->



  
</body>
</html>
