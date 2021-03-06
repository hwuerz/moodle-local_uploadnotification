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
 * @author    Hendrik Wuerz <hendrikmartin.wuerz@stud.tu-darmstadt.de>
 * @copyright (c) 2017 Hendrik Wuerz
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(dirname(__FILE__) . '/../../config.php');

// Include function library.
require_once(dirname(__FILE__) . '/definitions.php');
require_once(dirname(__FILE__) . '/classes/forms/user_form.php');
require_once(dirname(__FILE__) . '/classes/models/user_settings_model.php');

// Globals.
global $DB, $CFG, $OUTPUT, $USER, $SITE, $PAGE;

$homeurl = new moodle_url('/');
require_login();
if (isguestuser($USER)) {
    redirect($homeurl, get_string('settings_user_require_valid_users', LOCAL_UPLOADNOTIFICATION_FULL_NAME), 5);
}

$PAGE->set_context(context_user::instance($USER->id));
$PAGE->set_url("/mod/".LOCAL_UPLOADNOTIFICATION_NAME."/user.php");
$PAGE->set_title(get_string('heading', LOCAL_UPLOADNOTIFICATION_FULL_NAME));
$PAGE->set_heading(get_string('heading', LOCAL_UPLOADNOTIFICATION_FULL_NAME));

// Only add settings item on non-site course pages.
if (!$USER->id) {
    redirect($homeurl, get_string('settings_user_require_valid_users', LOCAL_UPLOADNOTIFICATION_FULL_NAME), 5);
}

echo $OUTPUT->header();

$settings = new local_uploadnotification_user_settings_model($USER->id);

// Display global config.
$user_form = new local_uploadnotification_user_form(null, array(
    'id' => $USER->id,
    'enable_mail' => $settings->is_mail_enabled(),
    'enable_digest' => $settings->is_digest_enabled(),
    'max_mail_filesize' => $settings->get_max_filesize()));

// Evaluate form data.
$data = $user_form->get_data();
if ($data) {
    if (isset($data->enable_mail)) {
        $settings->set_mail_enabled($data->enable_mail);
    }
    if (isset($data->enable_digest)) {
        $settings->set_digest_enabled($data->enable_digest);
    }
    if (isset($data->max_mail_filesize)) { // Admin might have disabled the feature --> form element not rendered.
        $settings->set_max_filesize($data->max_mail_filesize);
    }
    $settings->save();
    \core\notification::success(get_string('settings_saved_successfully', LOCAL_UPLOADNOTIFICATION_FULL_NAME));
}

$user_form->display();


// Footing  =========================================================.

echo $OUTPUT->footer();
