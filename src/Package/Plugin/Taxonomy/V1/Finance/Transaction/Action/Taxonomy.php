<?php
namespace Ababilithub\FlexEFinance\Package\Plugin\Taxonomy\V1\Finance\Transaction\Action;

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
        public function init(): void
        {
            $this->taxonomy = 'finance-transaction-action';
            $this->slug = 'finance-transaction-action';

            $this->set_labels([
                'name'              => _x('Transaction Actions', 'taxonomy general name', 'flex-efinance'),
                'singular_name'     => _x('Transaction Action', 'taxonomy singular name', 'flex-efinance'),
                'search_items'      => __('Search Transaction Actions', 'flex-efinance'),
                'all_items'         => __('All Transaction Actions', 'flex-efinance'),
                'parent_item'       => __('Parent Transaction Action', 'flex-efinance'),
                'parent_item_colon' => __('Parent Transaction Action:', 'flex-efinance'),
                'edit_item'         => __('Edit Transaction Action', 'flex-efinance'),
                'update_item'       => __('Update Transaction Action', 'flex-efinance'),
                'add_new_item'      => __('Add New Transaction Action', 'flex-efinance'),
                'new_item_name'     => __('New Transaction Action Name', 'flex-efinance'),
                'menu_name'         => __('Transaction Actions', 'flex-efinance'),
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

            $this->set_terms([
                $this->generate_term_data(
                    'deposit',
                    'Deposit',
                    'Transaction Action Deposit',
                    [
                        'finance_term' => 'Debit',
                    ]
                ),
                $this->generate_term_data(
                    'withdraw',
                    'Withdraw',
                    'Transaction Action Withdraw',
                    [
                        'finance_term' => 'Credit',
                    ]
                ),
            ]);

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
    }
}