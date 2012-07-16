<?php
/*
Plugin Name: Multisite Admin Bar Tweaks
Plugin URI: 
Author: dpe415
Author URI: http://dpedesign.com
Version: 1.0
Description: Adds several useful links to the multisite "Network Admin" admin bar.  Current links added are: "Plugins" and "Install Plugin".
License: GPL2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

/*  Copyright 2012  David Paul Ellenwood  (email : david@dpedesign.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

// Block direct requests
if( !defined('ABSPATH') )
	die('-1');

// Admin Bar Customisation
function multisite_adminbar_tweaks() {
	global $wp_admin_bar;

	// Don't show for logged out users or single site mode.
	if ( ! is_user_logged_in() || ! is_multisite() )
		return;

	// Show only when the user has at least one site, or they're a super admin.
	if ( count( $wp_admin_bar->user->blogs ) < 1 && ! is_super_admin() )
		return;
		
	// First, remove a couple network menu items so we can place plugins before them
	$wp_admin_bar->remove_node('network-admin-u');  // Network Admin > Users
	$wp_admin_bar->remove_node('network-admin-v');	// Network Admin > Visit Network

	// Add a link to the Network > Plugins page.
	$wp_admin_bar->add_node( array(
		'parent' => 'network-admin',
		'id'     => 'network-admin-p',
		'title'  => __( 'Plugins' ),
		'href'   => network_admin_url( 'plugins.php' ),
	) );
	
	// Add a link to the Network > Add New Plugin page.
	$wp_admin_bar->add_node( array(
		'parent' => 'network-admin',
		'id'     => 'network-admin-pi',
		'title'  => __( 'Install Plugin' ),
		'href'   => network_admin_url( 'plugin-install.php' ),
	) );
	
	// Re-add the Users link after Plugins
	$wp_admin_bar->add_node( array(
		'parent' => 'network-admin',
		'id'     => 'network-admin-u',
		'title'  => __( 'Users' ),
		'href'   => network_admin_url( 'users.php' ),
	) );
	
	// Re-add the Visit Network link at the very end.
	$wp_admin_bar->add_node( array(
		'parent' => 'network-admin',
		'id'     => 'network-admin-v',
		'title'  => __( 'Visit Network' ),
		'href'   => network_home_url(),
	) );	
	
}
add_action( 'wp_before_admin_bar_render', 'multisite_adminbar_tweaks' );

?>