
<label for="<?php echo $name; ?>"
       class="text-5 color-6 d-inline-block mb-1"><?php echo $label; ?></label>

<div class="s-select-wrapper">

    <select name="<?php echo $name; ?>" id="<?php echo $name; ?>" data-selected="<?php echo $filled_params; ?>" class="<?php echo $class; ?>">

        <option value="">בחר</option>

		<?php
		echo '<pre style="direction: ltr;">';

		echo '</pre>';

		foreach ((array) $options_array as $key => $option ):?>
        <?php $key = $start_zero ? $key : $key + 1;?>

            <?php if (is_numeric($filled_params)) :?>
                <option value="<?php echo $key; ?>" <?php echo  (int)$filled_params === $key ? 'selected="selected"' : '';?> ><?php echo $option; ?></option>
			<?php else: ?>
                <option value="<?php echo $key; ?>" <?php echo  stripslashes($filled_params === $key) ? 'selected="selected"' : '';?> ><?php echo $option; ?></option>

			<?php endif;?>

<!--            <option value="--><?php //echo $key; ?><!--" --><?php //echo  (int)$filled_params == $key ? 'selected="selected"' : '';?><!-- >--><?php //echo $option; ?><!--</option>-->
        <?php endforeach; ?>

    </select>

</div>