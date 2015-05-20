<?php
/**
* Plugin Name: Tamaño de subida Avatar
* Plugin URI: http://fomento20.com
* Description: Limita el tamaño de subida del archivo del Avatar.
* Version: 1.0
* Author: Mlastra
* Author URI: http://fomento20.com
* License: GPL2
*/
/* Copyright YEAR PLUGIN_AUTHOR_NAME (email : PLUGIN AUTHOR EMAIL)
This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as
published by the Free Software Foundation.
This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
*/
// Start writing code after this line!

add_filter('wppb_server_max_upload_size_byte_constant', 'wppbc_change_max_upload_size_byte');
function wppbc_change_max_upload_size_byte(){
	return wppb_return_bytes('1M');
}
add_filter('wppb_server_max_upload_size_mega_constant', 'wppbc_change_max_upload_size_mega');
function wppbc_change_max_upload_size_mega(){
	return '1M';
}
?>