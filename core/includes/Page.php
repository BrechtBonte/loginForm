<?php

class Page {
    
    /** @var string */
    private $name;

    /** @var array */
    private $vars;
    
    public function  __construct($name) {
        $this->name = (string) $name;
        $this->vars = array();
    }

    public function setVar($key, $value) {
        $this->vars[$key] = $value;
    }
    
    public function setVars(array $values) {
        foreach($values as $key => $value) {
            $this->setVar($key, $value);
        }
    }
    
    public function render() {
        $loader = new Twig_Loader_Filesystem(TEMPLATES);
        $twig = new Twig_Environment($loader);
        $function = new Twig_SimpleFunction('self', function () {
            return $_SERVER['PHP_SELF'];
        });
        $twig->addFunction($function);
        return $twig->render($this->name . '.twig', $this->vars);
    }
}