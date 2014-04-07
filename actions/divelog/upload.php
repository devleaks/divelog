<?php
/**
 * Uplaod divelogs. Processes the uploaded file and prints a report of the created dives.
 *
 */
$upload = new UploadDivelogs();

/// Get the input from the form or hidden fields
$encoding  = get_input('encoding');
$delimiter = get_input('delimiter');
$confirm   = get_input('confirm', false);
$ignorefirst  = get_input('ignorefirst', false);

/// Set the parameters
$upload->setEncoding($encoding);
$upload->setDelimiter($delimiter);
$upload->setIgnoreFirst($ignorefirst);

if(!$confirm) {
	/// Open the file
	if(! $upload->openFile('filename')){
		forward("divelog/upload");
	}
	/// Process the file
	if(! $upload->processFile()){
		forward("divelog/upload");
	}
	/// Check the dives
	$upload->checkDivelogs();
	/// Print the uploaded dives for confirmation
	$content = $upload->getConfirmationReport();
	$title = elgg_echo('divelog:upload:process_report');
} else {
	/// Create the divelog/upload/
	$upload->createDivelogs($_POST);
	/// Everything was fine -> Display the creation report
	$content = $upload->getCreationReport();
	$title = elgg_echo('divelog:upload:creation_report');
}

$body = elgg_view_layout('content', array(
	'filter' => '',
	'content' => $content,
	'title' => $title,
));

echo elgg_view_page($title, $body);

exit;