<?php

// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Upload notification.
 *
 * @package   local_uploadnotification
 * @author    Hendrik Wuerz <hendrikmartin.wuerz@stud.tu-darmstadt.de>
 * @copyright 2017 Hendrik Wuerz
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


function xmldb_local_uploadnotification_upgrade($oldversion) {
    global $DB;
    $dbman = $DB->get_manager();

    // REMOVE sectionid
    // ADD timestamp
    if ($oldversion < 2017050800) {
        // Code to add the column, generated by the 'View PHP Code' option of the XMLDB editor.
        // Define field sectionid to be dropped from local_uploadnotification.
        $table = new xmldb_table('local_uploadnotification');
        $field = new xmldb_field('sectionid');

        // Conditionally launch drop field sectionid.
        if ($dbman->field_exists($table, $field)) {
            $dbman->drop_field($table, $field);
        }

        $field = new xmldb_field('timestamp', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, null, 0, 'userid');

        // Conditionally launch add field timestamp.
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        // Uploadnotification savepoint reached.
        upgrade_plugin_savepoint(true, 2017050800, 'local', 'uploadnotification');
    }

    if ($oldversion < 2017052300) {

        // Define table local_uploadnotification_cou to be created.
        $table = new xmldb_table('local_uploadnotification_cou');

        // Adding fields to table local_uploadnotification_cou.
        $table->add_field('courseid', XMLDB_TYPE_INTEGER, '6', null, null, null, null);
        $table->add_field('activated', XMLDB_TYPE_INTEGER, '1', null, null, null, null);

        // Adding keys to table local_uploadnotification_cou.
        $table->add_key('primary', XMLDB_KEY_PRIMARY, array('courseid'));

        // Conditionally launch create table for local_uploadnotification_cou.
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }

        // Uploadnotification savepoint reached.
        upgrade_plugin_savepoint(true, 2017052300, 'local', 'uploadnotification');
    }

    if ($oldversion < 2017052600) {

        // Define table local_uploadnotification_usr to be created.
        $table = new xmldb_table('local_uploadnotification_usr');

        // Adding fields to table local_uploadnotification_usr.
        $table->add_field('userid', XMLDB_TYPE_INTEGER, '10', null, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('activated', XMLDB_TYPE_INTEGER, '1', null, null, null, null);

        // Adding keys to table local_uploadnotification_usr.
        $table->add_key('primary', XMLDB_KEY_PRIMARY, array('userid'));

        // Conditionally launch create table for local_uploadnotification_usr.
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }

        // Uploadnotification savepoint reached.
        upgrade_plugin_savepoint(true, 2017052600, 'local', 'uploadnotification');
    }

    if ($oldversion < 2017061300) {

        // Define field attachement to be added to local_uploadnotification_usr.
        $table = new xmldb_table('local_uploadnotification_usr');
        $field = new xmldb_field('attachment', XMLDB_TYPE_INTEGER, '1', null, null, null, null, 'activated');

        // Conditionally launch add field attachement.
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        // Uploadnotification savepoint reached.
        upgrade_plugin_savepoint(true, 2017061300, 'local', 'uploadnotification');
    }

    if ($oldversion < 2017061800) {

        // Define field attachement to be added to local_uploadnotification_cou.
        $table = new xmldb_table('local_uploadnotification_cou');
        $field = new xmldb_field('attachment', XMLDB_TYPE_INTEGER, '1', null, null, null, null, 'activated');

        // Conditionally launch add field attachement.
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        // Uploadnotification savepoint reached.
        upgrade_plugin_savepoint(true, 2017061800, 'local', 'uploadnotification');
    }

    if ($oldversion < 2017061900) {

        // Define field attachement to be added to local_uploadnotification_cou.
        $table = new xmldb_table('local_uploadnotification_usr');
        $field = new xmldb_field('attachment');

        // Conditionally launch drop field attachment.
        if ($dbman->field_exists($table, $field)) {
            $dbman->drop_field($table, $field);
        }

        $field = new xmldb_field('max_filesize', XMLDB_TYPE_INTEGER, '12', null, null, null, null, 'activated');

        // Conditionally launch add field max_filesize.
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        // Uploadnotification savepoint reached.
        upgrade_plugin_savepoint(true, 2017061900, 'local', 'uploadnotification');
    }

    return true;
}