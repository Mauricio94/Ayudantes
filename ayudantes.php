<?php

/**
 *
 * @package local
 * @subpackage notebookstore
 * @copyright 2016 Mauricio Meza (mameza@alumnos.uai.cl)
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
 
require_once (dirname(dirname(dirname(__FILE__)))."/config.php");
global $DB, $PAGE, $OUTPUT;

require_login();
if (isguestuser()) {
	die();
}

$context = context_system::instance();
	
$urlindex = new moodle_url("/local/ayudantes/ayudantes.php");

// Page specification
$PAGE->set_url($urlindex);
$PAGE->set_context($context);
$PAGE->set_pagelayout("standard");
$PAGE->set_heading(get_string("my_helpers", "local_ayudantes"));


echo $OUTPUT->header();

//$test = "select id,firstname, lastname from {user}";

//Query to bring markers information
$markersinfosql = "select c.marker, u.firstname, u.lastname 
				from mdl_emarking e
				inner join mdl_emarking_submission s on (s.emarking = e.id)
				inner join mdl_emarking_draft d on (d.submissionid = s.id)
				inner join mdl_emarking_comment c on (c.draft = d.id)
				inner join mdl_user u (u.id = c.marker)";

$markers = $DB->get_records_sql($markersinfosql, array("id"=>"0"));

//With this we display the basic helper's information and a button to see their correcting development
//Right now it doesn't have focus on aesthetic, only on funtionality
foreach ($markers as $marker){
	$marker_id = $marker->marker;
	$buttonurl = new moodle_url('/local/ayudantes/misayudantes.php', array('id' => $marker_id));
	echo $marker->firstname."</br>".$marker->lastname;
	echo $OUTPUT->single_button($buttonurl, get_string("see_marker_info", "local_ayudantes"));
	
	
}
echo $OUTPUT->footer();