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
 *
 *
 * @package    report_rolessitemap
 * @copyright  2022 Andreas Schenkel
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
use report_rolessitemap\Helper;

require(__DIR__.'/../../config.php');
require_once($CFG->libdir . '/adminlib.php');
require_login();
// Todo: Weis nicht mehr wozu folgenden Zeile genutzt wird ... nochmal prüfen und klären.
// admin_externalpage_setup('rolessitemap');

// Proofing if the report is active or if it is inactive but allowes for siteadmins AND if the user is siteadmin.
$isactive = get_config('report_rolessitemap', 'isactive');
$isactiveforsiteadmin = get_config('report_rolessitemap', 'isactiveforsiteadmin');
$reportisactiveforthisuser = $isactive == "1" || ($isactiveforsiteadmin == "1" && is_siteadmin());
if (!$reportisactiveforthisuser) {
    echo get_string("reportisinactiv_msg", 'report_rolessitemap');
    die();
}
if (!has_capability('report/rolessitemap:view', context_system::instance())) {
    exit;
}

print $OUTPUT->header();
$helper = new Helper();
$helper->renderallroles();
$helper->rendercategoricesandroles();
print $OUTPUT->footer();


