<?php

declare(strict_types=1);

namespace Sekiphp\Sales\Model;

use Magento\Sales\Api\Data\OrderInterface;
use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SearchResultsInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Sekiphp\Sales\Api\OrderLoader as OrderLoaderInterface;

class OrderLoader implements OrderLoaderInterface
{
    protected OrderRepositoryInterface $orderRepository;
    protected SearchCriteriaBuilder $searchCriteriaBuilder;

    /**
     * @param OrderRepositoryInterface $orderRepository
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     */
    public function __construct(
        OrderRepositoryInterface $orderRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder
    ) {
        $this->orderRepository = $orderRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }

    /**
     * @inheirtDoc
     */
    public function loadByIncrementId(string $incrementId, ?int $storeId = null): OrderInterface
    {
        $builder = $this->searchCriteriaBuilder
            ->addFilter('increment_id', $incrementId);

        if ($storeId !== null) {
            $builder->addFilter('store_id', $storeId);
        }

        $searchCriteria = $builder->create();
        $orderList = $this->orderRepository->getList($searchCriteria);

        return $this->getFirstItem($orderList);
    }

    /**
     * @param SearchResultsInterface $searchResult
     *
     * @return OrderInterface
     * @throws NoSuchEntityException
     */
    protected function getFirstItem(SearchResultsInterface $searchResult): OrderInterface
    {
        $items = $searchResult->getItems();

        if (count($items) === 0) {
            throw new NoSuchEntityException(__("The entity that was requested was not found."));
        }

        return reset($items);
    }

}
