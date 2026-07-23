<?php
namespace Ababilithub\FlexEFinance\Package\Plugin\Posttype\V1\Concrete\Finance\Transaction\PostMeta\PostMetaBoxContent\Concrete\GeneralSettings;

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
        $this->tab_item_id = $this->posttype.'-'.'general-settings';
        $this->tab_item_label = esc_html__('General Settings');
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
                    <h2 class="panel-title">Transaction Details</h2>
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
                            $deedNumberField = FieldFactory::get(TextField::class);
                            $deedNumberField->init([
                                'name' => 'trx-amount',
                                'id' => 'trx-amount',
                                'label' => 'Trx Amount',
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
                        <?php
                            $plotNumberField = FieldFactory::get(TextField::class);
                            $plotNumberField->init([
                                'name' => 'trx-dcr-book-id',
                                'id' => 'trx-dcr-book-id',
                                'label' => 'DCR Book ID',
                                'class' => 'custom-file-input',
                                'required' => true,
                                'help_text' => 'Enter DCR Book ID',
                                'value' => $meta_values['trx_dcr_book_id'],
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
                            $landQuantityField = FieldFactory::get(TextField::class);
                            $landQuantityField->init([
                                'name' => 'trx-dcr-book-trx-id',
                                'id' => 'trx-dcr-book-trx-id',
                                'label' => 'DCR Book Trx ID',
                                'class' => 'custom-file-input',
                                'required' => true,
                                'help_text' => 'Enter DCR Book Trx ID',
                                'value' => $meta_values['trx_dcr_book_trx_id'],
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
            
            <div class="panel">
                <div class="panel-header">
                    <h2 class="panel-title">Transaction Images</h2>
                </div>
                <div class="panel-body">
                    <div class="panel-row">
                        <?php
                            $imageField = FieldFactory::get(ImageField::class);
                            $imageField->init([
                                'name' => 'thumbnail-image',
                                'id' => 'thumbnail-image',
                                'label' => 'Transaction Thumbnail',
                                'class' => 'custom-file-input',
                                'required' => true,
                                'multiple' => false,
                                'allowed_types' => ['.jpg', '.jpeg', '.png', '.gif', '.webp'],
                                'max_size' => 2097152, // 2MB
                                'enable_media_library' => true,
                                'upload_action_text' => 'Select Image',
                                'help_text' => 'Only jpg, png, gif, webp files are allowed',
                                'preview_items' => $meta_values['thumbnail_image'],
                                'data' => [
                                    'custom' => 'value'
                                ],
                                'attributes' => [
                                    'data-preview-size' => '150'
                                ]
                            ])->render();
                        ?>
                        <?php
                            $imageField = FieldFactory::get(ImageField::class);
                            $imageField->init([
                                'name' => 'gallery-images',
                                'id' => 'gallery-images',
                                'label' => 'Transaction Images',
                                'class' => 'custom-file-input',
                                'required' => true,
                                'multiple' => true,
                                'allowed_types' => ['.jpg', '.jpeg', '.png', '.gif', '.webp'],
                                'max_size' => 2097152, // 2MB
                                'enable_media_library' => true,
                                'upload_action_text' => 'Select Images',
                                'help_text' => 'Only jpg, png, gif, webp files are allowed',
                                'preview_items' => $meta_values['gallery_images'],
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

            <div class="panel">
                <div class="panel-header">
                    <h2 class="panel-title">Transaction Attachments</h2>
                </div>
                <div class="panel-body">
                    <div class="panel-row">
                        <?php
                            $deedPdfField = FieldFactory::get(DocField::class);
                            $deedPdfField->init([
                                'name' => 'attachments',
                                'id' => 'attachments',
                                'label' => 'Transaction Attachments',
                                'class' => 'custom-file-input',
                                'required' => true,
                                'multiple' => true,
                                'allowed_types' => ['.pdf', '.doc', '.docx', '.xls', '.xlsx'],
                                'upload_action_text' => 'Select Attachments',
                                'help_text' => 'Only PDF, Word, and Excel files are allowed',
                                'max_size' => 5242880, // 5MB
                                'enable_media_library' => true,
                                'preview_items' => $meta_values['attachments'],
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
            'trx_amount' => get_post_meta($post_id, 'trx-amount', true) ?: '',
            'trx_dcr_book_id' => get_post_meta($post_id, 'trx-dcr-book-id', true) ?: '',
            'trx_dcr_book_trx_id' => get_post_meta($post_id, 'trx-dcr-book-trx-id', true) ?: '',
            'thumbnail_image' => get_post_meta($post_id, 'thumbnail-image', true) ?: '',
            'gallery_images' => get_post_meta($post_id, 'gallery-images', true) ?: [],
            'attachments' => get_post_meta($post_id, 'attachments', true) ?: []
        ];
    }

    public function save($post_id, $post, $update) : void 
    {
        if (!$this->is_valid_save($post_id, $post)) 
        {
            return;
        }

        $this->save_text_field($post_id,'trx-date',sanitize_text_field($_POST['trx-date'] ?? ''));
        $this->save_text_field($post_id,'trx-amount',sanitize_text_field($_POST['trx-amount'] ?? ''));
        $this->save_text_field($post_id,'trx-dcr-book-id',sanitize_text_field($_POST['trx-dcr-book-id'] ?? ''));
        $this->save_text_field($post_id,'trx-dcr-book-trx-id',sanitize_text_field($_POST['trx-dcr-book-trx-id'] ?? ''));
        $this->save_thumbnail_image($post_id,'thumbnail-image',absint($_POST['thumbnail-image'] ?? ''));
        $this->save_multiple_images($post_id,'gallery-images',array_map('sanitize_text_field',$_POST['gallery-images'] ?? []));
        $this->save_multiple_attachments($post_id,'attachments',array_map('sanitize_text_field',$_POST['attachments'] ?? []));
    }
}