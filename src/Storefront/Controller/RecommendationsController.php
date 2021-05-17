<?php declare(strict_types=1);
/*
 * (c) VisualSearch GmbH <office@visualsearch.at>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with the source code.
 */

namespace Vis\RecommendSimilarProducts\Storefront\Controller;

use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Sorting\FieldSorting;
use Shopware\Core\Framework\Routing\Annotation\RouteScope;
use Shopware\Core\Framework\Uuid\Uuid;
use Shopware\Core\System\SalesChannel\SalesChannelContext;
use Shopware\Core\System\SystemConfig\SystemConfigService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Vis\RecommendSimilarProducts\Util\ApiRequest;
use Vis\RecommendSimilarProducts\Util\SwHosts;
use Vis\RecommendSimilarProducts\Util\SwRepoUtils;

class RecommendationsController extends AbstractController
{
    /**
     * @var SystemConfigService
     */
    private $systemConfigService;

    public function __construct(SystemConfigService $systemConfigService) {
        $this->systemConfigService = $systemConfigService;
    }

    /**
     * @RouteScope(scopes={"api"})
     * @Route("/api/v{version}/vis/delete_cross", name="api.action.vis.delete_cross", methods={"POST"})
     */
    public function deleteCrossSellings(Request $request, Context $context): JsonResponse
    {
        // Encode json parameters
        $parameters = json_decode($request->getContent(), true);
        $name = $parameters["name"];

        // Get repository with products cross-sellings
        $productCrossSellingRepository = $this->container->get('product_cross_selling.repository');

        $swRepo = new SwRepoUtils();
        $swRepo->deleteCrossSellings($productCrossSellingRepository, $name);

        return new JsonResponse(["code"=> 200, "message" => "Info VisRecommendSimilarProducts: cross-sellings deleted"]);
    }
    /**
     * @RouteScope(scopes={"api"})
     * @Route("/api/v{version}/vis/status_cross", name="api.action.vis.status_cross", methods={"POST"})
     */
    public function statusCrossSellings(Request $request, Context $context): JsonResponse
    {
        $name = $this->systemConfigService->get('VisRecommendSimilarProducts.config.cross');

        $productRepository = $this->container->get('product.repository');

        $swRepo = new SwRepoUtils();

        // search criteria
        $criteria = new Criteria();
        $criteria->addAssociation('cover');
        $criteria->addAssociation('crossSellings');

        // search repository
        $products = $swRepo->searchProducts($productRepository, $criteria);
        if(empty($products)){
            return new JsonResponse(["code"=> 200, "message" => "Info VisRecommendSimilarProducts: no products"]);
        }
        $sp = sizeof($products);

        // get category with missing cross-sellings
        $category = $swRepo->getFirstCategory($productRepository, $name);

        if(!empty($category)){
            return new JsonResponse(["code"=> 200, "message" => "Info VisRecommendSimilarProducts: size catalogue:".$sp."; category with no cross-selling:".$category]);
        }else{
            return new JsonResponse(["code"=> 200, "message" => "Info VisRecommendSimilarProducts: size catalogue:".$sp."; update of cross-sellings not needed"]);
        }
    }
    /**
     * @RouteScope(scopes={"api"})
     * @Route("/api/v{version}/vis/status_logging", name="api.action.vis.status_logging", methods={"POST"})
     */
    public function statusLogging(Request $request, Context $context): JsonResponse
    {
        $loggingRepository = $this->container->get('s_plugin_vis_log.repository');

        $criteria = new Criteria();
        $criteria->addSorting(new FieldSorting('createdAt', FieldSorting::DESCENDING));
        $criteria->setLimit(100);

        $loggingSearch = $loggingRepository->search(
            $criteria,
            \Shopware\Core\Framework\Context::createDefaultContext()
        );

        $logs = [];
        foreach($loggingSearch->getEntities()->getElements() as $key => $logEntity){
            array_push($logs, [$key, $logEntity->getMessage(), $logEntity->getCreatedAt()]);
        }

        $data = ["logs" => $logs];
        return new JsonResponse(["code"=> 200, "message" => $data]);
    }
    /**
     * @RouteScope(scopes={"api"})
     * @Route("/api/v{version}/vis/update_cross", name="api.action.vis.update_cross", methods={"POST"})
     */
    public function updateCrossSellings(Request $request, Context $context): JsonResponse
    {
        // Encode json parameters
        $parameters = json_decode($request->getContent(), true);
        $productEntities = $parameters["products"];

        // Get repository with products cross-sellings
        $productCrossSellingRepository = $this->container->get('product_cross_selling.repository');

        // For each product in input json
        foreach($productEntities as $productId => $productIDs){
            $assignedProducts = [];
            foreach($productIDs as $key => $productID){
                array_push($assignedProducts, [
                    'productId' => $productID,
                    'position' => $key,
                ]);
            }

            // Begin of existing cross selling check

            // Search criteria
            $criteria = new Criteria();
            $criteria->addFilter(new EqualsFilter('name', $this->systemConfigService->get('VisRecommendSimilarProducts.config.cross')));
            $criteria->addFilter(new EqualsFilter('productId', $productId));

            // Search for cross-sellings
            $productCrossSelling = $productCrossSellingRepository->search(
                $criteria,
                \Shopware\Core\Framework\Context::createDefaultContext()
            );
            $elements = $productCrossSelling->getEntities()->getElements();
            if(!empty($elements)){
                $id = array_key_first($elements);
            }
            if(empty($id)){
                $id = Uuid::randomHex();
            }else{
                // Delete our old cross selling as update does not update correctly
                $productCrossSellingRepository->delete([['id' => $id]], Context::createDefaultContext());
            }

            // End of existing cross selling check

            $newCrossSelling = [
                'id' => $id,
                'productId' => $productId,
                'active' => true,
                'name' => $this->systemConfigService->get('VisRecommendSimilarProducts.config.cross'),
                'type' => 'productList',
                'position' => 1,
                'assignedProducts' => $assignedProducts
            ];
            $productCrossSellingRepository->upsert([$newCrossSelling], Context::createDefaultContext());
        }
        return new JsonResponse(["code"=> 200, "message" => "Info VisRecommendSimilarProducts: cross-sellings updated successfully"]);
    }
    /**
     * @RouteScope(scopes={"api"})
     * @Route("/api/v{version}/vis/update_auto", name="api.action.vis.update_auto", methods={"POST"})
     */
    public function updateAuto(Request $request, Context $context): JsonResponse
    {
        // if the plugin config checkbox is not checked then the plugin is not active
        if(!$this->systemConfigService->get('VisRecommendSimilarProducts.config.enabled')){
            return new JsonResponse(["code"=>200, "message" =>"Info VisRecommendSimilarProducts: automatic updates not enabled"]);
        }

        // get name and product repository
        $name = $this->systemConfigService->get('VisRecommendSimilarProducts.config.cross');
        $productRepository = $this->container->get('product.repository');

        $swRepo = new SwRepoUtils();

        // search criteria
        $criteria = new Criteria();
        $criteria->addAssociation('cover');
        $criteria->addAssociation('crossSellings');

        // search repository
        $products = $swRepo->searchProducts($productRepository, $criteria);
        if(empty($products)){
            return new JsonResponse(["code"=> 200, "message" => "Info VisRecommendSimilarProducts: no products"]);
        }

        // for large catalogue update only one category
        if (sizeof($products) > 1000) {

            // get category with missing cross-sellings
            $category = $swRepo->getFirstCategory($productRepository, $name);

            // search criteria with category
            $criteria = new Criteria();
            if(!empty($category)) {
                $criteria->addFilter(new EqualsFilter('categoryTree', $category));
            }else{
                return new JsonResponse(["code"=> 200, "message" => "Info VisRecommendSimilarProducts: all products have cross-sellings"]);
            }
            $criteria->addAssociation('cover');
            $criteria->addAssociation('crossSellings');

            // search for products
            $products = $swRepo->searchProducts($productRepository, $criteria);

            if(empty($products)){
                return new JsonResponse(["code"=> 200, "message" => "Info VisRecommendSimilarProducts: no products"]);
            }
        }

        // retrieve hosts and keys
        $retrieveHosts = new SwHosts($this->container->get('sales_channel.repository'));
        $systemHosts = $retrieveHosts->getLocalHosts();;

        // submit update request
        $api = new ApiRequest($this->container->get('s_plugin_vis_log.repository'));
        $message = $api->update(
            $this->systemConfigService->get('VisRecommendSimilarProducts.config.apiKey'),
            $products,
            $systemHosts);

        // return message
        return new JsonResponse(["code"=>200, "message" =>"Info VisRecommendSimilarProducts: ".$message]);
    }
    /**
     * @RouteScope(scopes={"api"})
     * @Route("/api/v{version}/vis/update_categories", name="api.action.vis.update_categories", methods={"POST"})
     */
    public function updateCategories(Request $request, Context $context): JsonResponse
    {
        // if the plugin config checkbox is not checked then the plugin is not active
        if(!$this->systemConfigService->get('VisRecommendSimilarProducts.config.enabled')){
            return new JsonResponse(["code"=>200, "message" =>"Info VisRecommendSimilarProducts: automatic updates not enabled"]);
        }

        // get name and product repository
        $name = $this->systemConfigService->get('VisRecommendSimilarProducts.config.cross');
        $productRepository = $this->container->get('product.repository');

        $swRepo = new SwRepoUtils();

        // search criteria
        $criteria = new Criteria();
        $criteria->addAssociation('cover');
        $criteria->addAssociation('crossSellings');

        // search repository
        $products = $swRepo->searchProducts($productRepository, $criteria);
        if(empty($products)){
            return new JsonResponse(["code"=> 200, "message" => "Info VisRecommendSimilarProducts: no products"]);
        }

        // retrieve hosts and keys
        $retrieveHosts = new SwHosts($this->container->get('sales_channel.repository'));
        $systemHosts = $retrieveHosts->getLocalHosts();;

        // submit update request
        $api = new ApiRequest($this->container->get('s_plugin_vis_log.repository'));
        $message = $api->update(
            $this->systemConfigService->get('VisRecommendSimilarProducts.config.apiKey'),
            $products,
            $systemHosts);

        // return message
        return new JsonResponse(["code"=>200, "message" =>"Info VisRecommendSimilarProducts: ".$message]);
    }
    /**
     * @RouteScope(scopes={"api"})
     * @Route("/api/v{version}/vis/update_one_category", name="api.action.vis.update_one_category", methods={"POST"})
     */
    public function updateOneCategory(Request $request, Context $context): JsonResponse
    {
        // get name and product repository
        $name = $this->systemConfigService->get('VisRecommendSimilarProducts.config.cross');
        $productRepository = $this->container->get('product.repository');

        // get category with missing cross-sellings
        $swRepo = new SwRepoUtils();
        $category = $swRepo->getFirstCategory($productRepository, $name);

        // search criteria with category
        $criteria = new Criteria();
        if(!empty($category)) {
            $criteria->addFilter(new EqualsFilter('categoryTree', $category));
        }else{
            return new JsonResponse(["code"=> 200, "message" => "Info VisRecommendSimilarProducts: all products have cross-sellings"]);
        }
        $criteria->addAssociation('cover');
        $criteria->addAssociation('crossSellings');

        // search for products
        $products = $swRepo->searchProducts($productRepository, $criteria);
        if(empty($products)){
            return new JsonResponse(["code"=> 200, "message" => "Info VisRecommendSimilarProducts: no products"]);
        }

        // retrieve hosts and keys
        $retrieveHosts = new SwHosts($this->container->get('sales_channel.repository'));
        $systemHosts = $retrieveHosts->getLocalHosts();;

        // submit update request
        $api = new ApiRequest($this->container->get('s_plugin_vis_log.repository'));
        $message = $api->update(
            $this->systemConfigService->get('VisRecommendSimilarProducts.config.apiKey'),
            $products,
            $systemHosts);

        // return message
        return new JsonResponse(["code"=>200, "message" =>"Info VisRecommendSimilarProducts: ".$message]);
    }
    /**
     * @RouteScope(scopes={"api"})
     * @Route("/api/v{version}/vis/api_key_verify", name="api.action.vis.api_key_verify", methods={"POST"})
     */
    public function apiKeyVerify(Request $request, Context $context): JsonResponse
    {
        // verify api key
        $api = new ApiRequest($this->container->get('s_plugin_vis_log.repository'));
        $message = $api->verify($this->systemConfigService->get('VisRecommendSimilarProducts.config.apiKey'));

        if($message == "API key ok"){
            return new JsonResponse(['success' => true]);
        }else{
            return new JsonResponse(['success' => false]);
        }
    }
}
