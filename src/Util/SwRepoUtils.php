<?php declare(strict_types=1);
/*
 * (c) VisualSearch GmbH <office@visualsearch.at>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with the source code.
 */

namespace Vis\RecommendSimilarProducts\Util;

use Shopware\Core\Framework\DataAbstractionLayer\EntityRepositoryInterface;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Symfony\Component\HttpFoundation\JsonResponse;

class SwRepoUtils
{
    // get first category without cross-selling
    public function getFirstCategory(EntityRepositoryInterface $productRepository, $name): string
    {
        // Search criteria
        $criteria = new Criteria();
        $criteria->addAssociation('crossSellings');

        // Search in repository
        $products = $productRepository->search(
            $criteria,
            \Shopware\Core\Framework\Context::createDefaultContext()
        );

        $category = "";
        $productEntities = $products->getEntities()->getElements();

        // Find first category with no cross-selling
        foreach($productEntities as $key => $productEntity){
            if(!empty($productEntity->getName())){
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

    public function searchProducts(
        EntityRepositoryInterface $productRepository,
        Criteria $criteria): array
    {
        $products = $productRepository->search(
            $criteria,
            \Shopware\Core\Framework\Context::createDefaultContext()
        );

        $productEntities = $products->getEntities()->getElements();

        if(empty($productEntities)){
            return new JsonResponse(["code"=> 200, "message" => "Info VisRecommendSimilarProducts: no product entities"]);
        }

        $products = [];

        // Get all products
        foreach($productEntities as $key => $productEntity){
            if(!empty($productEntity->getName())){
                if($productEntity->getCover()){
                    array_push($products, [$key, $productEntity->getName(), $productEntity->getCategoryTree(), $productEntity->getCover()->getMedia()->getUrl()]);
                }else{
                    array_push($products, [$key, $productEntity->getName(), $productEntity->getCategoryTree()]);
                }
            }
        }

        return $products;
    }
}