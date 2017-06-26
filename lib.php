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

/**
 * Action: created.
 *
 * @var integer
 */
define('LOCAL_UPLOADNOTIFICATION_ACTION_CREATED', 1);

/**
 * Action: updated.
 *
 * @var integer
 */
define('LOCAL_UPLOADNOTIFICATION_ACTION_UPDATED', 2);

/**
 * Send scheduled notification emails.
 *
 * @return void
 */
function local_uploadnotification_cron() {

    // Only send mails if a moodle admin has enabled this function
    $enabled = get_config('uploadnotification', 'enabled');
    if (!$enabled) {
        return;
    }

    $recipients  = new local_uploadnotification_recipient_iterator();
    $supportuser = core_user::get_support_user();
    $mailer      = new local_uploadnotification_mailer($recipients, $supportuser);

    $mailer->execute();
}



/**
 * Inject a link in course settings menu.
 * Provides options for docents to disable mail delivery in particular courses.
 * @param $settingsnav settings_navigation
 * @param $context navigation_node
 */
function local_uploadnotification_extend_settings_navigation($settingsnav, $context) {
    global $PAGE;

    // Disable menu if admin has forbidden mail delivery
    if (!get_config('uploadnotification', 'enabled')) {
        return;
    }

    // Only add this settings item on non-site course pages.
    if (!$PAGE->course or $PAGE->course->id == 1) {
        return;
    }

    // Only let users with the appropriate capability see this settings item.
    if (!has_capability('moodle/backup:backupcourse', context_course::instance($PAGE->course->id))) {
        return;
    }

    if ($settingnode = $settingsnav->find('courseadmin', navigation_node::TYPE_COURSE)) {
        $displayed_text = get_string('course_settings_link', 'local_uploadnotification');
        $url = new moodle_url('/local/uploadnotification/course.php', array('id' => $PAGE->course->id));
        $foonode = navigation_node::create(
            $displayed_text,
            $url,
            navigation_node::NODETYPE_LEAF,
            $displayed_text,
            'uploadnotification_course',
            new pix_icon('t/right', $displayed_text)
        );
        if ($PAGE->url->compare($url, URL_MATCH_BASE)) {
            $foonode->make_active();
        }
        $settingnode->add_node($foonode);
    }
}


// Inject link in user settings menu.
// Provides options for students to disable mail delivery for themselves
function local_uploadnotification_extend_navigation_user_settings
(navigation_node $parentnode, stdClass $user, context_user $context, stdClass $course, context_course $coursecontext) {
    global $PAGE;

    // Disable menu if admin has forbidden mail delivery
    if (!get_config('uploadnotification', 'enabled')) {
        return;
    }

    // Only add this settings item on non-site course pages.
    if (!$user->id) {
        return;
    }

    $displayed_text = get_string('course_settings_link', 'local_uploadnotification');
    $url = new moodle_url('/local/uploadnotification/user.php');
    $foonode = navigation_node::create(
        $displayed_text,
        $url,
        navigation_node::NODETYPE_LEAF,
        $displayed_text,
        'uploadnotification_course',
        new pix_icon('t/right', $displayed_text)
    );
    if ($PAGE->url->compare($url, URL_MATCH_BASE)) {
        $foonode->make_active();
    }
    $parentnode->add_node($foonode);
}