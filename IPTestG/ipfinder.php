<?php
	function getUserIP()
	{
	    $client  = @$_SERVER['HTTP_CLIENT_IP'];
	    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
	    $remote  = $_SERVER['REMOTE_ADDR'];
	
	    if(filter_var($client, FILTER_VALIDATE_IP))
	    {
	        $ip = $client;
	    }
	    elseif(filter_var($forward, FILTER_VALIDATE_IP))
	    {
	        $ip = $forward;
	    }
	    else
	    {
	        $ip = $remote;
	    }
	
	    return $ip;
	}

	$now = date('Y_m_d-H_i_s');
	$f = fopen('logs/' . $now . '-' . $_REQUEST['usr'] . '.txt', 'w');
	
	fwrite($f, 'IP: ' . getUserIP() . PHP_EOL . PHP_EOL);
	fwrite($f, 'Browser info: ' . $_SERVER['HTTP_USER_AGENT'] . PHP_EOL . PHP_EOL);
	
	fclose($f);
	
	header("Content-Type: image/jpeg");
	echo file_get_contents('images/' . $_REQUEST['img']);

?>