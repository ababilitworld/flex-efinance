<?php
namespace Ababilithub\FlexEFinance\Package\Plugin\Posttype\V1\Concrete\Land\Deed\PostMeta\PostMetaBoxContent\Concrete\Section\General;

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
                    <h2 class="panel-title">Deed Details</h2>
                </div>
                <div class="panel-body">
                    <div class="panel-row">
                        <?php
                            $deedDateField = FieldFactory::get(TextField::class);
                            $deedDateField->init([
                                'name' => 'deed-date',
                                'id' => 'deed-date',
                                'label' => 'Deed Date',
                                'class' => 'custom-file-input',
                                'required' => true,
                                'help_text' => 'Enter Deed Date used in the Deed',
                                'value' => $meta_values['deed_date'],
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
                                'name' => 'deed-number',
                                'id' => 'deed-number',
                                'label' => 'Deed Number',
                                'class' => 'custom-file-input',
                                'required' => true,
                                'help_text' => 'Enter Deed number of the deed',
                                'value' => $meta_values['deed_number'],
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
                                'name' => 'plot-number',
                                'id' => 'plot-number',
                                'label' => 'Plot Number',
                                'class' => 'custom-file-input',
                                'required' => true,
                                'help_text' => 'Enter Plot number according to the Respective Survey',
                                'value' => $meta_values['plot_number'],
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
                                'name' => 'land-quantity',
                                'id' => 'land-quantity',
                                'label' => 'Land Quantity (Decimal)',
                                'class' => 'custom-file-input',
                                'required' => true,
                                'help_text' => 'Enter Land Quantity in decimal used in the Deed',
                                'value' => $meta_values['land_quantity'],
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
                            // Regular text field for map URL/embed code
                            $googleMapLocationField = FieldFactory::get(TextField::class);
                            $googleMapLocationField->init([
                                'name' => 'google-map-location',
                                'id' => 'google-map-location',
                                'label' => 'Google Map Embed Code',
                                'class' => 'custom-file-input',
                                'required' => false,
                                'help_text' => 'Paste Google Map embed code or share link',
                                'value' => $this->get_map_location($meta_values['google_map_location']),
                                'attributes' => [
                                    'data-preview-size' => '150'
                                ]
                            ])->render();
                        ?>
                    </div>
                    <!-- Add new fields for latitude/longitude -->
                    <div class="panel-row two-columns">
                        <?php
                            $latitudeField = FieldFactory::get(TextField::class);
                            $latitudeField->init([
                                'name' => 'map-latitude',
                                'id' => 'map-latitude',
                                'label' => 'Latitude',
                                'value' => $meta_values['map_latitude'],
                                'help_text' => 'e.g., 23.8103'
                            ])->render();
                            
                            $longitudeField = FieldFactory::get(TextField::class);
                            $longitudeField->init([
                                'name' => 'map-longitude',
                                'id' => 'map-longitude',
                                'label' => 'Longitude',
                                'value' => $meta_values['map_longitude'],
                                'help_text' => 'e.g., 90.4125'
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
            'deed_date' => get_post_meta($post_id, 'deed-date', true) ?: '',
            'deed_number' => get_post_meta($post_id, 'deed-number', true) ?: '',
            'plot_number' => get_post_meta($post_id, 'plot-number', true) ?: '',
            'land_quantity' => get_post_meta($post_id, 'land-quantity', true) ?: '',
            'google_map_location' => get_post_meta($post_id, 'google-map-location', true) ?: '',
            'map_latitude' => get_post_meta($post_id, 'map-latitude', true) ?: '',
            'map_longitude' => get_post_meta($post_id, 'map-longitude', true) ?: ''
        ];
    }

    public function save($post_id, $post, $update): void 
    {
        if (!$this->is_valid_save($post_id, $post)) 
        {
            return;
        }

        // Save text fields
        $this->save_text_field($post_id,'deed-date',sanitize_text_field($_POST['deed-date'] ?? ''));
        $this->save_text_field($post_id,'deed-number',sanitize_text_field($_POST['deed-number'] ?? ''));
        $this->save_text_field($post_id,'plot-number',sanitize_text_field($_POST['plot-number'] ?? ''));
        $this->save_text_field($post_id,'land-quantity',sanitize_text_field($_POST['land-quantity'] ?? ''));
        $this->save_text_field($post_id, 'google-map-location', sanitize_textarea_field($this->prepare_map_location($_POST['google-map-location'] ?? '')));
        $this->save_text_field($post_id, 'map-latitude', sanitize_text_field($_POST['map-latitude'] ?? ''));
        $this->save_text_field($post_id, 'map-longitude', sanitize_text_field($_POST['map-longitude'] ?? ''));
    }
}