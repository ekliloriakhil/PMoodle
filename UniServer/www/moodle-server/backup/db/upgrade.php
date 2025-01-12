<?php  //$Id$

// This file keeps track of upgrades to 
// the backup system
//
// Sometimes, changes between versions involve
// alterations to database structures and other
// major things that may break installations.
//
// The upgrade function in this file will attempt
// to perform all the necessary actions to upgrade
// your older installtion to the current version.
//
// If there's something it cannot do itself, it
// will tell you what you need to do.
//
// The commands in here will all be database-neutral,
// using the functions defined in lib/ddllib.php

function xmldb_backup_upgrade($oldversion=0) {

    global $CFG, $THEME, $db;

    $result = true;

/// And upgrade begins here. For each one, you'll need one 
/// block of code similar to the next one. Please, delete 
/// this comment lines once this file start handling proper
/// upgrade code.

/// if ($result && $oldversion < YYYYMMDD00) { //New version in version.php
///     $result = result of "/lib/ddllib.php" function calls
/// }

    if ($result && $oldversion < 2008061000) {    // MDL-12037
    /// Define field backuptype to be added to backup_log
        $table = new XMLDBTable('backup_log');
        $field = new XMLDBField('backuptype');
        $field->setAttributes(XMLDB_TYPE_CHAR, '50', null, XMLDB_NOTNULL, null, null, null, null, 'info');
    /// Launch add field name
        $result = $result && add_field($table, $field);
    }


    return $result;
}

?>
