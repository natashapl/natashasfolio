<?php
/**
 * Pingback Comment Template
 *
 * The pingback comment template displays an individual pingback comment.
 *
 * @package Chun
 * @subpackage Template
 * @since 0.1.0
 * @author Justin Tadlock <justin@justintadlock.com>
 * @copyright Copyright (c) 2012, Justin Tadlock
 * @link http://themehybrid.com/themes/chun
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

	global $post, $comment;
?>

	<li id="comment-<?php comment_ID(); ?>" class="<?php hybrid_comment_class(); ?>">

		<?php do_atomic( 'open_comment' ); // chun_open_comment ?>

		<?php echo hybrid_avatar(); ?>

		<?php echo apply_atomic_shortcode( 'comment_meta', '<div class="comment-meta">[comment-author] [comment-published] [comment-permalink before="| "] [comment-edit-link before="| "]</div>' ); ?>

		<?php do_atomic( 'close_comment' ); // chun_close_comment ?>

	<?php /* No closing </li> is needed.  WordPress will know where to add it. */ ?>