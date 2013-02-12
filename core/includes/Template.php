<?php

/**
 * Class to insert text into template files
 *
 * @author brecht.bonte
 */
class Template {

    /**
     * holds the text
     * @var string
     */
    private $template;


    /**
     * creates a template object for the supplied file
     * @param string $path
     * @return Template
     */
    public static function getInstance($path) {
        $var = new Template();
        $res = $var->loadTemplate($path);
        if($res !== FALSE) return $var;
        else return NULL;
    }

    /**
     * loads a template from the supplied path
     * @param string $path
     * @return bool
     */
    public function loadTemplate($path) {
        $val = file_get_contents($path);

        if($val === FALSE) return false;
        $this->template = $val;
        return true;
    }

    /**
     * set a variable in the template
     * @param string $key
     * @param string $value
     */
    public function setVar($key, $value) {
        $this->template = preg_replace('/\{\$' . $key . '\}/' ,$value, $this->template);
    }

    /**
     * returns the (modified) content of the template
     * @return string
     */
    public function getContent() {
        return $this->template;
    }
}
?>
