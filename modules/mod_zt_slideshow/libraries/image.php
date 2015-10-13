<?php

/* {$id} */

if (!class_exists('ZtSlideshowImage'))
{

    jimport('joomla.filesystem.folder');

    class ZtSlideshowImage extends JObject
    {

        public function __construct($properties = null)
        {
            parent::__construct($properties);
            $this->_prepare();
            $this->set('image_path', JPATH_ROOT . '/' . $this->image);
            $this->set('image_url', rtrim(JUri::root(), '/') . '/' . $this->image);
        }

        private function _prepare()
        {
            $cacheDir = JPATH_ROOT . '/cache/ztslideshow/';
            if (!JFolder::exists($cacheDir))
            {
                JFolder::create($cacheDir);
            }
            $imager = new ZtSlideshowImager('gd');
            $imagePath = JPATH_ROOT . '/' . $this->get('image');
            $imageFileName = md5($imagePath);
            if (JFile::exists($imagePath))
            {
                $imager->loadFile($imagePath);
                $method = $this->params->get('resize_method', 'fit');


                $imager->$method($this->params->get('width'), $this->params->get('height'));
                $ext = JFile::getExt($imagePath);
                $saveImagePath = $cacheDir . $imageFileName . '.' . $ext;
                if ($imager->saveToFile($saveImagePath))
                {
                    $this->set('resized_image_url', rtrim(JUri::root(), '/') . '/cache/ztslideshow/' . $imageFileName . '.' . $ext);
                }
            }
        }

        public function getImage($attributes = array(), $size = '')
        {
            foreach ($attributes as $key => $value)
            {
                $htmlAttributes [] = $key . '="' . $value . '"';
            }

            $src = $size . '_image_url';
            $html = '<img src="' . $src . '" ' . implode(' ', $htmlAttributes) . ' />';
            return $html;
        }

    }

}