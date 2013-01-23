<?php

namespace PHPDocMD;

use
    Twig_Loader_String,
    Twig_Environment,
    Twig_Filter_Function;


/**
 * This class takes the output from 'parser', and generate the markdown
 * templates.
 *
 * @copyright Copyright (C) 2007-2012 Rooftop Solutions. All rights reserved.
 * @author Evert Pot (http://www.rooftopsolutions.nl/)
 * @license Mit
 */
class Generator
{

    /**
     * Output directory
     *
     * @var string
     */
    protected $outputDir;

    /**
     * The list of classes and interfaces
     *
     * @var array
     */
    protected $classDefinitions;

    /**
     * Directory containing the twig templates
     *
     * @var string
     */
    protected $templateDir;

    /**
     * Constructor
     *
     * @param string $structureXmlFile
     * @param string $outputDir
     */
    public function __construct(array $classDefinitions, $outputDir, $templateDir)
    {

        $this->classDefinitions = $classDefinitions;
        $this->outputDir = $outputDir;
        $this->templateDir = $templateDir;

    }

    /**
     * Starts the generator
     *
     * @return void
     */
    public function run() {
        
        //Sort this stuff by class name.
        ksort($this->classDefinitions);

        $loader = new Twig_Loader_String();
        $twig = new Twig_Environment($loader);

        // Sad, sad global
        $GLOBALS['PHPDocMD_classDefinitions'] = $this->classDefinitions;
        $GLOBALS['PHPDocMD_outputDir'] = $this->outputDir;

        $twig->addFilter('classLink', new Twig_Filter_Function('PHPDocMd\\Generator::classLink'));
        foreach($this->classDefinitions as $className=>$data) {
            
            $wcd = count(explode('\\', $className))-1;
            $GLOBALS['PHPDocMD_workingClassDepth'] = $wcd;
            $data['escapeToRoot'] = str_repeat('../', $wcd);
            
            //Sort constants.
            usort($data['constants'], function($a, $b){
                if($a['name'] == $b['name']) return 0;
                return ($a['name'] < $b['name']) ? -1 : 1;
            });
            
            //Sort properties.
            usort($data['properties'], function($a, $b){
                if($a['static'] != $b['static'])
                    return $a['static'] ? -1 : 1;
                if($a['visibility'] != $b['visibility'])
                    return $a['visibility'] > $b['visibility'] ? -1 : 1;
                if ($a['name'] == $b['name']) return 0;
                return ($a['name'] < $b['name']) ? -1 : 1;
            });
            
            //Sort methods.
            usort($data['methods'], function($a, $b){
                if($a['static'] != $b['static'])
                    return $a['static'] ? -1 : 1;
                if($a['visibility'] != $b['visibility'])
                    return $a['visibility'] > $b['visibility'] ? -1 : 1;
                if ($a['name'] == $b['name']) return 0;
                return ($a['name'] < $b['name']) ? -1 : 1;
            });
            
            $output = $twig->render(
                file_get_contents($this->templateDir . '/class.twig'),
                $data
            );
            self::ensureDir($this->outputDir . '/' . $data['fileName']);
            file_put_contents($this->outputDir . '/' . $data['fileName'], $output);

        }
        
        $wcd = 0;
        $GLOBALS['PHPDocMD_workingClassDepth'] = $wcd;
        $escapeToRoot = str_repeat('../', $wcd);
        
        $index = $this->createIndex();

        $index = $twig->render(
            file_get_contents($this->templateDir . '/index.twig'),
            array(
                'index' => $index,
                'classDefinitions' => $this->classDefinitions,
                'escapeToRoot' => $escapeToRoot
            )
        );
        self::ensureDir($this->outputDir . '/API-index.md');
        file_put_contents($this->outputDir . '/API-index.md', $index);

    }

    /**
     * Creates an index of classes and namespaces.
     *
     * I'm generating the actual markdown output here, which isn't great.. but
     * it will have to do. If I don't want to make things too complicated.
     *
     * @return array
     */
    protected function createIndex() {

        $tree = array();

        foreach($this->classDefinitions as $className=>$classInfo) {

            $current =& $tree;

            foreach(explode('\\', $className) as $part) {

                if (!isset($current[$part])) {
                    $current[$part] = array();
                }
                $current =& $current[$part];

            }

        }

        $treeOutput = function($item, $fullString = '', $depth=0) use (&$treeOutput) {

            $output = '';
            foreach($item as $name=>$subItems) {
                
                $isNs = $subItems && is_array($subItems) && count($subItems) > 0;
                $b = $isNs ? '**' : '';
                $fullName = $fullString?$fullString."\\".$name:$name;
                $output.= str_repeat(' ', $depth*2) . '* ' . $b . Generator::classLink($fullName, $name) . $b . "\n";
                $output.= $treeOutput($subItems, $fullName, $depth+1);

            }

            return $output;

        };

        return $treeOutput($tree);

    }

    /**
     * This is a twig template function.
     *
     * This function allows us to easily link classes to their existing
     * pages.
     *
     * Due to the unfortunate way twig works, this must be static, and we must
     * use a global to achieve our goal.
     *
     * @param mixed $className
     * @return void
     */
    static function classLink($className, $label = null) {

        $classDefinitions = $GLOBALS['PHPDocMD_classDefinitions'];
        $outputDir = $GLOBALS['PHPDocMD_outputDir'];
        $wcd = $GLOBALS['PHPDocMD_workingClassDepth'];
        $escapeToRoot = str_repeat('../', $wcd);

        $returnedClasses = array();

        foreach(explode('|', $className) as $oneClass) {

            $oneClass = trim($oneClass,'\\ ');

            $myLabel = $label?:$oneClass;

            if (!isset($classDefinitions[$oneClass])) {

                /*
                $known = array('string', 'bool', 'array', 'int', 'mixed', 'resource', 'DOMNode', 'DOMDocument', 'DOMElement', 'PDO', 'callback', 'null', 'Exception', 'integer', 'DateTime');
                if (!in_array($oneClass, $known)) {
                    file_put_contents('/tmp/classnotfound',$oneClass . "\n", FILE_APPEND);
                }*/

                $returnedClasses[] = $oneClass;

            } else {

                $returnedClasses[] = "[" . $myLabel . "](" . $escapeToRoot . str_replace('\\', '/', $oneClass) . '.md)';

            }

        }

       return implode('|', $returnedClasses);

    }
    
    /**
     * Ensures the directories exists for the given path.
     */
    private static function ensureDir($filename){
        $dir = substr($filename, 0, strrpos($filename, '/'));
        @mkdir($dir, 0777, true);
    }

}
