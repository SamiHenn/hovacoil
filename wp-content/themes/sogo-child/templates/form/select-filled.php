<?
/*
 * Add esc_attr and stripslashes function to avoid compare condition errors and broken car sub model names
 *  esc_attr(stripslashes($filled_params))
 *  esc_attr($option);
 */
?>
<label for="<?php echo $name; ?>"
       class="text-5 color-6 d-inline-block mb-1"><?php echo $label; ?></label>

<div class="s-select-wrapper">

    <select name="<?php echo $name; ?>" id="<?php echo $name; ?>"
            data-selected='<?php echo esc_attr(stripslashes($filled_params)); ?>' class="<?php echo $class; ?>">

       <?php if(!empty($filled_params) && ($name !== 'youngest-driver' && $name !== 'lowest-seniority')):?>
        <option value="<?php  echo  esc_attr(stripslashes($filled_params))?>"><?php  echo  esc_attr(stripslashes($filled_params))?></option>
        <?php endif; ?>

        <?php if($name === 'youngest-driver' || $name === 'lowest-seniority'): ?>
            <?php if (count((array)$options_array) > 1): ?>
                <option value="">בחר</option>
            <?php endif; ?>

            <?php
            foreach ((array)$options_array as $key => $option):?>
                <?php $option = is_array($option) ? $option[0] : $option; ?>

                <?php if (preg_match('/^\d.\+$/', $option)) : ?>
                    <option value="<?php echo rtrim(esc_attr($option), '+'); ?>" <?php echo esc_attr(stripslashes($filled_params)) == rtrim(esc_attr(stripslashes($option)), '+') ? 'selected' : ''; ?> ><?php echo $option; ?></option>
                <?php else: ?>
                    <option value="<?php echo esc_attr(stripslashes($option)); ?>" <?php echo esc_attr(stripslashes($filled_params)) == esc_attr(stripslashes($option)) ? 'selected' : ''; ?> ><?php echo $option; ?></option>
                <?php endif; ?>

            <?php endforeach; ?>
        <?php endif; ?>
    </select>

</div>