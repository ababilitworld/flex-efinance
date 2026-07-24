<?php
namespace Ababilithub\FlexEFinance\Package\Plugin\Shortcode\V1\Concrete\Finance\Transaction\List\Presentation\Template\List\Transaction;

(defined('ABSPATH') && defined('WPINC')) || exit();

use Ababilithub\{
    FlexAahub\Package\Plugin\Template\V1\Concrete\List\Table\Template as ListTableTemplate,
    FlexEFinance\Package\Plugin\Posttype\V1\Concrete\Finance\Transaction\Posttype as FinanceTransactionPosttype,
};

use const Ababilithub\{
    FlexEFinance\PLUGIN_URL,
};

class Template
{
    public function __construct()
    {
        add_action('admin_enqueue_scripts', [$this, 'enqueue_scripts']);
        add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts']);
    }

    public function enqueue_scripts(): void
    {
        $base_url = PLUGIN_URL . '/src/Package/Plugin/Shortcode/V1/Concrete/Finance/Transaction/List/Presentation/Template/List/PremiumCard/Asset/';
        wp_enqueue_style('flex-efinance-transaction-list', $base_url . 'Css/Style.css', [], null);
        wp_enqueue_script('flex-efinance-transaction-list', $base_url . 'Js/Script.js', [], null, true);
    }

    public static function transaction_list($posts = null, array $options = []): bool|string
    {
        $list_template = new ListTableTemplate();
        $posts = $posts ?: get_posts([
            'post_type' => FinanceTransactionPosttype::POSTTYPE,
            'posts_per_page' => -1,
            'post_status' => 'publish',
        ]);

        if (!$posts) {
            return '<p>' . esc_html__('No transactions found.', 'flex-efinance') . '</p>';
        }

        $options = array_merge([
            'type' => 'table',
            'size' => 'large',
            'color' => 'primary',
            'columns' => 3,
            'search_filter' => true,
            'sidebar_filter' => true,
            'filter_attribute' => 'fixed',
            'filter_type' => 'vertical',
            'filter_size' => 'medium',
            'filter_color' => 'primary',
            'table_attributes' => ['scroll-x'],
            'table_type' => 'normal',
            'table_size' => 'medium',
            'table_color' => 'primary',
            'pagination_attributes' => ['centered'],
            'pagination_type' => 'load-more',
            'pagination_size' => 'medium',
            'pagination_color' => 'primary',
            'per_page' => 10,
        ], $options);

        $taxonomies = apply_filters(
            'flex_efinance_transaction_list_taxonomies',
            get_object_taxonomies(FinanceTransactionPosttype::POSTTYPE, 'objects'),
            $posts,
            $options
        );
        $meta_fields = self::meta_fields($posts, $options);
        $items = array_map(
            static fn($post) => self::item($post, $taxonomies, $meta_fields),
            $posts
        );

        $filter_classes = sprintf(
            'faih-filter attribute-%s type-%s size-%s color-%s finance-transaction-list-sidebar',
            sanitize_html_class($options['filter_attribute']),
            sanitize_html_class($options['filter_type']),
            sanitize_html_class($options['filter_size']),
            sanitize_html_class($options['filter_color'])
        );

        ob_start();
        ?>
        <section class="finance-transaction-list-app">
            <?php if ($options['search_filter']) : ?>
                <div class="finance-transaction-list-search">
                    <input type="search" data-transaction-search placeholder="<?php esc_attr_e('Search transactions…', 'flex-efinance'); ?>">
                    <button type="button" data-transaction-reset><?php esc_html_e('Reset', 'flex-efinance'); ?></button>
                </div>
            <?php endif; ?>

            <div class="finance-transaction-list-layout<?php
                echo !$options['sidebar_filter'] ? ' without-sidebar' : '';
                echo $options['filter_type'] === 'horizontal' ? ' filter-horizontal' : '';
            ?>">
                <?php if ($options['sidebar_filter']) : ?>
                    <aside class="<?php echo esc_attr($filter_classes); ?>">
                        <div class="faih-filter-header finance-transaction-filter-heading">
                            <h3 class="faih-filter-title"><?php esc_html_e('Filters', 'flex-efinance'); ?></h3>
                            <div>
                                <button class="faih-filter-action" type="button" data-transaction-reset><?php esc_html_e('Clear all', 'flex-efinance'); ?></button>
                                <button class="faih-filter-toggle" type="button" data-filter-toggle aria-expanded="true">
                                    <?php esc_html_e('Toggle filters', 'flex-efinance'); ?>
                                </button>
                            </div>
                        </div>
                        <div class="faih-filter-body">
                            <?php self::filters($taxonomies, $meta_fields, $posts); ?>
                        </div>
                    </aside>
                <?php endif; ?>

                <div class="finance-transaction-list-results">
                    <?php
                    echo $list_template->render($items, [
                        'type' => $options['type'],
                        'size' => $options['size'],
                        'color' => $options['color'],
                        'columns' => $options['columns'],
                        'empty_message' => __('No transactions found.', 'flex-efinance'),
                        'table' => [
                            'attributes' => $options['table_attributes'],
                            'type' => $options['table_type'],
                            'size' => $options['table_size'],
                            'color' => $options['table_color'],
                        ],
                        'pagination' => [
                            'enabled' => $options['pagination_type'] !== 'none',
                            'type' => $options['pagination_type'],
                            'attributes' => $options['pagination_attributes'],
                            'size' => $options['pagination_size'],
                            'color' => $options['pagination_color'],
                            'per_page' => $options['per_page'],
                            'labels' => [
                                'aria' => __('Transaction list pagination', 'flex-efinance'),
                            ],
                        ],
                    ]);
                    ?>
                    <p class="finance-transaction-list-empty" hidden><?php esc_html_e('No transactions match the selected filters.', 'flex-efinance'); ?></p>
                </div>
            </div>
        </section>
        <?php
        return ob_get_clean();
    }

    private static function item($post, array $taxonomies, array $meta_fields): array
    {
        $fields = [];
        $labels = [];
        $attributes = ['data-search' => strtolower(wp_strip_all_tags(get_the_title($post)))];

        foreach ($taxonomies as $taxonomy) {
            $names = wp_get_post_terms($post->ID, $taxonomy->name, ['fields' => 'names']);
            $slugs = wp_get_post_terms($post->ID, $taxonomy->name, ['fields' => 'slugs']);
            $fields['tax_' . $taxonomy->name] = is_wp_error($names) || !$names ? '—' : implode(', ', $names);
            $labels['tax_' . $taxonomy->name] = $taxonomy->label;
            $attributes['data-tax-' . sanitize_key($taxonomy->name)] = is_wp_error($slugs) ? '' : implode('|', $slugs);
        }

        foreach ($meta_fields as $key => $field) {
            $value = get_post_meta($post->ID, $key, true);
            if (!empty($field['display'])) {
                $fields['meta_' . $key] = self::format_value($value, $field);
                $labels['meta_' . $key] = $field['label'];
            }
            if (!empty($field['filterable'])) {
                $attributes['data-meta-' . sanitize_key($key)] = is_scalar($value) ? strtolower((string) $value) : '';
            }
        }

        return apply_filters('flex_efinance_transaction_list_item', [
            'title' => get_the_title($post),
            'url' => get_permalink($post),
            'accent' => self::format_value(get_post_meta($post->ID, 'trx-amount', true), ['type' => 'number']),
            'fields' => $fields,
            'labels' => $labels,
            'attributes' => $attributes,
        ], $post, $taxonomies, $meta_fields);
    }

    private static function filters(array $taxonomies, array $meta_fields, array $posts): void
    {
        foreach ($taxonomies as $taxonomy) {
            $terms = get_terms(['taxonomy' => $taxonomy->name, 'hide_empty' => true]);
            if (is_wp_error($terms) || !$terms) {
                continue;
            }
            echo '<details class="faih-filter-group finance-transaction-filter-group" open>';
            echo '<summary>' . esc_html($taxonomy->label) . '</summary><div class="finance-transaction-filter-options">';
            foreach ($terms as $term) {
                printf(
                    '<label><input type="checkbox" data-filter-taxonomy="%s" value="%s"><span>%s</span><small>%d</small></label>',
                    esc_attr($taxonomy->name),
                    esc_attr($term->slug),
                    esc_html($term->name),
                    (int) $term->count
                );
            }
            echo '</div></details>';
        }

        foreach ($meta_fields as $key => $field) {
            if (empty($field['filterable'])) {
                continue;
            }
            $values = [];
            foreach ($posts as $post) {
                $value = get_post_meta($post->ID, $key, true);
                if (is_scalar($value) && $value !== '') {
                    $values[] = (string) $value;
                }
            }
            $values = array_values(array_unique($values));
            if (!$values) {
                continue;
            }
            echo '<details class="faih-filter-group finance-transaction-filter-group"><summary>' . esc_html($field['label']) . '</summary>';
            echo '<div class="finance-transaction-filter-options">';
            foreach ($values as $value) {
                printf(
                    '<label><input type="checkbox" data-filter-meta="%s" value="%s"><span>%s</span></label>',
                    esc_attr($key),
                    esc_attr($value),
                    esc_html($value)
                );
            }
            echo '</div></details>';
        }
    }

    private static function meta_fields(array $posts, array $options): array
    {
        return apply_filters('flex_efinance_transaction_list_meta_fields', [
            'trx-date' => ['label' => __('Transaction Date', 'flex-efinance'), 'type' => 'date', 'display' => true, 'filterable' => true],
            'pr-account' => ['label' => __('Principal Account', 'flex-efinance'), 'type' => 'text', 'display' => true, 'filterable' => true],
            'bf-account' => ['label' => __('Beneficiary Account', 'flex-efinance'), 'type' => 'text', 'display' => true, 'filterable' => true],
            'trx-amount' => ['label' => __('Amount', 'flex-efinance'), 'type' => 'number', 'display' => true, 'filterable' => true],
            'trx-dcr-book-id' => ['label' => __('DCR Book ID', 'flex-efinance'), 'type' => 'text', 'display' => true, 'filterable' => true],
            'trx-dcr-book-trx-id' => ['label' => __('DCR Transaction ID', 'flex-efinance'), 'type' => 'text', 'display' => true, 'filterable' => true],
        ], $posts, $options);
    }

    private static function format_value($value, array $field): string
    {
        if ($value === '' || $value === null || $value === []) {
            return '—';
        }
        if (($field['type'] ?? '') === 'number' && is_numeric($value)) {
            return number_format_i18n((float) $value, 2);
        }
        return is_array($value) ? implode(', ', array_map('strval', $value)) : (string) $value;
    }
}
