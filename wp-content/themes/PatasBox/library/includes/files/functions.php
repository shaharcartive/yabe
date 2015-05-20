<?php 
function c5_get_width_class() {
	return 'c5-main-width-wrap';
}
function c5_get_width_class_option($option) {
	
	return 'c5-main-width-wrap';
}

function c5_get_header_width_class() {
	
	return 'c5-main-width-wrap';
}

function c5_get_page_width() {
	global $c5_skindata;
	
	$device = new C5AB_Mobile_Detect();
	if( $device->isTablet() ){
	
		$GLOBALS['c5_content_width'] = 645;
		return;
	}
	
	if( $device->isMobile() && !$device->isTablet() ){
		$GLOBALS['c5_content_width'] = 300;
		return;
	}
	
	switch ($c5_skindata['page_width']) {
		case 'full':
			return 1070;
			break;
		default:
			return 740;
			break;
	}
}

function c5_check_mobile_width() {
	$device = new C5AB_Mobile_Detect();
	if( $device->isTablet() ){
	
		$GLOBALS['c5_content_width'] = 645;
		return;
	}
	
	if( $device->isMobile() && !$device->isTablet() ){
		$GLOBALS['c5_content_width'] = 300;
		return;
	}
}

 ?>