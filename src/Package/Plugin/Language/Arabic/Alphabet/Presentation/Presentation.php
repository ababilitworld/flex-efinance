<?php

namespace Ababilithub\FlexEFinance\Package\Plugin\Alphabet\Presentation;

(defined('ABSPATH') && defined('WPINC')) || die();

use Ababilithub\{
    FlexPhp\Package\Mixin\V1\Standard\Mixin as StandardMixin,
    FlexWordpress\Package\Mixin\V1\Standard\Mixin as WpStandardMixin, 
};

if (!class_exists(__NAMESPACE__.'\Presentation')) 
{
    class Presentation 
    {
        use StandardMixin;

        private $package;

        public function __construct() 
        {
            //
        }
    }
}

?>
