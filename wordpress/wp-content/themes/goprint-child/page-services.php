<?php
/**
 * Custom Services Page Template
 * Template Name: Services Page Template
 * @package goprint-child
 */

// Security check
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Load site header
get_header();
?>

<!-- Services Page Main Container -->
<section class="services-page-container" style="max-width: 1200px; margin: 60px auto; padding: 0 20px;">
    <h1 style="text-align: center; margin-bottom: 40px; color: #222;">Our Professional Printing Services</h1>

    <!-- Services Grid Layout -->
    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 30px;">
        <div style="background: #ffffff; padding: 30px; border: 1px solid #eee; border-radius: 8px;">
            <h3>Business Cards</h3>
            <p>Premium custom business cards for corporate and personal branding.</p>
        </div>
        <div style="background: #ffffff; padding: 30px; border: 1px solid #eee; border-radius: 8px;">
            <h3>Flyers & Brochures</h3>
            <p>High-quality marketing materials for business promotion and events.</p>
        </div>
        <div style="background: #ffffff; padding: 30px; border: 1px solid #eee; border-radius: 8px;">
            <h3>Envelopes & Letterheads</h3>
            <p>Custom branded stationery for official business communications.</p>
        </div>
        <div style="background: #ffffff; padding: 30px; border: 1px solid #eee; border-radius: 8px;">
            <h3>Banners & Posters</h3>
            <p>Large format printing for advertising, exhibitions and outdoor promotions.</p>
        </div>
    </div>
</section>

<?php
// Load site footer
get_footer();
?>