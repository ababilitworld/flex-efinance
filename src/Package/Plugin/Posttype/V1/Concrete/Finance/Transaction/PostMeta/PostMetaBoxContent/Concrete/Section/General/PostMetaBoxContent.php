<?php
namespace Ababilithub\FlexEFinance\Package\Plugin\Posttype\V1\Concrete\Finance\Transaction\PostMeta\PostMetaBoxContent\Concrete\Section\General;

use Ababilithub\{
    FlexEFinance\Package\Plugin\Posttype\V1\Concrete\Finance\Transaction\Posttype as FinanceTransactionPosttype,
    FlexWordpress\Package\PostMeta\V1\Mixin\PostMeta as PostMetaMixin,
    FlexWordpress\Package\PostMetaBoxContent\V1\Base\PostMetaBoxContent as BasePostMetaBoxContent,
    FlexPhp\Package\Form\Field\V1\Factory\Field as FieldFactory,
    FlexPhp\Package\Form\Field\V1\Concrete\Text\Field as TextField,
    FlexPhp\Package\Form\Field\V1\Concrete\File\Document\Field as DocField,
    FlexPhp\Package\Form\Field\V1\Concrete\File\Image\Field as ImageField
};

use const Ababilithub\{
    FlexEFinance\PLUGIN_PRE_HYPH,
    FlexEFinance\PLUGIN_PRE_UNDS,
};

class PostMetaBoxContent extends BasePostMetaBoxContent
{
    use PostMetaMixin;
    public function init(array $data = []) : static
    {
        $this->posttype = FinanceTransactionPosttype::POSTTYPE;
        $this->post_id = get_the_ID();
        $this->tab_item_id = $this->posttype.'-'.'section-general';
        $this->tab_item_label = esc_html__('General');
        $this->tab_item_icon = 'fas fa-edit';
        $this->tab_item_status = 'active';

        $this->init_service();
        $this->init_hook();

        return $this;
    }

    public function init_service():void
    {

    }

    public function init_hook() : void
    {
        add_action(PLUGIN_PRE_UNDS.'_'.$this->posttype.'_'.'meta_box_tab_item',[$this,'tab_item']);
        add_action(PLUGIN_PRE_UNDS.'_'.$this->posttype.'_'.'meta_box_tab_content', [$this,'tab_content']);
        //add_action('save_post', [$this, 'save'], 10, 3);
    }

    public function render() : void
    {
        $meta_values = $this->get_meta_values(get_the_ID());
        //echo "<pre>";print_r($meta_values);echo "</pre>";exit;
        ?>
            <div class="panel">
                <div class="panel-header">
                    <h2 class="panel-title">Details Information</h2>
                </div>
                <div class="panel-body">
                    <div class="panel-row">
                        <?php
                            $deedDateField = FieldFactory::get(TextField::class);
                            $deedDateField->init([
                                'name' => 'trx-date',
                                'id' => 'trx-date',
                                'label' => 'Transaction Date',
                                'class' => 'custom-file-input',
                                'required' => true,
                                'help_text' => 'Enter Transaction Date',
                                'value' => $meta_values['trx_date'],
                                'data' => [
                                    'custom' => 'value'
                                ],
                                'attributes' => [
                                    'data-preview-size' => '150'
                                ]
                            ])->render();
                        ?>
                    </div>
                    <div class="panel-row two-columns">
                        <?php
                            $deedDateField = FieldFactory::get(TextField::class);
                            $deedDateField->init([
                                'name' => 'pr-account',
                                'id' => 'pr-account',
                                'label' => 'Principal Account',
                                'class' => 'custom-file-input',
                                'required' => true,
                                'help_text' => 'Enter Principal Account',
                                'value' => $meta_values['pr_account'],
                                'data' => [
                                    'custom' => 'value'
                                ],
                                'attributes' => [
                                    'data-preview-size' => '150'
                                ]
                            ])->render();
                        ?>
                        <?php
                            $deedDateField = FieldFactory::get(TextField::class);
                            $deedDateField->init([
                                'name' => 'bf-account',
                                'id' => 'bf-account',
                                'label' => 'Beneficiary Account',
                                'class' => 'custom-file-input',
                                'required' => true,
                                'help_text' => 'Enter Beneficiary Account',
                                'value' => $meta_values['bf_account'],
                                'data' => [
                                    'custom' => 'value'
                                ],
                                'attributes' => [
                                    'data-preview-size' => '150'
                                ]
                            ])->render();
                        ?>
                    </div>
                    <div class="panel-row">
                        <?php
                            $deedAmountField = FieldFactory::get(TextField::class);
                            $deedAmountField->init([
                                'name' => 'trx-amount',
                                'id' => 'trx-amount',
                                'label' => 'Transaction Amount',
                                'class' => 'custom-file-input',
                                'required' => true,
                                'help_text' => 'Enter Transaction Amount',
                                'value' => $meta_values['trx_amount'],
                                'data' => [
                                    'custom' => 'value'
                                ],
                                'attributes' => [
                                    'data-preview-size' => '150'
                                ]
                            ])->render();
                        ?>                        
                    </div>
                </div>
            </div>
        <?php

    }

    public function get_meta_values($post_id): array 
    {
        return [
            'trx_date' => get_post_meta($post_id, 'trx-date', true) ?: '',
            'pr_account' => get_post_meta($post_id, 'pr-account', true) ?: '',
            'bf_account' => get_post_meta($post_id, 'bf-account', true) ?: '',
            'trx_amount' => get_post_meta($post_id, 'trx-amount', true) ?: '',
        ];
    }

    public function save($post_id, $post, $update): void 
    {
        if (!$this->is_valid_save($post_id, $post)) 
        {
            return;
        }

        // Save text fields
        $this->save_text_field($post_id,'trx-date',sanitize_text_field($_POST['trx-date'] ?? ''));
        $this->save_text_field($post_id,'pr-account',sanitize_text_field($_POST['pr-account'] ?? ''));
        $this->save_text_field($post_id,'bf-account',sanitize_text_field($_POST['bf-account'] ?? ''));
        $this->save_text_field($post_id,'trx-amount',sanitize_text_field($_POST['trx-amount'] ?? ''));
        
    }
}