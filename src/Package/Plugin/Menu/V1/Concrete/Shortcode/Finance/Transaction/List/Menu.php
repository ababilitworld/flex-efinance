<?php
namespace Ababilithub\FlexEFinance\Package\Plugin\Menu\V1\Concrete\Shortcode\Finance\Transaction\List;

(defined( 'ABSPATH' ) && defined( 'WPINC' )) || exit();

use Ababilithub\{
    FlexPhp\Package\Mixin\V1\Standard\Mixin as StandardMixin,
    FlexWordpress\Package\Menu\V1\Base\Menu as BaseMenu,
    FlexEFinance\Package\Plugin\Posttype\V1\Concrete\Finance\Transaction\Posttype as FinanceTransactionPosttype,
    FlexEFinance\Package\Plugin\Taxonomy\V1\Concrete\Finance\Transaction\Taxonomy as FinanceTransactionTaxonomy
};

use const Ababilithub\{
    FlexEFinance\PLUGIN_PRE_HYPH,
    FlexEFinance\PLUGIN_PRE_UNDS,
    FlexEFinance\PLUGIN_DIR,
};

if (!class_exists(__NAMESPACE__.'\Menu')) 
{

    class Menu extends BaseMenu
    {

        public function init(array $data = []) : static
        {
            $this->type = 'submenu';
            $this->parent_slug = 'flex-efinance';
            $this->page_title = 'App';
            $this->menu_title = 'App';
            $this->capability = 'manage_options';
            $this->menu_slug = 'flex-efinance-transaction-list';
            $this->callback = [$this,'render'];
            $this->position = 6;
            $this->screen_rules = [
                'id' => 'flex-efinance-transaction-list',
            ];

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
            add_filter( 'parent_file', [ $this, 'set_active_parent_menu' ] );
            add_filter( 'submenu_file', [ $this, 'set_active_submenu' ] );
            
        }

        /**
         * Add default menu items
         */
        public function add_menu_items($menu_items = [])
        {
            $menu_items[] = [
                'type' => $this->type,
                'parent_slug' => $this->parent_slug,
                'page_title' => $this->page_title,
                'menu_title' => $this->menu_title,
                'capability' => $this->capability,
                'menu_slug' => $this->menu_slug,
                'callback' => $this->callback,
                'position' => $this->position,
            ];

            return $menu_items;
        }

        /**
         * Custom main page render
         */
        public function render_main_page()
        {
            echo '<div class="wrap">';
            echo '<h1>Main Menu Dashboard</h1>';
            echo '<p>Welcome to Flex Bangla Land administration panel.</p>';
            echo '</div>';
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

        /**
         * Custom main page render
         */
        public function render()
        {
            echo do_shortcode("[".PLUGIN_PRE_HYPH."-".FinanceTransactionPosttype::POSTTYPE."-"."list]");
        }
        
    }
}
