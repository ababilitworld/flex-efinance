<?php
namespace Ababilithub\FlexEFinance\Package\Plugin\Menu\V1\Concrete\Faker\Finance\Transaction;

(defined('ABSPATH') && defined('WPINC')) || exit();

use Ababilithub\{
    FlexWordpress\Package\Menu\V1\Base\Menu as BaseMenu,
    FlexPhp\Package\Faker\V1\Factory\Faker as FakerFactory,
    FlexAahub\Package\Plugin\Faker\V1\Concrete\Post\Faker as PostFaker,
    FlexEFinance\Package\Plugin\Posttype\V1\Concrete\Finance\Transaction\Posttype as FinanceTransactionPosttype,
};

use const Ababilithub\{
    FlexEFinance\PLUGIN_PRE_UNDS,
};

class Menu extends BaseMenu
{
    private const ACTION = 'flex_efinance_generate_dummy_transactions';
    private const NONCE_ACTION = 'flex_efinance_generate_30_dummy_transactions';
    private const COUNT = 30;

    public function init(array $data = []): static
    {
        $this->type = 'submenu';
        $this->parent_slug = 'flex-efinance';
        $this->page_title = 'Dummy Transactions';
        $this->menu_title = 'Dummy Transactions';
        $this->capability = 'manage_options';
        $this->menu_slug = 'flex-efinance-dummy-transactions';
        $this->callback = [$this, 'render'];
        $this->position = 7;
        $this->screen_rules = ['id' => $this->menu_slug];
        $this->menu_filter_name = PLUGIN_PRE_UNDS . '_admin_menu';

        $this->init_hook();
        return $this;
    }

    public function init_service(): void
    {
    }

    public function init_hook(): void
    {
        add_filter($this->menu_filter_name, [$this, 'add_menu_items']);
        add_filter('parent_file', [$this, 'set_active_parent_menu']);
        add_filter('submenu_file', [$this, 'set_active_submenu']);
        add_action('admin_post_' . self::ACTION, [$this, 'generate']);
    }

    public function add_menu_items($menu_items = []): array
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

    public function render(): void
    {
        if (!current_user_can($this->capability)) {
            wp_die(esc_html__('You are not allowed to generate dummy transactions.', 'flex-efinance'));
        }

        $created = isset($_GET['created']) ? absint($_GET['created']) : null;
        $errors = isset($_GET['errors']) ? absint($_GET['errors']) : 0;
        $batch_id = isset($_GET['batch']) ? sanitize_text_field(wp_unslash($_GET['batch'])) : '';
        ?>
        <div class="wrap">
            <h1><?php esc_html_e('Dummy Transactions', 'flex-efinance'); ?></h1>

            <?php if ($created !== null) : ?>
                <div class="notice notice-<?php echo $errors ? 'warning' : 'success'; ?> is-dismissible">
                    <p>
                        <?php
                        echo esc_html(
                            sprintf(
                                __('Created %1$d dummy transactions with %2$d errors. Batch: %3$s', 'flex-efinance'),
                                $created,
                                $errors,
                                $batch_id
                            )
                        );
                        ?>
                    </p>
                </div>
            <?php endif; ?>

            <p><?php esc_html_e('Generate 30 published finance transactions with realistic metadata and taxonomy assignments.', 'flex-efinance'); ?></p>
            <p><strong><?php esc_html_e('This creates database records. Use it only for development or testing.', 'flex-efinance'); ?></strong></p>

            <form action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post">
                <input type="hidden" name="action" value="<?php echo esc_attr(self::ACTION); ?>">
                <?php wp_nonce_field(self::NONCE_ACTION); ?>
                <?php submit_button(__('Generate 30 Transactions', 'flex-efinance'), 'primary', 'submit', false); ?>
            </form>
        </div>
        <?php
    }

    public function generate(): void
    {
        if (!current_user_can($this->capability)) {
            wp_die(esc_html__('You are not allowed to generate dummy transactions.', 'flex-efinance'));
        }

        check_admin_referer(self::NONCE_ACTION);

        try {
            $faker = FakerFactory::get(PostFaker::class);
            $result = $faker->generate($this->configuration());
            $redirect = add_query_arg([
                'page' => $this->menu_slug,
                'created' => count($result['post_ids']),
                'errors' => count($result['errors']),
                'batch' => $result['batch_id'],
            ], admin_url('admin.php'));
        } catch (\Throwable $exception) {
            $redirect = add_query_arg([
                'page' => $this->menu_slug,
                'created' => 0,
                'errors' => 1,
                'batch' => 'generation-failed',
            ], admin_url('admin.php'));
        }

        wp_safe_redirect($redirect);
        exit;
    }

    private function configuration(): array
    {
        return apply_filters('flex_efinance_dummy_transaction_faker_config', [
            'post_type' => FinanceTransactionPosttype::POSTTYPE,
            'count' => self::COUNT,
            'locale' => 'en_US',
            'author' => get_current_user_id(),
            'post' => [
                'post_title' => static function ($faker, int $index): string {
                    return sprintf('Transaction %s', strtoupper($faker->bothify('TRX-####-????')));
                },
                'post_content' => ['formatter' => 'paragraphs', 'arguments' => [2, true]],
                'post_excerpt' => ['formatter' => 'sentence', 'arguments' => [12]],
                'post_status' => 'publish',
            ],
            'meta' => [
                'trx-date' => static function ($faker): string {
                    return $faker->dateTimeBetween('-2 years', 'now')->format('Y-m-d');
                },
                'trx-amount' => ['formatter' => 'randomFloat', 'arguments' => [2, 100, 500000]],
                'pr-account' => static function ($faker): string {
                    return strtoupper($faker->bothify('PR-####-####'));
                },
                'bf-account' => static function ($faker): string {
                    return strtoupper($faker->bothify('BF-####-####'));
                },
                'trx-dcr-book-id' => static function ($faker): string {
                    return strtoupper($faker->bothify('DCR-BOOK-###'));
                },
                'trx-dcr-book-trx-id' => static function ($faker): string {
                    return strtoupper($faker->bothify('DCR-TRX-######'));
                },
                'thumbnail-image' => '',
                'gallery-images' => ['value' => []],
                'attachments' => ['value' => []],
            ],
            'taxonomies' => [
                'finance-transaction-type' => [
                    'use_available_terms' => true,
                ],
                'finance-transaction-purpose' => [
                    'use_available_terms' => true,
                ],
                'finance-transaction-medium' => [
                    'use_available_terms' => true,
                ],
                'finance-transaction-action' => [
                    'use_available_terms' => true,
                ],
                'finance-transaction-domain' => [
                    'use_available_terms' => true,
                ],
                'finance-transaction-account' => [
                    'use_available_terms' => true,
                    'terms_per_post' => 2,
                ],
            ],
        ]);
    }
}
