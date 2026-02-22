<?php
namespace Ababilithub\FlexEFinance\Package\Plugin\Language\Arabic\Alphabet\Presentation\Template;

(defined('ABSPATH') && defined('WPINC')) || die();

use Ababilithub\{
    FlexPhp\Package\Mixin\V1\Standard\Mixin as StandardMixin,
    FlexWordpress\Package\Mixin\V1\Standard\Mixin as WpStandardMixin, 
};

use const Ababilithub\{
    FlexEFinance\PLUGIN_NAME,
    FlexEFinance\PLUGIN_DIR,
    FlexEFinance\PLUGIN_URL,
    FlexEFinance\PLUGIN_FILE,
    FlexEFinance\PLUGIN_PRE_UNDS,
    FlexEFinance\PLUGIN_PRE_HYPH,
    FlexEFinance\PLUGIN_VERSION
};

if (!class_exists(__NAMESPACE__.'\Template')) 
{
    class Template 
    {
        use StandardMixin, WpStandardMixin;

        private $package;
        private $template_url;
        private $asset_url;

        public function __construct() 
        {
            $this->asset_url = $this->get_url('Asset/');
            add_action('admin_enqueue_scripts', array($this, 'enqueue_scripts' ) );
            add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts' ) );
        }

        public function enqueue_scripts()
        {
            wp_enqueue_script('jquery');

            wp_enqueue_style(
                'flex-efinance-template-style', 
                $this->asset_url.'Style/style.css',
                array(), 
                time()
            );

            wp_enqueue_script(
                'flex-efinance-template-script', 
                $this->asset_url.'Script/script.js',
                array(), 
                time(), 
                true
            );
            
            wp_localize_script(
                'flex-efinance-template-script', 
                'flex_efinance_template_localize', 
                array(
                    'adminAjaxUrl' => admin_url('admin-ajax.php'),
                    'ajaxUrl' => admin_url('admin-ajax.php'),
                    'ajaxNonce' => wp_create_nonce(PLUGIN_PRE_UNDS . '_nonce'),
                    // 'ajaxAction' => PLUGIN_PRE_UNDS . '_action',
                    // 'ajaxData' => PLUGIN_PRE_UNDS . '_data',
                    // 'ajaxError' => PLUGIN_PRE_UNDS . '_error',
                )
            );
        }
        
        public static function alphabet_grid(array $data)
        {
            $instance = new self();
            $instance->enqueue_scripts();
            ob_start();
            
            $languages = [
                'ar' => [
                    'lan' => 'ar',
                    'dir' => 'rtl',
                    'letters' => [
                        'row' => 8,
                        'column' => 4,
                        'empty_cells' => [[2, 4], [6, 4]],
                        'items' => [
                            ['ا', 'a'], ['ب', 'b'], ['ت', 't'], ['ث', 'th'],
                            ['ج', 'j'], ['ح', 'h'], ['خ', 'kh'],
                            ['د', 'd'], ['ذ', 'dh'], ['ر', 'r'], ['ز', 'z'], 
                            ['س', 's'], ['ش', 'sh'], ['ص', 'ss'], ['ض', 'dd'],
                            ['ط', 'tt'], ['ظ', 'zz'], ['ع', 'aa'], ['غ', 'gh'],
                            ['ف', 'f'], ['ق', 'q'], ['ك', 'k'], 
                            ['ل', 'l'], ['م', 'm'], ['ن', 'n'], ['و', 'w'],
                            ['ه', 'h2'], ['ء', 'hamza'], ['ى', 'ya']
                        ]
                    ],
                    'digits' => [
                        'row' => 3,
                        'column' => 4,
                        'empty_cells' => [[3, 3], [3, 4]],
                        'items' => [
                            ['١', '1'], ['٢', '2'], ['٣', '3'], ['٤', '4'],
                            ['٥', '5'], ['٦', '6'], ['٧', '7'], ['٨', '8'],
                            ['٩', '9'], ['٠', '0']
                        ]
                    ]
                ]
            ];
            
            foreach ($languages as $language) 
            {
                foreach (['letters', 'digits'] as $type) 
                {
                    $grid = $language[$type];
                    $rowCount = $grid['row'];
                    $colCount = $grid['column'];
                    $emptyCells = $grid['empty_cells'];
                    $items = $grid['items'];
        
                    echo "<div class='alphabet-grid' lan='{$language['lan']}' dir='{$language['dir']}' 
                          style='--rows: {$rowCount}; --columns: {$colCount};'>";
                    
                    $index = 0;
                    for ($row = 1; $row <= $rowCount; $row++) {
                        for ($col = 1; $col <= $colCount; $col++) {
                            if (in_array([$row, $col], $emptyCells)) {
                                echo "<div class='cell'></div>";
                            } else {
                                if (isset($items[$index])) {
                                    [$letter, $sound] = $items[$index];
                                    echo "<div class='cell' data-sound='{$sound}'>{$letter}</div>";
                                    $index++;
                                } else {
                                    echo "<div class='cell'></div>";
                                }
                            }
                        }
                    }
                    
                    echo "</div>";
                }
            }
            
            return ob_get_clean();
        }
        
        public function matchPattern(array $data, array $pattern): bool
        {
            foreach ($data as $key => $value) 
            {
                if (!$this->recursiveMatch($value, $pattern['*'])) 
                {
                    return false;
                }
            }
            return true;
        }

        // Recursive function to check nested structures
        private function recursiveMatch(array $data, array $pattern): bool
        {
            foreach ($pattern as $key => $expectedType) 
            {
                if (!array_key_exists($key, $data)) 
                {
                    return false; // Missing expected key
                }

                if (is_array($expectedType)) 
                {
                    // If pattern expects an array, ensure data[key] is also an array
                    if (!is_array($data[$key])) 
                    {
                        return false;
                    }
                    
                    // Check if it's an array of arrays (like letters & digits)
                    if ($this->isArrayOfArrays($expectedType)) 
                    {
                        if (!$this->isArrayOfArrays($data[$key])) 
                        {
                            return false;
                        }
                    } 
                    else 
                    {
                        // Recursively check nested arrays
                        if (!$this->recursiveMatch($data[$key], $expectedType))
                        {
                            return false;
                        }
                    }
                }
            }
            return true;
        }

        // Helper function to check if an array contains only arrays
        private function isArrayOfArrays(array $arr): bool
        {
            foreach ($arr as $item) 
            {
                if (!is_array($item))
                {
                    return false;
                }
            }
            return true;
        }


    }
}

?>