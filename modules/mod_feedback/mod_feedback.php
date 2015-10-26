<?php defined( '_JEXEC' ) or die( 'Restricted access' );

if(isset($_POST['mod_feedback_submitted']))
{
	$name = isset($_POST['feedback_name']) ? $_POST['feedback_name'] : 'Не указано' ;
	$phone = isset($_POST['feedback_phone']) ? $_POST['feedback_phone'] : 'Не указано' ;
	$adress = isset($_POST['feedback_adress']) ? $_POST['feedback_adress'] : 'Не указано' ;
	
	$name = strip_tags($name); 
	$phone = strip_tags($phone); 
	$adress = strip_tags($adress); 
	
	$message = "<h2>Сообщение с сайта: $params[title]</h2>" ;
	$message .= "<p>Имя: $name" ;
	$message .= "<p>Телефон: $phone" ;
	$message .= "<p>Адрес: $adress" ;
	
	$headers= "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
	
	@mail($params['email'], $params['title'], $message, $headers) ;

    require( JModuleHelper::getLayoutPath( 'mod_feedback', "success" ) );
}
else
{
    require( JModuleHelper::getLayoutPath( 'mod_feedback' ) );    
}