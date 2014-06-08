<?php
/**
 * advAdmin_simpleXML gives you extra editing power
 *
 * @author lordmatt
 */
class advAdmin_simpleXML extends SimpleXMLElement {

    /**
     * Adds the child to the start of the list. Enjoy.
     * 
     * See also: http://stackoverflow.com/questions/2092012/simplexml-how-to-prepend-a-child-in-a-node
     * 
     * @param type $name
     * @param type $value
     * @return type 
     */
    public function prependChild($name, $value)
    {
        $dom = dom_import_simplexml($this);

        $new = $dom->insertBefore(
            $dom->ownerDocument->createElement($name, $value),
            $dom->firstChild
        );

        return simplexml_import_dom($new, get_class($this));
    }
}