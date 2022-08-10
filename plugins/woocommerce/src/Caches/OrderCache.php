<?php

namespace Automattic\WooCommerce\Caches;

use Automattic\WooCommerce\Caching\ObjectCache;

class OrderCache extends ObjectCache
{

	public function get_object_type(): string
	{
		return 'order';
	}

	protected function get_object_id( $object ) {
		return $object->get_id();
	}

	protected function validate( $object ): ?array {
		if(!$object instanceof \WC_Abstract_Legacy_Order) {
			return ['The supplied order is not an instance of WC_Order'];
		}

		return null;
	}
}
