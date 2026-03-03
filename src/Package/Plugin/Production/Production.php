<?php
namespace Ababilithub\FlexEFinance\Package\Plugin\Production;

(defined( 'ABSPATH' ) && defined( 'WPINC' )) || exit();

use Ababilithub\{
    FlexPhp\Package\Mixin\V1\Standard\Mixin as StandardMixin,
    FlexEFinance\Package\Plugin\Menu\V1\Manager\Menu as MenuManager,
    FlexEFinance\Package\Plugin\Route\V1\Manager\Route as RouteManager,
    FlexEFinance\Package\Plugin\Taxonomy\V1\Manager\Taxonomy as TaxonomyManager,
    FlexEFinance\Package\Plugin\Posttype\V1\Manager\Posttype as PosttypeManager,
    FlexEFinance\Package\Plugin\Shortcode\V1\Manager\Shortcode as ShortcodeManager, 
};

if (!class_exists(__NAMESPACE__.'\Production')) 
{
    class Production 
    {
        use StandardMixin;

        public function __construct($data = []) 
        {
            $this->init();      
        }

        public function init() 
        {

            add_action('init', function () {
                (new TaxonomyManager())->boot();
            });

            add_action('init', function () {
                (new PosttypeManager())->boot();
            });

            add_action('init', function () {
                (new ShortcodeManager())->boot();
            });

            add_action('init', function () {
                (new MenuManager())->boot();
            });
        }
        
    }
}