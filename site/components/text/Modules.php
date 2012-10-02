<?php namespace components\text; if(!defined('TX')) die('No direct access.');

class Modules extends \dependencies\BaseViews
{

  protected function text($options)
  {
    return array(
      'info' => $this->table('Items')->join('ItemInfo', $ii)->select("$ii.title", 'title')->select("$ii.description", 'description')->select("$ii.text", 'text')->where('page_id', "'{$options->pid}'")->order('order_nr', 'ASC')->execute_single()
    );
  }

  protected function latest_news($options)
  {
    return tx('Sql')->execute_query("SELECT * FROM #__text_items item LEFT JOIN #__text_item_info item_info ON item_info.item_id = item.id WHERE page_id IN (SELECT page_id FROM tx__menu_items WHERE lft > (SELECT lft FROM tx__menu_items WHERE id = 162) AND rgt < (SELECT rgt FROM tx__menu_items WHERE id = 162)) ORDER BY dt_created DESC LIMIT 0,2");;
  }

  protected function search_bar()
  {
    return 'Bonjour.';
  }

}