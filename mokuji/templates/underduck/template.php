<?php namespace templates; if(!defined('TX')) die('No direct access.'); ?>
<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
    <meta name="viewport" content="width=device-width">
    <base href="<?php echo $head->base->href; ?>" target="<?php echo $head->base->target; ?>" />
    
    <title><?php echo $head->title; ?></title>
    <meta name="revisit-after" content="5 days" />
    <?php
      echo $head->meta;
      echo $head->links;
      echo $head->plugins;
      echo $head->theme;
      echo $head->scripts;
    ?>
  </head>
  
  <body class="underduck-template">
    <header id="header">
      <img class="logo" src="http://placehold.it/135x35" />
      <nav class="main-menu">
        <?php echo tx('Component')->modules('menu')->get_html('menu', array('max_depth' => 1)); ?>
      </nav>
    </header>
    
    <div id="content-body">
      <?php echo $body->content; ?>
    </div>
    
    <footer id="footer">
      <div class="clearfix">
        
        <div class="col1">
          <h4>About</h4>
          <p>Cras ornare metus sit amet massa dapibus laoreet. Quisque eu sapien ante. Curabitur placerat eleifend elementum. Aenean lorem justo, tincidunt eu dictum quis, gravida quis sapien. Mauris convallis consectetur lectus quis tempor. Cras eget erat nibh. Nullam erat nisl, mattis adipiscing viverra quis, cursus pretium neque. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. In augue velit, pulvinar et tempor sit amet, scelerisque consequat mi. Duis imperdiet aliquet eleifend.</p>
        </div>
        
        <div class="col2">
          <h4>Tweets</h4>
          <p>
            Hi this is a very interesting <a href="#">#tweet</a>! <a href="#">j.mp/blabla</a><br>
            <a href="#">5 minutes ago</a>
          </p>
          <hr>
          <p>
            Wow, tweets can be so awesome <a href="#">#awesomeness</a>! <a href="#">j.mp/abjkla</a><br>
            <a href="#">12 minutes ago</a>
          </p>
        </div>
        
        <div class="col3">
          <h4>Latest news</h4>
          <p>Ut sollicitudin cursus odio, id gravida odio sodales at. Morbi dapibus suscipit urna, vel aliquam neque tincidunt id.</p>
          <p>Duis dapibus, ligula sit amet bibendum blandit, justo odio accumsan lorem, eu euismod urna risus id sapien. Nam pulvinar elit at sapien fermentum ullamcorper. Integer fringilla mattis ante, id hendrerit velit malesuada eget. Mauris eu erat vulputate mauris posuere venenatis. Cras sed nisi dui, in pulvinar arcu.</p>
        </div>
        
      </div>
      
      <hr>
      
      <p>
        <?php echo tx('Config')->user('site_copyright')->is_set() ? tx('Config')->user('site_copyright').br : ''; ?>
        Powered by <a href="http://mokuji.net/" target="_blank">Mokuji</a>. Underduck theme by iarehero.
      </p>
    </footer>
    
    <?php echo $body->admin_toolbar; ?>
  </body>
</html>
