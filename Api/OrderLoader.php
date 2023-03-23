<?php

declare(strict_types=1);

namespace Sekiphp\Sales\Api;

use Magento\Sales\Api\Data\OrderInterface;

// TODO move to separate API module
/**
 * @api
 */
interface OrderLoader
{
    /**
     * @param string $incrementId
     * @param int|null $storeId NULL -> Skip storeId from query
     *
     * @return OrderInterface
     */
    public function loadByIncrementId(string $incrementId, ?int $storeId = null): OrderInterface;

}
