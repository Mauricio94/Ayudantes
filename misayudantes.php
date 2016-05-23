<?php

/**
 *
 * @package local
 * @subpackage notebookstore
 * @copyright 2015 Mauricio Meza (mameza@alumnos.uai.cl)
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
 
require_once (dirname(dirname(dirname(__FILE__)))."/config.php");
include $CFG->dirroot.'/lib/graphlib.php';
global $DB, $PAGE, $OUTPUT;

require_login();
if (isguestuser()) {
	die();
}

// Optional Parameters
$marker_id = optional_param("id", null, PARAM_INT);

$context = context_system::instance();

$urlayudantes = new moodle_url("/local/ayudantes/misayudantes.php");

//We make use of the recieved id to obtain the marker information on this page
$markerinfosql = "select firstname, lastname
				from {user} u
				where u.id =".$marker_id;

$marker = $DB->get_record_sql($markerinfosql);

// Page specification
$PAGE->set_url($urlayudantes);
$PAGE->set_context($context);
$PAGE->set_pagelayout("standard");
$PAGE->set_heading(get_string("helper_name", "local_ayudantes").$marker->firstname." ".$marker->lastname);

$advlink = $CFG->wwwroot.'/local/ayudantes/img/advance.PNG';
$justlink = $CFG->wwwroot.'/local/ayudantes/img/just.PNG';

echo $OUTPUT->header();

echo get_string("corrected_questions", "local_ayudantes");
$graphs = new html_table();

$graphs->data[] = array(
		get_string("progress_day", "local_ayudantes"),
		get_string("justice_perception", "local_ayudantes")
);

$graphs->data[] = array(	
		"<img src=".$advlink.">",
		"<img src=".$justlink.">"
);

$buttonurl = new moodle_url('/local/ayudantes/ayudantes.php');

echo html_writer::table ( $graphs );
echo html_writer::nonempty_tag("div", $OUTPUT->single_button($buttonurl, "Atras"), array("align" => "center"));

echo $OUTPUT->footer();