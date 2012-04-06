<?php
// set format for status posts to exclude title
// if status post is short enough, do not include URL either
function akv3_social_broadcast_format($format, $post, $service) {
	if (get_post_format($post) == 'status') {
		$format = (strlen($post->post_content) <= $service->max_broadcast_length() ? '{content}' : '{content} {url}');
	}
	return $format;
}
add_filter('social_broadcast_format', 'akv3_social_broadcast_format', 10, 3);

// remove URL in comments if comment is short enough to be included
function akv3_social_comment_broadcast_format($format, $comment, $service) {
	return (strlen($comment->comment_content) <= $service->max_broadcast_length() ? '{content}' : '{content} {url}');
}
add_filter('social_comment_broadcast_format', 'akv3_social_comment_broadcast_format', 10, 3);

// move comment form after the comments themselves
function akv3_social_comment_block_order($order) {
	return array('comments', 'form');
}
add_filter('social_comment_block_order', 'akv3_social_comment_block_order');

// remove the CSS for Colors from the HTML (if you want to load it via child theme instead)
function favepersonal_remove_inline_color_css() {
	remove_action('wp_head', 'cfcp_color_css_min', 8); 
}
add_action('wp', 'favepersonal_remove_inline_color_css', 11);

function fpcs_author() {
	echo "<p class=\"entry-meta author\"><a href=\"" . get_author_posts_url(get_the_author_meta( 'ID' ))."\">";
	echo get_avatar( get_the_author_meta('ID'), 32 );
	echo "</a></p>";
}
add_action('favepersonal_content_sidebar_after', 'fpcs_author');
add_action('favepersonal_excerpt_sidebar_after', 'fpcs_author');

