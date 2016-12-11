<?php

//define('CFCT_DEBUG', true);

update_option('siteurl','http://cosnow.com');
update_option('home','http://cosnow.com');

add_filter('widget_text', 'do_shortcode');

function fpdr_author_redirect() {
	if(is_author( 'admin' )) {
		wp_redirect( '/author/devin/', 301 );
	}
}
add_action('template_redirect', 'fpdr_author_redirect');

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

// Show author avatar next to posts (except mine)
function fpcs_author() {
	echo "<p class=\"entry-meta author\"><a href=\"" . get_author_posts_url(get_the_author_meta( 'ID' ))."\">";
	echo get_avatar( get_the_author_meta('ID'), 32 );
	echo "</a></p>";
}
add_action('favepersonal_content_sidebar_after', 'fpcs_author');
add_action('favepersonal_excerpt_sidebar_after', 'fpcs_author');

function fpcs_byline() {
	echo "<p class=\"entry-meta author\">By <a href=\"" . get_author_posts_url(get_the_author_meta( 'ID' ))."\">";
	echo get_the_author();
	echo "</a></p>";
}
add_action('favepersonal_content_sidebar_after', 'fpcs_byline');

//add Infinite Scroll support
add_theme_support( 'infinite-scroll', array(
	'container'  => 'primary',
	'footer'     => 'footer',
	'footer_widgets' => array( 'sidebar-section-1', 'sidebar-section-2', 'sidebar-section-3' ),
	'render'	 => 'cfct_loop',
) );

// add copyright and byline to RSS feed content
function fpcs_feed_byline($content) {
	if ( !has_post_format( 'status') ) {
	   $content .= '<p><small>This article is published at <a href="http://cosnow.com/">Colorado Snow (cosnow.com)</a>. All rights reserved. Republication, in part or entirety is welcome with attribution.</small></p>';
   }
   return $content;
}
add_filter( "the_content_feed", "fpcs_feed_byline" );

// add twitter card creator IDs for Rachel and Devin
function twitter_custom( $twitter_card ) {
	if ( is_array( $twitter_card ) ) {
		global $post;
		if ( get_the_author_meta( 'user_login' ) == 'Rachel' ) {
			$twitter_card['creator'] = '@rstephensme';
		} elseif ( get_the_author_meta( 'ID' ) == '1' ) {
			$twitter_card['creator'] = '@devinreams';
		} else {
			$twitter_card['creator'] = '@cosnow';
		}
		$twitter_card['site:id'] = '16420441';
	}
	return $twitter_card;
}
add_filter( 'twitter_cards_properties', 'twitter_custom' );
