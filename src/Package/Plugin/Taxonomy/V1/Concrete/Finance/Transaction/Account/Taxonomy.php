<?php
namespace Ababilithub\FlexEFinance\Package\Plugin\Taxonomy\V1\Concrete\Finance\Transaction\Account;

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
            $this->taxonomy = 'finance-transaction-account';
            $this->slug = 'finance-transaction-account';

            $this->set_labels([
                'name'              => _x('Transaction Accounts', 'taxonomy general name', 'flex-efinance'),
                'singular_name'     => _x('Transaction Account', 'taxonomy singular name', 'flex-efinance'),
                'search_items'      => __('Search Transaction Accounts', 'flex-efinance'),
                'all_items'         => __('All Transaction Accounts', 'flex-efinance'),
                'parent_item'       => __('Parent Transaction Account', 'flex-efinance'),
                'parent_item_colon' => __('Parent Transaction Account:', 'flex-efinance'),
                'edit_item'         => __('Edit Transaction Account', 'flex-efinance'),
                'update_item'       => __('Update Transaction Account', 'flex-efinance'),
                'add_new_item'      => __('Add New Transaction Account', 'flex-efinance'),
                'new_item_name'     => __('New Transaction Account Name', 'flex-efinance'),
                'menu_name'         => __('Transaction Accounts', 'flex-efinance'),
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
                    'ababil-it-hub',
                    'Ababil IT Hub',
                    'Transaction Account',
                    [
                        'finance_term' => 'Account',
                    ]
                ),
                $this->generate_term_data(
                    'md-shafiul-alam',
                    'Md Shafiul Alam',
                    'Transaction Account',
                    [
                        'finance_term' => 'Account',
                    ]
                ),
                $this->generate_term_data(
                    'shyma-akter-sweety',
                    'Shyma Akter Sweety',
                    'Transaction Account',
                    [
                        'finance_term' => 'Account',
                    ]
                ),
                $this->generate_term_data(
                    'shayaan-abdullah-swapnil',
                    'Shayaan Abdullah Swapnil',
                    'Transaction Account',
                    [
                        'finance_term' => 'Account',
                    ]
                ),
                $this->generate_term_data(
                    'sanila-salsabil-fatima',
                    'Sanila Salsabil Fatima',
                    'Transaction Account',
                    [
                        'finance_term' => 'Account',
                    ]
                ),
                $this->generate_term_data(
                    'noshin tasnim',
                    'Noshin Tasnim',
                    'Transaction Account',
                    [
                        'finance_term' => 'Account',
                    ]
                ),
                $this->generate_term_data(
                    'mst-bilkis-ara',
                    'Mst Bilkis Ara',
                    'Transaction Account',
                    [
                        'finance_term' => 'Account',
                    ]
                ),
                $this->generate_term_data(
                    'md-shamsul-alam',
                    'Md Shamsul Alam',
                    'Transaction Account',
                    [
                        'finance_term' => 'Account',
                    ]
                ),
                $this->generate_term_data(
                    'md-nurunnabi-sarker',
                    'Md Nurunnabi Sarker',
                    'Transaction Account',
                    [
                        'finance_term' => 'Account',
                    ]
                ),
                $this->generate_term_data(
                    'md-forhad-hossen',
                    'Md Forhad Hossen',
                    'Transaction Account',
                    [
                        'finance_term' => 'Account',
                    ]
                ),
                $this->generate_term_data(
                    'md-imran-ali',
                    'Md Imran Ali',
                    'Transaction Account',
                    [
                        'finance_term' => 'Account',
                    ]
                ),
                $this->generate_term_data(
                    'md-rafiquzzaman-rana',
                    'Md Rafiquzzaman Rana',
                    'Transaction Account',
                    [
                        'finance_term' => 'Account',
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