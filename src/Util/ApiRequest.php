<?php declare(strict_types=1);
/*
 * (c) VisualSearch GmbH <office@visualsearch.at>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with the source code.
 */

namespace Vis\RecommendSimilarProducts\Util;

class ApiRequest
{
    public function notification($hosts, $post, $type): void
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.visualsearch.wien/installation_notify',
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'{"'.$post.'":"VisRecommendSimilarProducts"}',
            CURLOPT_HTTPHEADER => array(
                'Vis-API-KEY: marketing',
                'Vis-SYSTEM-HOSTS:'.$hosts,
                'Vis-SYSTEM-TYPE: '.$type.';VisRecommendSimilarProducts',
                'Content-Type: application/json'
            ),
        ));
        curl_exec($curl);
        curl_close($curl);
    }

    public function update($apiKey, $products, $systemHosts, $systemKeys): string
    {
        // Form data for the API request
        $data = ["products" => $products];

        // Create a connection
        $url = 'https://api.visualsearch.wien/similar_compute';
        $ch = curl_init($url);

        // Form data string
        $postString = json_encode($data);
        // $postString = http_build_query($data);

        // Setting our options
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postString);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json',
            'Vis-API-KEY:'.$apiKey,
            'Vis-SYSTEM-KEY:'.$systemKeys,
            'Vis-SYSTEM-HOSTS:'.$systemHosts,
            'Vis-SYSTEM-TYPE:shopware'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        try{
            // Get the response
            $response = curl_exec($ch);
            curl_close($ch);
            $response = json_decode($response);
            return $response->{'message'};
        }catch(Exception $e){
            return $e->getMessage;
        }
    }

    public function verify($apiKey): string
    {
        // Create a connection
        $url = 'https://api.visualsearch.wien/api_key_verify';
        $ch = curl_init($url);

        // Setting our options
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json',
            'Vis-API-KEY:'.$apiKey));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        try{
            // Get the response
            $response = curl_exec($ch);
            curl_close($ch);
            $response = json_decode($response);
            return $response->{'message'};
        }catch(Exception $e){
            return $e->getMessage;
        }
    }
}
