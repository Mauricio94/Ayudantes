<?php

/**
 *
 * @package local
 * @subpackage notebookstore
 * @copyright 2015 Mauricio Meza (mameza@alumnos.uai.cl)
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
 
require_once (dirname(dirname(dirname(__FILE__)))."/config.php");
//This library will be used to generate the graphs, still not implemented
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

//Pictures to make an example of how graphs will look there
$advlink = $CFG->wwwroot.'/local/ayudantes/img/advance.PNG';
$justlink = $CFG->wwwroot.'/local/ayudantes/img/just.PNG';

$markersinfosql = "select c.markerid 
				from {emarking} e
				inner join {emarking_submission} s on (s.emarking = e.id)
				inner join {emarking_draft} d on (d.submissionid = s.id)
				inner join {emarking_comment} c on (c.draft = d.id)
				where c.markerid=".$marker_id;


echo $OUTPUT->header();

echo get_string("corrected_questions", "local_ayudantes");
//We make a table only for data structure and order
$graphs = new html_table();

//We define where graphs and their names should be
$graphs->data[] = array(
		get_string("progress_day", "local_ayudantes"),
		get_string("justice_perception", "local_ayudantes")
);

$graphs->data[] = array(	
		"<img src=".$advlink.">",
		"<img src=".$justlink.">"
);

$buttonurl = new moodle_url('/local/ayudantes/ayudantes.php');

//With this we display the table and the button that redirect us to "ayudantes.php
echo html_writer::table ( $graphs );
echo html_writer::nonempty_tag("div", $OUTPUT->single_button($buttonurl, "Atras"), array("align" => "center"));

echo $OUTPUT->footer();