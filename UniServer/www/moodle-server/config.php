<?php  /// Moodle Configuration File 

unset($CFG);
global $CFG;  // This is necessary here for PHPUnit execution
$CFG = new stdClass();

$CFG->dbtype    = 'mysql';
$CFG->dbhost    = 'localhost';
$CFG->dbname    = 'moodle_server';
$CFG->dbuser    = 'root';
$CFG->dbpass    = 'root';
$CFG->dbpersist =  false;
$CFG->prefix    = 'mdl_srv_';

$CFG->wwwroot   = 'http://localhost:4001/moodle-server';
$CFG->dirroot   = 'W:\www\moodle-server';
$CFG->dataroot   = 'W:/moodle-server-data';
$CFG->admin     = 'admin';

$CFG->directorypermissions = 00777;  // try 02777 on a server in Safe Mode

require_once("$CFG->dirroot/lib/setup.php");
// MAKE SURE WHEN YOU EDIT THIS FILE THAT THERE ARE NO SPACES, BLANK LINES,
// RETURNS, OR ANYTHING ELSE AFTER THE TWO CHARACTERS ON THE NEXT LINE.
?>