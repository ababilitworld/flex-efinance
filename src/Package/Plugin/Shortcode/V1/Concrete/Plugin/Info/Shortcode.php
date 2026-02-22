<?php

namespace Ababilithub\FlexEFinance\Package\Plugin\Shortcode\V1\Concrete\Plugin\Info;

(defined('ABSPATH') && defined('WPINC')) || exit();

use Ababilithub\{
    FlexWordpress\Package\Shortcode\V1\Base\Shortcode as BaseShortcode,
    FlexEFinance\Package\Plugin\Shortcode\V1\Concrete\Plugin\Info\Presentation\Template\Template as PluginInfoTemplate,
};

use const Ababilithub\{
    FlexEFinance\PLUGIN_PRE_UNDS,
    FlexEFinance\PLUGIN_PRE_HYPH,
};

class Shortcode extends BaseShortcode
{
    public function init(): void
    {
        $this->set_tag(PLUGIN_PRE_HYPH.'-plugin-info'); 
        $this->set_default_attributes([
            'style' => 'grid',
            'debug' => 'no'
        ]);
        
        $this->init_service();
        $this->init_hook();
    }

    public function init_hook(): void
    {
        add_action(PLUGIN_PRE_UNDS.'_plugin_info', [$this, 'plugin_info']);
    }

    public function init_service()
    {
        new PluginInfoTemplate();
    }

    public function render(array $attributes): string
    {
        $this->set_attributes($attributes);
        ob_start();
        $this->display_plugin_info();
        return ob_get_clean();
    }

    protected function display_plugin_info(): void
    {
        ?>
        <div class="fel-plugin-info">
            <?php do_action(PLUGIN_PRE_UNDS.'_plugin_info', $this->get_attributes()); ?>
        </div>
        <?php
    }

    public function plugin_info(array $params = []): void
    {
        $this->render_hero_section();
        $this->render_stats_section();
        $this->render_features_section();
        $this->render_workflow_section();
        $this->render_benefits_section();
        $this->render_integrations_section();
        $this->render_testimonials_section();
        $this->render_pricing_section();
        $this->render_faq_section();
        $this->render_cta_section();
    }

    protected function render_hero_section(): void
    {
        ?>
        <section class="hero-section">
            <div class="container">
                <div class="hero-content">
                    <div class="badge">Revolutionary Land Registry Solution</div>
                    <h1>Transform Land Documents with <span>Flex-ELand</span></h1>
                    <p class="subtitle">Blockchain-powered platform bringing transparency, security and efficiency to land registration worldwide</p>
                    <div class="hero-actions">
                        <a href="#features" class="btn btn-primary">
                            <i class="fas fa-rocket"></i> Explore Features
                        </a>
                        <a href="#pricing" class="btn btn-outline">
                            <i class="fas fa-chart-line"></i> View Plans
                        </a>
                    </div>
                    <div class="trust-badges">
                        <div class="trust-item">
                            <i class="fas fa-shield-alt"></i> <span>Bank-Level Security</span>
                        </div>
                        <div class="trust-item">
                            <i class="fas fa-globe"></i> <span>Global Compliance</span>
                        </div>
                    </div>
                </div>
                <div class="hero-image">
                    <div class="dashboard-preview">
                        <div class="screen"></div>
                        <div class="floating-elements">
                            <div class="element-1"></div>
                            <div class="element-2"></div>
                            <div class="element-3"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="wave-divider">
                <svg viewBox="0 0 1200 120" preserveAspectRatio="none">
                    <path d="M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z" opacity=".25" fill="currentColor"></path>
                    <path d="M0,0V15.81C13,36.92,27.64,56.86,47.69,72.05,99.41,111.27,165,111,224.58,91.58c31.15-10.15,60.09-26.07,89.67-39.8,40.92-19,84.73-46,130.83-49.67,36.26-2.85,70.9,9.42,98.6,31.56,31.77,25.39,62.32,62,103.63,73,40.44,10.79,81.35-6.69,119.13-24.28s75.16-39,116.92-43.05c59.73-5.85,113.28,22.88,168.9,38.84,30.2,8.66,59,6.17,87.09-7.5,22.43-10.89,48-26.93,60.65-49.24V0Z" opacity=".5" fill="currentColor"></path>
                    <path d="M0,0V5.63C149.93,59,314.09,71.32,475.83,42.57c43-7.64,84.23-20.12,127.61-26.46,59-8.63,112.48,12.24,165.56,35.4C827.93,77.22,886,95.24,951.2,90c86.53-7,172.46-45.71,248.8-84.81V0Z" fill="currentColor"></path>
                </svg>
            </div>
        </section>
        <?php
    }

    protected function render_stats_section(): void
    {
        ?>
        <section class="stats-section">
            <div class="container">
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-number" data-count="99.9" data-prefix="" data-suffix="%">0</div>
                        <div class="stat-label">Uptime</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number" data-count="15" data-prefix="+" data-suffix="">0</div>
                        <div class="stat-label">Properties Registered</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number" data-count="1" data-prefix="" data-suffix="">0</div>
                        <div class="stat-label">Countries Supported</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number" data-count="1" data-prefix="+" data-suffix="">0</div>
                        <div class="stat-label">Government Partners</div>
                    </div>
                </div>
            </div>
        </section>
        <?php
    }

    protected function render_features_section(): void
    {
        $features = [
            [
                'icon' => 'fingerprint',
                'title' => 'Biometric Authentication',
                'description' => 'Secure access with fingerprint and facial recognition technology'
            ],
            [
                'icon' => 'file-contract',
                'title' => 'Smart Contracts',
                'description' => 'Automate property transfers with self-executing contracts'
            ],
            [
                'icon' => 'search-plus',
                'title' => 'AI-Powered Search',
                'description' => 'Find properties using natural language queries'
            ],
            [
                'icon' => 'mobile-alt',
                'title' => 'Mobile App',
                'description' => 'Full functionality on iOS and Android devices'
            ],
            [
                'icon' => 'chart-line',
                'title' => 'Interactive Dashboards',
                'description' => 'Visualize property data with powerful analytics tools'
            ],
            [
                'icon' => 'network-wired',
                'title' => 'Stakeholder Network',
                'description' => 'Connect with notaries, surveyors, and lawyers'
            ]
        ];
        ?>
        <section id="features" class="features-section">
            <div class="container">
                <div class="section-header">
                    <h2>Cutting-Edge Features</h2>
                    <p class="section-description">Designed for the future of property management</p>
                </div>
                <div class="features-grid">
                    <?php foreach ($features as $feature): ?>
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-<?php echo esc_attr($feature['icon']); ?>"></i>
                        </div>
                        <h3><?php echo esc_html($feature['title']); ?></h3>
                        <p><?php echo esc_html($feature['description']); ?></p>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <?php
    }

    protected function render_workflow_section(): void
    {
        ?>
        <section class="workflow-section">
            <div class="container">
                <div class="section-header">
                    <h2>How It Works</h2>
                    <p class="section-description">Simple three-step process to modernize your land registry</p>
                </div>
                <div class="workflow-steps">
                    <div class="step">
                        <div class="step-number"></div>
                        <div class="step-content">
                            <h3>Confirm Flex ELand</h3>
                            <p>Buy this Revolutionary Software from us.</p>
                        </div>
                    </div>
                    <div class="step">
                        <div class="step-number"></div>
                        <div class="step-content">
                            <h3>Property Registration</h3>
                            <p>Upload property documents and verify ownership through our secure portal</p>
                        </div>
                    </div>
                    <div class="step">
                        <div class="step-number"></div>
                        <div class="step-content">
                            <h3>Digital Management</h3>
                            <p>Manage all aspects of your property through our intuitive dashboard</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <?php
    }

    protected function render_benefits_section(): void
    {
        $benefits = [
            'owners' => [
                'title' => 'For Property Owners',
                'items' => [
                    'Instant proof of ownership',
                    'Fraud-proof digital records',
                    '24/7 access from anywhere',
                    'Faster transactions (minutes vs weeks)',
                    'Reduced paperwork and bureaucracy'
                ]
            ],
            'government' => [
                'title' => 'For Government',
                'items' => [
                    'Eliminate land disputes',
                    'Transparent audit trail',
                    'Automated tax collection',
                    'Urban planning analytics',
                    'Reduced administrative costs'
                ]
            ],
            'businesses' => [
                'title' => 'For Businesses',
                'items' => [
                    'Instant due diligence',
                    'Smart contract integration',
                    'Portfolio management tools',
                    'Market trend analysis',
                    'Stakeholder collaboration'
                ]
            ]
        ];
        ?>
        <section id="benefits" class="benefits-section">
            <div class="container">
                <div class="section-header">
                    <h2>Transformational Benefits</h2>
                    <p class="section-description">Value for all stakeholders in the property ecosystem</p>
                </div>
                <div class="benefits-grid">
                    <?php foreach ($benefits as $key => $group): ?>
                    <div class="benefit-card">
                        <div class="benefit-header">
                            <h3><?php echo esc_html($group['title']); ?></h3>
                        </div>
                        <ul>
                            <?php foreach ($group['items'] as $item): ?>
                            <li>
                                <i class="fas fa-check-circle"></i>
                                <?php echo esc_html($item); ?>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <?php
    }

    protected function render_integrations_section(): void
    {
        $integrations = [
            ['name' => 'Government Registries', 'icon' => 'landmark'],
            ['name' => 'Banks & Lenders', 'icon' => 'university'],
            ['name' => 'Notary Services', 'icon' => 'file-signature'],
            ['name' => 'Survey Companies', 'icon' => 'ruler-combined'],
            ['name' => 'Legal Firms', 'icon' => 'balance-scale'],
            ['name' => 'Tax Authorities', 'icon' => 'receipt']
        ];
        ?>
        <section class="integrations-section">
            <div class="container">
                <div class="section-header">
                    <h2>Seamless Integrations</h2>
                    <p class="section-description">Works with your existing ecosystem</p>
                </div>
                <div class="integrations-grid">
                    <?php foreach ($integrations as $integration): ?>
                    <div class="integration-card">
                        <div class="integration-icon">
                            <i class="fas fa-<?php echo esc_attr($integration['icon']); ?>"></i>
                        </div>
                        <div class="integration-name"><?php echo esc_html($integration['name']); ?></div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <?php
    }

    protected function render_testimonials_section(): void
    {
        $testimonials = [
            [
                'quote' => "Flex-ELand reduced our property transfer processing from 3 weeks to just 48 hours while eliminating fraud cases completely.",
                'author' => "Land Registry Department",
                'role' => "Government Agency",
                'avatar' => "fas fa-landmark"
            ],
            [
                'quote' => "The blockchain verification gives us absolute confidence in property titles, reducing our due diligence time by 90%.",
                'author' => "Global Trust Bank",
                'role' => "Financial Institution",
                'avatar' => "bank"
            ],
            [
                'quote' => "Our rural clients can now verify and transfer properties using just their mobile phones - a game changer for financial inclusion.",
                'author' => "Notary Association",
                'role' => "Legal Services",
                'avatar' => "legal"
            ]
        ];
        ?>
        <section class="testimonials-section">
            <div class="container">
                <div class="section-header">
                    <h2>Trusted By Leaders</h2>
                    <p class="section-description">What our partners say about us</p>
                </div>
                <div class="testimonials-slider">
                    <?php foreach ($testimonials as $testimonial): ?>
                    <div class="testimonial-card">
                        <div class="testimonial-avatar avatar-<?php echo esc_attr($testimonial['avatar']); ?>">
                            <i class="fas fa-<?php echo esc_attr($testimonial['avatar']); ?>"></i>
                        </div>
                        <blockquote>
                            <p><?php echo esc_html($testimonial['quote']); ?></p>
                            <footer>
                                <cite><?php echo esc_html($testimonial['author']); ?></cite>
                                <span><?php echo esc_html($testimonial['role']); ?></span>
                            </footer>
                        </blockquote>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <?php
    }

    protected function render_pricing_section(): void
    {
        ?>
        <section id="pricing" class="pricing-section">
            <div class="container">
                <div class="section-header">
                    <h2>Simple, Transparent Pricing</h2>
                    <p class="section-description">Choose the plan that fits your needs</p>
                </div>
                <div class="pricing-grid">
                    <div class="pricing-card">
                        <div class="pricing-header">
                            <h3>Starter</h3>
                            <div class="price">$270</div>                            
                            <p> domain & hosting ($99<span>/year</span>)</p>
                            <p>For individual property owners</p>
                        </div>
                        <ul class="features">
                            <li><i class="fas fa-check"></i> Up to 5 properties</li>
                            <li><i class="fas fa-check"></i> Basic verification</li>
                            <li><i class="fas fa-check"></i> Mobile access</li>
                            <li><i class="fas fa-check"></i> Email support</li>
                        </ul>
                        <a href="#" class="btn btn-outline">Get Started</a>
                    </div>
                    
                    <div class="pricing-card featured">
                        <div class="popular-badge">Most Popular</div>
                        <div class="pricing-header">
                            <h3>Professional</h3>
                            <div class="price">$490</div>
                            <p> domain & hosting ($99<span>/year</span>)</p>
                            <p>For real estate professionals</p>                            
                        </div>
                        <ul class="features">
                            <li><i class="fas fa-check"></i> Up to 50 properties</li>
                            <li><i class="fas fa-check"></i> Advanced verification</li>
                            <li><i class="fas fa-check"></i> API access</li>
                            <li><i class="fas fa-check"></i> Priority support</li>
                            <li><i class="fas fa-check"></i> Analytics dashboard</li>
                        </ul>
                        <a href="#" class="btn btn-primary">Get Started</a>
                    </div>
                    
                    <div class="pricing-card">
                        <div class="pricing-header">
                            <h3>Enterprise</h3>
                            <div class="price">Custom</div>
                            <p>For governments & institutions</p>
                        </div>
                        <ul class="features">
                            <li><i class="fas fa-check"></i> Unlimited properties</li>
                            <li><i class="fas fa-check"></i> Premium verification</li>
                            <li><i class="fas fa-check"></i> White-label solution</li>
                            <li><i class="fas fa-check"></i> Dedicated support</li>
                            <li><i class="fas fa-check"></i> Custom integrations</li>
                        </ul>
                        <a href="#" class="btn btn-outline">Contact Sales</a>
                    </div>
                </div>
            </div>
        </section>
        <?php
    }

    protected function render_faq_section(): void
    {
        $faqs = [
            [
                'question' => 'How does blockchain improve land registration?',
                'answer' => 'Blockchain creates an immutable, tamper-proof record of property ownership that is transparent yet secure. Once recorded, property details cannot be altered or disputed, eliminating fraud and reducing legal conflicts.'
            ],
            [
                'question' => 'Is my data secure with Flex-ELand?',
                'answer' => 'Absolutely. We use military-grade encryption combined with blockchain technology. Your data is distributed across multiple nodes, making it virtually impossible to hack or lose.'
            ],
            [
                'question' => 'Can I use Flex-ELand for commercial properties?',
                'answer' => 'Yes, our platform supports all property types including residential, commercial, agricultural, and industrial properties with customized workflows for each category.'
            ],
            [
                'question' => 'How long does property verification take?',
                'answer' => 'Most properties are verified within 24-48 hours through our automated systems. Complex cases requiring manual review may take up to 5 business days.'
            ],
            [
                'question' => 'Do you offer mobile access?',
                'answer' => 'Yes, we have full-featured iOS and Android apps that allow you to manage properties, verify ownership, and even conduct transactions from your mobile device.'
            ]
        ];
        ?>
        <section class="faq-section">
            <div class="container">
                <div class="section-header">
                    <h2>Frequently Asked Questions</h2>
                    <p class="section-description">Everything you need to know</p>
                </div>
                <div class="faq-accordion">
                    <?php foreach ($faqs as $index => $faq): ?>
                    <div class="faq-item">
                        <div class="faq-question">
                            <h3><?php echo esc_html($faq['question']); ?></h3>
                            <i class="fas fa-chevron-down"></i>
                        </div>
                        <div class="faq-answer">
                            <p><?php echo esc_html($faq['answer']); ?></p>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <?php
    }

    protected function render_cta_section(): void
    {
        ?>
        <section id="contact" class="cta-section">
            <div class="container">
                <div class="cta-content">
                    <h2>Ready to Transform Your Property Management?</h2>
                    <p>Join thousands of satisfied users revolutionizing land registration worldwide</p>
                    <div class="cta-actions">
                        <a href="/contact" class="btn btn-primary btn-large">
                            <i class="fas fa-calendar-check"></i> Schedule Demo
                        </a>
                        <a href="#pricing" class="btn btn-outline btn-large">
                            <i class="fas fa-box-open"></i> View All Plans
                        </a>
                    </div>
                </div>
            </div>
        </section>
        <?php
    }
}