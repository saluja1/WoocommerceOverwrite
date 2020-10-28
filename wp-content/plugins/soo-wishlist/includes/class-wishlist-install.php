<?php
/**
 * Installation actions
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Soo_Wishlist_Install
 */
class Soo_Wishlist_Install {
	/**
	 * Creates tables and the wishlist page.
	 */
	public static function install() {
		self::add_tables();
		self::add_pages();

		update_option( 'soo_wishlist_version', SOOW_VERSION );
		update_option( 'soo_wishlist_db_version', SOOW_DB_VERSION );
		add_action( 'init', 'flush_rewrite_rules' );
	}

	/**
	 * Add tables for a fresh installation
	 */
	private static function add_tables() {
		global $wpdb;

		$wpdb->hide_errors();

		require_once ABSPATH . 'wp-admin/includes/upgrade.php';

		dbDelta( self::get_schema() );

		// Recreate if table is not exists.
		if ( ! $wpdb->get_var( "SHOW TABLES LIKE '{$wpdb->prefix}soo_wishlists';" ) ) {
			dbDelta( self::get_schema( false ) );
		}
	}

	/**
	 * Get table schema.
	 *
	 * @param  bool $auto
	 * @return string
	 */
	private static function get_schema( $auto_collate = true ) {
		global $wpdb;

		$collate = '';

		if ( $auto_collate === false ) {
			$collate = 'DEFAULT CHARSET=utf8 AUTO_INCREMENT=1';
		} elseif ( is_string( $auto_collate ) ) {
			$collate = $auto_collate;
		} elseif ( $wpdb->has_cap( 'collation' ) ) {
			$collate = $wpdb->get_charset_collate();
		}

		$sql = "
CREATE TABLE {$wpdb->prefix}soo_wishlists (
  ID BIGINT(20) NOT NULL AUTO_INCREMENT,
  title TEXT,
  slug VARCHAR(200) NOT NULL,
  status VARCHAR(20) NOT NULL DEFAULT 'private',
  user_id BIGINT(20) NULL DEFAULT NULL,
  hash VARCHAR(64) NOT NULL,
  created_date DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
  updated_date DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
  is_default TINYINT(1) NOT NULL DEFAULT 0,
  PRIMARY KEY  (ID),
  KEY (slug)
) $collate;
CREATE TABLE {$wpdb->prefix}soo_wishlists_items (
  ID BIGINT(20) NOT NULL AUTO_INCREMENT,
  product_id BIGINT UNSIGNED NOT NULL,
  quantity INT(11) NULL,
  user_id BIGINT(20) NOT NULL,
  wishlist_id BIGINT(20) NOT NULL,
  added_date DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY  (ID),
  KEY (product_id)
) $collate;
		";

		return $sql;
	}

	/**
	 * Add "Wishlist" page
	 */
	private static function add_pages() {
		wc_create_page(
			sanitize_title_with_dashes( _x( 'wishlist', 'page_slug', 'soow' ) ),
			'soo_wishlist_page_id',
			__( 'Wishlist', 'soow' ),
			'<!-- wp:shortcode -->[soo_wishlist]<!-- /wp:shortcode -->'
		);
	}
}