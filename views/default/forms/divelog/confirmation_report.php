<?php
/**
 * Upload divelog creation report view. Prints a nice table of all the created divelogs.
 *
 */
$headers = $vars['headers'];
$report = $vars['report'];
?>
<div class="upload_divelogs_container">
	<ul>
		<li><?php echo elgg_echo('divelog:upload:number_of_divelogs'); ?>: <?php echo count($report); ?></li>
		<li><?php echo elgg_echo('divelog:upload:number_of_errors'); ?>: <?php echo $vars['num_of_failed']; ?></li>
	</ul>
</div>
<p/>

<input type="hidden" id="header" name="header" value="<?php echo implode(',', $headers); ?>">
<input type="hidden" id="num_of_divelogs" name="num_of_divelogs" value="<?php echo count($report) - $vars['num_of_failed']; ?>">
<input type="hidden" name="confirm" id="confirm" value="1">
<input type="hidden" name="encoding" id="encoding" value="<?php echo $vars['encoding']; ?>">
<input type="hidden" name="delimiter" id="delimiter" value="<?php echo $vars['delimiter']; ?>">

<table id="creation_report" class="elgg-table-alt">
	<thead>
		<?php
		foreach ($headers as $header)
			echo '<th>' . ucwords($header) . '</th>';
		?>
	</thead>

	<?php
	for ($i = 0; $i < count($report); $i++) {
		echo "<tr>";
		foreach ($headers as $header) {
			echo '<td>';
			echo $report[$i][$header];
			/// Print the hidden field if we want to create this group
			if ($report[$i]['create_divelog'])
				echo '<input type="hidden" name="' . $header . '[]" value="' . $report[$i][$header] . '">';
			echo '</td>';
		}
		echo "</tr>";
	}
	?>
</table>

<?php echo elgg_view('input/securitytoken') ?>
<?php echo elgg_view('input/submit', array('value' => elgg_echo('divelog:upload:create_divelogs'))); ?>
