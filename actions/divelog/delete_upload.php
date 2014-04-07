<?php
/**
 * Uplaod divelogs. Processes the uploaded file and prints a report of the created dives.
 *
 */
/// Get the input from the form or hidden fields
$confirm = get_input('confirm');

$upload_guid  = get_input('upload');
$upload = get_entity($upload_guid);

$options = array(
	'relationship_guid' => $upload_guid,
	'relationship' => 'divelog_upload',
	'inverse_relationship' => false, // event is end of relationship...
	'limit' => 0,
);

$report = "Divelogs for ".date('d-m-Y G:h', $upload->date) . " (".$upload->count.").<p/><p/>";
$deleted = 0;

if(!$confirm) { // prompt confirmation
	if($existing_rels = elgg_get_entities_from_relationship($options)) {
		foreach($existing_rels as $rel) {
			$report .= $rel->title . "<br/>";
			$deleted++;
		}
	}
	$report .= '<p/><p/>Total to delete: '.$deleted.'.<p/>';
	$content = elgg_view_form('divelog/confirmation_delete',
								 array('enctype' => 'multipart/form-data',
									   'method' => 'POST',
									   'id' => 'divelog-delete-form'),
								 array('report' => $report, 'upload' => $upload_guid));
	$title = elgg_echo('divelog:upload:delete_report');
} else { // does the work
	if($existing_rels = elgg_get_entities_from_relationship($options)) {
		foreach($existing_rels as $rel) {
			$report .= 'Deleted ' . $rel->title . "<br/>";
			if(check_entity_relationship($upload_guid, "divelog_upload", $rel->guid))
				remove_entity_relationship($upload_guid, "divelog_upload", $rel->guid);
			$rel->delete();
			$deleted++;
		}
	}
	$upload->delete();
	$report .= '<p/><p/>Total deleted: '.$deleted.'.<p/>';
	$content = elgg_view('divelog/upload/delete_report', array('report' => $report));
	$title = elgg_echo('divelog:upload:delete_report');
}

$body = elgg_view_layout('content', array(
	'filter' => '',
	'content' => $content,
	'title' => $title,
));

echo elgg_view_page($title, $body);

exit;