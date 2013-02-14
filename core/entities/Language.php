<?php
namespace LoginForm\Enums;

/** @Entity */
class Language {
    /**
     * @Id @Column(type="integer") @GeneratedValue(strategy="AUTO")
     * @var int
     */
    private $id;
    
    /**
     * @Column(type="string", length=3)
     * @var string
     */
    private $code;
    
    /**
     * @Column(type="string", length=20)
     * @var string
     */
    private $name;
    
    public function getCode() {
        return $this->code;
    }

    public function getName() {
        return $this->name;
    }
 
    public function __construct($name, $code) {
        $this->code = (string) $code;
        $this->name = (string) $name;
    }
}