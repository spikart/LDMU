<?php
/**
 * @package		SP Download
 * @subpackage	Plugins
 * @copyright	SP CYEND - All rights reserved.
 * @author		SP CYEND
 * @link		http://www.cyend.com
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
*/

// no direct access
defined('_JEXEC') or die;

jimport('joomla.plugin.plugin');

/**
 * Vote plugin.
 *
 * @package		Joomla.Plugin
 * @subpackage	SPDigitalGoods.show in article
 */
class plgContentSpThumbnail extends JPlugin
{
	/**
	 * Constructor
	 *
	 * @access      protected
	 * @param       object  $subject The object to observe
	 * @param       array   $config  An array that holds the plugin configuration
	 * @since       1.5
	 */
	public function __construct(& $subject, $config)
	{
		parent::__construct($subject, $config);
		$this->loadLanguage();
	}

        /**
	 * SP Digital Goods prepare content method
	 *
	 * Method is called by the view
	 *
	 * @param	string	The context of the content being passed to the plugin.
	 * @param	object	The content object.  Note $article->text is also available
	 * @param	object	The content params
	 * @param	int		The 'page' number
	 * @since	1.6
	 */
        public function onContentPrepare($context, &$article, &$params, $limitstart=0)
	{
        if (empty($article->text)) return true; //exit if empty article
        
		$app = JFactory::getApplication();
                $type = $this->params->get('thumbnails_for');
                $class = $this->params->get('class');

                // Loop to find and replace
                $pos_img = 0;
                $pos_img = strpos($article->text, '<img', $pos_img + 1);
                $new_txt = $article->text;
                while ($pos_img > 0)
                {
                    //Find class
                    $pos_greater = strpos($article->text, '>', $pos_img + 1);
                    $replace_str = substr($article->text, $pos_img, $pos_greater - $pos_img + 1);
                    $pos_class = strpos($replace_str, 'class');
                    $class_str = '';
                    if ($pos_class > 0) {
                        $pos_class_start = strpos($replace_str, '"', $pos_class + 1);
                        $pos_class_end = strpos($replace_str, '"', $pos_class_start + 1);
                        $class_str = substr($replace_str, $pos_class_start + 1, $pos_class_end - $pos_class_start - 1);
                    }

                    switch ($type) {
                        case 0:
                            if (strpos($class_str, $class) !== false) {
                                $new_txt = $this->convertString($new_txt, $replace_str);                                
                            }
                            break;
                        case 1:
                            if (strpos($class_str, $class) === false) {
                                $new_txt = $this->convertString($new_txt, $replace_str);                                
                            }
                            break;
                        case 2:
                            $new_txt = $this->convertString($new_txt, $replace_str);
                            break;
                        default:
                            break;
                    }

                    $pos_img = strpos($article->text, '<img', $pos_img + 1);
                }

                $article->text = $new_txt;

                return true;
	}

        function onBeforeRender(){
            JHTML::_('behavior.modal');
        }

        private function convertString($text, $replace_str) {
            $pos = strpos($replace_str, 'src=');
            $pos_start = strpos($replace_str, '"', $pos + 1);
            $pos_end = strpos($replace_str, '"', $pos_start + 1);
            $image_str = substr($replace_str, $pos_start + 1, $pos_end - $pos_start - 1);
            $new_str = '<a class="modal" href="'.$image_str.'">'.$replace_str.'</a>';
            $return_str = str_replace($replace_str, $new_str, $text);
            return $return_str;
        }
}
