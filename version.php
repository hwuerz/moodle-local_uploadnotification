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

global $CFG;

$plugin->component = 'local_uploadnotification';

$plugin->release  = '0.2.0';
$plugin->maturity = MATURITY_ALPHA;

// Emails are sent daily unless we're in debug mode
// TODO: Add internal checks:
// Notification does not need to be checked often,
// deleted files should be checked often
$plugin->cron = $CFG->debugdeveloper ? 1 : 86400;
$plugin->cron = 1;

// Version format:  YYYYMMDDXX
$plugin->version  = 2017070717;
$plugin->requires = 2013111800;
