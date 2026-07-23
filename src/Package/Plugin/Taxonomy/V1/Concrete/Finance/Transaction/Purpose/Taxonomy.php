<?php
namespace Ababilithub\FlexEFinance\Package\Plugin\Taxonomy\V1\Concrete\Finance\Transaction\Purpose;

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
        public const TAXONOMY = 'finance-transaction-purpose'; 
        public function init(): void
        {
            $this->taxonomy = self::TAXONOMY;
            $this->slug = self::TAXONOMY;

            $this->set_labels([
                'name'              => _x('Transaction Purposes', 'taxonomy general name', 'flex-efinance'),
                'singular_name'     => _x('Transaction Purpose', 'taxonomy singular name', 'flex-efinance'),
                'search_items'      => __('Search Transaction Purposes', 'flex-efinance'),
                'all_items'         => __('All Transaction Purposes', 'flex-efinance'),
                'parent_item'       => __('Parent Transaction Purpose', 'flex-efinance'),
                'parent_item_colon' => __('Parent Transaction Purpose:', 'flex-efinance'),
                'edit_item'         => __('Edit Transaction Purpose', 'flex-efinance'),
                'update_item'       => __('Update Transaction Purpose', 'flex-efinance'),
                'add_new_item'      => __('Add New Transaction Purpose', 'flex-efinance'),
                'new_item_name'     => __('New Transaction Purpose Name', 'flex-efinance'),
                'menu_name'         => __('Transaction Purposes', 'flex-efinance'),
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
            add_action(self::TAXONOMY . '_add_form_fields', [ $this, 'render_add_term_meta_fields' ] );
            add_action(self::TAXONOMY . '_edit_form_fields', [ $this, 'render_edit_term_meta_fields' ], 10, 2 );
            add_action('created_' . self::TAXONOMY, [ $this, 'save_term_meta' ] );
            add_action('edited_' . self::TAXONOMY, [ $this, 'save_term_meta' ] );
            
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
                'loan' => [
                    'name'        => 'Loan',
                    'description' => 'Transaction Purpose',
                    'metas'       => [
                        'finance_term' => 'Purpose',
                    ],
                ],
                'buy' => [
                    'name'        => 'Buy',
                    'description' => 'Transaction Purpose',
                    'metas'       => [
                        'finance_term' => 'Purpose',
                    ],
                ],
                'lease' => [
                    'name'        => 'Lease',
                    'description' => 'Transaction Purpose',
                    'metas'       => [
                        'finance_term' => 'Purpose',
                    ],
                ],
                'advance' => [
                    'name'        => 'Advance',
                    'description' => 'Transaction Purpose',
                    'metas'       => [
                        'finance_term' => 'Purpose',
                    ],
                ],
                'return' => [
                    'name'        => 'Return',
                    'description' => 'Transaction Purpose',
                    'metas'       => [
                        'finance_term' => 'Purpose',
                    ],
                ],
                'repayment' => [
                    'name'        => 'Repayment',
                    'description' => 'Transaction Purpose',
                    'metas'       => [
                        'finance_term' => 'Purpose',
                    ],
                ],
                'loan-repayment' => [
                    'name'        => 'Loan Repayment',
                    'description' => 'Transaction Purpose',
                    'metas'       => [
                        'finance_term' => 'Purpose',
                    ],
                ],
                'buy-return' => [
                    'name'        => 'Buy Return',
                    'description' => 'Transaction Purpose',
                    'metas'       => [
                        'finance_term' => 'Purpose',
                    ],
                ],
                'advance-return' => [
                    'name'        => 'Advance Return',
                    'description' => 'Transaction Purpose',
                    'metas'       => [
                        'finance_term' => 'Purpose',
                    ],
                ],
                'personal-expense' => [
                    'name'        => 'Personal Expense',
                    'description' => 'Transaction Purpose',
                    'metas'       => [
                        'finance_term' => 'Purpose',
                    ],
                ],

                /*
                * Bills and transport.
                */
                'bill' => [
                    'name'        => 'Bill',
                    'description' => 'Transaction Purpose',
                    'metas'       => [
                        'finance_term' => 'Purpose',
                    ],
                ],
                'fare' => [
                    'name'        => 'Fare',
                    'description' => 'Transaction Purpose',
                    'metas'       => [
                        'finance_term' => 'Purpose',
                    ],
                ],
                'bill-mobile' => [
                    'name'        => 'Bill - Mobile',
                    'description' => 'Transaction Purpose',
                    'metas'       => [
                        'finance_term' => 'Purpose',
                    ],
                ],
                'bill-internet' => [
                    'name'        => 'Bill - Internet',
                    'description' => 'Transaction Purpose',
                    'metas'       => [
                        'finance_term' => 'Purpose',
                    ],
                ],
                'bill-electricity' => [
                    'name'        => 'Bill - Electricity',
                    'description' => 'Transaction Purpose',
                    'metas'       => [
                        'finance_term' => 'Purpose',
                    ],
                ],
                'bill-labour' => [
                    'name'        => 'Bill - Labour',
                    'description' => 'Transaction Purpose',
                    'metas'       => [
                        'finance_term' => 'Purpose',
                    ],
                ],
                'bill-courier' => [
                    'name'        => 'Bill - Courier',
                    'description' => 'Transaction Purpose',
                    'metas'       => [
                        'finance_term' => 'Purpose',
                    ],
                ],
                'fare-auto' => [
                    'name'        => 'Fare - Auto',
                    'description' => 'Transaction Purpose',
                    'metas'       => [
                        'finance_term' => 'Purpose',
                    ],
                ],
                'fare-van' => [
                    'name'        => 'Fare - Van',
                    'description' => 'Transaction Purpose',
                    'metas'       => [
                        'finance_term' => 'Purpose',
                    ],
                ],

                /*
                * Household and market expenses.
                */
                'daily-bazar' => [
                    'name'        => 'Daily Bazar',
                    'description' => 'Transaction Purpose',
                    'metas'       => [
                        'finance_term' => 'Purpose',
                    ],
                ],
                'caret-fruit' => [
                    'name'        => 'Caret - Fruit',
                    'description' => 'Transaction Purpose',
                    'metas'       => [
                        'finance_term' => 'Purpose',
                    ],
                ],
                'caret-egg' => [
                    'name'        => 'Caret - Egg',
                    'description' => 'Transaction Purpose',
                    'metas'       => [
                        'finance_term' => 'Purpose',
                    ],
                ],
                'bag-bazar' => [
                    'name'        => 'Bag - Bazar',
                    'description' => 'Transaction Purpose',
                    'metas'       => [
                        'finance_term' => 'Purpose',
                    ],
                ],
                'drug' => [
                    'name'        => 'Drug',
                    'description' => 'Transaction Purpose',
                    'metas'       => [
                        'finance_term' => 'Purpose',
                    ],
                ],

                /*
                * General food categories.
                */
                'rice' => [
                    'name'        => 'Rice',
                    'description' => 'Transaction Purpose',
                    'metas'       => [
                        'finance_term' => 'Purpose',
                    ],
                ],
                'atta-whole-wheat' => [
                    'name'        => 'Atta - Whole Wheat',
                    'description' => 'Transaction Purpose',
                    'metas'       => [
                        'finance_term' => 'Purpose',
                    ],
                ],
                'meat' => [
                    'name'        => 'Meat',
                    'description' => 'Transaction Purpose',
                    'metas'       => [
                        'finance_term' => 'Purpose',
                    ],
                ],
                'fish' => [
                    'name'        => 'Fish',
                    'description' => 'Transaction Purpose',
                    'metas'       => [
                        'finance_term' => 'Purpose',
                    ],
                ],
                'lentil' => [
                    'name'        => 'Lentil',
                    'description' => 'Transaction Purpose',
                    'metas'       => [
                        'finance_term' => 'Purpose',
                    ],
                ],
                'milk' => [
                    'name'        => 'Milk',
                    'description' => 'Transaction Purpose',
                    'metas'       => [
                        'finance_term' => 'Purpose',
                    ],
                ],
                'egg' => [
                    'name'        => 'Egg',
                    'description' => 'Transaction Purpose',
                    'metas'       => [
                        'finance_term' => 'Purpose',
                    ],
                ],
                'vegetables' => [
                    'name'        => 'Vegetables - s',
                    'description' => 'Transaction Purpose',
                    'metas'       => [
                        'finance_term' => 'Purpose',
                    ],
                ],
                'fruits' => [
                    'name'        => 'Fruits',
                    'description' => 'Transaction Purpose',
                    'metas'       => [
                        'finance_term' => 'Purpose',
                    ],
                ],
                'nut' => [
                    'name'        => 'Nut',
                    'description' => 'Transaction Purpose',
                    'metas'       => [
                        'finance_term' => 'Purpose',
                    ],
                ],
                'bean' => [
                    'name'        => 'Bean',
                    'description' => 'Transaction Purpose',
                    'metas'       => [
                        'finance_term' => 'Purpose',
                    ],
                ],
                'oil' => [
                    'name'        => 'Oil',
                    'description' => 'Transaction Purpose',
                    'metas'       => [
                        'finance_term' => 'Purpose',
                    ],
                ],
                'spice' => [
                    'name'        => 'Spice',
                    'description' => 'Transaction Purpose',
                    'metas'       => [
                        'finance_term' => 'Purpose',
                    ],
                ],

                /*
                * Meat.
                */
                'meat-cow' => [
                    'name'        => 'Meat - Cow',
                    'description' => 'Transaction Purpose',
                    'metas'       => [
                        'finance_term' => 'Purpose',
                    ],
                ],
                'meat-goat' => [
                    'name'        => 'Meat - Goat',
                    'description' => 'Transaction Purpose',
                    'metas'       => [
                        'finance_term' => 'Purpose',
                    ],
                ],
                'meat-chicken' => [
                    'name'        => 'Meat - Chicken',
                    'description' => 'Transaction Purpose',
                    'metas'       => [
                        'finance_term' => 'Purpose',
                    ],
                ],

                /*
                * Fish.
                */
                'fish-rohu' => [
                    'name'        => 'Fish - Rohu',
                    'description' => 'Transaction Purpose',
                    'metas'       => [
                        'finance_term' => 'Purpose',
                    ],
                ],
                'fish-katla' => [
                    'name'        => 'Fish - Katla',
                    'description' => 'Transaction Purpose',
                    'metas'       => [
                        'finance_term' => 'Purpose',
                    ],
                ],
                'fish-silver-carp' => [
                    'name'        => 'Fish - Silver Carp',
                    'description' => 'Transaction Purpose',
                    'metas'       => [
                        'finance_term' => 'Purpose',
                    ],
                ],
                'fish-japanese-rohu' => [
                    'name'        => 'Fish - Japanese Rohu',
                    'description' => 'Transaction Purpose',
                    'metas'       => [
                        'finance_term' => 'Purpose',
                    ],
                ],

                /*
                * Lentils and beans.
                */
                'lentil-red' => [
                    'name'        => 'Lentil - Red',
                    'description' => 'Transaction Purpose',
                    'metas'       => [
                        'finance_term' => 'Purpose',
                    ],
                ],
                'lentil-yellow' => [
                    'name'        => 'Lentil - Yellow',
                    'description' => 'Transaction Purpose',
                    'metas'       => [
                        'finance_term' => 'Purpose',
                    ],
                ],
                'lentil-brown' => [
                    'name'        => 'Lentil - Brown',
                    'description' => 'Transaction Purpose',
                    'metas'       => [
                        'finance_term' => 'Purpose',
                    ],
                ],
                'lentil-chickpeas' => [
                    'name'        => 'Lentil - Chickpeas',
                    'description' => 'Transaction Purpose',
                    'metas'       => [
                        'finance_term' => 'Purpose',
                    ],
                ],
                'lentil-pigeon-pea' => [
                    'name'        => 'Lentil - Pigeon Pea',
                    'description' => 'Transaction Purpose',
                    'metas'       => [
                        'finance_term' => 'Purpose',
                    ],
                ],
                'lentil-black-gram' => [
                    'name'        => 'Lentil - Black Gram',
                    'description' => 'Transaction Purpose',
                    'metas'       => [
                        'finance_term' => 'Purpose',
                    ],
                ],
                'lentil-soybeans' => [
                    'name'        => 'Lentil - Soybeans',
                    'description' => 'Transaction Purpose',
                    'metas'       => [
                        'finance_term' => 'Purpose',
                    ],
                ],

                /*
                * Milk products.
                */
                'yogurt-plain-curd' => [
                    'name'        => 'Yogurt - Plain / Curd',
                    'description' => 'Transaction Purpose',
                    'metas'       => [
                        'finance_term' => 'Purpose',
                    ],
                ],
                'yogurt-sweet' => [
                    'name'        => 'Yogurt - Sweet',
                    'description' => 'Transaction Purpose',
                    'metas'       => [
                        'finance_term' => 'Purpose',
                    ],
                ],
                'yogurt-borhani' => [
                    'name'        => 'Yogurt - Borhani',
                    'description' => 'Transaction Purpose',
                    'metas'       => [
                        'finance_term' => 'Purpose',
                    ],
                ],
                'yogurt-lassi' => [
                    'name'        => 'Yogurt - Lassi',
                    'description' => 'Transaction Purpose',
                    'metas'       => [
                        'finance_term' => 'Purpose',
                    ],
                ],
                'yogurt-laban-matha' => [
                    'name'        => 'Yogurt - Laban / Matha',
                    'description' => 'Transaction Purpose',
                    'metas'       => [
                        'finance_term' => 'Purpose',
                    ],
                ],
                'ghee' => [
                    'name'        => 'Ghee',
                    'description' => 'Transaction Purpose',
                    'metas'       => [
                        'finance_term' => 'Purpose',
                    ],
                ],

                /*
                * Eggs.
                */
                'egg-chicken' => [
                    'name'        => 'Egg - Chicken',
                    'description' => 'Transaction Purpose',
                    'metas'       => [
                        'finance_term' => 'Purpose',
                    ],
                ],
                'egg-duck' => [
                    'name'        => 'Egg - Duck',
                    'description' => 'Transaction Purpose',
                    'metas'       => [
                        'finance_term' => 'Purpose',
                    ],
                ],
                'egg-quail' => [
                    'name'        => 'Egg - Quail',
                    'description' => 'Transaction Purpose',
                    'metas'       => [
                        'finance_term' => 'Purpose',
                    ],
                ],

                /*
                * Vegetables.
                */
                'vegetables-potato' => [
                    'name'        => 'Vegetables - Potato',
                    'description' => 'Transaction Purpose',
                    'metas'       => [
                        'finance_term' => 'Purpose',
                    ],
                ],
                'vegetables-sweet-potato' => [
                    'name'        => 'Vegetables - Sweet Potato',
                    'description' => 'Transaction Purpose',
                    'metas'       => [
                        'finance_term' => 'Purpose',
                    ],
                ],
                'vegetables-crookneck-pumpkin' => [
                    'name'        => 'Vegetables - Crookneck Pumpkin',
                    'description' => 'Transaction Purpose',
                    'metas'       => [
                        'finance_term' => 'Purpose',
                    ],
                ],
                'vegetables-cucumber' => [
                    'name'        => 'Vegetables - Cucumber',
                    'description' => 'Transaction Purpose',
                    'metas'       => [
                        'finance_term' => 'Purpose',
                    ],
                ],
                'vegetables-kakrol' => [
                    'name'        => 'Vegetables - Kakrol',
                    'description' => 'Transaction Purpose',
                    'metas'       => [
                        'finance_term' => 'Purpose',
                    ],
                ],
                'vegetables-green-banana' => [
                    'name'        => 'Vegetables - Green Banana',
                    'description' => 'Transaction Purpose',
                    'metas'       => [
                        'finance_term' => 'Purpose',
                    ],
                ],
                'vegetables-ash-gourd' => [
                    'name'        => 'Vegetables - Ash Gourd',
                    'description' => 'Transaction Purpose',
                    'metas'       => [
                        'finance_term' => 'Purpose',
                    ],
                ],
                'vegetables-pointed-gourd' => [
                    'name'        => 'Vegetables - Pointed Gourd',
                    'description' => 'Transaction Purpose',
                    'metas'       => [
                        'finance_term' => 'Purpose',
                    ],
                ],
                'vegetables-lemon' => [
                    'name'        => 'Vegetables - Lemon',
                    'description' => 'Transaction Purpose',
                    'metas'       => [
                        'finance_term' => 'Purpose',
                    ],
                ],
                'vegetables-bottle-gourd' => [
                    'name'        => 'Vegetables - Bottle Gourd',
                    'description' => 'Transaction Purpose',
                    'metas'       => [
                        'finance_term' => 'Purpose',
                    ],
                ],
                'vegetables-pumpkin' => [
                    'name'        => 'Vegetables - Pumpkin',
                    'description' => 'Transaction Purpose',
                    'metas'       => [
                        'finance_term' => 'Purpose',
                    ],
                ],
                'vegetables-okra' => [
                    'name'        => 'Vegetables - Okra',
                    'description' => 'Transaction Purpose',
                    'metas'       => [
                        'finance_term' => 'Purpose',
                    ],
                ],
                'vegetables-taro-stem' => [
                    'name'        => 'Vegetables - Taro Stem',
                    'description' => 'Transaction Purpose',
                    'metas'       => [
                        'finance_term' => 'Purpose',
                    ],
                ],
                'vegetables-chickpeas' => [
                    'name'        => 'Vegetables - Chickpeas',
                    'description' => 'Transaction Purpose',
                    'metas'       => [
                        'finance_term' => 'Purpose',
                    ],
                ],
                'vegetables-soybean' => [
                    'name'        => 'Vegetables - Soybean',
                    'description' => 'Transaction Purpose',
                    'metas'       => [
                        'finance_term' => 'Purpose',
                    ],
                ],
                'vegetables-hyacinth-bean' => [
                    'name'        => 'Vegetables - Hyacinth Bean / Shim',
                    'description' => 'Transaction Purpose',
                    'metas'       => [
                        'finance_term' => 'Purpose',
                    ],
                ],

                /*
                * Fruits.
                */
                'fruit-olive' => [
                    'name'        => 'Fruit - Olive',
                    'description' => 'Transaction Purpose',
                    'metas'       => [
                        'finance_term' => 'Purpose',
                    ],
                ],
                'fruit-guava' => [
                    'name'        => 'Fruit - Guava',
                    'description' => 'Transaction Purpose',
                    'metas'       => [
                        'finance_term' => 'Purpose',
                    ],
                ],
                'fruit-mango' => [
                    'name'        => 'Fruit - Mango',
                    'description' => 'Transaction Purpose',
                    'metas'       => [
                        'finance_term' => 'Purpose',
                    ],
                ],
                'fruit-banana' => [
                    'name'        => 'Fruit - Banana',
                    'description' => 'Transaction Purpose',
                    'metas'       => [
                        'finance_term' => 'Purpose',
                    ],
                ],
                'fruit-jackfruit' => [
                    'name'        => 'Fruit - Jackfruit',
                    'description' => 'Transaction Purpose',
                    'metas'       => [
                        'finance_term' => 'Purpose',
                    ],
                ],
                'fruit-apple' => [
                    'name'        => 'Fruit - Apple',
                    'description' => 'Transaction Purpose',
                    'metas'       => [
                        'finance_term' => 'Purpose',
                    ],
                ],
                'fruit-orange' => [
                    'name'        => 'Fruit - Orange',
                    'description' => 'Transaction Purpose',
                    'metas'       => [
                        'finance_term' => 'Purpose',
                    ],
                ],
                'fruit-malta' => [
                    'name'        => 'Fruit - Malta',
                    'description' => 'Transaction Purpose',
                    'metas'       => [
                        'finance_term' => 'Purpose',
                    ],
                ],
                'fruit-pear' => [
                    'name'        => 'Fruit - Pear',
                    'description' => 'Transaction Purpose',
                    'metas'       => [
                        'finance_term' => 'Purpose',
                    ],
                ],
                'fruit-blackberry' => [
                    'name'        => 'Fruit - Blackberry',
                    'description' => 'Transaction Purpose',
                    'metas'       => [
                        'finance_term' => 'Purpose',
                    ],
                ],
                'fruit-strawberry' => [
                    'name'        => 'Fruit - Strawberry',
                    'description' => 'Transaction Purpose',
                    'metas'       => [
                        'finance_term' => 'Purpose',
                    ],
                ],
                'fruit-blueberry' => [
                    'name'        => 'Fruit - Blueberry',
                    'description' => 'Transaction Purpose',
                    'metas'       => [
                        'finance_term' => 'Purpose',
                    ],
                ],
                'fruit-dragon-fruit' => [
                    'name'        => 'Fruit - Dragon Fruit',
                    'description' => 'Transaction Purpose',
                    'metas'       => [
                        'finance_term' => 'Purpose',
                    ],
                ],

                /*
                * Nuts.
                */
                'nut-peanut' => [
                    'name'        => 'Nut - Peanut / Chinabadam',
                    'description' => 'Transaction Purpose',
                    'metas'       => [
                        'finance_term' => 'Purpose',
                    ],
                ],
                'nut-almond' => [
                    'name'        => 'Nut - Almond / Kathbadam',
                    'description' => 'Transaction Purpose',
                    'metas'       => [
                        'finance_term' => 'Purpose',
                    ],
                ],
                'nut-cashew' => [
                    'name'        => 'Nut - Cashew / Kajubadam',
                    'description' => 'Transaction Purpose',
                    'metas'       => [
                        'finance_term' => 'Purpose',
                    ],
                ],
                'nut-walnut' => [
                    'name'        => 'Nut - Walnut / Akhrot',
                    'description' => 'Transaction Purpose',
                    'metas'       => [
                        'finance_term' => 'Purpose',
                    ],
                ],
                'nut-pistachio' => [
                    'name'        => 'Nut - Pistachio',
                    'description' => 'Transaction Purpose',
                    'metas'       => [
                        'finance_term' => 'Purpose',
                    ],
                ],

                /*
                * Oils.
                */
                'oil-ghee' => [
                    'name'        => 'Oil - Ghee',
                    'description' => 'Transaction Purpose',
                    'metas'       => [
                        'finance_term' => 'Purpose',
                    ],
                ],
                'oil-olive' => [
                    'name'        => 'Oil - Olive',
                    'description' => 'Transaction Purpose',
                    'metas'       => [
                        'finance_term' => 'Purpose',
                    ],
                ],
                'oil-mustard' => [
                    'name'        => 'Oil - Mustard',
                    'description' => 'Transaction Purpose',
                    'metas'       => [
                        'finance_term' => 'Purpose',
                    ],
                ],

                /*
                * Spices and cooking ingredients.
                */
                'spice-natural-honey' => [
                    'name'        => 'Spice - Natural Honey',
                    'description' => 'Transaction Purpose',
                    'metas'       => [
                        'finance_term' => 'Purpose',
                    ],
                ],
                'spice-litchi-honey' => [
                    'name'        => 'Spice - Litchi Honey',
                    'description' => 'Transaction Purpose',
                    'metas'       => [
                        'finance_term' => 'Purpose',
                    ],
                ],
                'spice-pink-salt' => [
                    'name'        => 'Spice - Pink Salt',
                    'description' => 'Transaction Purpose',
                    'metas'       => [
                        'finance_term' => 'Purpose',
                    ],
                ],
                'spice-salt' => [
                    'name'        => 'Spice - Salt',
                    'description' => 'Transaction Purpose',
                    'metas'       => [
                        'finance_term' => 'Purpose',
                    ],
                ],
                'spice-ginger' => [
                    'name'        => 'Spice - Ginger',
                    'description' => 'Transaction Purpose',
                    'metas'       => [
                        'finance_term' => 'Purpose',
                    ],
                ],
                'spice-garlic' => [
                    'name'        => 'Spice - Garlic',
                    'description' => 'Transaction Purpose',
                    'metas'       => [
                        'finance_term' => 'Purpose',
                    ],
                ],
                'spice-onion' => [
                    'name'        => 'Spice - Onion',
                    'description' => 'Transaction Purpose',
                    'metas'       => [
                        'finance_term' => 'Purpose',
                    ],
                ],
                'spice-green-chilli' => [
                    'name'        => 'Spice - Green Chilli',
                    'description' => 'Transaction Purpose',
                    'metas'       => [
                        'finance_term' => 'Purpose',
                    ],
                ],
                'spice-red-chilli' => [
                    'name'        => 'Spice - Red Chilli',
                    'description' => 'Transaction Purpose',
                    'metas'       => [
                        'finance_term' => 'Purpose',
                    ],
                ],
                'spice-dried-red-chilli' => [
                    'name'        => 'Spice - Dried Red Chilli',
                    'description' => 'Transaction Purpose',
                    'metas'       => [
                        'finance_term' => 'Purpose',
                    ],
                ],
                'spice-chilli-flakes' => [
                    'name'        => 'Spice - Chilli Flakes',
                    'description' => 'Transaction Purpose',
                    'metas'       => [
                        'finance_term' => 'Purpose',
                    ],
                ],
                'spice-bell-pepper' => [
                    'name'        => 'Spice - Bell Pepper / Capsicum',
                    'description' => 'Transaction Purpose',
                    'metas'       => [
                        'finance_term' => 'Purpose',
                    ],
                ],

                /*
                * Rice products.
                */
                'rice-puffed-rice' => [
                    'name'        => 'Rice - Puffed Rice',
                    'description' => 'Transaction Purpose',
                    'metas'       => [
                        'finance_term' => 'Purpose',
                    ],
                ],
            ];

            return $default_terms;

        }

        public function render_add_term_meta_fields(): void
        {

        }

        public function render_edit_term_meta_fields( int $term_id ): void
        {

        }

        public function save_term_meta( int $term_id ): void
        {
            $taxonomy_object = get_taxonomy( self::TAXONOMY );

            if ( ! $taxonomy_object || ! current_user_can( $taxonomy_object->cap->edit_terms )) 
            {
                return;
            }

            $value = isset(
                $_POST[ self::META_FINANCE_TERM ]
            )
                ? sanitize_text_field(
                    wp_unslash(
                        $_POST[ self::META_FINANCE_TERM ]
                    )
                )
                : '';

            if ( '' === $value ) {
                delete_term_meta(
                    $term_id,
                    self::META_FINANCE_TERM
                );

                return;
            }

            update_term_meta(
                $term_id,
                self::META_FINANCE_TERM,
                $value
            );
        }
    }
}