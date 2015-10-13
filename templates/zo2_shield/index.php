<?php
/**
 * Zo2 (http://www.zo2framework.org)
 * A powerful Joomla template framework
 *
 * @link        http://www.zo2framework.org
 * @link        http://github.com/aploss/zo2
 * @author      Duc Nguyen <ducntv@gmail.com>
 * @author      Hiepvu <vqhiep2010@gmail.com>
 * @copyright   Copyright (c) 2013 APL Solutions (http://apl.vn)
 * @license     GPL v2
 */
defined('_JEXEC') or die('Restricted Access');

require_once __DIR__ . '/includes/bootstrap.php';

/**
 * @todo Opengraph support
 * @todo Facebook & Twitter ... data attributes support
 */
?>
<!DOCTYPE html>
<html lang="<?php echo $this->zo2->template->getLanguage(); ?>" dir="<?php echo $this->zo2->template->getDirection(); ?>">
<head>
    <?php unset($this->_scripts[JURI::root(true).'/media/jui/js/bootstrap.min.js']); ?>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Enable responsive -->
        <?php if(!$this->zo2->framework->get('non_responsive_layout')) :  ?>
            <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php endif; ?>
    <![if gte IE 9]>    
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600' rel='stylesheet' type='text/css'>
    <![endif]>
    <jdoc:include type="head" />
</head>
<body class="<?php echo $this->zo2->layout->getBodyClass() ?> <?php echo $this->zo2->template->getDirection(); ?> <?php echo $this->zo2->framework->isBoxed() ? 'boxed' : ''; ?>">
<?php echo $this->zo2->template->fetch('html://layouts/css.condition.php'); ?>

<section class="zo2-wrapper <?php echo $this->zo2->framework->isBoxed() ? 'boxed container' : ''; ?>">
    <?php //echo $this->zo2->utilities->socialshares->render('floatbar'); ?>
    <?php echo $this->zo2->utilities->styleswitcher->render(); ?>
    <?php echo $this->zo2->layout->render(); ?>
</section>
<?php echo $this->zo2->layout->renderOut(); ?>
<?php echo $this->zo2->template->fetch('html://layouts/joomla.debug.php'); ?>
</body>
<script>
    <?php echo $this->zo2->utilities->bottomscript->render() ?>
</script>
<script>
	jQuery(document).ready(function() {
        jQuery('#zo2-mega-menu .navbar-nav a').click(function(){
            var element = jQuery(this).attr('href');
            jQuery('html, body').animate({
                scrollTop: jQuery(element).offset().top
            }, 800);   
        });
        jQuery('#gototop').click(function() {
            jQuery('html, body').animate({
                scrollTop: jQuery('.zo2-wrapper').offset().top
            }, 500);

        });
	
		if( jQuery('#gototop').lenght > 0){
			if(jQuery('#gototop').offset().top < 600) {
				jQuery('#gototop').fadeOut(500);
			}else{
				jQuery('#gototop').fadeIn(500);
			}

			jQuery(window).scroll(function() {
				if(jQuery('#gototop').offset().top < 800) {
					jQuery('#gototop').fadeOut(500);
				}else{
					jQuery('#gototop').fadeIn(500);
				}
			}); 
		}
        
    });
    <?php echo $this->zo2->utilities->bottomscript->render() ?>
</script>
</html>
