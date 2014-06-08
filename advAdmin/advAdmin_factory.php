<?php
/**
 * advAdmin_factory provides a factory for building things that should in MHO be
 * something that the core has (or should soon get) but as it doesn't yet we are
 * making it. The idea is to make hacking enw admin functions super simple by 
 * having this factory do the building which can be changed.
 *
 * @author lordmatt
 */
class advAdmin_factory /* extends advAdmin_singleton */{
   
    private $overRides = array();
    
    private static $_controller = null;

    private function __construct() {
    }

    /**
     * Thanks to http://stackoverflow.com/questions/18907922/singleton-pattern-not-working-in-php-5-2
     * @return type 
     */
    public static function getInstance() {
            if (!self::$_controller) {
                    self::$_controller = new self();
            }
            return self::$_controller;
    }
    
    /**
     * Set a class object to be replaced from the default. If you need a complex 
     * set up then you will need to make sure taht gets called as the auto over
     * ride will use a very simple new $NAME(); One way would be to extend this
     * class and set your version to be used in advAdmin.php.
     * 
     * EX: $FACTORY->setOverRide('admin','customAdmin');
     * 
     * @param type $class
     * @param type $newclass 
     */
    public function setOverRide($class,$newclass){
        $this->overRides[$class]=$newclass;
    }
    
    /**
     * Ideally I would like not have to do it this way but this does work 
     */
    public function on_start(){
        $data = array('factory' => &$this);
        $manager = MANAGER::instance();
        $manager->notify('advAdminInit', $data);
    }
    
    public function buildClass($class){
        
        // 1. Simple Override
        if(isset($this->overRides[$class])){
            $WHAT = $this->overRides[$class];
            return new $WHAT(); 
        }
        
        // 2. complex override
        $methodVariable = 'adv_technique_'.$class;
        if(method_exists($this,$methodVariable)){
            return $this->$methodVariable();
        }
        
        // 3. fall back
        return new $class();
        
    }
}

