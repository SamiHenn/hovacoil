<?php

$val = sogo_get_cookie_param( $name );

?>
<label class="text-5 color-6 d-block mb-1"><?php echo $label; ?></label>

<div class="s-select-wrapper">

    <select name="<?php echo $name; ?>[]" data-selected="<?php echo $val; ?>" class="<?php echo $class; ?>">

        <option value="">בחר</option>


		<?php
		$index = (int) $i;
		foreach ( (array)$options_array as $option ):

			$option_set = isset( $option[0] ) && ! empty( $option[0] ) ? $option[0] : '';

			if ( $db_array ) {

				$index  = $option_set;
				$option = $option_set;
			}

			?>
            <option value="<?php echo $index; ?>" <?php selected( $index, $val ) ?> ><?php echo $option; ?></option>
			<?php
			$index ++;
		endforeach; ?>

    </select>

</div>