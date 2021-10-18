<?php

declare(strict_types=1);
/*
 * (c) VisualSearch GmbH <office@visualsearch.at>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with the source code.
 */

namespace Vis\RecommendSimilarProducts\Util;

use Shopware\Core\Framework\DataAbstractionLayer\EntityRepositoryInterface;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;

class SwHosts
{
    /**
     * @var salesChannelRepository
     */
    private $salesChannelRepository;

    public function __construct(EntityRepositoryInterface $salesChannelRepository)
    {
        $this->salesChannelRepository = $salesChannelRepository;
    }

    // retrieve all sw hosts
    public function getLocalHosts(): string
    {
        $systemHosts = [];

        $criteria = new Criteria();
        $criteria->addAssociation('domains');

        $salesChannelIds = $this->salesChannelRepository->search(
            $criteria,
            \Shopware\Core\Framework\Context::createDefaultContext()
        );

        foreach ($salesChannelIds->getEntities()->getElements() as $key =>$salesChannel) {
            foreach ($salesChannel->getDomains()->getElements() as $element) {
                array_push($systemHosts, $element->getUrl());
            }
        }
        return implode(";", $systemHosts);
    }
}
