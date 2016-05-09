<?php

/**
 *
 * @package local
 * @subpackage notebookstore
 * @copyright 2015 Mauricio Meza (mameza@alumnos.uai.cl)
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
 
require_once (dirname(dirname(dirname(__FILE__)))."/config.php");
require_once ($CFG->dirroot."/local/notebookstore/forms/index_forms.php");
global $DB, $USER, $PAGE, $OUTPUT;

require_login();
if (isguestuser()) {
	die();
}

// Optional Parameters
$action = optional_param("action", "view", PARAM_TEXT);
$rutclient = optional_param("rutclient", null, PARAM_INT);
$sesskey = optional_param("sesskey", null, PARAM_ALPHANUM);

$context = context_system::instance();
	
$urlindex = new moodle_url("/local/notebookstore/index.php");

// Page specification
$PAGE->set_url($urlindex);
$PAGE->set_context($context);
$PAGE->set_pagelayout("standard");
$PAGE->set_heading("Nombre del Alumno: Patricio Rivera");

$advlink = $CFG->wwwroot.'/local/ayudantes/img/advance.PNG';
$justlink = $CFG->wwwroot.'/local/ayudantes/img/just.PNG';

echo $OUTPUT->header();

echo "Preguntas Corregidas por dia: 10";

$graphs = new html_table();

$graphs->data[] = array(
		"Avance por dias",
		"Percepcion de justicia"
);

$graphs->data[] = array(	
		"<img src=".$advlink.">",
		"<img src=".$justlink.">"
);

$buttonurl = new moodle_url($CFG->dirroot . "/");

echo html_writer::table ( $graphs );
echo html_writer::nonempty_tag("div", $OUTPUT->single_button($buttonurl, "Atras"), array("align" => "center"));

echo $OUTPUT->footer();

/*select c.marker, u.* 
from mdl_emarking e
inner join mdl_emarking_submission s on (s.emarking = e.id)
inner join mdl_emarking_draft d on (d.submissionid = s.id)
inner join mdl_emarking_comment c on (c.draft = d.id)
inner join mdl_user u (u.id = c.marker)
*/

