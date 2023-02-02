<?php
global $order_params;
$val        = sogo_get_cookie_param( $name );
$is_tooltip = get_field( $name . '_tooltip', 'option' );
$tooltip    = isset( $is_tooltip ) && ! empty( $is_tooltip ) ? $is_tooltip : '';


//. ' - ' . $order_params['mandat_price'] .  &#8362;
$price = '';
if ('mandat-num-payments' == $name) {
    $price .= ' - <span class="price-box"> ' . (isset($order_params['order_details']['mandat_price']) ? $order_params['order_details']['mandat_price'] : $order_params['order_details']['price']) . '</span> &#8362;';
} else if ('other-num-payments' == $name) {

    //if havila price exists we separate price of insurance and havila
    if (intval($order_params['order_details']['price_havila']) > 0) {
        $price .= ' - <span class="price-box">' . (intval( $order_params['order_details']['second_price']) - intval($order_params['order_details']['price_havila'])) . '</span> &#8362;';
    } else {
        $price .= ' - <span class="price-box">' . intval( $order_params['order_details']['second_price']) . '</span> &#8362;';
    }

} else if ('havila-num-payments' == $name) {
	$label = 'תשלומים עבור חבילה';
	$price .= ' - <span class="price-box">' . $order_params['order_details']['price_havila'] . '</span> &#8362;';
} else if ( substr($name, 0, 21 ) === 'upsales_payments_num_' ) {
	$price .= ' - <span class="upsales-price-info">' . (isset($order_params['upsales-price'])  && !empty($order_params['upsales-price']) ? $order_params['upsales-price'] : '') . '</span><span> &#8362;</span>';

}

?>
<?php if ( array_key_exists( $name, (array)$help_array ) ): ?>
	<?php sogo_include_tooltip( $name, $help_array, $label, $help_array[$name] ); ?>
<?php endif; ?>

<label for="<?php echo $name; ?>"
       class="text-5 color-6 d-inline-block mb-1"><?php echo $label . $price; ?></label>

<div class="s-select-wrapper">

    <select name="<?php echo $name; ?><?php echo $array_data ? '[]' : ''; ?>" id="<?php echo $name; ?>" data-selected="<?php echo $val; ?>"
            class="<?php echo $class; ?>">

        <option value="">בחר</option>


		<?php

        $excludeArr = [
                'insurance-1-year',
                'insurance-2-year',
                'insurance-3-year',
                'law-suites-3-year',
                'law-suite-what-year',

        ];
		$index = (int) $i;
		foreach ( $options_array as $option ):

			$option_set = isset( $option[0] ) && ! empty( $option[0] ) ? $option[0] : $option;

			if ( $db_array ) {

				$index  = $option_set;
				$option = $option_set;
			}

			?>
        <?php if (in_array($name, $excludeArr)):?>
            <option value="<?php echo $index; ?>" ><?php echo $option; ?></option>
        <?php else:?>
            <option value="<?php echo $index; ?>" <?php selected( $index, $val ) ?> ><?php echo $option; ?></option>
        <?php endif;?>

			<?php
			$index ++;
		endforeach; ?>

    </select>

</div>