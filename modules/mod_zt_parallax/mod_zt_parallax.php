<?php
/**
 * @package Module ZT Parallax
 * @author ZooTemplate
 * @copyright(C) 2014 - ZooTemplate.com
 * @license PHP files are GNU/GPL
 **/
// no direct access
defined('_JEXEC') || die('Restricted access');
if (!defined('DS'))
define('DS', '/');
jimport( 'joomla.user.user' );
// include the syndicate functions only once
require_once dirname(__FILE__) . '/helper.php';
$document = JFactory::getDocument(); 
$background_image = $params->get('background_image', '');

$text_content = $params->get('text_content', '');
$background_position = $params->get('background_position', 'center center');
$parallax_background = $params->get('parallax_background', 0);
$repeat_background = $params->get('repeat_background', 'no-repeat');
$text_color = $params->get('text_color', '#FFF');
$top_padding = $params->get('top_padding', '20');
$bottom_padding = $params->get('bottom_padding', '20');
$moduleclass_sfx = $params->get('moduleclass_sfx', '');

$module_id = $module->id;
$back = '';


if ($parallax_background) {
  $back = 'fixed';
} else {
  $back = 'scroll';
}
require(JModuleHelper::getLayoutPath('mod_zt_parallax', $params->get('zt_parallax_layout', 'default')));