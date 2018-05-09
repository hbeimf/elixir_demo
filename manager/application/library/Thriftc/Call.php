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
include APP_PATH . '/application/library/Thriftc/call/CallService.php';

class Thriftc_Call {

	// http://yaf.demo.com/demo/index
	function call($id) {
		$msg = new \call\Message(['id' => 1, 'text' => "mike: " . $id]);
		$reply = $this->client->call($msg);
		// print_r($reply);
	}

	function __construct() {
		// $dir = dirname(__FILE__) . '/call/CallService.php';
		// echo $dir;exit;
		// /erlang/elixir_demo/manager/application/library/Thriftc/call/CallService.php

		$socket = new TSocket($this->_host, $this->_port);
		$this->transport = new TBufferedTransport($socket, 1024, 1024);
		$protocol = new TBinaryProtocol($this->transport);
		// $this->client = new \call\CallService\CallServiceClient($protocol);
		$this->client = new \call\CallServiceClient($protocol);
		// $this->client = new CallServiceClient($protocol);

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