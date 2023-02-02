<?php
$order = '';
$disabled = '';

$isDisabledArr = [
        'street-another',
        'house-number-another',
        'apartment-number-another',
];

if (in_array($field, $isDisabledArr)) {
    $disabled = ' disabled ';
}

if ($field == 'last-name') {
	$order = ' order-lg-2 ';
}

?>


<div class="<?php echo $wrapper; ?> <?php echo $order;?>">

	<?php if ( array_key_exists( $field,(array) $help_array ) ): ?>
		<?php sogo_include_tooltip( $field, $help_array, $label, $help_array[$field] ); ?>
	<?php endif; ?>

	<label for="<?php echo $field; ?>" class="text-5 color-6 d-inline-block mb-1"><?php echo $label; ?></label>
<?php
    //$maxLength = ('identical-number' == $field ? 'maxlength=9' : '');
    $maxLength = (preg_match('/identical-number/', $field) ? 'maxlength=9' : '');

    $newType =  ($field === 'email') ? 'email' : $type;
?>
<!--	<input --><?php //echo $disabled;?><!----><?php //echo $maxLength;?><!-- type="--><?php //echo $type; ?><!--" id="--><?php //echo $field; ?><!--" name="--><?php //echo $field; ?><!----><?php //echo $array_data ? '[]' : '';?><!--" class="w-100" value="--><?php //echo $array_data?><!--" />-->
	<input <?php echo $disabled;?><?php echo $maxLength;?> type="<?php echo $newType; ?>" id="<?php echo $field; ?>" name="<?php echo $field; ?>" class="w-100" value="<?php echo $array_data?>" />

</div>