<?php
require_once("email.class.php");
	$status = "";
//self posting variables
	$firstName = "";
	$lastName = "";
	$email = "";
	$phone = "";
	$reference = "";
	$tourDate = "";
	$tourTime = "";
	$message = "";
//self posting errors
	$firstNameERR = "";
	$lastNameERR = "";
	$emailERR = "";
	$phoneERR = "";
	$referenceERR = "";
	$tourDateERR = "";
	$tourTimeERR = "";
	$messageERR = "";
function validateDate($date, $format = 'Y-m-d'){
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) === $date;
}
if (isset($_POST['submit'])){
	$firstName = $_POST['firstName'];
	$lastName = $_POST['lastName'];
	$email = $_POST['email'];
	$phone = $_POST['phone'];
	if(isset($_POST['reference'])){$reference = $_POST['reference'];}
	$tourDate = $_POST['tourDate'];
	if(isset($_POST['tourTime'])){$tourTime = $_POST['tourTime'];}
	
	$message = $_POST['message'];
	
	//validation
	$validPost = true;
	
	//firstname
		$firstName = filter_var($firstName);
		if (!is_numeric($firstName)){
			$firstNameERR = "";
		}
		else {
			//failure to validate
			$firstNameERR = "Please use non-numerics";
			$validPost = false;
		}
	//lastname
		$lastName = filter_var($lastName);
		if (!is_numeric($lastName)){
			$lastNameERR = "";
		}
		else{
			//failure to validate
			$lastNameERR = "Please use non-numerics";
			$validPost = false;
		}
	//email
		$email = filter_var($email, FILTER_SANITIZE_EMAIL);
		if (!filter_var($email, FILTER_VALIDATE_EMAIL) === false){
			$emailERR = "";
		}
		else {
			//failure to validate
			$emailERR = "Invalid E-mail Adress";
			$validPost = false;
		}
		$phone = filter_var($phone);
		if(preg_match('/^[0-9]{3}-[0-9]{3}-[0-9]{4}$/', $phone)){
		  $phoneERR = "";
		}
		else {
			//failure to validate
			$phoneERR = "Please enter a valid Phone";
			$validPost = false;
		}
	//tour time
	if(isset($_POST['tourTime'])){
		$tourTimeERR = "";
	}
	else {
		$tourTimeERR = "Select a Time";
		$validPost = false;
	}
	//tour date
		$tourDate = filter_var($tourDate);
		if (validateDate($tourDate)){
			$tourDateERR = "";
		}
		else{
			//failure to validate
			$tourDateERR = "Invalid Date";
			$validPost = false;
		}
	//message
		$message = filter_var($message);
		if (filter_var($message)){
			$messageERR = "";
		}
		else{
			//failure to validate
			$messageERR = "Invalid characters in message";
			$validPost = false;
		}
	//delivery
		if($validPost){
			$status = "success";
			
			$mail = new ContactForm();
			$mail->setFirst($firstName);
			$mail->setLast($lastName);
			$mail->setEmail($email);
			$mail->setPhone($phone);
			$mail->setReference($reference);
			$mail->setDate($tourDate);
			$mail->setTime($tourTime);
			$mail->setMessage($message);
			$mail->setSubject("Vintage Cooperative Schedule a Tour");
			$mail->sendTour();
		}
		else {
			$status = "failure";
		}
}
function checkBoxes($value){
	if(isset($_POST['reference'])){
		$boxes = $_POST['reference'];
		for ($i = 0; $i < count($boxes); $i++){
			if ($value == $boxes[$i]){echo "checked";}
		}
	}
}
//echo $status;
?>
<!doctype html>
<html>
	<!--VIEWPORT-->
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
<head>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	
	<link rel="stylesheet" type="text/css" href="coopTemplateStyle.css">
	<link rel = "manifest" href = "/manifest.json">
	<style>	
		#contact {
			width: 80%;
			margin-left: auto;
			margin-right: auto;
			text-align: center;
			background-color: antiquewhite;
			padding: 20px;
		}
		h1 {
			text-shadow: 4px 4px 6px;
		}
		form {
			font-size: 1.5em;
		}
		.checkBoxes {
			text-align: left;
			margin: 15px;
		}
		.checkBoxes table {
			margin-left: auto;
			margin-right: auto;
		}
		.wide {
			width: 100%;
			margin-right: auto;
			margin-left: auto;
		}
		input[type = 'checkbox'], input[type = 'radio']{
			width: 1em;
			height:1em;
		}
		.buttons {
			margin: 15px;
		}
		.buttons input {
			color: white;
			background-color: #B41831;
			background-image: linear-gradient(#EB6D81, #B41831);
			transition: background-image 2s;
			border: none;
		}
		.buttons input:hover {
			background-image: linear-gradient(#B41831, #EB6D81);
			text-shadow: 1px 1px black;
		}

		.toggleForm {
			width: 80%;
			height: 75px;
			margin-left: auto;
			margin-right: auto;
			font-size: 2em;
			font-weight: bold;
			background-color: #857d78;
			text-align: center;
		}
		.navLink, .navLink:hover {
			color: black;
		}
		.contactButton, .scheduleButton {
			display: inline-block;
			width: 50%;
			height: 75px;
			line-height: 75px;
		}
		.contactButton:hover {
			cursor: pointer;
		}
		.scheduleButton {
			background-color: #A8AC86;
		}
		.tourDate {
			display: inline;
			width: 50%;
			margin-left: 5px;
			
		}
		.tourTime  {
			text-align: left;
			margin-left: auto;
			margin-right: auto;
		}
		h2 {
			font-weight: bold;
		}
		.tourInfo {
			margin: 15px;
		}
		.error {
			text-align: center;
			color: lightcoral;
			border-radius: 45px;
			margin: 5px auto 5px auto;
			font-weight: bold;
		}
		/*Media Queries*/
		@media only screen and (max-width: 991px){
			
			.wide {
				width: 70%;
			}
			table {
				width: 70%;
			}
			.checkBoxes table {
				width: auto;
			}
			.scheduleButton, .contactButton {
				display: block;
				width: 100%;
			}
			.toggleForm {
				height: 150px;
			}
			.tourDate {
				width: 40%;
			}
			.tourTime {
				width: auto;
			}
		}
		@media only screen and (max-width: 576px){
			.wide {
				width: 100%;
			}
			#contact {
				width: 100%;
			}

			body {
				font-size: 1.25em;
			}
			table {
				width: 80%;
			}
			h1 {
				font-size: 2em;
			}
			.toggleForm {
				width: 100%;
			}
			.tourTime {
				width: 70%;
			}
			h2 {
				font-size: 1.25em;
			}
		}
	</style>
	<script>
			function resetErrors(){
			$(".error").html("");
		}
	</script>
<meta charset="utf-8">
<title>Contact Us!</title>
</head>
<header>
	
	<a href="index.html"><img src="photos/logo.png" id="headLogo" alt="logo"></a>	
	
	<nav class="navbar navbar-expand-lg" style="background-color: #A8AC86;">
		<button class="navbar-toggler custom-toggler ml-auto" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarNav" style="justify-content: center">
			<ul class="navbar-nav" >
				<li class="nav-item">
					<a class="nav-link" href="index.html">Home</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="ourStory.html">About</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="floor-plans.html">Floor Plans</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="gallery.html">Gallery</a>
				</li>
				<li class="nav-item active">
					<a class="nav-link" href="contact.php">Contact</a>
				</li>
			</ul>
		</div>
	</nav>
	
	<img id="bannerHome" src="photos/contact.jpeg" alt="banner photo" width="100%" height="100%">

	<img id="bannerHomeMobile" src="photos/contactsmall.jpeg" alt="banner photo" width="100%" height="100%">
	
</header>

<body>
	<div class = "toggleForm" id = "top">
		<a href = "contact.php#top" class = "navLink"><div class= "contactButton">CONTACT US</div></a><div class= "scheduleButton active">SCHEDULE TOUR</div>
	</div>
	<div id = "contact">
		<form action = "tour.php#top" method = "post" id = "scheduleForm">
			<div class= "row">
				<div class = "col-lg-1 col-md-3" ></div>
				<div class = "col-lg-5">
					<label for = "firstName" class="form-label">First Name*</label><br>
					<input type = "text" name = "firstName" class = "wide form-control" placeholder = "John" require value ="<?php echo $firstName;?>">
					<div class = "error"><?php echo $firstNameERR;?></div>
				</div>
				<div class = "w-100 d-none"></div>
				<div class = "col-lg-5">
					<label for = "lastName" class="form-label">Last Name*</label><br>
					<input type = "text" name = "lastName" class = "wide form-control" placeholder = "Doe" require value ="<?php echo $lastName;?>">
					<div class = "error"><?php echo $lastNameERR;?></div>
				</div>
				<div class = "col-lg-1 col-md-3"></div>
			</div>
			
			<div class= "row">
				<div class = "col-lg-1"></div>
				<div class = "col-lg-5">
					<label for = "email" class="form-label">Email*</label><br>
					<input type = "email" name = "email" class = "wide form-control" placeholder = "example@service.com" require value ="<?php echo $email;?>">
					<div class = "error"><?php echo $emailERR;?></div>
				</div>
				<div class = "col-lg-5">
					<label for = "phone" class="form-label">Phone ###-###-####</label><br>
					<input type = "text" name = "phone" class = "wide form-control" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" placeholder="###-###-####"  value ="<?php echo $phone;?>">
					<div class = "error"><?php echo $phoneERR;?></div>
				</div>
				<div class = "col-lg-1"></div>
			</div>
			<div class = "row checkBoxes">
				<div class = "col-lg-1"></div>
				<div class= "col-lg-5">
					<table>
							<tr><td><label for "reference" class="form-label">How did you hear about us?</label></td></tr>
								<tr><td><input type = "checkbox" name = "reference[]" value = "Mail" <?php checkBoxes("Mail");?>> Mail</td></tr>
								<tr><td><input type = "checkbox" name = "reference[]" value = "Social Media" <?php checkBoxes("Social Media");?>> Social Media</td></tr>
								<tr><td><input type = "checkbox" name = "reference[]" value = "Newspaper" <?php checkBoxes("Newspaper");?>> Newspaper</td></tr>
								<tr><td><input type = "checkbox" name = "reference[]" value = "Drive By" <?php checkBoxes("Drive By");?>> Drive By</td></tr>
								<tr><td><input type = "checkbox" name = "reference[]" value = "Other" <?php checkBoxes("Other");?>> Other</td></tr>
					</table>
				</div>
				<div class = "col-lg-5"></div>
				<div class = "col-lg-1"></div>
			</div>
			<h2>Tour Information</h2>
			<div class = " tourInfo row">
				<div class =  "col-lg-1"></div>
				<div class = "col-lg-5">
					<label for "tourDate" class = "form-label">Select Date: </label><input type = "date" name = "tourDate" class = "tourDate form-control" require  value ="<?php echo $tourDate;?>">
					<div class = "error"><?php echo $tourDateERR;?></div>
				</div>
				<div class = "col-lg-5">
					<table class = "tourTime">
						<tr>
							<td><label for = "tourTime" class = "form-label">Preferred Time:</label></td>
						</tr>
						<tr><td><input type = "radio" name = "tourTime" value = "Morning" require <?php if($tourTime == "Morning") { echo 'checked="checked"';} ?>> Morning</td></tr>
						<tr><td><input type = "radio" name = "tourTime" value = "Afternoon" require <?php if($tourTime == "Afternoon") { echo 'checked="checked"';} ?>> Afternoon</td></tr>
					</table>
					<div class = "error"><?php echo $tourTimeERR;?></div>
				</div>
				<div class =  "col-lg-1"></div>

			</div>
			<div class = "row">
				<div class = "col-lg-1"></div>
				<div class = "col-lg-10">
					<label for = "message" class="form-label">Leave a comment or question</label><br>
					<textarea name = "message" class = "wide form-control" rows = "5"><?php echo $message;?></textarea>
					<div class = "error"><?php echo $messageERR;?></div>
				</div>
				<div class = "col-lg-1"></div>
			</div>
			<div class = "row buttons" >
				<div class = "col-lg-4"></div>
				<div class = "col-lg-4"><input type = "submit" name = "submit"> <input type = reset onClick="resetErrors()"></div>
				<div class = "col-lg-4"></div>
			</div>	
		</form>
	</div>
	
	<!-- Modal -->
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-body alert-success">
			<h1 style="text-align: center">Tour Request Submission Successful</h1>
			<h2 style="text-align: center">We will follow up with you as soon as possible.</h2>
		  </div>
		  <div class="modal-footer alert-success">
			<button type="button" class="btn btn-success" data-dismiss="modal" style="margin-left: auto; margin-right: auto">Close</button>
		  </div>
		</div>
	  </div>
	</div>
</body>
<footer>
	
	
	<div class="row" id="footContainer">
		
		
		<div id="navFoot" class="col-lg-4">
			<h4><strong>Navigation:</strong></h4>
			
			<p>
				<div id="divFootNav">
					<u>
						<a class="nav-link" href="index.html">Home</a>
						<a class="nav-link" href="ourStory.html">About</a>
						<a class="nav-link" href="floor-plans.html">Floor Plans</a>
						<a class="nav-link" href="gallery.html">Gallery</a>
						<a class="nav-link" href="contact.php">Contact</a>
					</u>
				</div>
			</p>
		</div>

		<div class="col-lg-4">
			<h4><strong>Vintage Cooperative of Prairie Trail</strong></h4>

			<p>
				1370 SW Magazine Rd<br>
				Ankeny, Iowa 50023<br>
				515.279.3000
			</p>
			
			<button id="footContact" onClick="document.location='contact.php'">Contact</button>
		</div>

		<div class="col-lg-4 order-first order-lg-last">

			<img id="footLogo" src="photos/logo.png" alt="logo">
			
		</div>
		
	</div>
		
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	<script src="js/main.js"></script>

</footer>
<?php if ($status == "success"){?>
	<script>$('#myModal').modal('show');
	$("#myModal").on("hidden.bs.modal", function () {
		window.location.replace("index.html")
});
		</script>
<?php } ?>
</html>