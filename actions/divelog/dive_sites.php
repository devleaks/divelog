<?
/**
 * Elgg divelog callback action
 *
 * @package Divelog
 */
elgg_load_library('divelog');

$dive_sites = get_dive_sites();
$json_response = json_encode($dive_sites);

# Optionally: Wrap the response in a callback function for JSONP cross-domain support
if($_GET["callback"]) {
    $json_response = $_GET["callback"] . "(" . $json_response . ")";
}

# Return the response
echo $json_response;
?>
