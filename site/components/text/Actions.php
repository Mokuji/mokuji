<?php namespace components\text; if(!defined('TX')) die('No direct access.');

class Actions extends \dependencies\BaseComponent
{

  protected function save_item($data)
  {
    
    $item_id = 0;
    tx($data->id->get('int') > 0 ? 'Updating a text item.' : 'Adding a new text item', function()use($data, &$item_id){
      
      //Append user object for easy access.
      $user_id = tx('Data')->session->user->id;

      $data->order_nr = $data->order_nr->otherwise(0);

      //Save item.
      $item = tx('Sql')->table('text', 'Items')->pk($data->id->get('int'))->execute_single()->is('empty')
        ->success(function()use($data, $user_id, &$item_id){
          tx('Sql')->model('text', 'Items')->merge($data->having('page_id', 'order_nr'))->merge(array('dt_created' => date("Y-m-d H:i:s")))->merge(array('user_id' => $user_id))->save();
          $item_id = mysql_insert_id();
        })
        ->failure(function($item)use($data, $user_id, &$item_id){
          $item->merge($data->having('page_id', 'order_nr', 'dt_created'))->merge(array('user_id' => $user_id))->save();
          $item_id = $item->id->get('int');
        });

      //Delete existing item info.
      tx('Sql')->table('text', 'ItemInfo')->where('item_id', $item_id)->execute()->each(function($row){
        $row->delete();
      });

      //Save item info.
      $data->info->each(function($info)use($data, $item_id){

        $language_id = $info->key();
        tx('Sql')->model('text', 'ItemInfo')->set($info->having('title', 'description', 'text'))->merge(array('item_id' => $item_id, 'language_id' => $language_id))->save();

      });

    })
    
    ->failure(function($info){
      throw $info->exception;
      tx('Controller')->message(array(
        'error' => $info->get_user_message()
      ));

    });

    echo $item_id;exit;
    // tx('Url')->redirect(url('item_id=NULL'));
    
  }

  //Export all text items to a document.
  protected function export_to_doc()
  {

    $output =
      '<html><head>'.
      '  <meta http-equiv="content-type" content="text/html;CHARSET=UTF-8" />'.
      '  <style type="text/css">ul, li{list-style:none;margin:0;padding:0;}li{display:inline-block;padding-right:10px;margin-right:10px;}li:after{content:"»";display:inline-block;}</style>'.
      '</head><body>';

    //First: get all text items and order on menu-item order.
    tx('Sql')
      ->table('menu', 'MenuItems')
        ->sk(tx('Data')->filter('cms')->menu_id->is_set() ? tx('Data')->filter('cms')->menu_id : '1')
        ->add_absolute_depth('depth')
        ->join('MenuItemInfo', $mii)->inner()
      ->workwith($mii)
        ->select('title', 'title')
        ->where('language_id', tx('Language')->get_language_id())
      ->execute()
      ->each(function($menu_item)use(&$output){

        $text_item = tx('Sql')
          ->table('text', 'Items')
          ->join('ItemInfo', $ii)
          ->select("$ii.title", 'title')
          ->select("$ii.description", 'description')
          ->select("$ii.text", 'text')
          ->where('page_id', "'{$menu_item->page_id}'")
          ->where('trashed', '!', 1)
          ->where("$ii.language_id", tx('Language')->get_language_id())
          ->order('order_nr', 'DESC')
          ->execute_single();

        if($text_item->id->gt(0)->get('bool'))
        {

          tx('Data')->get->menu = $menu_item->id->get('int');

          $output .=

            ''.tx('Component')->modules('menu')->get_html('breadcrumbs', array('menu_item_id' => $menu_item->id)).
            '<h1>'.$text_item->title.'</h1>'.
            ''.(Data(trim($text_item->description->get()))->not('empty')->get('bool') ? $text_item->description.'<div style="width:100%;border-top:double 1px #3607ad;padding:1px;margin-top:15px;overflow:hidden;">&nbsp;</div>' : '').
            ''.$text_item->text.
            '<br clear="all" style="page-break-before:always" />';

        }

      });

    $output .=
      '</body></html>';

    header("Content-Type: application/vnd.ms-word"); 
    header("Expires: 0"); 
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
    header("Content-Type: text/html; charset=UTF-8");
    header("content-disposition: attachment;filename=export-".date("Ymd-Hi").".doc"); 
    echo $output;
    exit;

  }

}
