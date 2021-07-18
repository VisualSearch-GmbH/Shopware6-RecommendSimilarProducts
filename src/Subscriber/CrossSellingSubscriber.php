<?php

namespace Vis\RecommendSimilarProducts\Subscriber;

use Shopware\Core\Content\Product\Events\ProductCrossSellingCriteriaEvent;
use Shopware\Core\Content\Product\Events\ProductCrossSellingsLoadedEvent;
use Shopware\Core\Content\Product\Events\ProductListingCriteriaEvent;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepositoryInterface;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\Uuid\Uuid;
use Shopware\Core\System\SystemConfig\SystemConfigService;
use Shopware\Storefront\Page\Product\ProductPageLoadedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Vis\RecommendSimilarProducts\Core\Content\VisClickedProducts\VisClickedProductsEntity;

class CrossSellingSubscriber implements EventSubscriberInterface
{
    /**
     * @var SystemConfigService
     */
    private $systemConfigService;

    /**
     * @var EntityRepositoryInterface
     */
    private $visSoldClickedRepository;

    public function __construct(SystemConfigService $systemConfigService, EntityRepositoryInterface $visSoldClickedRepository)
    {
        $this->systemConfigService = $systemConfigService;
        $this->visSoldClickedRepository = $visSoldClickedRepository;
    }

    public static function getSubscribedEvents()
    {
        return [
            ProductPageLoadedEvent::class => 'productLoaded'
        ];
    }

    public function productLoaded(ProductPageLoadedEvent $event)
    {
        $visSearchName = $this->systemConfigService->get('VisRecommendSimilarProducts.config.cross');

        if ($visSearchName == urldecode($_SERVER['QUERY_STRING'])) {
            $criteria = new Criteria();
            $visClickedProducts = $this->visSoldClickedRepository->search($criteria, Context::createDefaultContext())->getElements();

            $logExist = false;

            /** @var VisClickedProductsEntity $visClickedProduct */
            foreach ($visClickedProducts as $visClickedProduct) {
                $dateCreated = $visClickedProduct->getCreatedAt();
                $now = new \DateTimeImmutable();
                if ($dateCreated->format('Y-m-d') == $now->format('Y-m-d')) {
                    $visClickedProductObject = [
                      'id' => $visClickedProduct->getId(),
                      'numberClick' => $visClickedProduct->getNumberClick() + 1
                    ];
                    $this->visSoldClickedRepository->upsert([$visClickedProductObject], Context::createDefaultContext());
                    $logExist = true;
                    break;
                }
            }

            if(!$logExist) {
                $now = new \DateTimeImmutable();
                $visClickedProductObject = [
                    'id' => Uuid::randomHex(),
                    'numberClick' => 1,
                    'date' => $now
                ];
                $this->visSoldClickedRepository->create([$visClickedProductObject], Context::createDefaultContext());
            }

            $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
            $url = strtok($actual_link, '?');
            header('Location: ' . $url);
        }
    }
}
