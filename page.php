<?php get_header(); 
?>
    <section class="page_inner">
        <div class="container page">
            <div class="blog_wrapper">
                <article class="blog_content full-width">
                    <?php while(have_posts(  )): the_post(  ); ?>
                    <div class="inner_content">
                        <div class="post_thumbnail_image">
                            <?php 
                                if(has_post_thumbnail()){
                                    the_post_thumbnail('full');
                                }    
                             ?>
                        </div>
                        <div class="entry_content_single">
                            <?php the_content(); ?>
                        </div>
                    </div>
                    <?php endwhile; ?>
                </article> 
            </div>
        </div>
    </section>
<?php get_footer(); ?>