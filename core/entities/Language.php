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
        if($name === null || (string) $name === '') {
            throw new \InvalidArgumentException('the $name parameter expects a non-empty string');
        }
        
        if($code === null || (string) $code === '') {
            throw new \InvalidArgumentException('the $code parameter expects a non-empty string');
        }
        
        $this->code = (string) $code;
        $this->name = (string) $name;
    }
}