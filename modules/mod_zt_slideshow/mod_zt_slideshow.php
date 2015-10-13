<?php

/* {$id} */

require_once __DIR__ . '/bootstrap.php';

$slides = json_decode($params->get('slides'));

$slides = ZtSlideshowHelperHelper::prepare($slides, $params);

require JModuleHelper::getLayoutPath('mod_zt_slideshow', $params->get('layout', 'default'));
