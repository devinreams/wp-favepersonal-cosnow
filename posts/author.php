<?php


if (__FILE__ == $_SERVER['SCRIPT_FILENAME']) { die(); }
if (CFCT_DEBUG) { cfct_banner(__FILE__); }

$author = esc_attr(get_query_var('author_name'));

$user_obj = get_queried_object();
$user_id = is_object($user_obj) ? $user_obj->ID : 0;


get_header();

?>

<div id="primary">
	<div class="heading">
		<?php cfpt_page_title('<h1 class="page-title">Articles ', '</h1>'); ?>
	</div>
	
	<div class="author-bio">
	<div class="author-info clearfix">
		<?php echo get_avatar($user_id, 120); ?>
	<?php
	$user = get_user_by('login', $author);
	if (is_object($user) && $user->user_description) {
		echo '<div class="author-description">' . 
		wpautop($user->user_description) . 
		'</div>';
	}			
	?>	
	</div>
	</div>
<?php

cfct_loop();
cfct_misc('nav-posts');

?>
</div>

<div id="secondary">
	<?php get_sidebar(); ?>
</div>

<?php get_footer(); ?>