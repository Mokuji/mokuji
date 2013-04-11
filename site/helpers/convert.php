<?php if(!defined('TX')) die('No direct access.');

function argument_to_string($arg)
{
	
  switch(strtolower(gettype($arg))){

		case 'string':
		case 'boolean':
			return '<span title="'.json_encode(htmlspecialchars($arg)).'">'.json_encode(htmlspecialchars(var_export((strlen($arg) > 20 ? substr($arg, 0, 10).'...'.substr($arg, -10) : $arg), true))).'</span>';

		case 'object':
      if(is_data($arg)){
        return 'Data('.argument_to_string($arg->get()).')';
      }else{
        return 'object('.get_class($arg).')';
      }
      
		case 'array':
			$ret = 'array(';
      $separtor = '';
			if(count($arg) < 5){
				foreach($arg as $k => $v){
					$ret .= $separtor.'['.argument_to_string($k).'] => '.argument_to_string($v);
					$separtor = ', ';
				}
			}else{
				foreach($arg as $k => $v){
					$ret .= $separtor.argument_to_string($k);
					$separtor = ', ';
				}
			}
			$ret .= ')';

			return $ret;

		case 'resource':
			return 'resource('.get_resource_type($arg).')';

		default:
			return var_export($arg, true);
	}
  
}

function query_string_to_array($qs)
{

  parse_string($qs, $return);
  return $return;

}

function number_to_ordinal($number)
{
  
  if($number % 100 > 10 && $number % 100 < 14){
    return 'th';
  }

  switch($number % 10){
    case 1:  return 'st';
    case 2:  return 'nd';
    case 3:  return 'rd';
    default: return 'th';
  }
  
}

