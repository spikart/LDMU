<?php
/* {$id} */

$slides = json_decode($this->value);

$link = 'index.php?option=com_media&amp;view=images&amp;tmpl=component';
$button = new JObject;
$button->modal = true;
$button->class = 'btn modal';
$button->link = $link;
$button->text = JText::_('Select image');
$button->name = 'picture';
$button->options = "{handler: 'iframe', size: {x: 800, y: 500}}";
$button->onclick = 'zo2.modules.slideshow.activeElement(this);return false;';
$script = "
			if (typeof jInsertEditorText == 'undefined'){
				function jInsertEditorText(text, editor) {
					var source = text.match(/(src)=(\"[^\"]*\")/i), img;
					text = source[2].replace(/\\\"/g, '');
					img =  text;
                                        // Current focused
                                        input = jQuery(zo2.modules.slideshow.currentActiveElement).prev();
                                        jQuery(input).val(img);
				};
			};
			";
$doc = JFactory::getDocument();
$doc->addScriptDeclaration($script);
$doc->addScript(JUri::root() . '/modules/mod_zt_slideshow/assets/scripts.js');
$doc->addStyleSheet(JUri::root() . '/modules/mod_zt_slideshow/assets/css/back/admin.css');
$doc->addStyleSheet(JUri::root() . '/modules/mod_zt_slideshow/assets/fontawesome/css/font-awesome.min.css');
?>
<script>
    /**
     * Default function. Usually would be overriden by the component
     */
    Joomla.submitbutton = function (pressbutton) {
        zo2.modules.slideshow.hookSave();
        if (pressbutton) {
            document.adminForm.task.value = pressbutton;
        }
        if (typeof document.adminForm.onsubmit == "function") {
            document.adminForm.onsubmit();
        }
        if (typeof document.adminForm.fireEvent == "function") {
            document.adminForm.fireEvent('onsubmit');
        }
        document.adminForm.submit();
    }
</script>
<!-- Wrapper -->
<div class="zt-slider" id="zt-slidershow-wrapper">
    <div class="modal fade" id="zt-slidershow-modal-cannotdelete">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Can not delete</h4>
                </div>
                <div class="modal-body">
                    <p>Slider need at least one slide.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <div class="modal fade" id="zt-slidershow-modal-confirm">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Delete confirm</h4>
                </div>
                <div class="modal-body">
                    <p>Do you want delete this slide.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                    <button type="button" class="btn btn-primary" onclick="zo2.modules.slideshow.deleteSlide();">Yes</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <button type="button" class="btn-add-slider btn btn-primary" onclick="zo2.modules.slideshow.addSlide(this);">Add
        slide
    </button>
    <!-- Wrapper -->
    <div class="slides sortable" id="zt-slidershow-container">
        <?php if (count($slides) > 0): ?>
            <?php $slideCount = 0; ?>
            <?php foreach ($slides as $slide) : ?>
                <?php $slideCount++; ?>
                <?php $slide = new JObject($slide); ?>
                <?php require __DIR__ . '/slide.php'; ?>
            <?php endforeach; ?>
        <?php else : ?>
            <?php $slide = new JObject (); $slideCount = 1; ?>
            <?php require __DIR__ . '/slide.php'; ?>
        <?php endif; ?>
    </div>
    <button type="button" class="btn-add-slider btn btn-primary" onclick="zo2.modules.slideshow.addSlide();">Add
        slide
    </button>

    <input id="slides" type="hidden" name="jform[params][slides]" value=""/>
</div>