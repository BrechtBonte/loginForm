<?php

class Config extends Zend_Config_Ini {
    
    /** @var string */
    protected $filename;
    
    public function __construct($filename, $section = null, $options = false) {
        $this->filename = $filename;
        parent::__construct($filename, $section, $options);
        $this->parseSpecial($this->_data);
    }
    
    public function parseSpecial(array &$data) {
        foreach($data as &$item) {
            if(is_string($item)) {
                $item = preg_replace("/\{__FILE__\}/", $this->filename, $item);
                $item = preg_replace("/\{__DIR__\}/", dirname($this->filename), $item);
            }
            if($item instanceof Zend_Config) {
                $this->parseSpecial($item->_data);
            }
        }
    }
}