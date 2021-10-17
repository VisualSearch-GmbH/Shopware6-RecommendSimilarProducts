<?php

namespace Vis\RecommendSimilarProducts\Core\Content\VisClickedProducts;

use DateTimeInterface;
use Shopware\Core\Framework\DataAbstractionLayer\Entity;
use Shopware\Core\Framework\DataAbstractionLayer\EntityIdTrait;

class VisClickedProductsEntity extends Entity
{
    use EntityIdTrait;

    /**
     * @var DateTimeInterface
     */
    protected $date;

    /**
     * @return DateTimeInterface
     */
    public function getDate(): DateTimeInterface
    {
        return $this->date;
    }

    /**
     * @param DateTimeInterface $date
     */
    public function setDate(DateTimeInterface $date): void
    {
        $this->date = $date;
    }
}
