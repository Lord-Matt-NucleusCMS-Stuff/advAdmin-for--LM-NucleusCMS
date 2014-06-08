<?php
/**
 * The class advAdmin_admin wrappers ADMIN to make page generation all come 
 * before outputting. This then gives plugin authors two new methods to edit the
 * admin area.
 * 
 * allAdminHTMM: This is the early bird event and is NOT RECOMENDED for making 
 *               changes to the admin area. It is best saved for simple text 
 *               based inspection. You will find the HTML in $data['PAGE'].
 * 
 * allAdminXML:  This gives you a simpleXML element to play with. This can be 
 *               transformed however needed to DOM or whatever. This event is 
 *               RECOMENDED for admin area editing.  You will find the object in 
 *               $data['PAGE'].
 *
 * @author lordmatt
 */                                   
class advAdmin_admin extends ADMIN{

    protected $PAGE='';

    /**
     * This steps in nice and early and stops the output from doing anything yet
     * so that the output(s) can be manipulated. The output is buffered which is 
     * not the most economic way to approach things but as the page is output as 
     * it is built we have little choice at this stage.
     * 
     */
    public function __construct() {
            ob_start();
    }
    
    /**
     * pagefoot finishesd the page.
     * 
     * This overloader catches the final output page and then gives two methods
     * for plugins to manipulate this and do something useful.
     */
    public function pagefoot() {
        global $manager;
        //first do things as they should be done
        parent::pagefoot();
        $this->PAGE = ob_get_contents();
        ob_end_clean();
        /**
         * First we simple hand out the HTML for people to use string editing 
         */
        $data = array(
                'PAGE' => &$this->PAGE
        );
        $manager->notify('allAdminHTML', $data);
        
        /**
         * There is a better way given the carefully XML compliant xHTML so 
         * unlesssomeone breaks something with sloppy string manipulation.
         */
        $guff = "<?xml version=\"1.0\"?>\n";
        $this->PAGE = $guff . $this->PAGE;
        
        /*
         * This bit is thanks to help found here:
         * http://stackoverflow.com/questions/6635849/can-simplexml-be-used-to-rifle-through-html
         */
        $doc = new DOMDocument();
        //$doc->strictErrorChecking = FALSE;
        $doc->loadHTML($this->PAGE);
        $doc->encoding = 'utf-8';
        $xmlObject = simplexml_import_dom($doc,'advAdmin_simpleXML');
        //$xmlObject = simplexml_load_string($this->PAGE,'advAdmin_simpleXML');
        
        $data = array(
                'PAGE' => $xmlObject
        );
        $manager->notify('allAdminXML', $data);
        $doc = dom_import_simplexml($xmlObject);
 
        $doc->ownerDocument->encoding = 'iso-8859-1';
        $doc->ownerDocument->preserveWhiteSpace = false;
        $doc->ownerDocument->formatOutput = true;        
        $this->PAGE = $doc->ownerDocument->saveXML($doc);

        
        // If there is anything else that advAdmin needs to do do it here
        // [...]
        // now we output
        echo $this->PAGE;
    }    
    
    
    
    
}


