<?php
namespace Ababilithub\FlexEFinance\Package\Plugin\Taxonomy\V1\Finance\Transaction\Medium;

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
            $this->taxonomy = 'finance-transaction-medium';
            $this->slug = 'finance-transaction-medium';

            $this->set_labels([
                'name'              => _x('Transaction Mediums', 'taxonomy general name', 'flex-efinance'),
                'singular_name'     => _x('Transaction Medium', 'taxonomy singular name', 'flex-efinance'),
                'search_items'      => __('Search Transaction Mediums', 'flex-efinance'),
                'all_items'         => __('All Transaction Mediums', 'flex-efinance'),
                'parent_item'       => __('Parent Transaction Medium', 'flex-efinance'),
                'parent_item_colon' => __('Parent Transaction Medium:', 'flex-efinance'),
                'edit_item'         => __('Edit Transaction Medium', 'flex-efinance'),
                'update_item'       => __('Update Transaction Medium', 'flex-efinance'),
                'add_new_item'      => __('Add New Transaction Medium', 'flex-efinance'),
                'new_item_name'     => __('New Transaction Medium Name', 'flex-efinance'),
                'menu_name'         => __('Transaction Mediums', 'flex-efinance'),
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
                    'cash',
                    'Cash',
                    'Transaction Medium',
                    [
                        'finance_term' => 'Medium',
                    ]
                ),
                $this->generate_term_data(
                    'bank-deposit',
                    'Bank Deposit',
                    'Transaction Medium',
                    [
                        'finance_term' => 'Medium',
                    ]
                ),
                $this->generate_term_data(
                    'check',
                    'Check',
                    'Transaction Medium',
                    [
                        'finance_term' => 'Medium',
                    ]
                ),
                $this->generate_term_data(
                    'channel beftn',
                    'Channel BEFTN',
                    'Transaction Medium',
                    [
                        'finance_term' => 'Medium',
                    ]
                ),
                $this->generate_term_data(
                    'channel swift',
                    'Channel SWIFT',
                    'Transaction Medium',
                    [
                        'finance_term' => 'Medium',
                    ]
                ),
                $this->generate_term_data(
                    'channel-payment-gateway',
                    'Channel Payment Gateway',
                    'Transaction Medium',
                    [
                        'finance_term' => 'Medium',
                    ]
                ),
                $this->generate_term_data(
                    'channel-mfs-bkash',
                    'Channel MFS bKash',
                    'Transaction Medium',
                    [
                        'finance_term' => 'Medium',
                    ]
                ),
                $this->generate_term_data(
                    'channel-mfs-nagad',
                    'Channel MFS Nagad',
                    'Transaction Medium',
                    [
                        'finance_term' => 'Medium',
                    ]
                ),
                $this->generate_term_data(
                    'channel-mfs-rocket',
                    'Channel MFS Rocket',
                    'Transaction Medium',
                    [
                        'finance_term' => 'Medium',
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