<?php

namespace Vis\RecommendSimilarProducts\Core\Content\VisSoldClickedProducts;

use DateTimeInterface;
use Shopware\Core\Content\Product\ProductEntity;
use Shopware\Core\Framework\DataAbstractionLayer\Entity;
use Shopware\Core\Framework\DataAbstractionLayer\EntityIdTrait;

class VisSoldClickedProductsEntity extends Entity
{
    use EntityIdTrait;

    /**
     * @var int
     */
    protected $numberClick;

    /**
     * @var int
     */
    protected $numberSold;

    /**
     * @var float
     */
    protected $totalAmount;

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
     * @return int
     */
    public function getNumberSold(): int
    {
        return $this->numberSold;
    }

    /**
     * @param int $numberSold
     */
    public function setNumberSold(int $numberSold): void
    {
        $this->numberSold = $numberSold;
    }

    /**
     * @return float
     */
    public function getTotalAmount(): float
    {
        return $this->totalAmount;
    }

    /**
     * @param float $totalAmount
     */
    public function setTotalAmount(float $totalAmount): void
    {
        $this->totalAmount = $totalAmount;
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
