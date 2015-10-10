<?php
/**
* @package   yoo_master
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) YOOtheme GmbH
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/

// get template configuration
include($this['path']->path('layouts:template.config.php'));
	
?>
<!DOCTYPE HTML>
<html lang="<?php echo $this['config']->get('language'); ?>" dir="<?php echo $this['config']->get('direction'); ?>">

<head>
<?php echo $this['template']->render('head'); ?>

</head>

<body id="page" class="page <?php echo $this['config']->get('body_classes'); ?>" data-config='<?php echo $this['config']->get('body_config','{}'); ?>'>
	
<div class="header-outer">
<?php if ($this['modules']->count('toolbar-l + toolbar-r') || $this['config']->get('date')) : ?>
<div class="jp-toolbar-outer clearfix">
	<div class="wrapper clearfix">
		<div id="toolbar" class="clearfix">
			<?php if ($this['modules']->count('toolbar-l') || $this['config']->get('date')) : ?>
			<div class="float-left">
				<?php if ($this['config']->get('date')) : ?>
				<time datetime="<?php echo $this['config']->get('datetime'); ?>"><?php echo $this['config']->get('actual_date'); ?></time>
				<?php endif; ?>
				<?php echo $this['modules']->render('toolbar-l'); ?>
			</div>
			<?php endif; ?>
			<?php if ($this['modules']->count('toolbar-r')) : ?>
			<div class="float-right"><?php echo $this['modules']->render('toolbar-r'); ?></div>
			<?php endif; ?>
		</div>
	</div>
</div>
<?php endif; ?>

	<?php if ($this['modules']->count('logo + menu')) : ?>
	<div class="menu-outer">
        <div class="wrapper clearfix margin-bottom">
          <header id="header">
                    <div id="headerbar" class="clearfix">
                        <?php if ($this['modules']->count('logo')) : ?>	
                        <a id="logo" href="<?php echo $this['config']->get('site_url'); ?>"><?php echo $this['modules']->render('logo'); ?></a>
                        <?php endif; ?>
                        <?php if ($this['modules']->count('menu')) : ?>
                        <div id="menubar" class="clearfix">
                            <nav id="menu"><?php echo $this['modules']->render('menu'); ?></nav>
                         <?php endif; ?>
                        </div>
                     </div>
                </header>
            </div>
        <?php endif; ?>
    </div><!--end menu-outer-->

	<?php if ($this['modules']->count('slidetop')) : ?>
        <div style="padding:20px 0" class="wrapper clearfix">
        <?php echo $this['modules']->render('slidetop'); ?>
        </div>
    <?php endif; ?>
</div><!--end supersize-->

<div id="mainsite" class="clearfix">


	<?php if ($this['modules']->count('top-a + top-b + top-c + top-d')) : ?>
	<div style="padding:20px 0" class="wrapper clearfix">
		<?php if ($this['modules']->count('top-a')) : ?>
		<section id="top-a" class="grid-block"><?php echo $this['modules']->render('top-a', array('layout'=>$this['config']->get('top-a'))); ?></section>
		<?php endif; ?>
		<?php if ($this['modules']->count('top-b')) : ?>
		<section id="top-b" class="grid-block"><?php echo $this['modules']->render('top-b', array('layout'=>$this['config']->get('top-b'))); ?></section>
		<?php endif; ?>
		<?php if ($this['modules']->count('top-c')) : ?>
		<section id="top-c" class="grid-block"><?php echo $this['modules']->render('top-c', array('layout'=>$this['config']->get('top-c'))); ?></section>
		<?php endif; ?>
		<?php if ($this['modules']->count('top-d')) : ?>
		<section id="top-d" class="grid-block"><?php echo $this['modules']->render('top-d', array('layout'=>$this['config']->get('top-d'))); ?></section>
		<?php endif; ?>
	</div>
	<?php endif; ?>



	<?php if ($this['modules']->count('innertop + innerbottom + sidebar-a + sidebar-b') || $this['config']->get('system_output')) : ?>
	<div class="main-outer clearfix">
		<div class="wrapper clearfix">
			<div id="main" class="grid-block">
	
				<div id="maininner" class="grid-box">
					<?php if ($this['modules']->count('innertop')) : ?>
					<section id="innertop" class="grid-block"><?php echo $this['modules']->render('innertop', array('layout'=>$this['config']->get('innertop'))); ?></section>
					<?php endif; ?>
					<?php if ($this['modules']->count('breadcrumbs')) : ?>
					<section id="breadcrumbs"><?php echo $this['modules']->render('breadcrumbs'); ?></section>
					<?php endif; ?>
	
					<?php if ($this['config']->get('system_output')) : ?>
					<section id="content" class="grid-block"><?php echo $this['template']->render('content'); ?></section>
					<?php endif; ?>
	
					<?php if ($this['modules']->count('innerbottom')) : ?>
					<section id="innerbottom" class="grid-block"><?php echo $this['modules']->render('innerbottom', array('layout'=>$this['config']->get('innerbottom'))); ?></section>
					<?php endif; ?>
				</div>
				<!-- maininner end -->
				
				<?php if ($this['modules']->count('sidebar-a')) : ?>
				<aside id="sidebar-a" class="grid-box"><?php echo $this['modules']->render('sidebar-a', array('layout'=>'stack')); ?></aside>
				<?php endif; ?>
				
				<?php if ($this['modules']->count('sidebar-b')) : ?>
				<aside id="sidebar-b" class="grid-box"><?php echo $this['modules']->render('sidebar-b', array('layout'=>'stack')); ?></aside>
				<?php endif; ?>
				
			</div><!-- main end -->
			
		</div><!-- wrapper end -->
	</div><!-- main-outer end -->
	<?php endif; ?>
    
    
	<?php if ($this['modules']->count('bottom-a + bottom-b + bottom-c')) : ?>
	<div style="padding:20px 0" class="wrapper clearfix">
		<?php if ($this['modules']->count('bottom-a')) : ?>
		<section id="bottom-a" class="grid-block"><?php echo $this['modules']->render('bottom-a', array('layout'=>$this['config']->get('bottom-a'))); ?></section>
		<?php endif; ?>
		<?php if ($this['modules']->count('bottom-b')) : ?>
		<section id="bottom-b" class="grid-block"><?php echo $this['modules']->render('bottom-b', array('layout'=>$this['config']->get('bottom-b'))); ?></section>
		<?php endif; ?>
		<?php if ($this['modules']->count('bottom-c')) : ?>
		<section id="bottom-c" class="grid-block"><?php echo $this['modules']->render('bottom-c', array('layout'=>$this['config']->get('bottom-c'))); ?></section>
		<?php endif; ?>
	</div>
	<?php endif; ?>
	


	<div class="bottom-d-outer" style="padding:10px 0">
		<div class="wrapper clearfix" style="padding:10px 0">
			<?php if ($this['modules']->count('bottom-d')) : ?>
			<section id="bottom-d" class="grid-block"><?php echo $this['modules']->render('bottom-d', array('layout'=>$this['config']->get('bottom-d'))); ?></section>
			<?php endif; ?>
		</div>
	</div>


	<?php if ($this['modules']->count('footer-a')) : ?>
		<div class="footer-outer" style="padding:10px 0">
			<div class="wrapper clearfix" style="padding:10px 0">
				<section id="footer-a" class="grid-block"><?php echo $this['modules']->render('footer-a', array('layout'=>$this['config']->get('footer-a'))); ?></section>
				<?php if ($this['config']->get('totop_scroller')) : ?>
				<p id="back-top"><a href="#page"><span></span></a></p>
				<?php endif; ?>
			</div>
		</div>
	<?php endif; ?>
	

	<?php if ($this['modules']->count('debug')) : ?>
	<?php echo $this['modules']->render('debug'); ?>
	<?php endif; ?>

</div><!-- main-site end -->


</body>
</html>