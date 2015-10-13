<?php
/**
 * Zo2 (http://www.zootemplate.com/zo2)
 * A powerful Joomla template framework
 *
 * @version     1.4.3
 * @since       1.4.3
 * @link        http://www.zootemplate.com/zo2
 * @link        https://github.com/cleversoft/zo2
 * @author      ZooTemplate <http://zootemplate.com>
 * @copyright   Copyright (c) 2014 CleverSoft (http://cleversoft.co/)
 * @license     GPL v2
 */
defined('_JEXEC') or die('Restricted access');
?>
<footer>
    <section class="zo2-copyright"><?php echo $copyright; ?></section>    
    <?php if ($showLogo) : ?>
        <a 
            title="<?php echo $title; ?>" 
            class="zo2-copyright-logo" 
            href="<?php echo $link; ?>">
            <img src="<?php echo $logoUrl; ?>" alt="<?php echo $title; ?>" />
        </a>
    <?php endif; ?>
    <?php if ($gototop): ?>
        <a href="#" id="gototop" title="Go to top"><i class="fa fa-chevron-up"></i></a>
        <script>
            jQuery("#gototop").click(function () {
                jQuery("body, html").animate({scrollTop: 0});
                return false;
            });
        </script>
    <?php endif; ?>
</footer>