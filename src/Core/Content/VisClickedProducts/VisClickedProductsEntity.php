<?php

namespace Vis\RecommendSimilarProducts\Core\Content\VisClickedProducts;

use DateTimeInterface;
use Shopware\Core\Content\Product\ProductEntity;
use Shopware\Core\Framework\DataAbstractionLayer\Entity;
use Shopware\Core\Framework\DataAbstractionLayer\EntityIdTrait;

class VisClickedProductsEntity extends Entity
{
    use EntityIdTrait;

    /**
     * @var string|null
     */
    protected $productId;

    /**
     * @var ProductEntity|null
     */
    protected $product;

    /**
     * @var int
     */
    protected $numberClick;

    /**
     * @var DateTimeInterface
     */
    protected $date;

    /**
     * @return string|null
     */
    public function getProductId(): ?string
    {
        return $this->productId;
    }

    /**
     * @param string|null $productId
     */
    public function setProductId(?string $productId): void
    {
        $this->productId = $productId;
    }

    /**
     * @return ProductEntity|null
     */
    public function getProduct(): ?ProductEntity
    {
        return $this->product;
    }

    /**
     * @param ProductEntity|null $product
     */
    public function setProduct(?ProductEntity $product): void
    {
        $this->product = $product;
    }

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
