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

class JFormFieldLayout extends JFormField {
	protected $type = 'Layout'; //the form field type
	    var $options = array();
	    
	    protected function getInput() {
	    $html=array();
	    $files=array();
			$options = array();
	    $i=0;
	    	$html[]='<select class="zt-field single" name="'.$this->name.'">';
	    	if(is_dir(JPATH_SITE . '/templates/' . $this->getTemplate() . '/html/mod_zt_parallax/'))
	    	if ($handle = opendir(JPATH_SITE . '/templates/' . $this->getTemplate() . '/html/mod_zt_parallax/')) {
		    while (false !== ($entry = readdir($handle))) {
		    	$files[$entry]=$entry;
		    	if ($entry != "." && $entry != ".." &&$entry!="index.html"){
		    		if($this->value==str_replace('.php','',$entry)) {
		    			$selected=" selected=true ";
		    			}
		    		else $selected="";
						//Parser layout name
						$layout_name = str_replace('.php','',$entry);
						$order = 9999;
						ob_start();
						readfile(JPATH_SITE . '/templates/' . $this->getTemplate() . '/html/mod_zt_parallax/' . $entry);
						$file_content = ob_get_clean();
						preg_match("'<!--layout:(.*?),order:(.*?)-->'si", $file_content, $match);
						if(isset($match[1])) $layout_name = $match[1];
						if(isset($match[2])) $order = $match[2];
						$option_html = '<option '.$selected.' value="'.str_replace('.php','',$entry).'">'.$layout_name.'</option>';
						$options[] = array('order'=>$order,'html'=> $option_html);
						//$html[]='<option '.$selected.' value="'.str_replace('.php','',$entry).'">'.$layout_name.'</option>';
			}
		    }

		    closedir($handle);
		}
		if ($handle = opendir(JPATH_SITE.'/modules/mod_zt_parallax/tmpl/')) {
		    while (false !== ($entry = readdir($handle))) {
		    	if(!in_array($entry,$files))
		    	if ($entry != "." && $entry != ".." &&$entry!="index.html"){
		    		if($this->value==str_replace('.php','',$entry)) {
		    			$selected=" selected=true ";
		    			}
		    		else $selected="";
						//Parser layout name
						$layout_name = str_replace('.php','',$entry);
						$order = 9999;
						ob_start();
						readfile(JPATH_SITE.'/modules/mod_zt_parallax/tmpl/' . $entry);
						$file_content = ob_get_clean();
						preg_match("'<!--layout:(.*?),order:(.*?)-->'si", $file_content, $match);
						if(isset($match[1])) $layout_name = $match[1];
						if(isset($match[2])) $order = $match[2];
						$option_html = '<option '.$selected.' value="'.str_replace('.php','',$entry).'">'.$layout_name.'</option>';
						$options[] = array('order'=>$order,'html'=> $option_html);
			}
		    }

		    closedir($handle);
		}
		$orders = array();
		foreach($options as $key => $option){
			$orders[$key] = $option['order'];
		}
		array_multisort($orders, SORT_ASC, $options);
		$html='<select class="zt-field single" name="'.$this->name.'">';
		foreach($options as $option){
			$html .= $option['html'];
		}
		$html .= '</select>';
		return $html;
	}
	function getTemplate(){
		$db=JFactory::getDBO();
		$query=$db->getQuery(true);
		$query->select('*');
		$query->from('#__template_styles');
		$query->where('home=1');
		$query->where('client_id=0');
		$db->setQuery($query);
		return $db->loadObject()->template;
	}
    
}
