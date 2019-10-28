<?php require 'view_data.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="keywords" content="Artur, Mostowiak, contact, form">
	<meta name="author" content="Artur Mostowiak">
	<title>Contact Artur Mostowiak</title>
	<link rel="stylesheet" href="css/contact.css">
	<link rel="shortcut icon" type="image/x-icon" href="images/computer.png">
	<link href='https://fonts.googleapis.com/css?family=Aldrich' rel='stylesheet'>
	<link href='https://fonts.googleapis.com/css?family=Armata' rel='stylesheet'>
	<script src="https://kit.fontawesome.com/6e421ca0b1.js" crossorigin="anonymous"></script>
	<script src="https://www.google.com/recaptcha/api.js?render=6LfyKL0UAAAAABuYBtOXDP-6X_wYDT6mbrXWTUuT"></script>
</head>
<body>
	<nav class="navbar">
		<ul class="link-list">
			<li class="link-list-element"><a href="index.html" class="menu-link">About</a></li>
			<li class="link-list-element"><a href="index.html#projects" class="menu-link">Projects</a></li>
			<li class="link-list-element"><a href="index.html#tech" class="menu-link">Tech</a></li>
			<li class="link-list-element"><a href="contact.php" class="menu-link">Contact</a></li>
		</ul>
	</nav>
	<?php echo $userFeedback; ?>
	<div class="form-container">
		<h1 class="header">Send an email</h1>
		<p class="sending-details">
		  You can send me an email using the form below. If you want an answear please enter your email or phone number. Text message is required and mustn't exceed 1000 characters, the rest is optional however a subject mustn't exceed 30 characters.
		</p>
		<form action="send_email.php" method="POST" class="mail-form">
			<input type="hidden" name="recaptcha_token" id="recaptcha_token">
		<label class="single-layer-label <?php echo $classes['user_contact']; ?>">
			Mail/phone : <input class="single-layer-input" type="text" value="<?php echo $values['user_contact']; ?>" name="user_contact" />
		</label>
		<label class="single-layer-label <?php echo $classes['subject']; ?>">
			Subject : <input max="30" value="<?php echo $values['subject']; ?>" class="single-layer-input" type="text" name="subject" />
		</label>
		<label for="text-message" class="text-message-label">Message</label>
		<textarea name="message" id="text-message" max="1000" class="text-message <?php echo $classes['message']; ?>" required><?php echo $values['message']; ?></textarea>
		<div class="buttons-container">
			<input class="submit-button button" id="submit-button" type="submit" value="send">
		    <input type="reset" class="reset-button button"  value="reset" class="reset-button">
		</div>
	</form>
	</div>

	<footer class="footer">
		<a class="icon-link" href="https://github.com/arturpuck">
		  <span class="visually-hidden">Artur Mostowiak Github profile</span>
		  <span class="fab icon fa-github"></span> 
		</a>
		<a class="icon-link" href="&#109;&#97;&#105;&#108;&#116;&#111;&#58;&#97;&#114;&#116;&#117;&#114;&#109;&#111;&#115;&#116;&#111;&#119;&#105;&#97;&#107;&#64;&#103;&#109;&#97;&#105;&#108;&#46;&#99;&#111;&#109;" class="email-address">
			<span class="visually-hidden">Send me a mail message</span>
			<span class="fas icon fa-envelope"></span>
		</a>
		<span class="footer-info-text">2019 ©</span>
	</footer>
</body>
<?php session_destroy();?>
<script src="captcha.js"></script>
</html>