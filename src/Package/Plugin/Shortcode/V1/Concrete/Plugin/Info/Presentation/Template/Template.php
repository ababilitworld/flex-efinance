<?php
namespace Ababilithub\FlexEFinance\Package\Plugin\Shortcode\V1\Concrete\Plugin\Info\Presentation\Template;

(defined('ABSPATH') && defined('WPINC')) || die();

use Ababilithub\{
    FlexPhp\Package\Mixin\V1\Standard\Mixin as StandardMixin,
    FlexWordpress\Package\Mixin\V1\Standard\Mixin as StandardWpMixin,
};

use const Ababilithub\{
    FlexEFinance\PLUGIN_NAME,
    FlexEFinance\PLUGIN_DIR,
    FlexEFinance\PLUGIN_URL,
    FlexEFinance\PLUGIN_FILE,
    FlexEFinance\PLUGIN_PRE_UNDS,
    FlexEFinance\PLUGIN_PRE_HYPH,
    FlexEFinance\PLUGIN_VERSION,
};

class Template 
{
    use StandardMixin, StandardWpMixin;

    private $asset_url;

    public function __construct() 
    {
        //echo "Bismillah";exit;
        $this->asset_url = $this->get_url('Asset/');
        add_action('admin_enqueue_scripts', array($this, 'enqueue_scripts'));
        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
    }

    public function enqueue_scripts()
    {
        wp_enqueue_style(
            PLUGIN_PRE_HYPH.'-plugin-info', 
            $this->asset_url.'Css/Style.css',
            array(), 
            time()
        );

        wp_enqueue_script(
            PLUGIN_PRE_HYPH.'-plugin-info-script', 
            $this->asset_url.'Js/Script.js',
            array(), 
            time(),
            true
        );
    }

}