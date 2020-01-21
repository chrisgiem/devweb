<?php

namespace Hummingbird\Core\Api\Request;

use Hummingbird\Core\Api\Exception;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Cloudflare
 *
 * @package Hummingbird\Core\Api\Request
 */
class Cloudflare extends Request {

	private $auth_email = '';
	private $auth_key   = '';
	private $zone       = '';

	public function get_api_key() {
		return '';
	}

	public function get_api_url( $path = '' ) {
		$url = 'https://api.cloudflare.com/client/v4/' . $path;
		return str_replace( '%ZONE%', $this->zone, $url );
	}

	protected function sign_request() {
		$this->add_header_argument( 'X-Auth-Key', $this->auth_key );
		$this->add_header_argument( 'X-Auth-Email', $this->auth_email );
	}

	public function set_zone( $zone ) {
		$this->zone = $zone;
	}

	public function set_auth_email( $email ) {
		$this->auth_email = $email;
	}

	public function set_auth_key( $key ) {
		$this->auth_key = $key;
	}

	/**
	 * @inheritdoc
	 */
	public function request( $path, $data = array(), $method = 'post' ) {
		$this->add_header_argument( 'Content-Type', 'application/json' );

		$response = parent::request( $path, $data, $method );

		if ( is_wp_error( $response ) ) {
			throw new Exception( $response->get_error_message(), $response->get_error_code() );
		}

		$code = wp_remote_retrieve_response_code( $response );
		$body = wp_remote_retrieve_body( $response );
		$body = json_decode( $body );
		if ( $body && 200 != $code ) {
			/* translators: %s: cloudflare error */
			throw new Exception( sprintf( __( 'Cloudflare error: %s', 'wphb' ), $body->errors[0]->message ), $code );
		} elseif ( false === $body ) {
			throw new Exception( __( 'Cloudflare unknown error', 'wphb' ), $code );
		}

		return $body;

	}

}
