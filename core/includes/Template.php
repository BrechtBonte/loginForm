<?php
class Template {

    /** @var string */
    private $template;

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
     * sets vars according to an assoc array
     * @param array $values
     */
    public function setVars($values) {

        foreach($values as $key => $value) {
            $this->setVar($key, $value);
        }
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
