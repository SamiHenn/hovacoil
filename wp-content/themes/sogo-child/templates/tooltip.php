<?php if ( array_key_exists( $key, $help_array ) ): ?>
    <button type="button" class="tool-tip-btn" data-toggle="tooltip" data-placement="<?php echo wp_is_mobile() ? 'left' : 'top'; ?>"
            title="
                 <div class='bg-white'>
                       <p class='text-p-3 p-1 color-3 bg-8 bold border-bottom border-color-3'>
                           <?php echo $tip_title; ?>
                       </p>
                       <p class='p-1 text-7'>
                           <?php echo esc_html( $tip_content ); ?>
                       </p>
                 </div>
                 ">
        <span class="">?</span>
    </button>
<?php endif; ?>