<?php

namespace Hummingbird\Core\Api\Service;

use Hummingbird\Core\Api\Exception;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Cloudflare
 *
 * @package Hummingbird\Core\Api\Service\
 */
class Cloudflare extends Service {

	protected $name = 'cloudflare';

	/**
	 * Cloudflare constructor.
	 *
	 * @throws Exception  Exception.
	 */
	public function __construct() {
		$this->request = new \Hummingbird\Core\Api\Request\Cloudflare( $this );
	}

	public function set_auth_email( $email ) {
		$this->request->set_auth_email( $email );
	}

	public function set_auth_key( $key ) {
		$this->request->set_auth_key( $key );
	}

	public function get_zones_list( $page = 1, $per_page = 20 ) {
		return $this->request->get(
			'zones',
			array(
				'per_page' => $per_page,
				'page'     => $page,
			)
		);
	}

	public function get_page_rules_list( $zone ) {
		return $this->request->get( "zones/{$zone}/pagerules" );
	}

	public function add_page_rule( $targets, $actions, $zone, $status = 'active', $priority = null ) {
		$data = array(
			'targets'  => $targets,
			'actions'  => $actions,
			'priority' => $priority,
			'status'   => $status,
		);

		return $this->request->post( "zones/{$zone}/pagerules", json_encode( $data ) );
	}

	public function update_page_rule( $id, $targets, $actions, $zone, $status = 'active', $priority = null ) {
		$data = array(
			'targets'  => $targets,
			'actions'  => $actions,
			'priority' => $priority,
			'status'   => $status,
		);

		return $this->request->patch( "zones/{$zone}/pagerules/{$id}", json_encode( $data ) );
	}

	public function delete_page_rule( $id, $zone ) {
		return $this->request->delete( "zones/{$zone}/pagerules/{$id}" );
	}

	public function set_caching_expiration( $zone, $value ) {
		$data = array(
			'value' => $value,
		);
		return $this->request->patch( "zones/{$zone}/settings/browser_cache_ttl", json_encode( $data ) );
	}

	public function get_caching_expiration( $zone ) {
		return $this->request->get( "zones/{$zone}/settings/browser_cache_ttl" );
	}

	public function purge_cache( $zone ) {
		return $this->request->delete(
			"/zones/{$zone}/purge_cache",
			wp_json_encode(
				array(
					'purge_everything' => true,
				)
			)
		);
	}

}
