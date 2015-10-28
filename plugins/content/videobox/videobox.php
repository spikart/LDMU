<?php
/*------------------------------------------------------------------------
# plg_videobox - Videobox
# ------------------------------------------------------------------------
# author    HiTKO
# copyright Copyright (C) 2012 hitko.si. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://hitko.si
-------------------------------------------------------------------------*/
// no direct access
defined( '_JEXEC' ) or die( 'Restricted Access' );

jimport( 'joomla.plugin.plugin' );



class plgContentVideobox extends JPlugin
{

	public function onContentPrepare( $context, &$article, &$params, $limitstart )
	{
		$app = JFactory::getApplication();
		jimport('joomla.version');
		$version = new JVersion();
		$version = $version->RELEASE;
		$custom_tag = preg_replace("/[^a-zA-Z0-9]/", "", $this->params->get('tag'));
		
		$hits = array();
		
		// setup what to look for in the content		
		$regex = '/{videobox}(.*){\/videobox}/isU';
		
		// find all instances of the video players
		preg_match_all( $regex, $article->text, $matches );
		
		foreach($matches[1] as $match){
			$hit[0] = $match;
			$hit[1] = $regex;	
			$hits[] = $hit;
		}
		
		$matches = array();
		
		if(($custom_tag!='videobox')&($custom_tag!='')){
			$regex = '/{'.$custom_tag.'}(.*){\/'.$custom_tag.'}/iU';
			
			preg_match_all( $regex, $article->text, $matches );
			
			foreach($matches[1] as $match){
				$hit[0] = $match;
				$hit[1] = $regex;
				$hits[] = $hit;
			}
			
			$regex = '/{'.$custom_tag.'}(.*){\/videobox}/iU';
			
			preg_match_all( $regex, $article->text, $matches );
			
			foreach($matches[1] as $match){
				$hit[0] = $match;
				$hit[1] = $regex;
				$hits[] = $hit;
			}
			
			$regex = '/{videobox}(.*){\/'.$custom_tag.'}/iU';
			
			preg_match_all( $regex, $article->text, $matches );
			
			foreach($matches[1] as $match){
				$hit[0] = $match;
				$hit[1] = $regex;
				$hits[] = $hit;
			}
		}
		$pageslink = '/index.php';
		$cg = 0;
		foreach($_GET as $key => $get){
			if($cg == 0){
				$pageslink .= '?'.$key.'='.$get;
			} else {
				$pageslink .= '&'.$key.'='.$get;
			}
			$cg++;
		}
		//var_dump($pageslink);
		$url1 = JURI::getInstance();
		$url2 = array(0);
		if(isset($_GET['vblimits'])) $url2 = explode(',', $_GET['vblimits']);
		$url_params = $url1->getQuery(true);
		$org_params = $url1->buildQuery($url_params);
		$videos_root = JURI::root();
		
		$co = 0;
		foreach($hits as $match){
			
			$co++;
			$regex = $match[1];
			$match = strip_tags($match[0]);
			
			// breakdown the string of videos being passed		
			$parametri = explode('||', $match);
			$videos = explode('|,', $parametri[0]);
			
			// count the number of vidoes		
			$count = count($videos);
			
			// get parameters	
			$parametri_a = array();
			if(isset($parametri[1])) $parametri_a = explode(',', $parametri[1]);
			$parametri = array();
			$parametri['pages'] = $this->params->get('pages');
			$parametri['box'] = 0;	
			$parametri['break'] = $this->params->get('break');
			$parametri['full_url'] = $this->params->get('full_url');
			$parametri['t_width'] = 206;
			$parametri['t_height'] = 155;
			$parametri['width'] = 640;
			$parametri['height'] = 363;
			$parametri['style'] = '';
			$parametri['class'] = '';
			$parametri['box'] = '0';
			
			if($count>1){
				$parametri['t_width'] = $this->params->get('width_gt');
				$parametri['t_height'] = $this->params->get('height_gt');
				$parametri['width'] = $this->params->get('width_g');
				$parametri['height'] = $this->params->get('height_g');
				$parametri['style'] = $this->params->get('style_g');
				$parametri['class'] = $this->params->get('class_g');
			} else {
				$parametri['width'] = $this->params->get('width');
				$parametri['height'] = $this->params->get('height');
				$parametri['style'] = $this->params->get('style');
				$parametri['class'] = $this->params->get('class');		
				$parametri['box'] = $this->params->get('box');		
			}
			
			foreach($parametri_a as $parameter){
				$parameter = explode('=',$parameter);
				if((trim($parameter[0])!='')&(trim($parameter[1])!='')) $parametri[trim($parameter[0])] = trim($parameter[1]);
			}
			
			if($count>1){				
				if(!isset($parametri['lightbox'])) $parametri['lightbox'] = $this->params->get('no_lb');
				if($parametri['lightbox']==0){
					$parametri['play'] = $this->params->get('play_nlb_g');
				} else {
					$parametri['play'] = $this->params->get('play_g');
				}
			}
			
			if($parametri['box']==1){
				$parametri['t_width'] = $this->params->get('width_bt');
				$parametri['t_height'] = $this->params->get('height_bt');
				$parametri['width'] = $this->params->get('width_b');
				$parametri['height'] = $this->params->get('height_b');
				$parametri['style'] = $this->params->get('style_b');
				$parametri['class'] = $this->params->get('class_b');
				if(!isset($parametri['lightbox'])) $parametri['lightbox'] = $this->params->get('no_lb_b');
				if($parametri['lightbox']==0){
					$parametri['play'] = $this->params->get('play_nlb_b');
				} else {
					$parametri['play'] = $this->params->get('play_b');
				}
			}
			
			foreach($parametri_a as $parameter){
				$parameter = explode('=',$parameter);
				if((trim($parameter[0])!='')&(trim($parameter[1])!='')) $parametri[trim($parameter[0])] = trim($parameter[1]);
			}
			
			if($parametri['pages']==0) $parametri['pages'] = 99999999;
			if($parametri['break']==0) $parametri['break'] = 99999999;
			
			//create pagination (if necessary)		
			$start = 0;
			$pagination = '';
			if(($count>$parametri['pages'])&($parametri['pages']!=0)&($version{0}=='3')){
				$start = (int)$url2[$co-1];
				$path = '';
				for($h = 0; $h<$co-1; $h++){
					if($url2[$h]=='') $url2[$h]='0';
					$path .= ','.$url2[$h];
				}
				$after = '';
				for($h = $co; $h<count($url2); $h++){
					if($url2[$h]=='') $url2[$h]='0';
					$after .= ','.$url2[$h];
				}				
				$pages = (int)($count/$parametri['pages']);
				if($count%$parametri['pages']>0) $pages++;
				$page = (int)($start/$parametri['pages']);
				if($start%$parametri['pages']>0) $page++;
				$pagination = '<div class="pagination"><p class="counter pull-right">Page '.($page+1).' of '.$pages.'</p><ul class="pagination-list">';
				if($page==0){
					$pagination .= '<li class="disabled"><a><i class="icon-first"></i></a></li><li class="disabled"><a><i class="icon-previous"></i></a></li>';
				} else {
					$url3 = $path.',0'.$after;
					if($url3{0}==',') $url3 = substr($url3, 1);
					$url_params = array_merge($url1->getQuery(true), array('vblimits' => $url3));
					$url_params = $url1->buildQuery($url_params);
					$url_link = JURI::getInstance();
					$url_link->setQuery($url_params);
					$pagination .= '<li><a title="Start" href="'.$url_link->toString().'" class="pagenav">Start</a></li>';
					$url3 = $path.','.($page-1)*$parametri['pages'].$after;
					if($url3{0}==',') $url3 = substr($url3, 1);
					$url_params = array_merge($url1->getQuery(true), array('vblimits' => $url3));
					$url_params = $url1->buildQuery($url_params);
					$url_link = JURI::getInstance();
					$url_link->setQuery($url_params);
					$pagination .= '<li><a title="Prev" href="'.$url_link->toString().'" class="pagenav">Prev</a></li>';
				}
				for($j = 0; $j<$pages; $j++){
					if($j==$page){
						$pagination .= '<li class="active"><a>'.($j+1).'</a></li>';
					}else{
						$url3 = $path.','.$j*$parametri['pages'].$after;
						if($url3{0}==',') $url3 = substr($url3, 1);
						$url_params = array_merge($url1->getQuery(true), array('vblimits' => $url3));
						$url_params = $url1->buildQuery($url_params);
						$url_link = JURI::getInstance();
						$url_link->setQuery($url_params);
						$pagination .= '<li><a title="'.($j+1).'" href="'.$url_link->toString().'" class="pagenav">'.($j+1).'</a></li>';
					}
				}
				if($page==($pages-1)){
					$pagination .= '<li class="disabled"><a><i class="icon-next"></i></a></li><li class="disabled"><a><i class="icon-last"></i></a></li>';
				} else {
					$url3 = $path.','.($page+1)*$parametri['pages'].$after;
					if($url3{0}==',') $url3 = substr($url3, 1);
					$url_params = array_merge($url1->getQuery(true), array('vblimits' => $url3));
					$url_params = $url1->buildQuery($url_params);
					$url_link = JURI::getInstance();
					$url_link->setQuery($url_params);
					$pagination .= '<li><a title="Next" href="'.$url_link->toString().'" class="pagenav">Next</a></li>';
					$url3 = $path.','.($pages-1)*$parametri['pages'].$after;
					if($url3{0}==',') $url3 = substr($url3, 1);
					$url_params = array_merge($url1->getQuery(true), array('vblimits' => $url3));
					$url_params = $url1->buildQuery($url_params);
					$url_link = JURI::getInstance();
					$url_link->setQuery($url_params);
					$pagination .= '<li><a title="End" href="'.$url_link->toString().'" class="pagenav">End</a></li>';
				}	
				$pagination .= '</ul></div>';
			}
			if(($count>$parametri['pages'])&($parametri['pages']!=0)&($version{0}!='3')){
				$start = (int)$url2[$co-1];
				$path = '';
				for($h = 0; $h<$co-1; $h++){
					if($url2[$h]=='') $url2[$h]='0';
					$path .= ','.$url2[$h];
				}
				$after = '';
				for($h = $co; $h<count($url2); $h++){
					if($url2[$h]=='') $url2[$h]='0';
					$after .= ','.$url2[$h];
				}				
				$pages = (int)($count/$parametri['pages']);
				if($count%$parametri['pages']>0) $pages++;
				$page = (int)($start/$parametri['pages']);
				if($start%$parametri['pages']>0) $page++;
				$pagination = '<div class="pagination"><p class="counter">Page '.($page+1).' of '.$pages.'</p><div class="pagination">';
				if($page==0){
					$pagination .= '<span>Start</span><span>Prev</span>';
				} else {
					$url3 = $path.',0'.$after;
					if($url3{0}==',') $url3 = substr($url3, 1);
					$url_params = array_merge($url1->getQuery(true), array('vblimits' => $url3));
					$url_params = $url1->buildQuery($url_params);
					$url_link = JURI::getInstance();
					$url_link->setQuery($url_params);
					$pagination .= '<a href="'.$url_link->toString().'" title="Start">Start</a>';
					$url3 = $path.','.($page-1)*$parametri['pages'].$after;
					if($url3{0}==',') $url3 = substr($url3, 1);
					$url_params = array_merge($url1->getQuery(true), array('vblimits' => $url3));
					$url_params = $url1->buildQuery($url_params);
					$url_link = JURI::getInstance();
					$url_link->setQuery($url_params);
					$pagination .= '<a href="'.$url_link->toString().'" title="Prev">Prev</a>';
				}
				for($j = 0; $j<$pages; $j++){
					if($j==$page){
						$pagination .= '<strong><span>'.($j+1).'</span></strong>';
					}else{
						$url3 = $path.','.$j*$parametri['pages'].$after;
						if($url3{0}==',') $url3 = substr($url3, 1);
						$url_params = array_merge($url1->getQuery(true), array('vblimits' => $url3));
						$url_params = $url1->buildQuery($url_params);
						$url_link = JURI::getInstance();
						$url_link->setQuery($url_params);
						$pagination .= '<strong><a href="'.$url_link->toString().'" title="'.($j+1).'">'.($j+1).'</a></strong>';
					}
				}
				if($page==($pages-1)){
					$pagination .= '<span>Next</span><span>End</span>';
				} else {
					$url3 = $path.','.($page+1)*$parametri['pages'].$after;
					if($url3{0}==',') $url3 = substr($url3, 1);
					$url_params = array_merge($url1->getQuery(true), array('vblimits' => $url3));
					$url_params = $url1->buildQuery($url_params);
					$url_link = JURI::getInstance();
					$url_link->setQuery($url_params);
					$pagination .= '<a href="'.$url_link->toString().'" title="Next">Next</a>';
					$url3 = $path.','.($pages-1)*$parametri['pages'].$after;
					if($url3{0}==',') $url3 = substr($url3, 1);
					$url_params = array_merge($url1->getQuery(true), array('vblimits' => $url3));
					$url_params = $url1->buildQuery($url_params);
					$url_link = JURI::getInstance();
					$url_link->setQuery($url_params);
					$pagination .= '<a href="'.$url_link->toString().'" title="End">End</a>';
				}	
				$pagination .= '</div></div>';
			}


			
			//include necessary header content
			$document = JFactory::getDocument();
			if($document instanceof JDocumentHTML) {
				$arr = $document->getHeadData();
				$trr = false;
				$rrr = false;
				foreach($arr['custom'] as $rr){
					if(strpos($rr, 'videobox.css')!==false) $trr = true;		
					if(strpos($rr, 'videobox.js')!==false) $rrr = true;
				}
				if($trr===false){
					$document->addCustomTag('<link rel="stylesheet" href="plugins/content/videobox/css/videobox.css" type="text/css" media="screen" />');			
				}
				if (($count>=2)||($parametri['box']==1)) {
					if($rrr===false){
						$document->addCustomTag('<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script><script src="http://api.html5media.info/1.1.5/html5media.min.js"></script><script type="text/javascript">jQuery.noConflict();</script><script type="text/javascript" src="plugins/content/videobox/videobox.js"></script><script type="text/javascript">
							var displayvideo;
							var vb_site_base = "'.JPATH_BASE.'/";
							var vb_site_root = "'.JURI::root().'";
							jQuery(document).ready(function($) {
								displayvideo = function (vid, src, vwidth, vheight, twidth, theight, html5, audio){
									var frame = document.getElementById(\'video_\'+vid);
									var image = document.getElementById(\'thumb_\'+vid);
									var close = document.getElementById(\'close_\'+vid);
									var title = document.getElementById(\'title_\'+vid);
									if((frame.getAttribute(\'style\').indexOf(\'block\')==-1)){
										image.style.display = \'none\';
										frame.style.display = \'block\';
										close.style.display = \'block\';
										$(frame).animate({height: vheight, width: vwidth}, { duration: 400, easing: \'swing\', queue: false });
										$(title).animate({width: vwidth}, { duration: 400, easing: \'swing\', queue: false });
										if(html5){
											var time = src.split(\'#\')[1];
											src = src.split(\'#\')[0];
											frame.parentNode.parentNode.setAttribute(\'onclick\', \'\');
											frame.setAttribute("poster", image.src.replace(twidth, vwidth).replace(theight, vheight).slice(0, -7));
											if(audio){
												frame.innerHTML = \'<source src="\'+src+\'.oga" type="audio/ogg"><source src="\'+src+\'.mp3" type="audio/mpeg"><source src="\'+src+\'.webma" type="audio/webm"><source src="\'+src+\'.wav" type="audio/wav"><source src="\'+src+\'.m4a" type="audio/mp4">\';
											} else {
												frame.innerHTML = \'<source src="\'+src+\'.ogv" type="video/ogg"><source src="\'+src+\'.mp4" type="video/mp4"><source src="\'+src+\'.m4v" type="video/mp4"><source src="\'+src+\'.webm" type="video/webm">\';
											}
											frame.play();
											frame.addEventListener(\'loadedmetadata\', function load(event){
												frame.currentTime = time;
											}, false);
										} else {
											frame.src = src;
										}
									} else {
										close.style.display = \'none\';
										$(frame).animate({height: theight, width: twidth}, { duration: 0, easing: \'swing\', queue: false });
										title.style.width = twidth+\'px\';
										if(html5){
											frame.pause();
											var container = frame.parentNode;
											container.removeChild(frame);
											frame = document.createElement(\'video\');
											frame.setAttribute(\'id\', \'video_\'+vid);
											frame.setAttribute(\'controls\', \'controls\');
											frame.setAttribute(\'autoplay\', \'autoplay\');
											frame.setAttribute(\'style\', \'display: none; width: \'+twidth+\'px; height: \'+theight+\'px; display: none;\');
											container.parentNode.setAttribute("onclick", "displayvideo(\'"+vid+"\', \'"+src+"\', \'"+vwidth+"\', \'"+vheight+"\', \'"+twidth+"\', \'"+theight+"\', "+html5+", "+audio+")");
											container.insertBefore(frame, image);
										} else {
											frame.src = \'\';
										}
										frame.style.display = \'none\';
										image.style.display = \'block\';
									}
								}
							});
						</script>');
					}
				}
			}
			
			// display videos
			if ( $count ) {		  
				$video_content = '';
				$thumbnails    = '';
				$i = 1;
				$n = 1;

				foreach ($videos as $video) {
					$video = explode ('|', $video);
					if(!isset($video[1])) $video[1] = '';
					$video = array_map('trim', $video);
					$offset = explode ('#', $video[0]);
					$video[0] = trim($offset[0]);
					$video[0] = str_replace($videos_root, '', $video[0]);
					$video[4] = '';
					$videoinfo = pathinfo($video[0]);
					if(!isset($videoinfo['extension'])) $videoinfo['extension'] = 'ddd';
					$html5extensions = 'mp4,ogv,webm,m4v,oga,mp3,m4a,webma,wav';
					if(((strlen($video[0])>11)&(!is_numeric($video[0]))&($parametri['full_url']=='1'))&(strpos($html5extensions, $videoinfo['extension'])===false)){
						$coun_v = preg_match_all('/<a.*?>([^`]*?)<\/a>/', $video[0], $vvvvv);
						if($coun_v!=0) $video[0] = $vvvvv[1][0];
						if(strpos($video[0], 'youtube')!==false){
							$v_urls = explode ('?', $video[0]);
							$v_urls = explode ('#', $v_urls[1]);
							$v_urls = explode ('&', $v_urls[0]);
							foreach($v_urls as $v_url){
								if(($v_url{0}=='v')&($v_url{1}=='=')) $video[0] = substr($v_url, 2);
							}
						} else { 
							$v_urls = explode ('/', $video[0]);
							$v_urls = explode ('#', $v_urls[1]);
							$v_urls = explode ('&', $v_urls[0]);
							$video[0] = $v_urls[0];
						}
					}
					if((is_numeric(str_replace(':', '', $offset[count($offset)-1])))&(count($offset)!=1)){
						$offset = explode (':', $offset[count($offset)-1]);
						switch (count($offset)){
							case 1:
								$video[4] = '#t='.$offset[0].'s';
								break;
							case 2:
								$video[4] = '#t='.$offset[0].'m'.$offset[1].'s';
								break;
							case 3:
								$video[4] = '#t='.$offset[0].'h'.$offset[1].'m'.$offset[2].'s';
								break;
						}
					}
					$video[5] = false;
					$video[6] = 'true';
					$video[7] = '';
					$video[8] = '';
					$video[9] = JURI::root();
					if(strpos($html5extensions, $videoinfo['extension'])!==false){
						$video[5] = true;
						if (strpos('mp4,ogv,webm,m4v', $videoinfo['extension'])!==false) $video[6] = 'false';
						if (($count == 1)&($parametri['box']!=1)) {
							$video[0] = $videoinfo['dirname'].'/'.$videoinfo['filename'];
							$video[7] = '.'.$videoinfo['extension'];
							$video[4] = 0;
							foreach($offset as $offset1){
								$video[4] = $video[4]*60+$offset1;
							}
						}
						if ($parametri['lightbox']=='0') {
							$video[0] = $videoinfo['dirname'].'/'.$videoinfo['filename'];
							$video[7] = '.'.$videoinfo['extension'];
							$video[4] = 0;
							foreach($offset as $offset1){
								$video[4] = $video[4]*60+$offset1;
							}
							$video[4] = '#'.$video[4];
						}
						if(substr($video[0], 0, 4)!='http'){
							$video[8] = JPATH_BASE;
							if($video[0]{0}!='/') $video[0] = '/'.$video[0];
						}
					}
					if (($count == 1)&($parametri['box']!=1)) {
						$video_content .= $this->_videoCode($video, $parametri, $co, $parametri['width'], $parametri['height'], $n);
						$n++;
					}else{
						if($parametri['box']!=1){
							if(($n>$start)&($n<=($start+$parametri['pages']))){
								if($i==($parametri['break']+1)){
									$i = 1;
									$thumbnails .= '</ul><ul class="video">';
								}
								$thumbnails .= ' ' . $this->_videoThumb($video, $parametri, $co, $parametri['t_width'], $parametri['t_height'], $parametri['width'], $parametri['height'], $n) . ' ';
								$i++;
							}
							$n++;
						}else{
							if($n==1) $thumbnails .= ' ' . $this->_videoBox($video, $parametri, $co, $parametri['t_width'], $parametri['t_height'], $parametri['width'], $parametri['height'], $n) . ' ';
							$i++;
							$n++;
						}
					}
				}
				
				if(($count != 1)){
					$article->text = preg_replace( $regex, $video_content . '<div style="display: table; '.$parametri['style'].'" class="'.$parametri['class'].'"><ul class="video">' . $thumbnails . '</ul></div>'.$pagination, $article->text, 1);
				}else{
					$article->text = preg_replace( $regex, $video_content . '' . $thumbnails . '', $article->text, 1);
				}
			}
		}
		$url1->setQuery($org_params);
		return true;
	}
	
	protected function _videoCode( $video, $params, $i, $v_width, $v_height, $n ) {
		if($video[5]){
			$html  = '<div style="'.$params['style'].'" class="videoFrame '.$params['class'].'">
			<video controls="controls" width="'.$v_width.'" height="'.$v_height.'" poster="'.$video[9].'/plugins/content/videobox/showthumb.php?img='.rawurlencode($video[8].$video[0].$video[7]).'&width='.$v_width.'&height='.$v_height.'" style="display: block; background: #000;" id="video_'.$i.'_'.$n.'" >';
			if(strpos($video[0], 'http')!==0) $video[0] = $video[9].$video[0];
			if($video[6]=='true'){
				$html .='<source src="'.$video[0].'.oga" type="audio/ogg">
				<source src="'.$video[0].'.mp3" type="audio/mpeg">
				<source src="'.$video[0].'.wav" type="audio/wav">
				<source src="'.$video[0].'.m4a" type="audio/mp4">
				<source src="'.$video[0].'.webma" type="audio/webm">';
			} else {
				$html .='<source src="'.$video[0].'.webm" type="video/webm">
				<source src="'.$video[0].'.ogv" type="video/ogg">
				<source src="'.$video[0].'.mp4" type="video/mp4">
				<source src="'.$video[0].'.m4v" type="video/mp4">';
			}
			$html .= '</video><script type="text/javascript">
				document.getElementById(\'video_'.$i.'_'.$n.'\').addEventListener(\'loadedmetadata\', function load(event){
				document.getElementById(\'video_'.$i.'_'.$n.'\').currentTime = '.$video[4].';
			}, false);
			</script></div>';
		} else {
			if(!is_numeric($video[0])) {
				$src = 'http://www.youtube.com/embed/' . $video[0] . '?wmode=transparent&rel=0'.$video[4];
			} else {
				$src = 'http://player.vimeo.com/video/'.$video[0].$video[4];
			}
			$html  = '<div style="'.$params['style'].'" class="videoFrame '.$params['class'].'"><iframe width="'.$v_width.'" height="'.$v_height.'" src="'.$src.'" frameborder="0" allowfullscreen="1" style="display: block; background: #000;"></iframe></div>';
		}
		return $html;
	}

	protected function _videoThumb( $video, $params, $i, $t_width, $t_height, $v_width, $v_height, $n ) {
		if($video[5]){
			$src = $video[0].$video[4];
			if(strpos($src, 'http')!==0) $src = $video[9].$src;
		} elseif(!is_numeric($video[0])) {
			$src = 'http://www.youtube.com/embed/'.$video[0].'?wmode=transparent&rel=0&autoplay=1'.$video[4];
		} else {
			$src = 'http://player.vimeo.com/video/'.$video[0].'?autoplay=1'.$video[4];
		}
		$play = '&play=0';
		if($params['play']=='1') $play = '&play=1';
		$img = $video[9].'/plugins/content/videobox/showthumb.php?img='.rawurlencode($video[8].$video[0].$video[7]).'&width='.$t_width.'&height='.$t_height.$play;
		if($params['lightbox']=='0'){
			if($video[5]){
				$thumb  = '<li class="video_cont_0"><a class="video_close" onclick="displayvideo(\''.$i.'_'.$n.'\',\''.$src.'\',\''.$t_width.'\',\''.$t_height.'\',\''.$t_width.'\',\''.$t_height.'\', true, '.$video[6].')" id="close_'.$i.'_'.$n.'"></a><a onclick="displayvideo(\''.$i.'_'.$n.'\',\''.$src.'\',\''.$t_width.'\',\''.$t_height.'\',\''.$t_width.'\',\''.$t_height.'\', true, '.$video[6].')" ><span class="video_thumb"><video controls="controls" autoplay="autoplay" id="video_'.$i.'_'.$n.'" style="width: '.$t_width.'px; height: '.$t_height.'px; display: none;"></video><img src="'.$img.'" id="thumb_'.$i.'_'.$n.'"></span><span class="video_title" id="title_'.$i.'_'.$n.'" style="width: '.$t_width.'px;" >' . $video[1] . '</span></a></li>';
			} else {
				$thumb  = '<li class="video_cont_0"><a class="video_close" onclick="displayvideo(\''.$i.'_'.$n.'\',\''.$src.'\',\''.$t_width.'\',\''.$t_height.'\',\''.$t_width.'\',\''.$t_height.'\', false, true)" id="close_'.$i.'_'.$n.'"></a><a onclick="displayvideo(\''.$i.'_'.$n.'\',\''.$src.'\',\''.$t_width.'\',\''.$t_height.'\',\''.$t_width.'\',\''.$t_height.'\', false, true)" ><span class="video_thumb"><iframe allowfullscreen="1" id="video_'.$i.'_'.$n.'" style="width: '.$t_width.'px; height: '.$t_height.'px; display: none;"></iframe><img src="'.$img.'" id="thumb_'.$i.'_'.$n.'"></span><span class="video_title" id="title_'.$i.'_'.$n.'" style="width: '.$t_width.'px;" >' . $video[1] . '</span></a></li>';
			}
		} else {
			$thumb  = '<li class="video_cont_0"><a href="'.$src.'" rel="videobox.sig'.$i.'" title="' . $video[1] . '" videowidth="'.$v_width.'" videoheight="'.$v_height.'"><span class="video_thumb"><img src="'.$img.'" id="thumb_'.$i.'_'.$n.'"></span><span class="video_title" style="width: '.$t_width.'px;" >' . $video[1] . '</span></a></li>';
		}
		return $thumb;
	}
	
	protected function _videoBox( $video, $params, $i, $t_width, $t_height, $v_width, $v_height, $n ) {
		if($video[5]){
			$src = $video[0].$video[4];
			if(strpos($src, 'http')!==0) $src = $video[9].$src;
		} elseif(!is_numeric($video[0])) {
			$src = 'http://www.youtube.com/embed/' . $video[0] . '?wmode=transparent&rel=0&autoplay=1'.$video[4];
		} else {
			$hash = unserialize(file_get_contents('http://vimeo.com/api/v2/video/'.$video[0].'.php'));
			$src = 'http://player.vimeo.com/video/'.$video[0].'?autoplay=1'.$video[4];
		}
		$play = '&play=0';
		if($params['play']=='1') $play = '&play=1';
		$img = $video[9].'/plugins/content/videobox/showthumb.php?img='.rawurlencode($video[8].$video[0].$video[7]).'&width='.$t_width.'&height='.$t_height.$play;
		if($params['lightbox']=='0'){
			if($video[5]){
				$thumb  = '<span class="video_box_0 '.$params['class'].'" style="'.$params['style'].'"><a class="video_close" onclick="displayvideo(\''.$i.'_'.$n.'\',\''.$src.'\',\''.$v_width.'\',\''.$v_height.'\',\''.$t_width.'\',\''.$t_height.'\', true, '.$video[6].')" id="close_'.$i.'_'.$n.'"></a><a onclick="displayvideo(\''.$i.'_'.$n.'\',\''.$src.'\',\''.$v_width.'\',\''.$v_height.'\',\''.$t_width.'\',\''.$t_height.'\', true, '.$video[6].')" ><span class="video_thumb"><video controls="controls" autoplay="autoplay" id="video_'.$i.'_'.$n.'" style="width: '.$t_width.'px; height: '.$t_height.'px; display: none;"></video><img src="'.$img.'" id="thumb_'.$i.'_'.$n.'"></span><span class="video_title" id="title_'.$i.'_'.$n.'" style="width: '.$t_width.'px;">' . $video[1] . '</span></a></span>';
			} else {
				$thumb  = '<span class="video_box_0 '.$params['class'].'" style="'.$params['style'].'"><a class="video_close" onclick="displayvideo(\''.$i.'_'.$n.'\',\''.$src.'\',\''.$v_width.'\',\''.$v_height.'\',\''.$t_width.'\',\''.$t_height.'\', false, true)" id="close_'.$i.'_'.$n.'"></a><a onclick="displayvideo(\''.$i.'_'.$n.'\',\''.$src.'\',\''.$v_width.'\',\''.$v_height.'\',\''.$t_width.'\',\''.$t_height.'\', false, true)" ><span class="video_thumb"><iframe allowfullscreen="1" id="video_'.$i.'_'.$n.'" style="width: '.$t_width.'px; height: '.$t_height.'px; display: none;"></iframe><img src="'.$img.'" id="thumb_'.$i.'_'.$n.'"></span><span class="video_title" id="title_'.$i.'_'.$n.'" style="width: '.$t_width.'px;">' . $video[1] . '</span></a></span>';
			}
		} else {
			$thumb  = '<span class="video_box_0 '.$params['class'].'" style="'.$params['style'].'"><a href="'.$src.'" rel="videobox.sib'.$i.'" title="' . $video[1] . '" videowidth="'.$v_width.'" videoheight="'.$v_height.'"><span class="video_thumb"><img src="'.$img.'" id="thumb_'.$i.'_'.$n.'"></span><span class="video_title" style="width: '.$t_width.'px;">' . $video[1] . '</span></a></span>';
		}
		return $thumb;
	}
}