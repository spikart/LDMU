<?php

/* {$id} */

/**
 * Class exists checking
 */
if (!class_exists('ZtSlideshowImager'))
{

    /**
     * Image process class
     */
    class ZtSlideshowImager
    {

        /**
         *
         * @var object 
         */
        private $_adapter;

        /**
         * 
         * @param string $adapterName
         */
        public function __construct($adapterName)
        {
            $this->_adapter = $this->_createAdapter($adapterName);
        }

        /**
         * Get adapter
         * @param type $adapterName
         * @return \ZtSlideshowImagerImagick|\ZtSlideshowImagerGd
         */
        private function _createAdapter($adapterName)
        {
            switch ($adapterName)
            {
                case 'gd':
                    return new ZtSlideshowImagerGd ();
                case 'imagick':
                    return new ZtSlideshowImagerImagick ();
                default :
                    return new ZtSlideshowImagerGd ();
            }
        }

        /**
         * Execute adapter method
         * @param type $name
         * @param type $arguments
         * @return type
         */
        public function __call($name, $arguments)
        {
            if (method_exists($this->_adapter, $name))
            {
                return call_user_func_array(array($this->_adapter, $name), $arguments);
            }
        }

    }

}