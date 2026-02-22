<?php
namespace Ababilithub\FlexEFinance\Package\Plugin\Menu\V1\Concrete\Main;

(defined( 'ABSPATH' ) && defined( 'WPINC' )) || exit();

use Ababilithub\{
    FlexPhp\Package\Mixin\V1\Standard\Mixin as StandardMixin,
    FlexWordpress\Package\Menu\V1\Base\Menu as BaseMenu,
};

use const Ababilithub\{
    FlexEFinance\PLUGIN_PRE_UNDS,
    FlexEFinance\PLUGIN_PRE_HYPH,
    FlexEFinance\PLUGIN_DIR,
};

if (!class_exists(__NAMESPACE__.'\Menu')) 
{

    class Menu extends BaseMenu
    {

        public function init(array $data = []) : static
        {
            $this->menu_filter_name = PLUGIN_PRE_UNDS.'_admin_menu';
            $this->init_service();
            $this->init_hook();
            return $this;
        }

        public function init_service() : void
        {
            
        }

        public function init_hook() : void
        {
            // Add filter to collect menu items
            add_filter($this->menu_filter_name, [$this, 'add_menu_items']);
            
        }

        /**
         * Add default menu items
         */
        public function add_menu_items($menu_items = [])
        {
            $menu_items[] = [
                'type' => 'menu',
                'page_title' => 'Flex EFinance',
                'menu_title' => 'Flex EFinance',
                'capability' => 'manage_options',
                'menu_slug' => 'flex-efinance',
                'callback' => [$this, 'render_main_page'],
                'icon' => 'dashicons-location-alt',
                'position' => 9
            ];

            return $menu_items;
        }

        /**
         * Custom main page render
         */
        public function render_main_page()
        {
            echo do_shortcode('[' . PLUGIN_PRE_HYPH . '-plugin-info]');
        }

        /**
         * Custom main page render
         */
        public function render_submenu()
        {
            echo '<div class="wrap">';
            echo '<h1>Sub Menu Dashboard</h1>';
            echo '<p>Welcome to Flex Bangla Land administration panel.</p>';
            echo '</div>';
        }
        
    }
}
