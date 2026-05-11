<?php
/**
 * Custom Contact Page Template with Secure Form & Email API
 * Template Name: Contact Page Template
 * @package goprint-child
 */

// Security check - Prevent direct file access
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Initialize variables
$error = '';
$success = '';

// Handle form submission with security validation
if ( isset( $_POST['submit_contact_form'] ) ) {
	// Sanitize and validate input data
	$name    = sanitize_text_field( $_POST['contact_name'] );
	$email   = sanitize_email( $_POST['contact_email'] );
	$phone   = sanitize_text_field( $_POST['contact_phone'] );
	$message = sanitize_textarea_field( $_POST['contact_message'] );

	// Form validation
	if ( empty( $name ) || empty( $email ) || empty( $message ) ) {
		$error = 'All required fields must be filled in.';
	} elseif ( ! is_email( $email ) ) {
		$error = 'Please enter a valid email address.';
	} else {
		// WordPress Email API Configuration
		$to      = get_option( 'admin_email' ); // Send to site admin
		$subject = 'New Contact Message from ' . $name;
		$body    = "Name: $name\nEmail: $email\nPhone: $phone\nMessage: $message";
		$headers = array( 'From: ' . $name . ' <' . $email . '>' );

		// Send email using WordPress core API
		if ( wp_mail( $to, $subject, $body, $headers ) ) {
			$success = 'Your message has been sent successfully! We will reply soon.';
		} else {
			$error = 'Failed to send message. Please try again later.';
		}
	}
}

// Load site header
get_header();
?>

<!-- Contact Page Container -->
<section class="contact-container" style="max-width: 800px; margin: 60px auto; padding: 0 20px;">
    <h1 style="text-align: center; margin-bottom: 40px; color: #222;">Contact Us</h1>

    <!-- Error Message -->
    <?php if ( $error ) : ?>
        <div style="padding: 15px; background: #f8d7da; color: #721c24; border-radius: 4px; margin-bottom: 20px; text-align: center;">
            <?php echo esc_html( $error ); ?>
        </div>
    <?php endif; ?>

    <!-- Success Message -->
    <?php if ( $success ) : ?>
        <div style="padding: 15px; background: #d4edda; color: #155724; border-radius: 4px; margin-bottom: 20px; text-align: center;">
            <?php echo esc_html( $success ); ?>
        </div>
    <?php endif; ?>

    <!-- Secure Contact Form -->
    <form method="POST" style="display: flex; flex-direction: column; gap: 20px;">
        <div>
            <label style="display: block; margin-bottom: 8px; font-weight: bold;">Full Name *</label>
            <input type="text" name="contact_name" value="<?php echo isset( $_POST['contact_name'] ) ? esc_attr( $_POST['contact_name'] ) : ''; ?>" required style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 4px;">
        </div>

        <div>
            <label style="display: block; margin-bottom: 8px; font-weight: bold;">Email Address *</label>
            <input type="email" name="contact_email" value="<?php echo isset( $_POST['contact_email'] ) ? esc_attr( $_POST['contact_email'] ) : ''; ?>" required style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 4px;">
        </div>

        <div>
            <label style="display: block; margin-bottom: 8px; font-weight: bold;">Phone Number</label>
            <input type="tel" name="contact_phone" value="<?php echo isset( $_POST['contact_phone'] ) ? esc_attr( $_POST['contact_phone'] ) : ''; ?>" style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 4px;">
        </div>

        <div>
            <label style="display: block; margin-bottom: 8px; font-weight: bold;">Message *</label>
            <textarea name="contact_message" rows="5" required style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 4px;"><?php echo isset( $_POST['contact_message'] ) ? esc_textarea( $_POST['contact_message'] ) : ''; ?></textarea>
        </div>

        <button type="submit" name="submit_contact_form" style="padding: 14px; background: #007cba; color: #fff; border: none; border-radius: 4px; cursor: pointer; font-size: 16px;">
            Send Message
        </button>
    </form>
</section>

<?php
// Load site footer
get_footer();
?>