<?php
/**
 * Upload divelog creation report view. Prints a nice table of all the created divelog/upload/.
 *
 * @package divelog/upload/
 */
$headers = $vars['headers'];
$report  = $vars['report'];
?>
<div class="upload_divelog_container">
<ul>
<li><?php echo elgg_echo('divelog:upload:number_of_created_divelogs'); ?>: <?php echo count($report); ?>.</li>
<li><?php echo elgg_echo('divelog:upload:number_of_errors'); ?>: <?php echo $vars['num_of_failed']; ?>.</li>
</ul>
</div>
<p/>
<?php 
if($report){
?>
<table id="creation_report" class="elgg-table-alt">
<thead>
<?php 
foreach($headers as $header)
	echo '<th>' . ucwords($header) . '</th>';
?>
</thead>
<?php 
foreach ($report as $row) {
	echo '<tr>';
	foreach($headers as $header)
		echo '<td>' . $row[$header] . '</td>';
	echo '</tr>';
}

?>
</table>
<?php 
} else { /// ENDIF $report
	echo elgg_echo('divelog:upload:no_created_divelogs');	
}
$owner = elgg_get_logged_in_user_entity();
echo elgg_view('output/url', array(
			'href' => elgg_get_site_url()."divelog/owner/$owner->username",
			'text' => elgg_echo('divelog:upload:viewuploaded'),
			'title' => elgg_echo('divelog:upload:see_divelogs'),
		));

?>
