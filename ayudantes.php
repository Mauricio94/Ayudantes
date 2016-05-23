<?php

/**
 *
 * @package local
 * @subpackage notebookstore
 * @copyright 2016 Mauricio Meza (mameza@alumnos.uai.cl)
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
 
require_once (dirname(dirname(dirname(__FILE__)))."/config.php");
global $DB, $USER, $PAGE, $OUTPUT;

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
$PAGE->set_heading("Mis Ayudantes");


echo $OUTPUT->header();

$helpers_order = new html_table();

$test = "select id,firstname, lastname from mdl_user";
$markersinfosql = "select c.marker, u.* 
				from mdl_emarking e
				inner join mdl_emarking_submission s on (s.emarking = e.id)
				inner join mdl_emarking_draft d on (d.submissionid = s.id)
				inner join mdl_emarking_comment c on (c.draft = d.id)
				inner join mdl_user u (u.id = c.marker)";

$markers = $DB->get_records_sql($test, array("id"=>"0"));

foreach ($markers as $marker){
	$helper_id = $marker->id;
	$buttonurl = new moodle_url('/misayudantes.php', array('id' => $helper_id));
	echo $marker->firstname."</br>".$marker->lastname;
	echo $OUTPUT->single_button($buttonurl, "informacion");
	
	
}
echo $OUTPUT->footer();