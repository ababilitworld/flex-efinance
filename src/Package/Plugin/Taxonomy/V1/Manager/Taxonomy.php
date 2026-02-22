<?php
namespace Ababilithub\FlexEFinance\Package\Plugin\Taxonomy\V1\Manager;

(defined('ABSPATH') && defined('WPINC')) || exit();

use Ababilithub\{
    FlexPhp\Package\Manager\V1\Base\Manager as BaseManager,
    FlexWordpress\Package\Taxonomy\V1\Factory\Taxonomy as TaxonomyFactory,
    FlexWordpress\Package\Taxonomy\V1\Contract\Taxonomy as TaxonomyContract,
    FlexEFinance\Package\Plugin\Taxonomy\V1\Finance\Transaction\Type\Taxonomy as FinanceTransactionTypeTaxonomy,
    FlexEFinance\Package\Plugin\Taxonomy\V1\Finance\Transaction\Action\Taxonomy as FinanceTransactionActionTaxonomy,
    FlexEFinance\Package\Plugin\Taxonomy\V1\Finance\Transaction\Domain\Taxonomy as FinanceTransactionDomainTaxonomy,
};

class Taxonomy extends BaseManager
{
    public function __construct()
    {
        $this->init();
    }

    protected function init(): void
    {
        $this->set_items([
            FinanceTransactionActionTaxonomy::class,
            FinanceTransactionTypeTaxonomy::class,
            FinanceTransactionDomainTaxonomy::class,
            // Add more taxonomy classes here...
        ]);
    }

    public function boot(): void 
    {
        foreach ($this->get_items() as $itemClass) 
        {
            $taxonomy = TaxonomyFactory::get($itemClass);

            if ($taxonomy instanceof TaxonomyContract) 
            {
                $taxonomy->register();
                $taxonomy->process_terms();
            }
        }
    }
}
