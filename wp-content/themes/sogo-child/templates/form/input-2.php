<div class="<?php echo $wrapper; ?>">

	<?php if ( array_key_exists( $field,(array) $help_array ) ): ?>
		<?php sogo_include_tooltip( $field, $help_array, $label, $help_array[$field] ); ?>
	<?php endif; ?>

	<label for="<?php echo $field; ?>" class="text-5 color-6 d-inline-block mb-1"><?php echo $label; ?></label>
    <?php if($field == 'city' && $auto_data) :?>
        <input readonly type="<?php echo $type; ?>" id="<?php echo $field; ?>" name="<?php echo $field;?>" class="w-100" value="<?php echo $auto_data;?>" />
    <?php else :?>
        <input type="<?php echo $type; ?>" id="<?php echo $field; ?>" <?php echo isset($auto_data) && !empty($auto_data) ? 'disabled' : '';?> name="<?php echo $field; ?><?php echo $array_data ? '[]' : '';?>" class="w-100" value="<?php echo $auto_data;?>" />
    <?php endif;?>
</div>