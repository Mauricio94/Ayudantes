<?php

/**
 *
 * @package local
 * @subpackage notebookstore
 * @copyright 2015 Mauricio Meza (mameza@alumnos.uai.cl)
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
 
require_once (dirname(dirname(dirname(__FILE__)))."/config.php");
global $PAGE, $OUTPUT;

require_login();
if (isguestuser()) {
	die();
}

// Optional Parameters
$action = optional_param("action", "view", PARAM_TEXT);
$rutclient = optional_param("rutclient", null, PARAM_INT);
$sesskey = optional_param("sesskey", null, PARAM_ALPHANUM);

$context = context_system::instance();

$urlayudantes = new moodle_url("/local/ayudantes/misayudantes.php");

// Page specification
$PAGE->set_url($urlayudantes);
$PAGE->set_context($context);
$PAGE->set_pagelayout("standard");
$PAGE->set_heading(get_string("helper_name", "local_ayudantes"));

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

$buttonurl = new moodle_url($CFG->dirroot . "/");

echo html_writer::table ( $graphs );
echo html_writer::nonempty_tag("div", $OUTPUT->single_button($buttonurl, "Atras"), array("align" => "center"));

echo $OUTPUT->footer();

/*
*/

