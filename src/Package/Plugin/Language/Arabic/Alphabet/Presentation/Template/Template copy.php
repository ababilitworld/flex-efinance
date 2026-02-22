<?php
namespace Ababilithub\FlexEFinance\Package\Plugin\Alphabet\Presentation\Template;

(defined('ABSPATH') && defined('WPINC')) || die();

use Ababilitworld\FlexTraitByAbabilitworld\Standard\Standard;

use const Ababilithub\FlexEFinance\{
    PLUGIN_NAME,
    PLUGIN_DIR,
    PLUGIN_URL,
    PLUGIN_FILE,
    PLUGIN_PRE_UNDS,
    PLUGIN_PRE_HYPH,
    PLUGIN_VERSION
};

if (!class_exists(__NAMESPACE__.'\Template')) 
{
    class Template 
    {
        use Standard;

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
                'flex-multilingual-learning-kit-by-ababilithub-alphabet-grid-template-style', 
                $this->asset_url.'Style/style.css',
                array(), 
                time()
            );

            wp_enqueue_script(
                'flex-multilingual-learning-kit-by-ababilithub-alphabet-grid-template-script', 
                $this->asset_url.'Script/script.js',
                array(), 
                time(), 
                true
            );
            
            wp_localize_script(
                'flex-portfolio-by-ababilitworld-template-script', 
                'flex_portfolio_by_ababilitworld_template_localize', 
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
                            'row'=> '8',
                            'column' =>'4',
                            'empty_positions' => [[2,4],[6,4]],
                            'items'=> [
                            ['ا', 'a'], ['ب', 'b'], ['ت', 't'], ['ث', 'th'],
                            ['ج', 'j'], ['ح', 'h'], ['خ', 'kh'], ['', ''],
                            ['د', 'd'], ['ذ', 'dh'], ['ر', 'r'], ['ز', 'z'], 
                            ['س', 's'], ['ش', 'sh'], ['ص', 'ss'], ['ض', 'dd'],
                            ['ط', 'tt'],['ظ', 'zz'], ['ع', 'aa'], ['غ', 'gh'],
                            ['ف', 'f'], ['ق', 'q'], ['ك', 'k'], ['', ''],
                            ['ل', 'l'], ['م', 'm'], ['ن', 'n'], ['و', 'w'],
                            ['ه', 'h2'], ['ء', 'hamza'], ['ى', 'ya']
                        ]
                    ],
                    'digits' => [
                        'row'=> '4',
                        'column' =>'3',
                        'empty_positions' => [[3,3],[3,4]],
                        'items'=> [
                        ['١', '1'], ['٢', '2'], ['٣', '3'], ['٤', '4'],
                        ['٥', '5'], ['٦', '6'], ['٧', '7'], ['٨', '8'],
                        ['٩', '9'], ['٠', '0']
                        ]
                    ]
                ],
                'ar' => [
                    'lan' => 'ar',
                    'dir' => 'rtl',
                    'letters' => [
                        ['ا', 'a'], ['ب', 'b'], ['ت', 't'], ['ث', 'th'],
                        ['ج', 'j'], ['ح', 'h'], ['خ', 'kh'], ['', ''],
                        ['د', 'd'], ['ذ', 'dh'], ['ر', 'r'], ['ز', 'z'], 
                        ['س', 's'], ['ش', 'sh'], ['ص', 'ss'], ['ض', 'dd'],
                        ['ط', 'tt'],['ظ', 'zz'], ['ع', 'aa'], ['غ', 'gh'],
                        ['ف', 'f'], ['ق', 'q'], ['ك', 'k'], ['', ''],
                        ['ل', 'l'], ['م', 'm'], ['ن', 'n'], ['و', 'w'],
                        ['ه', 'h2'], ['ء', 'hamza'], ['ى', 'ya']
                    ],
                    'digits' => [
                        ['١', '1'], ['٢', '2'], ['٣', '3'], ['٤', '4'],
                        ['٥', '5'], ['٦', '6'], ['٧', '7'], ['٨', '8'],
                        ['٩', '9'], ['٠', '0']
                    ]
                ],
                'en' => [
                    'lan' => 'en',
                    'dir' => 'ltr',
                    'letters' => array_map(fn($l) => [$l, strtolower($l)], range('A', 'Z')),
                    'digits' => array_map(fn($d) => [$d, (string)$d], range(0, 9))
                ],
                'bn' => [
                    'lan' => 'bn',
                    'dir' => 'ltr',
                    'letters' => [
                        ['অ', 'a'], ['আ', 'aa'], ['ই', 'i'], ['ঈ', 'ii'],
                        ['উ', 'u'], ['ঊ', 'uu'], ['ঋ', 'ri'], ['এ', 'e'],
                        ['ঐ', 'oi'], ['ও', 'o'], ['ঔ', 'ou'], 
                        ['ক', 'k'], ['খ', 'kh'], ['গ', 'g'], ['ঘ', 'gh'], ['ঙ', 'ng'],
                        ['চ', 'c'], ['ছ', 'ch'], ['জ', 'j'], ['ঝ', 'jh'], ['ঞ', 'ny'],
                        ['ট', 't'], ['ঠ', 'th'], ['ড', 'd'], ['ঢ', 'dh'], ['ণ', 'n'],
                        ['ত', 't'], ['থ', 'th'], ['দ', 'd'], ['ধ', 'dh'], ['ন', 'n'], 
                        ['প', 'p'], ['ফ', 'ph'], ['ব', 'b'], ['ভ', 'bh'], ['ম', 'm'],
                        ['য', 'j'], ['র', 'r'], ['ল', 'l'], ['শ', 'sh'],
                        ['ষ', 'sh'], ['স', 's'], ['হ', 'h']
                    ],
                    'digits' => [['০', '0'], ['১', '1'], ['২', '2'], ['৩', '3'], ['৪', '4'], ['৫', '5'], ['৬', '6'], ['৭', '7'], ['৮', '8'], ['৯', '9']]
                ]
            ];

            $pattern = [
                '*' => [
                    'lan' => '',
                    'dir' => '',
                    'letters' => [['', '']],
                    'digits' => [['', '']]
                ]
            ];
        
            $data = $languages;
            $check_pattern = $instance->matchPattern($data, $pattern);
            
            if ($check_pattern) {
                foreach ($languages as $language) {
                    ?>
                    <div class="alphabet-grid" lan="<?php echo $language['lan']; ?>" dir="<?php echo $language['dir']; ?>">
                        <?php 
                        foreach ($language['letters'] as [$letter, $sound]) {
                            ?>
                            <div data-sound="<?php echo $sound; ?>"><?php echo $letter; ?></div>
                            <?php
                        }
                        ?>                
                    </div>
        
                    <div class="alphabet-grid digits" lan="<?php echo $language['lan']; ?>" dir="<?php echo $language['dir']; ?>">
                        <?php 
                        foreach ($language['digits'] as [$digit, $sound]) {
                            ?>
                            <div data-sound="<?php echo $sound; ?>"><?php echo $digit; ?></div>
                            <?php
                        }
                        ?>                
                    </div>
                    <?php
                }
            } else {
                ?>
                <div>Data mismatched with required pattern !!!</div>
                <?php
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