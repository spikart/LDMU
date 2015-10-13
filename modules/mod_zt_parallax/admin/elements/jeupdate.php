<?php

/**
 * @package Module ZT Parallax
 * @author ZooTemplate
 * @copyright(C) 2014 - ZooTemplate.com
 * @license PHP files are GNU/GPL
 **/
// no direct access
defined('_JEXEC') || die('Restricted access');
jimport('joomla.html.html');
jimport('joomla.form.formfield');

class JFormFieldJEUpdate extends JFormField {
	protected $type = 'JEUpdate'; //the form field type
    var $options = array();
    
    protected function getInput() {
        $html ='
            <div class="update-tab">
                <h3>This is Update tab!</h3>
            </div>
        ';
        return $html;
	}
    function getLabel() {
        return '';
    }
    
}
