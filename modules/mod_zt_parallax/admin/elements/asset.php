<?php
/**
 * @package Module ZT Parallax
 * @author ZooTemplate
 * @copyright(C) 2014 - ZooTemplate.com
 * @license PHP files are GNU/GPL
 **/
// no direct access
defined('_JEXEC') || die('Restricted access');
jimport('joomla.form.formfield');
class JFormFieldAsset extends JFormField {
    protected $type = 'Asset';
    protected function getInput() {
      $doc = JFactory::getDocument();
			jimport('joomla.version');
			$version = new JVersion();
			$joomla_version = JVERSION; 
			if (JVERSION <3) {
                $doc->addScript(JURI::root() . 'modules/mod_zt_parallax/assets/js/jquery-1.11.1.js');
                $doc->addScript(JURI::root() . 'modules/mod_zt_parallax/assets/js/jquery.noConflict.js');
                $doc->addScript(JURI::root() . $this->element['path'] . 'js/script2.5.js');
                $doc->addStyleSheet(JURI::root() . $this->element['path'] . 'css/style.css');
			}elseif(JVERSION >= 3){
				$doc->addScript(JURI::root() . $this->element['path'] . 'js/script3.js');
			}
			return null;
    }
}