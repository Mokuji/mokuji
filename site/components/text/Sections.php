<?php namespace components\text; if(!defined('TX')) die('No direct access.');

class Sections extends \dependencies\BaseViews
{

  /* ---------- Frontend ---------- */

  private function get_items($filter)
  {

    $that = $this;
    return tx('Fetching items.', function()use($filter, $that){

      return
        $that->table('Items')
        ->is($filter->id->gt(0)->and_is('set')->and_not('empty'), function($q)use($filter){
          $q->where('id', $filter->id);
        })
        ->is($filter->pid->is('set'), function($q)use($filter){
          $q->where('page_id', $filter->pid->get('int'));
        })
        ->execute()
        ->each(function($row){
          $row->info->set($row->info);
        });
    });

  }

  private function get_item($filter)
  {

    $that = $this;
    return tx('Fetching item.', function()use($filter, $that){

      return
        $that->table('Items')->where('id', $filter->id)->execute_single();

    });

  }

  protected function json($options)
  {

    switch(tx('Data')->server->REQUEST_METHOD->lowercase()->get()){
      case 'get': $data = tx('Data')->get; $method = 'get'; break;
      case 'post': $data = Data(tx('Data')->xss_clean(json_decode(file_get_contents("php://input"), true))); $method = 'create'; break;
      case 'put': $data = Data(tx('Data')->xss_clean(json_decode(file_get_contents("php://input"), true))); $method = 'update'; break;
      case 'delete': $data = Data(tx('Data')->xss_clean(json_decode(file_get_contents("php://input"), true))); $method = 'delete'; break;
      default: throw new \exception\Programmer('Method "%s" not supported.', tx('Data')->server->REQUEST_METHOD); break;
    }
    
    header('Content-type: application/json');

    if($data->model->is_empty()){
      set_status_header(412, "Model name required.");
      return null;
    }

    $method = "{$method}_{$data->model}";
    
    if(!method_exists($this, $method)){
      set_status_header(501, "Method ".get_class($this)."::$method() missing.");
      return null;
    }
    
    $data->model->un_set();
    $user_function = $this->{$method}($data);

    if( ! $user_function instanceof \dependencies\UserFunction){
      set_status_header(500, "Method ".get_class($this)."::$method() must return an instance of UserFunction.");
      return null;
    }
    
    if($user_function->failure()){
      
      switch($user_function->exception->getExCode()){
        case EX_AUTHORISATION: $code = 401; break;
        case EX_EMPTYRESULT: $code = 404; break;
        case EX_VALIDATION: $code = 412; break;
        default: $code = 500; break;
      }
      
      set_status_header($code, $user_function->get_user_message());
      return null;
      
    }
    
    return Data($user_function->return_value)->as_json();
    
  }



}
