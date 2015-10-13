<?php

/* {$id} */
?>
<div class="element-embed ps-<?php echo ($item->get('position')) ? $item->get('position') : 'none'; ?> animated <?php echo ($item->get('effect')) ? $item->get('effect') : 'none'; ?>">
    <?php echo $item->getEmbed(); ?>
</div>