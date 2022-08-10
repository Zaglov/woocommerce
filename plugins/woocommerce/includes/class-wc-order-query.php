<?php
/**
 * Parameter-based Order querying
 * Args and usage: https://github.com/woocommerce/woocommerce/wiki/wc_get_orders-and-WC_Order_Query
 *
 * @package WooCommerce\Classes
 * @version 3.1.0
 * @since   3.1.0
 */

use Automattic\WooCommerce\Caches\OrderCache;

defined( 'ABSPATH' ) || exit;

/**
 * Order query class.
 */
class WC_Order_Query extends WC_Object_Query {

	/**
	 * Valid query vars for orders.
	 *
	 * @return array
	 */
	protected function get_default_query_vars() {
		return array_merge(
			parent::get_default_query_vars(),
			array(
				'status'               => array_keys( wc_get_order_statuses() ),
				'type'                 => wc_get_order_types( 'view-orders' ),
				'currency'             => '',
				'version'              => '',
				'prices_include_tax'   => '',
				'date_created'         => '',
				'date_modified'        => '',
				'date_completed'       => '',
				'date_paid'            => '',
				'discount_total'       => '',
				'discount_tax'         => '',
				'shipping_total'       => '',
				'shipping_tax'         => '',
				'cart_tax'             => '',
				'total'                => '',
				'total_tax'            => '',
				'customer'             => '',
				'customer_id'          => '',
				'order_key'            => '',
				'billing_first_name'   => '',
				'billing_last_name'    => '',
				'billing_company'      => '',
				'billing_address_1'    => '',
				'billing_address_2'    => '',
				'billing_city'         => '',
				'billing_state'        => '',
				'billing_postcode'     => '',
				'billing_country'      => '',
				'billing_email'        => '',
				'billing_phone'        => '',
				'shipping_first_name'  => '',
				'shipping_last_name'   => '',
				'shipping_company'     => '',
				'shipping_address_1'   => '',
				'shipping_address_2'   => '',
				'shipping_city'        => '',
				'shipping_state'       => '',
				'shipping_postcode'    => '',
				'shipping_country'     => '',
				'shipping_phone'       => '',
				'payment_method'       => '',
				'payment_method_title' => '',
				'transaction_id'       => '',
				'customer_ip_address'  => '',
				'customer_user_agent'  => '',
				'created_via'          => '',
				'customer_note'        => '',
			)
		);
	}

	/**
	 * Get orders matching the current query vars.
	 *
	 * @return array|object of WC_Order objects
	 *
	 * @throws Exception When WC_Data_Store validation fails.
	 */
	public function get_orders() {
		$args    = apply_filters( 'woocommerce_order_query_args', $this->get_query_vars() );
		$results = WC_Data_Store::load( 'order' )->query( $args );
		$results = apply_filters( 'woocommerce_order_query', $results, $args );

		if(OrderUtil::custom_orders_table_usage_is_enabled()) {
			$order_cache = wc_get_container()->get(OrderCache::class);
			foreach($results as $order) {
				$order_cache->set($order);
			}
		}

		return $results;
	}
}
