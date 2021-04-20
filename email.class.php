<?php
class ContactForm {
	//properties
	var $firstName = "";
	var $lastName = "";
	var $email = "";
	var $phone = "N/A";
	var $reference = "N/A";
	var $tourDate = "";
	var $tourTime = "";
	var $message = "";
	var $subject = "";
	
	//functions
	function setFirst($firstName){
		$this->firstName = $firstName;
	}
	function setLast($lastName){
		$this->lastName = $lastName;
	}
	function setEmail($email){
		$this->email = $email;
	}
	function setPhone($phone){
		$this->phone = $phone;
	}
	function setReference($reference){
		$this->reference = "";
		for ($i = 0; $i < count($reference); $i++){
			$this->reference .= $reference[$i] . ", ";
		}
	}
	function setDate($tourDate){
		$this->tourDate = $tourDate;
	}
	function setTime($tourTime){
		$this->tourTime = $tourTime;
	}
	function setMessage($message){
		$this->message = $message;
	}
	function setSubject($subject){
		$this->subject = $subject;
	}
	function sendContact(){
		$to = $this->email;
		$content = 
			"My name is ".$this->firstName." ".$this->lastName."\n.
			My Email is ".$this->email."\n
			My Phone number is ".$this->phone."\n
			I found your cooperative via ".$this->reference."\n
			My message for you is ".$this->message;
		
		$headers = "From:" . "vcprairietrail@vintagecooperative.joshbarron.info";
		mail($to, $this->subject, $content, $headers);
	}
	function sendTour(){
		$to = $this->email;
		$content = 
			"My name is ".$this->firstName." ".$this->lastName."\n.
			My Email is ".$this->email."\n
			My Phone number is ".$this->phone."\n
			I found your cooperative via ".$this->reference."\n
			I would like to schedule a tour of your cooperative on " .$this->tourDate. " in the " . $this->tourTime . ".\n
			My message for you is ".$this->message;
		
		$headers = "From:" . "vcprairietrail@vintagecooperative.joshbarron.info";
		mail($to, $this->subject, $content, $headers);
	}
}
?>