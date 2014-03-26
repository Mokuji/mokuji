<?php namespace dependencies\email; if(!defined('MK')) die('No direct access.');

abstract class EmailFormatting
{
  
  const
    MARKDOWN = 'MARKDOWN',
    HTML = 'HTML',
    TEXT = 'TEXT';
  
  public static function format($type, $input)
  {
    
    switch ($type) {
      
      case EmailFormatting::MARKDOWN:
        return EmailFormatting::formatMarkdown($input);
      
      default:
        throw new \exception\Programmer('Unsupported formatting, %s', $type);
      
    }
    
  }
  
  public static function formatMarkdown($input)
  {
    
    load_plugin('php_markdown');
    $parser = new \Michelf\MarkdownExtra();
    $parser->no_markup = true;
    return $parser->transform($input);
    
  }
  
}