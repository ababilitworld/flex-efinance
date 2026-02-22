<?php
/**
 * Single fldoc Template
 */
if (!defined('ABSPATH')) exit; // Security check

get_header(); ?>

<main id="primary" class="site-main">
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <header class="entry-header">
            <h1 class="entry-title"><?php the_title(); ?></h1>
        </header>
        
        <div class="entry-content">
            <?php 
            // Main content
            the_content();
            
            // Optional: Page links for paginated posts
            wp_link_pages([
                'before' => '<div class="page-links">' . __('Pages:', 'flex-efinance'),
                'after'  => '</div>',
            ]);
            ?>
        </div>
    </article>
</main>

<?php 
get_footer();