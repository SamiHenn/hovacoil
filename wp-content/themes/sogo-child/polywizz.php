<!--?php /* Template Name: polywizz*/ ?-->
<?php
get_header();
?>
        <!-- CONTENT -->
<div style="position: fixed; top: 0px; left: 0px; right: 0px; bottom: 0px; z-index: 0">
<iframe style = "height: 100%; width: 100%;"; src='<?php the_title(); ?>' border='0' scrolling='yes' marginheight='0' marginwidth='0' frameborder='0' style='float:left; margin-left:0px' allowfullscreen='true' webkitallowfullscreen='true' mozallowfullscreen='true'></iframe>
                    <?php the_content(); ?>
                </div>
<?php include 'templates/footer-2/footer-2.php'; ?>

</body>
</html>