<?php
namespace Ababilithub\FlexEFinance\Package\Plugin\Shortcode\V1\Concrete\Finance\Transaction\List\Presentation\Template\List\PremiumCard;

(defined('ABSPATH') && defined('WPINC')) || die();

use Ababilithub\FlexEFinance\Package\Plugin\Posttype\V1\Concrete\Finance\Transaction\Posttype as FinanceTransactionPosttype;

class Template
{
    private $asset_url;

    public function __construct()
    {
        $this->asset_url = plugin_dir_url(__FILE__) . 'Asset/';
        add_action('admin_enqueue_scripts', [$this, 'enqueue_scripts']);
        add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts']);
    }

    public function enqueue_scripts(): void
    {
        $handle = 'flex-efinance-transaction-list';
        wp_enqueue_style($handle, $this->asset_url . 'Css/Style.css', [], null);
        wp_enqueue_script($handle, $this->asset_url . 'Js/Script.js', [], null, true);
    }

    public static function transaction_list($posts = null, array $options = []): bool|string
    {
        $posts = $posts ?: get_posts([
            'post_type' => FinanceTransactionPosttype::POSTTYPE,
            'posts_per_page' => -1,
            'orderby' => 'date',
            'order' => 'DESC',
        ]);

        if (empty($posts)) {
            return '<p>' . esc_html__('No transactions found.', 'flex-efinance') . '</p>';
        }

        $options = array_merge([
            'type' => 'grid',
            'size' => 'medium',
            'color' => 'primary',
            'columns' => 3,
            'search_filter' => true,
            'sidebar_filter' => true,
            'filter_attribute' => 'collapsible',
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

        $taxonomies = self::get_taxonomies($posts, $options);
        $meta_fields = self::get_meta_fields($posts, $options);

        $classes = sprintf(
            'faih-list type-%s size-%s color-%s finance-transaction-list',
            sanitize_html_class($options['type']),
            sanitize_html_class($options['size']),
            sanitize_html_class($options['color'])
        );
        $style = '--faih-list-columns:' . max(1, min(6, (int) $options['columns'])) . ';';
        $filter_classes = sprintf(
            'faih-filter attribute-%s type-%s size-%s color-%s finance-transaction-list-sidebar',
            sanitize_html_class($options['filter_attribute']),
            sanitize_html_class($options['filter_type']),
            sanitize_html_class($options['filter_size']),
            sanitize_html_class($options['filter_color'])
        );
        $table_attributes = array_map('sanitize_html_class', (array) $options['table_attributes']);
        $table_wrapper_classes = 'faih-table-wrapper';
        if (in_array('scroll-x', $table_attributes, true)) {
            $table_wrapper_classes .= ' attribute-scroll-x';
        }
        $table_classes = sprintf(
            'faih-table type-%s size-%s color-%s',
            sanitize_html_class($options['table_type']),
            sanitize_html_class($options['table_size']),
            sanitize_html_class($options['table_color'])
        );
        foreach (array_diff($table_attributes, ['scroll-x']) as $table_attribute) {
            $table_classes .= ' attribute-' . $table_attribute;
        }
        $pagination_classes = sprintf(
            'faih-pagination type-%s size-%s color-%s',
            sanitize_html_class($options['pagination_type']),
            sanitize_html_class($options['pagination_size']),
            sanitize_html_class($options['pagination_color'])
        );
        foreach ((array) $options['pagination_attributes'] as $pagination_attribute) {
            $pagination_classes .= ' attribute-' . sanitize_html_class($pagination_attribute);
        }

        ob_start();
        ?>
        <section class="finance-transaction-list-app">
            <?php if ($options['search_filter']) : ?>
                <div class="finance-transaction-list-search">
                    <label class="screen-reader-text" for="finance-transaction-search"><?php esc_html_e('Search transactions', 'flex-efinance'); ?></label>
                    <input id="finance-transaction-search" type="search" data-transaction-search
                        placeholder="<?php esc_attr_e('Search transactions…', 'flex-efinance'); ?>">
                    <button type="button" data-transaction-reset><?php esc_html_e('Reset', 'flex-efinance'); ?></button>
                </div>
            <?php endif; ?>

            <div class="finance-transaction-list-layout<?php
                echo !$options['sidebar_filter'] ? ' without-sidebar' : '';
                echo $options['filter_type'] === 'horizontal' ? ' filter-horizontal' : '';
            ?>">
            <?php if ($options['sidebar_filter']) : ?>
                <aside class="<?php echo esc_attr($filter_classes); ?>" aria-label="<?php esc_attr_e('Transaction filters', 'flex-efinance'); ?>">
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
                    <?php foreach ($taxonomies as $taxonomy) :
                        $terms = get_terms(['taxonomy' => $taxonomy->name, 'hide_empty' => true]);
                        if (is_wp_error($terms) || empty($terms)) {
                            continue;
                        }
                        ?>
                        <details class="faih-filter-group finance-transaction-filter-group" open>
                            <summary><?php echo esc_html($taxonomy->label); ?></summary>
                            <div class="finance-transaction-filter-options">
                                <?php foreach ($terms as $term) : ?>
                                    <label>
                                        <input type="checkbox" data-filter-taxonomy="<?php echo esc_attr($taxonomy->name); ?>"
                                            value="<?php echo esc_attr($term->slug); ?>">
                                        <span><?php echo esc_html($term->name); ?></span>
                                        <small><?php echo esc_html($term->count); ?></small>
                                    </label>
                                <?php endforeach; ?>
                            </div>
                        </details>
                    <?php endforeach; ?>

                    <?php foreach ($meta_fields as $key => $field) :
                        if (empty($field['filterable']) || in_array($field['type'], ['image', 'gallery', 'attachments'], true)) {
                            continue;
                        }
                        $values = self::get_meta_filter_values($posts, $key);
                        if (empty($values)) {
                            continue;
                        }
                        ?>
                        <details class="faih-filter-group finance-transaction-filter-group">
                            <summary><?php echo esc_html($field['label']); ?></summary>
                            <div class="finance-transaction-filter-options">
                                <?php foreach ($values as $value) : ?>
                                    <label>
                                        <input type="checkbox" data-filter-meta="<?php echo esc_attr($key); ?>"
                                            value="<?php echo esc_attr($value); ?>">
                                        <span><?php echo esc_html($value); ?></span>
                                    </label>
                                <?php endforeach; ?>
                            </div>
                        </details>
                    <?php endforeach; ?>
                    </div>
                </aside>
            <?php endif; ?>

            <div class="finance-transaction-list-results">
            <?php if ($options['type'] === 'table') : ?>
                <div class="<?php echo esc_attr($table_wrapper_classes); ?>">
            <?php endif; ?>
            <div class="<?php echo esc_attr($classes . ($options['type'] === 'table' ? ' ' . $table_classes : '')); ?>" style="<?php echo esc_attr($style); ?>">
            <?php if ($options['type'] === 'table') : ?>
                <div class="faih-list-header faih-table-header faih-table-row" role="row">
                    <div class="faih-list-cell faih-table-cell" role="columnheader"><?php esc_html_e('Transaction', 'flex-efinance'); ?></div>
                    <div class="faih-list-cell faih-table-cell" role="columnheader"><?php esc_html_e('Type', 'flex-efinance'); ?></div>
                    <div class="faih-list-cell faih-table-cell" role="columnheader"><?php esc_html_e('Amount', 'flex-efinance'); ?></div>
                    <div class="faih-list-cell faih-table-cell" role="columnheader"><?php esc_html_e('Date', 'flex-efinance'); ?></div>
                    <?php foreach ($taxonomies as $taxonomy) : ?>
                        <div class="faih-list-cell faih-table-cell" role="columnheader"><?php echo esc_html($taxonomy->label); ?></div>
                    <?php endforeach; ?>
                    <?php foreach ($meta_fields as $field) :
                        if (empty($field['display'])) {
                            continue;
                        }
                        ?>
                        <div class="faih-list-cell faih-table-cell" role="columnheader"><?php echo esc_html($field['label']); ?></div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <?php foreach ($posts as $post) :
                $amount = get_post_meta($post->ID, 'trx-amount', true);
                $types = get_the_terms($post->ID, 'finance-transaction-type');
                $type_name = (!is_wp_error($types) && !empty($types)) ? $types[0]->name : '—';
                $permalink = get_permalink($post);
                $attributes = self::item_filter_attributes($post, $taxonomies, $meta_fields);
                ?>
                <?php if ($options['type'] === 'table') : ?>
                    <div class="faih-list-item faih-table-row" role="row" <?php echo $attributes; ?>>
                        <div class="faih-list-cell faih-table-cell" role="cell">
                            <a class="faih-list-item-link" href="<?php echo esc_url($permalink); ?>">
                                <?php echo esc_html(get_the_title($post)); ?>
                            </a>
                        </div>
                        <div class="faih-list-cell faih-table-cell" role="cell"><?php echo esc_html($type_name); ?></div>
                        <div class="faih-list-cell faih-table-cell faih-list-item-accent" role="cell"><?php echo esc_html(self::format_amount($amount)); ?></div>
                        <div class="faih-list-cell faih-table-cell" role="cell"><?php echo esc_html(get_the_date('', $post)); ?></div>
                        <?php foreach ($taxonomies as $taxonomy) : ?>
                            <div class="faih-list-cell faih-table-cell" role="cell"><?php echo esc_html(self::taxonomy_names($post->ID, $taxonomy->name)); ?></div>
                        <?php endforeach; ?>
                        <?php foreach ($meta_fields as $key => $field) :
                            if (empty($field['display'])) {
                                continue;
                            }
                            ?>
                            <div class="faih-list-cell faih-table-cell" role="cell">
                                <?php echo wp_kses_post(self::format_meta_value(get_post_meta($post->ID, $key, true), $field)); ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else : ?>
                    <article class="faih-list-item" <?php echo $attributes; ?>>
                        <div class="faih-list-item-content">
                            <h3 class="faih-list-item-title">
                                <a class="faih-list-item-link" href="<?php echo esc_url($permalink); ?>">
                                    <?php echo esc_html(get_the_title($post)); ?>
                                </a>
                            </h3>
                            <div class="faih-list-item-meta">
                                <span><?php echo esc_html($type_name); ?></span>
                                <span><?php echo esc_html(get_the_date('', $post)); ?></span>
                            </div>
                            <p class="faih-list-item-accent"><?php echo esc_html(self::format_amount($amount)); ?></p>
                            <dl class="finance-transaction-list-meta">
                                <?php foreach ($taxonomies as $taxonomy) :
                                    $taxonomy_value = self::taxonomy_names($post->ID, $taxonomy->name);
                                    if ($taxonomy_value === '—') {
                                        continue;
                                    }
                                    ?>
                                    <div>
                                        <dt><?php echo esc_html($taxonomy->label); ?></dt>
                                        <dd><?php echo esc_html($taxonomy_value); ?></dd>
                                    </div>
                                <?php endforeach; ?>
                                <?php foreach ($meta_fields as $key => $field) :
                                    $value = get_post_meta($post->ID, $key, true);
                                    if ($value === '' || $value === [] || $value === null || empty($field['display'])) {
                                        continue;
                                    }
                                    ?>
                                    <div>
                                        <dt><?php echo esc_html($field['label']); ?></dt>
                                        <dd><?php echo wp_kses_post(self::format_meta_value($value, $field)); ?></dd>
                                    </div>
                                <?php endforeach; ?>
                            </dl>
                            <?php if ($options['type'] === 'masonry' && has_excerpt($post)) : ?>
                                <div class="faih-list-item-excerpt"><?php echo wp_kses_post(get_the_excerpt($post)); ?></div>
                            <?php endif; ?>
                        </div>
                    </article>
                <?php endif; ?>
            <?php endforeach; ?>
            </div>
            <?php if ($options['type'] === 'table') : ?>
                </div>
            <?php endif; ?>
            <p class="finance-transaction-list-empty" hidden><?php esc_html_e('No transactions match the selected filters.', 'flex-efinance'); ?></p>
            <?php if ($options['pagination_type'] !== 'none') : ?>
                <nav class="<?php echo esc_attr($pagination_classes); ?>"
                    data-pagination
                    data-pagination-type="<?php echo esc_attr($options['pagination_type']); ?>"
                    data-per-page="<?php echo esc_attr(max(1, (int) $options['per_page'])); ?>"
                    aria-label="<?php esc_attr_e('Transaction list pagination', 'flex-efinance'); ?>">
                    <button class="faih-pagination-button faih-pagination-previous" type="button" data-page-previous>
                        <?php esc_html_e('Previous', 'flex-efinance'); ?>
                    </button>
                    <span class="faih-pagination-pages" data-pagination-pages></span>
                    <span class="faih-pagination-status" data-pagination-status aria-live="polite"></span>
                    <button class="faih-pagination-button faih-pagination-next" type="button" data-page-next>
                        <?php esc_html_e('Next', 'flex-efinance'); ?>
                    </button>
                    <button class="faih-pagination-button faih-pagination-load-more" type="button" data-load-more>
                        <?php esc_html_e('Load more', 'flex-efinance'); ?>
                    </button>
                </nav>
            <?php endif; ?>
            </div>
            </div>
        </section>
        <?php
        return ob_get_clean();
    }

    /**
     * Backwards-compatible entry point for callers of the old template.
     */
    public static function deed_list($posts = null, array $options = []): bool|string
    {
        return self::transaction_list($posts, $options);
    }

    private static function format_amount($amount): string
    {
        if ($amount === '' || $amount === null) {
            return '—';
        }

        return is_numeric($amount) ? number_format_i18n((float) $amount, 2) : (string) $amount;
    }

    private static function get_taxonomies(array $posts, array $options): array
    {
        $taxonomies = get_object_taxonomies(FinanceTransactionPosttype::POSTTYPE, 'objects');
        return apply_filters('flex_efinance_transaction_list_taxonomies', $taxonomies, $posts, $options);
    }

    private static function get_meta_fields(array $posts, array $options): array
    {
        $fields = [
            'trx-date' => ['label' => __('Transaction Date', 'flex-efinance'), 'type' => 'date', 'display' => true, 'filterable' => true],
            'pr-account' => ['label' => __('Principal Account', 'flex-efinance'), 'type' => 'text', 'display' => true, 'filterable' => true],
            'bf-account' => ['label' => __('Beneficiary Account', 'flex-efinance'), 'type' => 'text', 'display' => true, 'filterable' => true],
            'trx-amount' => ['label' => __('Amount', 'flex-efinance'), 'type' => 'number', 'display' => true, 'filterable' => true],
            'trx-dcr-book-id' => ['label' => __('DCR Book ID', 'flex-efinance'), 'type' => 'text', 'display' => true, 'filterable' => true],
            'trx-dcr-book-trx-id' => ['label' => __('DCR Transaction ID', 'flex-efinance'), 'type' => 'text', 'display' => true, 'filterable' => true],
            'thumbnail-image' => ['label' => __('Thumbnail', 'flex-efinance'), 'type' => 'image', 'display' => true, 'filterable' => false],
            'gallery-images' => ['label' => __('Gallery', 'flex-efinance'), 'type' => 'gallery', 'display' => true, 'filterable' => false],
            'attachments' => ['label' => __('Attachments', 'flex-efinance'), 'type' => 'attachments', 'display' => true, 'filterable' => false],
        ];
        return apply_filters('flex_efinance_transaction_list_meta_fields', $fields, $posts, $options);
    }

    private static function get_meta_filter_values(array $posts, string $key): array
    {
        $values = [];
        foreach ($posts as $post) {
            $value = get_post_meta($post->ID, $key, true);
            if (is_scalar($value) && $value !== '') {
                $values[] = (string) $value;
            }
        }
        $values = array_values(array_unique($values));
        natcasesort($values);
        return array_values($values);
    }

    private static function item_filter_attributes($post, array $taxonomies, array $meta_fields): string
    {
        $attributes = ['data-search' => strtolower(wp_strip_all_tags(get_the_title($post)))];
        foreach ($taxonomies as $taxonomy) {
            $terms = wp_get_post_terms($post->ID, $taxonomy->name, ['fields' => 'slugs']);
            $attributes['data-tax-' . sanitize_key($taxonomy->name)] = is_wp_error($terms) ? '' : implode('|', $terms);
        }
        foreach ($meta_fields as $key => $field) {
            if (empty($field['filterable'])) {
                continue;
            }
            $value = get_post_meta($post->ID, $key, true);
            $attributes['data-meta-' . sanitize_key($key)] = is_scalar($value) ? strtolower((string) $value) : '';
        }
        $html = '';
        foreach ($attributes as $name => $value) {
            $html .= sprintf(' %s="%s"', esc_attr($name), esc_attr($value));
        }
        return apply_filters('flex_efinance_transaction_list_item_attributes', $html, $post, $attributes);
    }

    private static function format_meta_value($value, array $field): string
    {
        if ($value === '' || $value === [] || $value === null) {
            return '—';
        }
        if (is_array($value)) {
            if (in_array($field['type'], ['gallery', 'attachments'], true)) {
                $links = [];
                foreach ($value as $attachment_id) {
                    $url = wp_get_attachment_url((int) $attachment_id);
                    if ($url) {
                        $links[] = sprintf(
                            '<a href="%s">%s</a>',
                            esc_url($url),
                            esc_html(get_the_title((int) $attachment_id) ?: basename($url))
                        );
                    }
                }
                return $links ? implode(', ', $links) : '—';
            }
            return esc_html(implode(', ', array_map('strval', $value)));
        }
        if ($field['type'] === 'number' && is_numeric($value)) {
            return esc_html(number_format_i18n((float) $value, 2));
        }
        if ($field['type'] === 'image' && is_numeric($value)) {
            return wp_get_attachment_image((int) $value, 'thumbnail');
        }
        return esc_html((string) $value);
    }

    private static function taxonomy_names(int $post_id, string $taxonomy): string
    {
        $names = wp_get_post_terms($post_id, $taxonomy, ['fields' => 'names']);
        return (is_wp_error($names) || empty($names)) ? '—' : implode(', ', $names);
    }
}
