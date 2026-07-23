<?php
namespace Ababilithub\FlexEFinance\Package\Plugin\Taxonomy\V1\Concrete\Finance\Transaction\Type;

(defined('ABSPATH') && defined('WPINC')) || exit();

use Ababilithub\{
    FlexPhp\Package\Mixin\V1\Standard\Mixin as StandardMixin,
    FlexWordpress\Package\Taxonomy\V1\Base\Taxonomy as BaseTaxonomy
};

use const Ababilithub\{
    FlexEFinance\PLUGIN_PRE_UNDS
};

if (!class_exists(__NAMESPACE__.'\Taxonomy')) 
{
    class Taxonomy extends BaseTaxonomy
    {
        public const TAXONOMY = 'finance-transaction-type'; 
        public function init(): void
        {
            $this->taxonomy = self::TAXONOMY;
            $this->slug = self::TAXONOMY;

            $this->set_labels([
                'name'              => _x('Transaction Types', 'taxonomy general name', 'flex-efinance'),
                'singular_name'     => _x('Transaction Type', 'taxonomy singular name', 'flex-efinance'),
                'search_items'      => __('Search Transaction Types', 'flex-efinance'),
                'all_items'         => __('All Transaction Types', 'flex-efinance'),
                'parent_item'       => __('Parent Transaction Type', 'flex-efinance'),
                'parent_item_colon' => __('Parent Transaction Type:', 'flex-efinance'),
                'edit_item'         => __('Edit Transaction Type', 'flex-efinance'),
                'update_item'       => __('Update Transaction Type', 'flex-efinance'),
                'add_new_item'      => __('Add New Transaction Type', 'flex-efinance'),
                'new_item_name'     => __('New Transaction Type Name', 'flex-efinance'),
                'menu_name'         => __('Transaction Types', 'flex-efinance'),
            ]);

            $this->set_args([
                'hierarchical' => true,
                'labels' => $this->labels,
                'public' => true,
                'show_ui' => true,
                'show_admin_column' => true,
                'query_var' => true,
                'rewrite' => ['slug' => $this->slug],
                'show_in_quick_edit' => true,
                'show_in_rest' => true,
                'meta_box_cb' => 'post_categories_meta_box',
                'show_in_menu' => true,
                'show_in_nav_menus' => true,
            ]);

            $this->set_terms($this->generate_terms($this->get_default_terms()));

            $this->init_service();
            $this->init_hook();
            
        }

        protected function init_service(): void
        {
            //
        }

        protected function init_hook(): void
        {
            add_filter($this->taxonomy.'_row_actions', [$this, 'row_action_view_details'], 10, 2);            
        }

        /**
         * Get the default terms.
         *
         * @return array<int, mixed>
         */
        protected function get_default_terms(): array
        {
            $default_terms = [
                /*
                * General transaction purposes.
                */
                'normal' => [
                    'name'        => 'Normal',
                    'description' => 'Transaction Type',
                    'metas'       => [
                        'finance_term' => 'Type',
                    ],
                ],
                'deed' => [
                    'name'        => 'Deed',
                    'description' => 'Transaction Type',
                    'metas'       => [
                        'finance_term' => 'Type',
                    ],
                ],
            ];

            return $default_terms;
        }
    }
}