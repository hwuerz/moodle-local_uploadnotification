<?php
// This file is part of UploadNotification plugin for Moodle - http://moodle.org/
//
// UploadNotification is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// UploadNotification is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with UploadNotification.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Upload notification.
 *
 * @package   local_uploadnotification
 * @author    Luke Carrier <luke@tdm.co>, Hendrik Wuerz <hendrikmartin.wuerz@stud.tu-darmstadt.de>
 * @copyright (c) 2014 The Development Manager Ltd, 2017 Hendrik Wuerz
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

$observers = array(

    /*
     * Course module created.
     */
    array(
        'eventname' => '\core\event\course_module_created',
        'callback'  => 'local_uploadnotification_observer::course_module_created',
    ),

    /*
     * Course module updated.
     */
    array(
        'eventname' => '\core\event\course_module_updated',
        'callback'  => 'local_uploadnotification_observer::course_module_updated',
    ),

    /*
     * Course viewed
     * Enable for debugging
     *
    array(
        'eventname' => '\core\event\course_viewed',
        'callback'  => 'local_uploadnotification_observer::schedule_notification',
    ),*/

);
