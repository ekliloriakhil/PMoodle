<?php
/**
 * A template to test Moodle's XML-RPC feature
 * 
 * This script 'remotely' executes the mnet_concatenate_strings function in 
 * mnet/testlib.php
 * It steps through each stage of the process, printing some data as it goes
 * along. It should help you to get your remote method working.
 * 
 * @author  Donal McMullan  donal@catalyst.net.nz
 * @version 0.0.1
 * @license http://www.gnu.org/copyleft/gpl.html GNU Public License
 * @package mnet
 */
//require_once(dirname(dirname(dirname(__FILE__))) . '/config.php');
require_once dirname(__FILE__)."/../../admin/synch-setup.php";
require_once $CFG->dirroot.'/mnet/xmlrpc/client.php';
GLOBAL $Out;
$Out->append("testing");

error_reporting(E_ALL);

if (isset($_GET['func']) && is_numeric($_GET['func'])) {
    $func = $_GET['func'];


// Some HTML sugar
echo '<?xml version="1.0" encoding="utf-8"?>';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
<head><title>Moodle MNET Test Client</title></head><body>
<?php

// For the demo, our 'remote' host is actually our local host.
$wwwroot = $CFG->wwwroot;

// Enter the complete path to the file that contains the function you want to 
// call on the remote server. In our example the function is in 
// mnet/testlib/
// The function itself is added to that path to complete the $path_to_function 
// variable 
//$path_to_function[0] = '_development/20070808/rpclib/fetch_user_image';
$path_to_function[0] = 'synch/mnet/synch.php/test';
$path_to_function[1] = 'synch/mnet/synch.php/testResponse';
$path_to_function[2] = 'synch/mnet/synch.php/getBackupById';
$path_to_function[3] = 'synch/mnet/synch.php/restoreMergedBackupFromRemoteHost';
$path_to_function[4] = 'synch/mnet/synch.php/getServerDetails';
$path_to_function[5] = 'synch/mnet/synch.php/getHierarchyChildrenByIdAndType';
$sessionId = '6d6041fd-fadf-8764-f1c6-e920253df16a';
$session = $SynchSessionController->createSessionFromSessionId($sessionId, true); 
//$Out->print_r($session, '$session = ');
/*
$session_encoded = xmlrpc_encode($session);
$session_decoded = xmlrpc_decode($session_encoded);
$Out->print_r($session_encoded, '$session_encoded (1.1)= ');
$Out->print_r($session_decoded, '$session_decoded (1.1)= ');
$Out->flush();
die();
*/
$paramArray[0] = array();
$paramArray[1] = array(array('testing just to see if it is working correctly from the client', 'string'));
//$paramArray[2] = array(array('1020000002-3', 'string'));
$paramArray[2] = array(array('1010000009-3', 'string'),
                        array($wwwroot, 'string'),
                        array($session->id, 'string')
                        );
$paramArray[3] = array(array('1010000008-3', 'string'),
                        array($wwwroot, 'string'),
                        array($session->id, 'string'),
                        array('backup-teco1-20071002-1631.1191339106.merge.zip', 'string')
                        );  
$paramArray[4] = array();
$paramArray[5] = array(array('101-1', 'string'),
                        array('2', 'string')
                        ); 
echo 'Your local wwwroot appears to be <strong>'. $wwwroot ."</strong>.<br />\n";
echo "We will use this as the local <em>and</em> remote hosts.<br /><br />\n";
flush();

// mnet_peer pulls information about a remote host from the database.
$mnet_peer = new mnet_peer();
$mnet_peer->set_wwwroot($wwwroot);
$mnethostid = 1020000003;
$mnet_peer->set_id($mnethostid);
/*
echo "Your \$mnet_peer from the database looks like:<br />\n<pre>";
$h2 = get_object_vars($mnet_peer);
while(list($key, $val) = each($h2)) {
    echo '<strong>'.$key.':</strong> '. gettype($val)."\n";
    if(!is_numeric($key)){

	    switch (gettype($val)) {
	    	case 'object':
	    		echo '<pre>'.print_r($key).'</pre><br />';
	    		echo '<pre>'.print_r($val).'</pre>';
	    		break;
	    	default:
	    		echo '<strong>'.$key.':</strong> '. $val."\n";
	    		break;
	    }
    }
}

echo "</pre><br/>It's ok if that info is not complete - the required field is:<br />\nwwwroot: <b>{$mnet_peer->wwwroot}</b>.<br /><br/>\n";
flush();

// The transport id is one of:
// RPC_HTTPS_VERIFIED 1
// RPC_HTTPS_SELF_SIGNED 2
// RPC_HTTP_VERIFIED 3
// RPC_HTTP_SELF_SIGNED 4

if (!$mnet_peer->transport) exit('No transport method is approved for this host in your DB table. Please enable a transport method and try again.');
$t[1]  = 'http2 (port 443 encrypted) with a verified certificate.';
$t[2]  = 'https (port 443 encrypted) with a self-signed certificate.';
$t[4]  = 'http (port 80 unencrypted) with a verified certificate.';
$t[8]  = 'http (port 80 unencrypted) with a self-signed certificate.';
$t[16] = 'http (port 80 unencrypted) unencrypted with no certificate.';

echo 'Your transportid is  <strong>'.$mnet_peer->transport.'</strong> which represents <em>'.$t[$mnet_peer->transport]."</em><br /><br />\n";
flush();
*/
// Create a new request object
$mnet_request = new mnet_xmlrpc_client();

// Tell it the path to the method that we want to execute
$mnet_request->set_method($path_to_function[$func]);

// Set the time out to something decent in seconds
//$mnet_request->set_timeout(600);
//set_time_limit(120);
// Add parameters for your function. The mnet_concatenate_strings takes three
// parameters, like mnet_concatenate_strings($string1, $string2, $string3)
// PHP is weakly typed, so you can get away with calling most things strings, 
// unless it's non-scalar (i.e. an array or object or something).
foreach($paramArray[$func] as $param) {
   // $Out->print_r($param, '$param = ');
    $mnet_request->add_param($param[0], $param[1]);
}

if (count($mnet_request->params)) {
    echo 'Your parameters are:<br />';
    while(list($key, $val) = each($mnet_request->params)) {
        echo '&nbsp;&nbsp; <strong>'.$key.':</strong> '. $val."<br/>\n";
    }
}
flush();

// We send the request:
$mnet_request->send($mnet_peer);

$Out->print_r($mnet_request, '$mnet_request = ');
?>

A var_dump of the decoded response:  <strong><pre><?php var_dump($mnet_request->response); ?></pre></strong><br />

<?php


    // unserialise and display
    //$session = unserialize(utf8_decode($mnet_request->response));
    //$Out->print_r($session, '$session (2) = ');
    if (count($mnet_request->params)) {
?>
    A var_dump of the parameters you sent:  <strong><pre><?php var_dump($mnet_request->params); ?></pre></strong><br />
<?php
    }
}
    ?>
    <p>
    Choose a function to call:<br />
    <a href="testclient.php?func=0">synch/test</a><br />
    <a href="testclient.php?func=1">synch/testResponse</a><br />
    <a href="testclient.php?func=2">synch/getBackupById</a><br />
    <a href="testclient.php?func=3">synch/restoreMergedBackupFromRemoteHost</a><br />
    <a href="testclient.php?func=4">synch/getServerDetails</a><br />
    <a href="testclient.php?func=5">synch/getHierarchyChildrenByIdAndType</a><br />

</body></html>
<?php require_once dirname(__FILE__)."/../../admin/synch-teardown.php";?>