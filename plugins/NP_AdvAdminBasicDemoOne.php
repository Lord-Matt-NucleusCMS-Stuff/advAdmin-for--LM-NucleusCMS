<?php
/**
 * NP_AdvAdminBasicDemoOne as part of the Liquid Jazz release.
 *
 * @author lordmatt
 */
class NP_AdvAdminBasicDemoOne extends NucleusPlugin {

        public function getName() { return 'AdvAdmin Demo #1'; }
        public function getAuthor() { return 'Lord Matt'; }
        public function getURL() { return 'http://lordmatt.co.uk'; }
        public function getVersion() { return '1'; }
        public function getMinNucleusVersion() { return '330'; }
        public function getDescription() { return 'Use the AdvAdmin to put a message on the admin page'; }

        public function supportsFeature($what) {
            switch($what) {
                case 'SqlTablePrefix':
                    return 1;
                default:
                    return 0;
            }
        }
        
        public function getEventList()
        {
            return array('allAdminXML');
        }
        /*
         * html>body>

div > div ([2] id=container) > div (id=content)
         */
        public function event_allAdminXML(&$data){

            $cont   = $data['PAGE']->body->div[0]->div[1]->div[0];
            $newbox = $cont->prependChild('div', '');
            
            
            $newbox->addAttribute('style','border:3px solid #666;padding:8px;
                background-color:#FFFFCC;font-size:110%;color:#333;');
            $newbox->addAttribute('id','advAdminBasicDemoBox');
            $newbox->addChild('p','This is a box, with a paragaph added to admin 
                area to show that the advAdmin prototype works.');
            $newbox->addChild('p','You may now wish to uninstall the plugin as it
                really does not actually do anything of any value and this box
                looks kinda dumb.');

            
        }
}


