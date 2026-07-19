<?php
namespace Ababilithub\FlexEFinance\Package\Plugin\Menu\V1\Manager;

(defined('ABSPATH') && defined('WPINC')) || exit();

use Ababilithub\{
    FlexPhp\Package\Manager\V1\Base\Manager as BaseManager,
    FlexWordpress\Package\Menu\V1\Contract\Menu as MenuContract, 
    FlexWordpress\Package\Menu\V1\Factory\Menu as MenuFactory,
    FlexEFinance\Package\Plugin\Menu\V1\Concrete\Main\Menu as MainMenu,
    FlexEFinance\Package\Plugin\Menu\V1\Concrete\Taxonomy\Finance\Transaction\Purpose\Menu as FinanceTransactionPurposeMenu,
    FlexEFinance\Package\Plugin\Menu\V1\Concrete\Taxonomy\Finance\Transaction\Type\Menu as FinanceTransactionTypeMenu,
    FlexEFinance\Package\Plugin\Menu\V1\Concrete\Taxonomy\Finance\Transaction\Medium\Menu as FinanceTransactionMediumMenu,
    FlexEFinance\Package\Plugin\Menu\V1\Concrete\Taxonomy\Finance\Transaction\Action\Menu as FinanceTransactionActionMenu,
    FlexEFinance\Package\Plugin\Menu\V1\Concrete\Posttype\Finance\Transaction\Menu as FinanceTransactionMenu,
    FlexEFinance\Package\Plugin\Menu\V1\Concrete\Shortcode\Finance\Transaction\List\Menu as FinanceTransactionListMenu,

};

class  Menu extends BaseManager
{
    public function __construct()
    {
        $this->init();
    }
    
    public function init()
    {
        $this->set_items(
            [
                MainMenu::class,
                FinanceTransactionPurposeMenu::class,
                FinanceTransactionTypeMenu::class,
                FinanceTransactionMediumMenu::class,
                FinanceTransactionActionMenu::class,
                FinanceTransactionMenu::class,
                FinanceTransactionListMenu::class,                  
            ]
        );
    }

    public function boot(): void 
    {
        foreach ($this->get_items() as $item) 
        {
            $item_instance = MenuFactory::get($item);

            if ($item_instance instanceof MenuContract) 
            {
                $item_instance->register();
            }
        }
    }
}