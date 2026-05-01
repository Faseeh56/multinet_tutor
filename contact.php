<?php
$page_title = 'Contact Us';
include('header.php');
?>

<h2>📬 Contact Us</h2>
<p>Have a question or feedback? Fill out the form below.</p>

<?php
// Display success/error message after redirect (we'll set this in process_contact.php)
if (isset($_GET['status']) && $_GET['status'] == 'success') {
    echo '<p style="color: green;">✅ Thank you! Your message has been sent.</p>';
} elseif (isset($_GET['status']) && $_GET['status'] == 'error') {
    echo '<p style="color: red;">❌ Sorry, something went wrong. Please try again.</p>';
}
?>

<form action="process_contact.php" method="POST">
    <label for="name">Your Name:</label>
    <input type="text" id="name" name="name" required><br><br>

    <label for="email">Your Email:</label>
    <input type="email" id="email" name="email" required><br><br>

    <label for="message">Message:</label><br>
    <textarea id="message" name="message" rows="5" required></textarea><br><br>

    <button type="submit">Send Message</button>
</form>

<?php include('footer.php'); ?>