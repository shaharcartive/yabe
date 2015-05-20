<?php
/**
* Plugin Name: username based on their emails prefix
* Plugin URI: http://cozmoslabs.com
* Description: Crea el nombre del usuario con la primera parte del email
* Version: 1.0
* Author: Cozmoslabs
* Author URI: http://cozmoslabs.com
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

add_filter('wppb_generated_random_username', 'wppbc_rand_username', 10, 2);
function wppbc_rand_username( $username, $user_email ){
	$username = explode('@', $user_email);
	$username = $username[0];
	$j = 1;
	while ( username_exists( $username ) ){
		$username = $username . '_' . $j;
		$j++;
	}
	return $username;
}
?>