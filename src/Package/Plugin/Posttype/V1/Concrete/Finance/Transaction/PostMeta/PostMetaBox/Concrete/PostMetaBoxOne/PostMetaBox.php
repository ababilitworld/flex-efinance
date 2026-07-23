<?php
namespace Ababilithub\FlexEFinance\Package\Plugin\Posttype\V1\Concrete\Finance\Transaction\PostMeta\PostMetaBox\Concrete\PostMetaBoxOne;

use Ababilithub\{
    FlexWordpress\Package\PostMetaBox\V1\Base\PostMetaBox as BasePostMetaBox,
    FlexEFinance\Package\Plugin\Posttype\V1\Concrete\Finance\Transaction\Posttype as FinanceTransactionPosttype,
};

use const Ababilithub\{
    FlexEFinance\PLUGIN_PRE_HYPH,
    FlexEFinance\PLUGIN_PRE_UNDS,
};

class PostMetaBox extends BasePostMetaBox
{
    public function init() : void
    {
        $this->posttype = FinanceTransactionPosttype::POSTTYPE;
        $this->id = PLUGIN_PRE_HYPH.'-'.$this->posttype.'-'.'meta-box';
        $this->title = esc_html__(' Info : ', 'flex-efinance') . get_the_title(get_the_ID());
        $this->hook_prefix = PLUGIN_PRE_UNDS;
        $this->content_hook_suffix = 'meta_box_tab_content';
        $this->set_tab_style([
            'type' => 'horizontal',
            'size' => 'medium',
            'color' => 'aurora',
            'title' => esc_html__('Info', 'flex-efinance'),
        ]);
    }

    public function render(): void
    {
        $post_id = get_the_ID();
        // Dynamic title with post name if needed
        $this->title = esc_html__('Info : ', 'flex-efinance') . get_the_title($post_id);
        $this->renderDefault();
    }
}
