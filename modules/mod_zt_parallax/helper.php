<?php
/**
 * @package Module ZT Parallax
 * @author ZooTemplate
 * @copyright(C) 2014 - ZooTemplate.com
 * @license PHP files are GNU/GPL
 **/
// no direct access
defined('_JEXEC') || die('Restricted access');

class modZtParallaxHelper {

	static function getTemplate() {
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query->select('*');
		$query->from('#__template_styles');
		$query->where('home=1');
		$query->where('client_id=0');
		$db->setQuery($query);
		return $db->loadObject()->template;
	}

}