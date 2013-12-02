<?php namespace dependencies; if(!defined('TX')) die('No direct access.');

use \dependencies\BaseModel;

abstract class RelationType
{
  
  const
    ForeignKey = 1,
    Reference = 2,
    SelfReference = 3,
    LinkTable = 4,
    NestedSets = 5;
  
  //Detection function
  public static function detect_type(BaseModel $model, array $relation)
  {
    
    //Get data for this relation.
    reset($relation);
    $local_field = key($relation);
    $target_field = current($relation);
    
    //See if we are starting from our PK.
    $pks = $model->pks(true);
    $pk = current($pks);
    if(count($pks) == 1 && $pk === $local_field){
      
      //Means we are either reference or link table typed.
      #TODO: Detect the difference.
      return self::Reference;
      
    }
    
    //Means we are not reference or link table typed.
    else{
      
      //Since self-reference is not implemented in the ORM without secondary model, we won't try to detect it.
      #TODO: Detect self-reference.
      
      //Nested sets are also not supported, but are also not defined by a single field in the first place.
      #TODO: Detect nested sets.
      
      //Assume that anything else is a Foreign Key construction.
      return self::ForeignKey;
      
    }
    
  }
  
  //Comparing function
    
  //Casting function?
  
}
