<?php

namespace Vis\RecommendSimilarProducts\Core\Content\VisClickedProducts;

use DateTimeInterface;
use Shopware\Core\Framework\DataAbstractionLayer\Entity;
use Shopware\Core\Framework\DataAbstractionLayer\EntityIdTrait;

class VisClickedProductsEntity extends Entity
{
    use EntityIdTrait;

    /**
     * @var int
     */
    protected $numberClick;

    /**
     * @var DateTimeInterface
     */
    protected $date;


    /**
     * @return int
     */
    public function getNumberClick(): int
    {
        return $this->numberClick;
    }

    /**
     * @param int $numberClick
     */
    public function setNumberClick(int $numberClick): void
    {
        $this->numberClick = $numberClick;
    }

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
