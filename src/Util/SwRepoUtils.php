<?php declare(strict_types=1);
/*
 * (c) VisualSearch GmbH <office@visualsearch.at>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with the source code.
 */

namespace Vis\RecommendSimilarProducts\Util;

use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepositoryInterface;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;

class SwRepoUtils
{
    // delete cross-sellings
    public function deleteCrossSellings(EntityRepositoryInterface $repository, $name)
    {
        // Search criteria
        $criteria = new Criteria();
        $criteria->addAssociation('crossSellingsTranslation');

        // Search in repository
        $products = $repository->search($criteria, \Shopware\Core\Framework\Context::createDefaultContext());

        $productEntities = $products->getEntities()->getElements();

        // For each product in input json
        foreach($productEntities as $key => $productEntity){
            if (strcmp($productEntity->getName(),$name) == 0) {
                $repository->delete([['id' => $key]], Context::createDefaultContext());
            }
        }
    }

    // get configuration cross-selling name
    public function getCrossSellingName(EntityRepositoryInterface $repository) : string
    {
        $criteria = new Criteria();
        $criteria->addFilter(new EqualsFilter('configurationKey', "VisRecommendSimilarProducts.config.cross"));

        $config = $repository->search($criteria, \Shopware\Core\Framework\Context::createDefaultContext());

        // loop through results
        foreach($config->getEntities()->getElements() as $key => $productEntity) {
            // return first found configuration value
            return $productEntity->getConfigurationValue();
        }
        return '';
    }

    // get first category without cross-selling
    public function getFirstCategory(EntityRepositoryInterface $repository, $name): string
    {
        // Search criteria
        $criteria = new Criteria();
        $criteria->addAssociation('cover');
        $criteria->addAssociation('crossSellings');

        // Search in repository
        $products = $repository->search($criteria, \Shopware\Core\Framework\Context::createDefaultContext());

        $category = "";
        $productEntities = $products->getEntities()->getElements();

        // Find first category with no cross-selling
        foreach($productEntities as $key => $productEntity){
            $categories = $productEntity->getCategoryTree();
            if((!empty($productEntity->getName())) && ($productEntity->getCover()) && (count($categories) > 1)){
                $perform = true;
                if(empty($productEntity->getCrossSellings())){
                    $perform = true;
                }else{
                    foreach($productEntity->getCrossSellings()->getElements() as $key => $CrossSelling){
                        if($CrossSelling->getName() == $name){
                            $perform = false;
                        }
                    }
                }
                if($perform){
                    // $categoryTree = json_encode($productEntity->getCategoryTree());
                    $categoryTree = $productEntity->getCategoryTree();
                    $category = $categoryTree[sizeof($categoryTree)-1];
                    break;
                }
            }
        }
        return $category;
    }

    public function searchProducts(EntityRepositoryInterface $repository, Criteria $criteria): array
    {
        $productsSearch = $repository->search($criteria, \Shopware\Core\Framework\Context::createDefaultContext());

        $productEntities = $productsSearch->getEntities()->getElements();

        $products = [];
        if(empty($productEntities)){
            return $products;
        }

        // Get all products
        foreach($productEntities as $key => $productEntity){
            $categories = $productEntity->getCategoryTree();
            if((!empty($productEntity->getName())) && ($productEntity->getCover()) && (count($categories) > 1)){
                array_push($products, [$key, $productEntity->getName(), $productEntity->getCategoryTree(), $productEntity->getCover()->getMedia()->getUrl()]);
            }
        }

        return $products;
    }
}