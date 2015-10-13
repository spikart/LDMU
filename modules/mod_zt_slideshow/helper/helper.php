<?php

/* {$id} */

if (!class_exists('ZtSlideshowHelperHelper'))
{

    class ZtSlideshowHelperHelper
    {

        public static function prepare($slides, $params)
        {

            foreach ($slides as $index => $slide)
            {
                $properties = get_object_vars($slide);
                $left = new JObject();
                $right = new JObject();
                $data = new JObject();
                foreach ($properties as $key => $value)
                {
                    if (substr($key, 0, 2) == 'l-')
                    {
                        $left->set(substr($key, 2), $value);
                    } elseif (substr($key, 0, 2) == 'r-')
                    {
                        $right->set(substr($key, 2), $value);
                    } else
                    {
                        $data->set($key, $value);
                    }
                }
                if ($left->get('type') == 'image')
                {
                    $list[$index]['left'] = self::imagePrepare($left, $params);
                } else
                {
                    $list[$index]['left'] = self::embedPrepare($left, $params);
                }
                if ($right->get('type') == 'image')
                {
                    $list[$index]['right'] = self::imagePrepare($right, $params);
                } else
                {
                    $list[$index]['right'] = self::embedPrepare($right, $params);
                }
                $list[$index]['params'] = $data;
            }
            return $list;
        }

        public static function imagePrepare($slide, $params)
        {
            $properties = $slide->getProperties();
            $properties['params'] = $params;
            $image = new ZtSlideshowImage($properties);
            return $image;
        }

        public static function embedPrepare($slide, $params)
        {
            $embed = new ZtSlideshowEmbed($slide->getProperties());
            $embed->set('params', $params);
            return $embed;
        }

        public static function effectSlider($selected)
        {
            $arrayEffect = 'bounce|shake|swing|tada|bounceIn|bounceInDown|bounceInLeft|bounceInRight|bounceInUp|bounceOut|bounceOutDown|bounceOutLeft|bounceOutRight|bounceOutUp|fadeIn|fadeInDown|fadeInDownBig|fadeInLeft|fadeInLeftBig|fadeInRight|fadeInRightBig|fadeInUp|fadeInUpBig|fadeOut|fadeOutDown|fadeOutDownBig';
            $arrayList = explode('|', $arrayEffect);
            $html = '';

            foreach ($arrayList as $list)
            {
                $select = '';
                if (strtolower($selected) == strtolower($list))
                {
                    $select = 'selected="selected"';
                }
                $html .= '<option data-a="' . $selected . '" value="' . $list . '" ' . $select . '>' . $list . '</option>';
            }
            return $html;
        }

    }

}