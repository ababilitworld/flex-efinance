<?php
namespace Ababilithub\FlexEFinance\Package\Plugin\Posttype\V1\Concrete\Land\Deed\PostMeta\PostMetaBoxContent\Concrete\Section\Image;

use Ababilithub\{
    FlexEFinance\Package\Plugin\Posttype\V1\Concrete\Land\Deed\Posttype as LandDeedPosttype,
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
        $this->posttype = LandDeedPosttype::POSTTYPE;
        $this->post_id = get_the_ID();
        $this->tab_item_id = $this->posttype.'-'.'section-image';
        $this->tab_item_label = esc_html__('Images');
        $this->tab_item_icon = 'fas fa-edit';
        $this->tab_item_status = '';

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
                    <h2 class="panel-title">Deed Images</h2>
                </div>
                <div class="panel-body">
                    <div class="panel-row">
                        <?php
                            $imageField = FieldFactory::get(ImageField::class);
                            $imageField->init([
                                'name' => 'deed-thumbnail-image',
                                'id' => 'deed-thumbnail-image',
                                'label' => 'Deed Thumbnail',
                                'class' => 'custom-file-input',
                                'required' => true,
                                'multiple' => false,
                                'allowed_types' => ['.jpg', '.jpeg', '.png', '.gif', '.webp'],
                                'max_size' => 2097152, // 2MB
                                'enable_media_library' => true,
                                'upload_action_text' => 'Select Image',
                                'help_text' => 'Only jpg, png, gif, webp files are allowed',
                                'preview_items' => $meta_values['deed_thumbnail_image'],
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
                                'name' => 'deed-images',
                                'id' => 'deed-images',
                                'label' => 'Deed Images',
                                'class' => 'custom-file-input',
                                'required' => true,
                                'multiple' => true,
                                'allowed_types' => ['.jpg', '.jpeg', '.png', '.gif', '.webp'],
                                'max_size' => 2097152, // 2MB
                                'enable_media_library' => true,
                                'upload_action_text' => 'Select Images',
                                'help_text' => 'Only jpg, png, gif, webp files are allowed',
                                'preview_items' => $meta_values['deed_images'],
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
            'deed_thumbnail_image' => get_post_meta($post_id, 'deed-thumbnail-image', true) ?: '',
            'deed_images' => get_post_meta($post_id, 'deed-images', true) ?: [],            
        ];
    }

    public function save($post_id, $post, $update): void 
    {
        if (!$this->is_valid_save($post_id, $post)) 
        {
            return;
        }

        // Save media (IDs)
        $this->save_thumbnail_image($post_id,'deed-thumbnail-image',absint($_POST['deed-thumbnail-image'] ?? ''));
        $this->save_multiple_images($post_id,'deed-images',array_map('sanitize_text_field',$_POST['deed-images'] ?? []));
        
    }
}