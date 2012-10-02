<?php namespace components\menu; if(!defined('TX')) die('No direct access.'); ?>

<h1><?php __('Menu items') ?></h1>

<div id="config-column-2" class="config-column">
  <div class="inner">
    &nbsp;
  </div>
</div>

<div id="config-column-1" class="config-column clearfix">
  <div class="inner">
    <?php echo $menus->menu_item_list; ?>
  </div>
</div><!-- eof:#sidebar -->

<style type="text/css">
#config-column-1,
#config-column-2{
  float:left;
}
#config-column-1{
  width:200px;
  margin-left:-100%;
}
  #config-column-1 .inner{
    margin-right:10px;
  }
#config-column-2{
  width:100%;
}
  #config-column-2 .inner{
    margin-left:210px;
  }

</style>

<script type="text/javascript">
  $(function(){

    $(".category_list a.category, #new-category, #edit-category").on('click', function(e){
      e.preventDefault();
      $.ajax({
        url: $(this).attr('href')
      }).done(function(data){
        $("#config-column-2 > .inner").html(data);
      });
    });

    $(".category_list .icon-delete").on("click", function(e){
      e.preventDefault();
      if(confirm("Are you sure you want to delete this category?")){

        var category = $(this).parent().parent();

        $.ajax({
          url: $(this).attr('href')
        }).done(function(){
          category.fadeOut();
        });

      }
    });

  });
</script>