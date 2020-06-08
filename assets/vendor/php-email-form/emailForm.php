<?php
/**
 * 
 */
class EmailForm
{
	public $_to;
	protected $_from_email;
	protected $_from_name;
	protected $_subject;
	protected $_message;


	function __construct($name, $email, $subject, $message)
	{
		$this->hydrate($name, $email, $subject, $message);
	}


	function hydrate($name, $email, $subject, $message) 
	{
		$this->_from_name = $name;
		$this->_from_email = $email;
		$this->_subject = $subject;
		$this->_message = $message;
	}

	function add_message() {
		$addMessageTo  = "From : ".$this->_from_name;
		$addMessageTo .= "\nEmail : ".$this->_from_email;
		$addMessageTo .= "\nSubject : ".$this->_subject;
		$addMessageTo .= "\n".$this->_message;

		$this->_message = $addMessageTo;
	}

	function send()
	{
		if(mail($this->_to, $this->_subject, $this->_message))
		{
			return "OK";
		}else {
			return "error";
		}
	}
}
