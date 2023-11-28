<?php
if(class_exists('Redux')){
    $page_title_text_color = daneshyar_settings('headre_text_color');
    $page_title_text = (daneshyar_settings('custom_page_title_text'))?daneshyar_settings('custom_page_title_text'):'وبلاگ';
}
 $perfix = 'daneshyar_';
$bg_img = get_post_meta(get_the_ID(  ), $perfix.'header_bg_img',true);
$bg_color = get_post_meta(get_the_ID(  ), $perfix.'header_bg_color',true);
$style = '';
if($bg_color){
    $style .= 'background-color:'.$bg_color.';';
}
if($bg_img){
    $style .= 'background-image:url('.$bg_img.');';
}
?>
<section class="page_title" style ="<?php echo esc_attr( $style ); ?>">
    <div class="container">
            <?php 
            $perfix = 'daneshyar_';
            if(!get_post_meta(get_the_ID(  ), $perfix.'disable_page_title',true)){
            if(is_singular('post')){
            echo esc_html($page_title_text);
            }else{ ?>
                <h1 class="blog_title"><?php esc_html( wp_title('') ); ?></h1>
   <?php         }
        }
            ?>
        <?php
        if(!get_post_meta(get_the_ID(  ), $perfix.'disable_bredacrumb_page',true)){
            esc_html( denshyar_breadcrumb() ); 
        }
         ?>
    </div>
</section>
<style>
    .breadcrumb span{
        color:<?php echo $page_title_text_color; ?> !important;
    }
</style>