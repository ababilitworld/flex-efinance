<?php
namespace Ababilithub\FlexEFinance\Package\Plugin\Test;

use Ababilithub\{
    FlexPhp\Package\Mixin\V1\Standard\Mixin as StandardMixin,
    FlexEFinance\Package\Plugin\Menu\Menu as TestMenu,
};

use const Ababilithub\{
    FlexEFinance\PLUGIN_NAME,
    FlexEFinance\PLUGIN_DIR,
    FlexEFinance\PLUGIN_URL,
    FlexEFinance\PLUGIN_FILE,
    FlexEFinance\PLUGIN_PRE_UNDS,
    FlexEFinance\PLUGIN_PRE_HYPH,
    FlexEFinance\PLUGIN_VERSION
};

(defined( 'ABSPATH' ) && defined( 'WPINC' )) || exit();

if (!class_exists(__NAMESPACE__.'\Test')) 
{
    class Test 
    {
        use StandardMixin;
        private $menu;

        public function __construct($data = []) 
        {
            $this->init($data); 
            
        }

        public function init($data) 
        {
            $this->menu = TestMenu::getInstance();      
        }
    }
}