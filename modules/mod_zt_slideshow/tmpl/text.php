<?php
/* {$id} */
?>
<div class="content-text ps-<?php echo ($item->get('position')) ? $item->get('position') : 'none'; ?>">
    <?php if ($item->get('text-title') != '') : ?>
        <p class="small-title animated <?php echo ($item->get('effect')) ? $item->get('effect') : ''; ?>"
           style="animation-delay: 0.2s; -webkit-animation-delay: 0.2s;">
               <?php echo ($item->get('text-title')) ? $item->get('text-title') : ''; ?>
        </p>
    <?php endif; ?>
    <?php if ($item->get('text-stitle') != '') : ?>
        <h3 class="title animated <?php echo ($item->get('effect')) ? $item->get('effect') : ''; ?>"
            style="animation-delay: 0.5s; -webkit-animation-delay: 0.5s;">
            <?php echo ($item->get('text-stitle')) ? $item->get('text-stitle') : ''; ?></h3>
    <?php endif; ?>
    <?php if ($item->get('text-des') != '') : ?>
        <p class="description animated <?php echo ($item->get('effect')) ? $item->get('effect') : ''; ?>"
           style="animation-delay: 0.8s; -webkit-animation-delay: 0.8s;">
            <?php echo ($item->get('text-des')) ? $item->get('text-des') : ''; ?></p>
    <?php endif; ?>
    <?php if ($item->get('link') != '' && $item->get('text-link') != '') : ?>
        <p class="animated <?php echo ($item->get('effect')) ? $item->get('effect') : ''; ?>"
           style="animation-delay: 1s; -webkit-animation-delay: 1s;">
            <a class="zt-readmore" href="<?php echo ($item->get('link')) ? $item->get('link') : ''; ?>"><?php echo ($item->get('text-link')) ? $item->get('text-link') : ''; ?></a>
        </p>
    <?php endif; ?>
    <?php if($item->get('boxvideo')) { ?>
        <p class="animated <?php echo ($item->get('effect')) ? $item->get('effect') : ''; ?>"
           style="animation-delay: 1.2s; -webkit-animation-delay: 1.2s;">
            <?php if($item->get('boxtitle')) { ?>
            <span class="box-title"><?php echo $item->get('boxtitle'); ?></span>
            <?php } ?>
        </p>
        <p class="animated <?php echo ($item->get('effect')) ? $item->get('effect') : ''; ?>"
           style="animation-delay: 1.5s; -webkit-animation-delay: 1.5s;">
            <?php if($item->get('boxicon')) { ?>
                <a class="html5lightbox box-icon" href="<?php echo $item->get('boxvideo'); ?>"> <i class="<?php echo $item->get('boxicon'); ?>"></i></a>
            <?php } ?>
        </p>
    <?php } ?>
</div>