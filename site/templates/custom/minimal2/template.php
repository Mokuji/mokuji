<?php namespace templates; if(!defined('TX')) die('No direct access.'); ?>
<!doctype html>
<html>
  <head>
  
    <title><?php echo $head->title; ?></title>
    <base href="<?php echo $head->base->href; ?>" target="<?php echo $head->base->target; ?>" />

    <!-- character encoding -->
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />

    <!-- seo -->
    <meta name="description" content="Tuxion CMS" />
    <meta name="author" content="Tuxion" />
    <meta name="robots" content="index, follow" />
    <meta name="revisit-after" content="15 days" />
    <?php echo $head->meta; ?>
    
    <?php echo $head->theme; ?>

    <?php echo $head->links; ?>
    
    <?php echo $head->plugins; ?>

    <?php echo $head->scripts; ?>

    <style>
    .nav .selected:not(.active) > a{
      background: rgba(0, 136, 204, 0.20);
    }

    div.thumb {
      margin-bottom: 0.5em;
      border-style: solid;
      border-color: #EEEAE8;
      border-color: white;
      width: auto;
    }

    div.tright {
      clear: right;
      float: right;
      border-width: 0.5em 0 0.8em 1.4em;
    }

    div.thumb div {
      border: 1px solid #CCC;
      padding: 3px !important;
      background-color: #F9F9F9;
      font-size: 90%;
      text-align: center;
      overflow: hidden;
    }

    div.thumb div div.thumb-caption {
      border: none;
      text-align: left;
      line-height: 1.4em;
      padding: 0.3em 0 0.1em 0;
    }

    div.thumb div img {
      border: 1px solid #CCC;
    }

    #container p,
    #container li{
      font-size: 14px;
      line-height: 24px;
      font-family: 'proxima-nova',sans-serif;
      font-weight: 400;
    }
    #container p{
      margin-top: 20px;
      margin-bottom: 20px;
    }

    </style>
  
  </head>  
  <body>

<div id ="container" class="container-fluid">
  <div class="span2">
    <br />
    <nav>
      <?php echo tx('Component')->modules('menu')->get_html('menu', array('max_depth' => 1, 'classes' => 'nav nav-list')); ?>
    </nav>
  </div><!--/span-->
  <div class="span2">
    <br />
    <nav>
      <?php echo tx('Component')->modules('menu')->get_html('menu', array('min_depth' => 2, 'from_root' => true, 'parent_depth' => 1, 'classes' => 'nav nav-list')); ?>
    </nav>
  </div><!--/span-->
  <div class="span8">
    <div class="container">
      <div class="span8">
        <?php echo $body->content; ?>
      </div>
      <div class="span2">
        <?php
        if(tx('Data')->get->pid->get('int') > 0){
          $text_info =
            tx('Sql')
            ->table('text', 'Items')
            ->join('ItemInfo', $ii)
            ->select("$ii.title", 'titlte')
            ->select("$ii.description", 'description')
            ->where('page_id', tx('Data')->get->pid->get('int'))
            ->execute_single();
          if($text_info->description->get() != ''){
            ?>
            <div class="box" box-type="image-with-text" box-column="1">
              <?php echo $text_info->description; ?>
            </div>
            <?php
          }
        }
        ?>
      </div>

    </div>
  </div><!--/span-->
</div><!-- /.container-fluid -->

<?php echo $body->admin_toolbar; ?>
  
  </body>
</html>