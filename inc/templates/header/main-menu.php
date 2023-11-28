<?php
$menu = wp_nav_menu(
    array(
        'theme_location' => 'main-menu',
        'container' => false,
        'menu_class' => 'menu',
        'echo' =>false,
        'walker' => new DaneshyarFrontendWalker(),
    )
);
?>

<nav class="site-navigation daneshyar-navigation" role="navigation">
    <?php 
        if(has_nav_menu('main-menu')){
            echo wp_kses_post($menu);
        }
    ?>
</nav>

