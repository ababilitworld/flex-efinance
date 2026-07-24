<?php

namespace Ababilithub\FlexEFinance\Package\Plugin\Shortcode\V1\Concrete\Finance\Transaction\List;

(defined('ABSPATH') && defined('WPINC')) || exit();

use Ababilithub\{
    FlexWordpress\Package\Shortcode\V1\Base\Shortcode as BaseShortcode,
    FlexEFinance\Package\Plugin\Posttype\V1\Concrete\Finance\Transaction\Posttype as FinanceTransactionPosttype,
    FlexEFinance\Package\Plugin\Shortcode\V1\Concrete\Finance\Transaction\List\Presentation\Template\List\Transaction\Template as PosttypeListTemplate
};

use const Ababilithub\{
    FlexEFinance\PLUGIN_PRE_UNDS,
    FlexEFinance\PLUGIN_PRE_HYPH,
};

class Shortcode extends BaseShortcode
{
    public function init(): void
    {
        $this->set_tag(PLUGIN_PRE_HYPH.'-'.FinanceTransactionPosttype::POSTTYPE.'-list'); 

        $this->set_default_attributes([
            'type' => 'table',
            'style' => '',
            'size' => 'medium',
            'color' => 'primary',
            'columns' => '3',
            'pagination' => 'yes',
            'show' => '10',
            'sort' => 'DESC',
            'sort_by' => 'date',
            'status' => 'publish',
            'pagination_style' => 'load_more',
            'pagination_attribute' => 'centered,rounded',
            'pagination_type' => 'paged',
            'pagination_size' => 'small',
            'pagination_color' => 'primary',
            'search_filter' => 'yes',
            'sidebar_filter' => 'yes',
            'filter_attribute' => 'fixed',
            'filter_type' => 'vertical',
            'filter_size' => 'medium',
            'filter_color' => 'primary',
            'table_attribute' => 'scroll-x,bordered,hover,sticky-header,nowrap',
            'table_type' => 'normal',
            'table_size' => 'medium',
            'table_color' => 'primary',
            'transaction_type' => '',
            'purpose' => '',
            'medium' => '',
            'action' => '',
            'debug' => 'no'
        ]);

        $this->init_hook();
        $this->init_service();
    }

    public function init_hook(): void
    {
        add_action(PLUGIN_PRE_UNDS.'_'.FinanceTransactionPosttype::POSTTYPE."_"."list", [$this, 'show_list']);
    }

    public function init_service(): void
    {
        new PosttypeListTemplate();
    }

    public function render(array $attributes): string
    {
        $this->set_attributes($attributes);
        $params = $this->get_attributes();
        
        ob_start();
        do_action(PLUGIN_PRE_UNDS.'_'.FinanceTransactionPosttype::POSTTYPE."_"."list", $params);
        return ob_get_clean();
    }

    public function show_list(array $params): void
    {
        try {
            $type = !empty($params['style']) ? $params['style'] : $params['type'];
            $type = $this->allowed_value($type, ['grid', 'table', 'masonry'], 'grid');
            $size = $this->allowed_value(
                $params['size'],
                ['small', 'medium', 'large', 'xl', 'xxl', 'xxxl'],
                'medium'
            );
            $color = $this->allowed_value(
                $params['color'],
                ['primary', 'secondary', 'success', 'info', 'warning', 'danger', 'error', 'neutral'],
                'primary'
            );
            $columns = max(1, min(6, (int) $params['columns']));
            $filter_attribute = $this->allowed_value(
                $params['filter_attribute'],
                ['fixed', 'collapsible'],
                'collapsible'
            );
            $filter_type = $this->allowed_value(
                $params['filter_type'],
                ['horizontal', 'vertical'],
                'vertical'
            );
            $filter_size = $this->allowed_value(
                $params['filter_size'],
                ['small', 'medium', 'large', 'xl', 'xxl', 'xxxl'],
                'medium'
            );
            $filter_color = $this->allowed_value(
                $params['filter_color'],
                ['primary', 'secondary', 'success', 'info', 'warning', 'danger', 'error', 'neutral'],
                'primary'
            );
            $table_attributes = $this->allowed_values(
                $params['table_attribute'],
                ['scroll-x', 'bordered', 'hover', 'sticky-header', 'nowrap'],
                ['scroll-x']
            );
            $table_type_value = $params['table_type'] === 'stripped' ? 'striped' : $params['table_type'];
            $table_type = $this->allowed_value($table_type_value, ['normal', 'striped'], 'normal');
            $table_size = $this->allowed_value(
                $params['table_size'],
                ['small', 'medium', 'large', 'xl', 'xxl', 'xxxl'],
                'medium'
            );
            $table_color = $this->allowed_value(
                $params['table_color'],
                ['primary', 'secondary', 'success', 'info', 'warning', 'danger', 'error', 'neutral'],
                'primary'
            );
            $pagination_attributes = $this->allowed_values(
                $params['pagination_attribute'],
                ['centered', 'end', 'rounded', 'borderless', 'compact', 'full-width'],
                ['centered']
            );
            $pagination_type_value = $params['pagination_type'] ?: $params['pagination_style'];
            $pagination_type_value = str_replace('_', '-', (string) $pagination_type_value);
            $pagination_type = $this->allowed_value(
                $pagination_type_value,
                ['paged', 'load-more', 'previous-next', 'none'],
                'load-more'
            );
            if ($params['pagination'] !== 'yes') {
                $pagination_type = 'none';
            }
            $pagination_size = $this->allowed_value(
                $params['pagination_size'],
                ['small', 'medium', 'large', 'xl', 'xxl', 'xxxl'],
                'medium'
            );
            $pagination_color = $this->allowed_value(
                $params['pagination_color'],
                ['primary', 'secondary', 'success', 'info', 'warning', 'danger', 'error', 'neutral'],
                'primary'
            );

            // Build query args
            $args = [
                'post_type' => FinanceTransactionPosttype::POSTTYPE,
                'posts_per_page' => $params['pagination'] === 'yes' ? -1 : (int) $params['show'],
                'orderby' => sanitize_text_field($params['sort_by']),
                'order' => sanitize_text_field($params['sort']),
                'post_status' => sanitize_text_field($params['status'])
            ];

            // Add taxonomy filters
            $tax_queries = [];

            $taxonomy_filters = [
                'transaction_type' => 'finance-transaction-type',
                'purpose' => 'finance-transaction-purpose',
                'medium' => 'finance-transaction-medium',
                'action' => 'finance-transaction-action',
            ];

            foreach ($taxonomy_filters as $attribute => $taxonomy) {
                if (empty($params[$attribute])) {
                    continue;
                }

                $tax_queries[] = [
                    'taxonomy' => $taxonomy,
                    'field' => 'slug',
                    'terms' => array_map('sanitize_title', explode(',', $params[$attribute])),
                ];
            }

            if (!empty($tax_queries)) {
                $args['tax_query'] = $tax_queries;
                if (count($tax_queries) > 1) {
                    $args['tax_query']['relation'] = 'AND';
                }
            }

            /**
             * Modify the transaction query without replacing the shortcode.
             *
             * @param array $args   WP_Query/get_posts arguments.
             * @param array $params Sanitized shortcode attributes.
             */
            $args = apply_filters('flex_efinance_transaction_list_query_args', $args, $params);

            // Debug output if enabled
            if ($params['debug'] === 'yes') {
                echo '<pre>Query Args: ' . print_r($args, true) . '</pre>';
            }

            // Get posts
            $posts = apply_filters(
                'flex_efinance_transaction_list_posts',
                get_posts($args),
                $args,
                $params
            );

            if (empty($posts)) {
                echo '<div class="finance-transaction-list-notice">' . esc_html__('No transactions found matching your criteria.', 'flex-efinance') . '</div>';
                return;
            }

            //echo "<pre>";print_r($posts);echo "</pre>";exit;

            // Render the list with template
            $template_options = [
                'type' => $type,
                'size' => $size,
                'color' => $color,
                'columns' => $columns,
                'search_filter' => $params['search_filter'] === 'yes',
                'sidebar_filter' => $params['sidebar_filter'] === 'yes',
                'filter_attribute' => $filter_attribute,
                'filter_type' => $filter_type,
                'filter_size' => $filter_size,
                'filter_color' => $filter_color,
                'table_attributes' => $table_attributes,
                'table_type' => $table_type,
                'table_size' => $table_size,
                'table_color' => $table_color,
                'pagination_attributes' => $pagination_attributes,
                'pagination_type' => $pagination_type,
                'pagination_size' => $pagination_size,
                'pagination_color' => $pagination_color,
                'per_page' => max(1, (int) $params['show']),
            ];

            echo PosttypeListTemplate::transaction_list(
                $posts,
                apply_filters('flex_efinance_transaction_list_options', $template_options, $params, $posts)
            );

        } catch (\Exception $e) {
            if ($params['debug'] === 'yes') {
                echo '<div class="finance-transaction-list-error">' . esc_html__('Error: ', 'flex-efinance') . esc_html($e->getMessage()) . '</div>';
            } else {
                echo '<div class="finance-transaction-list-error">' . esc_html__('Unable to display transactions at this time.', 'flex-efinance') . '</div>';
            }
        }
    }

    private function allowed_value($value, array $allowed, string $fallback): string
    {
        $value = sanitize_key((string) $value);
        return in_array($value, $allowed, true) ? $value : $fallback;
    }

    private function allowed_values($value, array $allowed, array $fallback): array
    {
        $values = preg_split('/[\s,|]+/', strtolower((string) $value), -1, PREG_SPLIT_NO_EMPTY);
        $values = array_values(array_unique(array_intersect(array_map('sanitize_key', $values), $allowed)));
        return $values ?: $fallback;
    }
}
