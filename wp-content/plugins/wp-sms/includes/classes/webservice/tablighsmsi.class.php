<?php
	class tablighsmsi
	{
		private $wsdl_link = "http://sms.tablighsmsi.com/webservice/index.php?wsdl";
		public $tariff = "http://tablighsmsi.com";
		public $unitrial = true;
		public $unit;
		public $flash = "enable";
		public $user;
		public $pass;
		public $from;
		public $to;
		public $msg;
		public $isflash = false;

		function __construct()
		{
			ini_set("soap.wsdl_cache_enabled", "0");
		}

		function send_sms()
		{
			$client = new SoapClient($this->wsdl_link);
			
			$result = $client->sendsms($this->user, $this->pass, $this->to, $this->from, $this->msg);
			
			return $result;
		}

		function get_credit()
		{
			$client = new SoapClient($this->wsdl_link);
			
			$result = $client->balance($this->user, $this->pass);
			
			return $result;
		}
	}
?>