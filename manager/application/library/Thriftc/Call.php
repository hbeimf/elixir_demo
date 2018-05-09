<?php

use Thrift\Protocol\TBinaryProtocol;
use Thrift\Transport\TBufferedTransport;
use Thrift\Transport\TSocket;

// use example\ExampleServiceClient;

// http://thrift.apache.org/tutorial/php
// http://thrift.apache.org/tutorial/go
// thrift -r --gen php call.thrift

// require_once './call/CallService.php';
// require_once dirname(__FILE__) . '/call/CallService.php';
// include APP_PATH . '/application/library/Thriftc/call/CallService.php';

class Thriftc_Call {
	function call($cmd, $text) {
		$msg = new \call\Message(['id' => $cmd, 'text' => $text]);
		return $this->client->call($msg);
	}

	function __construct() {
		$socket = new TSocket($this->_host, $this->_port);
		$this->transport = new TBufferedTransport($socket, 1024, 1024);
		$protocol = new TBinaryProtocol($this->transport);
		$this->client = new \call\CallServiceClient($protocol);
		$this->transport->open();
	}

	function __destruct() {
		$this->transport->close();
	}

	public $transport = null;
	public $client = null;

	private $_host = "localhost";
	private $_port = 9009;
}

?>