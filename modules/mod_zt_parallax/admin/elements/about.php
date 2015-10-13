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
class JFormFieldAbout extends JFormField {
    protected $type = 'About';
    protected function getInput() {
        return '';
    }
}