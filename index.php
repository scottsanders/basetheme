<?php get_header(); ?>


    <div class="container">

    	<div class="row">

    		<section class="span9">
    			<?php while ( have_posts() ) : the_post(); ?>
				<article>
                    <header>
    					<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                        <p><?php bootstrap_posted_on(); ?></p>
                        <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a>
                    </header>

                    <p><?php the_excerpt(); ?></p>
				</article>
				<?php endwhile; ?>

                <?php wp_link_pages(); ?>
    		</section>

    		<aside class="span3">
    			<?php get_sidebar(); ?>
    		</aside>

    	</div>

    </div> <!-- /container -->


<?php get_footer(); ?>