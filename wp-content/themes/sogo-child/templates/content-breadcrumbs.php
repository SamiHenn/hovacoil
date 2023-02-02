<?php
?>
<section class="breadcrumbs pt-1 pb-2 pb-lg-4">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-10 col-lg-offset-1">
                <?php
                if (function_exists('yoast_breadcrumb')) {
                    yoast_breadcrumb('<div id="breadcrumbs">', '</div>');
                }
                ?>
            </div>
        </div>
    </div>
</section>