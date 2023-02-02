<div class="<?php echo $wrapper; ?>">
	<?php if ( array_key_exists( $field, (array)$help_array ) ): ?>
		<?php sogo_include_tooltip( $field, $help_array, $label, $help_array[$field] ); ?>
	<?php endif; ?>

	<label class="text-5 color-6 d-inline-block mb-1"><?php echo $label; ?></label>

<!--    --><?php //if ($field == 'driver-identical-number') :?>
<!--       --><?php
//        $i = 0;
//	    $prefix = ++$i;
//        ?>
<!--        <input type="--><?php //echo $type; ?><!--" name="--><?php //echo $field;?><!--[]" class="w-100 --><?php //echo $field?><!--" value="--><?php //echo isset($_GET['ins_order']) ? $order_params['city'] : '';?><!--" />-->
        <input type="<?php echo $type; ?>" name="<?php echo $field;?>[]" class="w-100 <?php echo $field?>" value="<?php echo $array_data?>" />
    <?php // else:?>
<!--        <input type="--><?php //echo $type; ?><!--" name="--><?php //echo $field; ?><!--[]" class="w-100 --><?php //echo $field?><!--" value="--><?php //echo isset($_GET['ins_order']) ? $order_params['city'] : '';?><!--" />-->
<!--        <input type="--><?php //echo $type; ?><!--" name="--><?php //echo $field; ?><!--[]" class="w-100 --><?php //echo $field?><!--" value="" />-->
    <?php //endif;?>
</div>