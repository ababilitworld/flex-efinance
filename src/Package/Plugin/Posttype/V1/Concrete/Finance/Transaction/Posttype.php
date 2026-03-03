<?php
namespace Ababilithub\FlexEFinance\Package\Plugin\Posttype\V1\Concrete\Finance\Transaction;

(defined('ABSPATH') && defined('WPINC')) || exit();

use Ababilithub\{
    FlexPhp\Package\Mixin\V1\Standard\Mixin as StandardMixin,
    FlexWordpress\Package\Posttype\V1\Mixin\Posttype as WpPosttypeMixin,
    FlexWordpress\Package\Posttype\V1\Base\Posttype as BasePosttype,
    FlexEFinance\Package\Plugin\Posttype\V1\Concrete\Finance\Transaction\Presentation\Template\List\PremiumCard\Template as PosttypeListTemplate,
    FlexEFinance\Package\Plugin\Posttype\V1\Concrete\Finance\Transaction\Presentation\Template\Single\Template as PosttypeTemplate,
    FlexEFinance\Package\Plugin\Posttype\V1\Concrete\Finance\Transaction\Setting\Setting as PosttypeSetting,
    FlexEFinance\Package\Plugin\Posttype\V1\Concrete\Finance\Transaction\PostMeta\PostMetaBox\Manager\PostMetaBox as FinanceTransactionMetaBoxManager,
    FlexEFinance\Package\Plugin\Posttype\V1\Concrete\Finance\Transaction\PostMeta\PostMetaBoxContent\Manager\PostMetaBoxContent as FinanceTransactionMetaBoxContentManager,
    
};

use const Ababilithub\{
    FlexEFinance\PLUGIN_PRE_UNDS,
    FlexEFinance\PLUGIN_DIR,
};

class Posttype extends BasePosttype 
{ 
    use WpPosttypeMixin;
    public const POSTTYPE = 'ftranx';

    private $template_service;

    private $meta_box_manager;
    private $meta_box_content_manager;
    
    public function init() : void
    {
        $this->posttype = self::POSTTYPE;
        $this->slug = self::POSTTYPE;

        $this->set_labels([
            'name' => esc_html__('Transactions', 'flex-efinance'),
            'singular_name' => esc_html__('Transaction', 'flex-efinance'),
            'menu_name' => esc_html__('Transactions', 'flex-efinance'),
            'name_admin_bar' => esc_html__('Transactions', 'flex-efinance'),
            'archives' => esc_html__('Transaction List', 'flex-efinance'),
            'attributes' => esc_html__('Transaction List', 'flex-efinance'),
            'parent_item_colon' => esc_html__('Transaction Item : ', 'flex-efinance'),
            'all_items' => esc_html__('All Transaction', 'flex-efinance'),
            'add_new_item' => esc_html__('Add new Transaction', 'flex-efinance'),
            'add_new' => esc_html__('Add new Transaction', 'flex-efinance'),
            'new_item' => esc_html__('New Transaction', 'flex-efinance'),
            'edit_item' => esc_html__('Edit Transaction', 'flex-efinance'),
            'update_item' => esc_html__('Update Transaction', 'flex-efinance'),
            'view_item' => esc_html__('View Transaction', 'flex-efinance'),
            'view_items' => esc_html__('View Transactions', 'flex-efinance'),
            'search_items' => esc_html__('Search Transactions', 'flex-efinance'),
            'not_found' => esc_html__('Transaction Not found', 'flex-efinance'),
            'not_found_in_trash' => esc_html__('Transaction Not found in Trash', 'flex-efinance'),
            'featured_image' => esc_html__('Transaction Feature Image', 'flex-efinance'),
            'set_featured_image' => esc_html__('Set Transaction Feature Image', 'flex-efinance'),
            'remove_featured_image' => esc_html__('Remove Feature Image', 'flex-efinance'),
            'use_featured_image' => esc_html__('Use as Transaction featured image', 'flex-efinance'),
            'insert_into_item' => esc_html__('Insert into Transaction', 'flex-efinance'),
            'uploaded_to_this_item' => esc_html__('Uploaded to this ', 'flex-efinance'),
            'items_list' => esc_html__('Transaction list', 'flex-efinance'),
            'items_list_navigation' => esc_html__('Transaction list navigation', 'flex-efinance'),
            'filter_items_list' => esc_html__('Filter Transaction List', 'flex-efinance')
        ]);

        $this->set_posttype_supports(
            array('title', 'thumbnail', 'editor')
        );

        $this->set_taxonomies(
            array('finance-transaction-type','finance-transaction-action','finance-transaction-domain')
        );

        $this->set_args([
            'public' => true,
            'publicly_queryable' => true,
            'show_ui' => true,
            'show_in_nav_menus' => true,
            'show_in_menu' => false, // Don't show in menu by default
            'capability_type' => [self::POSTTYPE,self::POSTTYPE.'es'], // Capability Type
            'map_meta_cap' => true, // Handle capability by wordpress
            'labels' => $this->labels,
            'menu_icon' => "dashicons-admin-post",
            'rewrite' => ['slug' => $this->slug,'with_front' => false],
            'has_archive' => true,        // If you want archive pages
            'supports' => $this->posttype_supports,
            'taxonomies' => $this->taxonomies,
        ]);

        $this->init_service();
        $this->init_hook();

    }

    public function init_service(): void
    {
       $this->template_service = new PosttypeTemplate();    
    }

    public function init_hook(): void
    {
        add_action('after_setup_theme', [$this, 'init_theme_supports'],0);

        add_action('add_meta_boxes', function () {
            //(new FinanceTransactionMetaBoxManager())->boot();
        });

        add_action('add_meta_boxes', function () {
            //(new FinanceTransactionMetaBoxContentManager())->boot();
        });

        add_action('save_post', function ($post_id, $post, $update) {
            //(new FinanceTransactionMetaBoxContentManager())->save_post($post_id, $post, $update);
        }, 10, 3);

        //add_filter(PLUGIN_PRE_UNDS.'_admin_menu', [$this, 'add_menu_items']);
        add_filter('the_content', [$this, 'single_post']);
        
        add_filter('post_row_actions', [$this, 'row_action_view_details'], 10, 2);
        add_filter('page_row_actions', [$this, 'row_action_view_details'], 10, 2);


    }

    public function init_theme_supports()
    {
        add_theme_support('post-thumbnails', [self::POSTTYPE]);
        add_theme_support('editor-color-palette', [
            [
                'name'  => 'Primary Blue',
                'slug'  => 'primary-blue',
                'color' => '#3366FF',
            ],
        ]);
        add_theme_support('align-wide');
        add_theme_support('responsive-embeds');
    }

    public function single_post($content)
    {
        // Only modify content on single post pages of specific post types
        if (!is_singular() || !in_the_loop() || !is_main_query()) 
        {
            return $content;
        }

        global $post;
        
        if ($post->post_type !== self::POSTTYPE) 
        {
            return $content;
        }

        // Prevent infinite recursion
        remove_filter('the_content', [$this, 'single_post']);
        
        // Get template content
        $template_content = $this->template_service->single_post($post);
        
        // Re-add our filter
        add_filter('the_content', [$this, 'single_post']);
        
        // Combine with original content
        return $template_content;
    }

}