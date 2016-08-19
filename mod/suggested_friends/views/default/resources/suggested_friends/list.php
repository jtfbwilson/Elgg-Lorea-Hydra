<?php

namespace AU\SuggestedFriends;

$title = elgg_echo('suggested_friends');

        // set up breadcrumbs
        elgg_push_breadcrumb(elgg_echo('members'), 'members');
        elgg_push_breadcrumb(elgg_echo('suggested_friends:suggested'));


$people = get_suggestions($vars['owner']->guid, $vars['friends'], $vars['groups']);

$content = elgg_view('suggested_friends/people', array('people' => $people));

$body = elgg_view_layout('content', array(
	'title' => $title,
	'filter' => false,
	'content' => $content
));

echo elgg_view_page($title, $body);
