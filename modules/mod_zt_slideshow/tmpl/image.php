<?php

/* {$id} */

?>
<p class="element-image animated ps-<?php echo ($item->get('position')) ? $item->get('position') : 'none'; ?> <?php echo $item->get('effect'); ?>" style="animation-delay: 0.5s; -webkit-animation-delay: 0.5s; animation-duration: 0.7s;">
    <img src="<?php echo $item->get('resized_image_url'); ?>" />
</p>