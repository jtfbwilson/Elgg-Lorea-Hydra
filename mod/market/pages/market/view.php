<?php
/**
 * Elgg Market Plugin
 * @package market
 */


// Get the specified market post
$post = (int) get_input('marketpost');

// If we can get out the market post ...
if ($marketpost = get_entity($post)) {
			
	// Load colorbox
	elgg_load_js('lightbox');
	elgg_load_css('lightbox');

	$category = $marketpost->marketcategory;

	elgg_push_breadcrumb(elgg_echo('market:title'), "market/category");
	elgg_push_breadcrumb(elgg_echo("market:category:{$category}"), "market/category/{$category}");
	elgg_push_breadcrumb($marketpost->title);

	// Display it
	$content = elgg_view_entity($marketpost, array('full_view' => true));
	if (elgg_get_plugin_setting('market_comments', 'market') == 'yes') {
		$content .= elgg_view_comments($marketpost);
	}

	// Set the title appropriately
	$title = elgg_echo("market:category") . ": " . elgg_echo("market:category:{$category}");

} else {
			
	// Display the 'post not found' page instead
	$content = elgg_view_title(elgg_echo("market:notfound"));
	$title = elgg_echo("market:notfound");
			
}
	
// Show market sidebar
//$sidebar = elgg_view("market/sidebar");

$params = array(
		'content' => $content,
		'title' => $title,
		'sidebar' => $sidebar,
		'filter' => '',
		'header' => '',
		);

$body = elgg_view_layout('content', $params);

echo elgg_view_page($title, $body);

