<?php

/* {$id} */

if (!class_exists('ZtSlideshowEmbed'))
{

    class ZtSlideshowEmbed extends JObject
    {

        public function __construct($properties = null)
        {
            parent::__construct($properties);
            $this->_prepare();
        }

        private function _prepare()
        {
            $uri = JUri::getInstance($this->get('embed'));
            $host = $uri->getHost();
            if ($host == 'www.youtube.com' || $host == 'youtube.com')
            {
                $id = $uri->getVar('v');
                $this->set('source', 'youtube');
                $this->set('id', $id);
            } elseif ($host == 'www.vimeo.com' || $host == 'vimeo.com')
            {
                $parts = explode('/', $this->get('embed'));
                $id = array_pop($parts);
                $this->set('id', $id);
                $this->set('source', 'vimeo');
            }
        }

        public function getEmbed($attributes = array())
        {
            $html = '';
            foreach ($attributes as $key => $value)
            {
                $htmlAttributes [] = $key . '="' . $value . '"';
            }
            if ($this->get('source') == 'youtube')
            {
                $htmlAttributes [] = 'width="500"';
                $htmlAttributes [] = 'height="315"';
                $htmlAttributes [] = 'src="//www.youtube.com/embed/' . $this->get('id') . '"';
                $html = '<iframe ' . implode(' ', $htmlAttributes) . ' frameborder="0" allowfullscreen></iframe>';
            }
            if ($this->get('source') == 'vimeo')
            {
                /**
                 * <iframe src="https://player.vimeo.com/video/124307250" width="500" height="281" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe> <p><a href="https://vimeo.com/124307250">Kelela - A Message (Official Video)</a> from <a href="https://vimeo.com/user7657149">Daniel Sannwald</a> on <a href="https://vimeo.com">Vimeo</a>.</p>
                 */
                $htmlAttributes [] = 'width="500"';
                $htmlAttributes [] = 'height="281"';
                $htmlAttributes [] = 'src="//player.vimeo.com/video/' . $this->get('id') . '"';
                $html = '<iframe ' . implode(' ', $htmlAttributes) . ' frameborder="0" allowfullscreen></iframe>';
            }
            return $html;
        }

    }

}