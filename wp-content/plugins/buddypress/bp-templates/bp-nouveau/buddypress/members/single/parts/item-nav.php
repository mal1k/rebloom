<?php
/**
 * BuddyPress Single Members item Navigation
 *
 * @since 3.0.0
 * @version 3.1.0
 */
?>

<div class="item-list-tabs no-ajax heading_font <?php bp_nouveau_single_item_nav_classes(); ?> " id="object-nav" aria-label="Member primary navigation" role="navigation">

<!--<nav class="<?php bp_nouveau_single_item_nav_classes(); ?>" id="object-nav" role="navigation" aria-label="<?php //esc_attr_e( 'Member menu', 'buddypress' ); ?>">-->

	<?php if ( bp_nouveau_has_nav( array( 'type' => 'primary' ) ) ) : ?>

		<ul>

			<?php
			while ( bp_nouveau_nav_items() ) :
				bp_nouveau_nav_item();
			?>

				<li id="<?php bp_nouveau_nav_id(); ?>" class="<?php bp_nouveau_nav_classes(); ?>">
					<a href="<?php bp_nouveau_nav_link(); ?>" id="<?php bp_nouveau_nav_link_id(); ?>">
						<?php bp_nouveau_nav_link_text(); ?>

						<?php if ( bp_nouveau_nav_has_count() ) : ?>
							<span class="count"><?php bp_nouveau_nav_count(); ?></span>
						<?php endif; ?>
					</a>
				</li>

			<?php endwhile; ?>

			<?php bp_nouveau_member_hook( '', 'options_nav' ); ?>

		</ul>

	<?php endif; ?>
</div>

<!--</nav>-->
