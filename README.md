# Shopware6 - Recommend Similar Products

## Highlights
* 10 days free testing with free support
* Increased conversion rate for the webshop
* Does not need user privacy data
* No labour costs with the maintenance of recommendations
* Does not need cookies

## Features
* Recommends the most visually similar products from the catalogue
* Regular automatic updating of these recommendations
* Available for any category like: Fashion, Furniture, Jewellery, Toys, etc.
* Recommendations are displayed on the product detail page as similar products
* Efficient search for the desired product
* Higher shopping satisfaction
* Customers stay longer in the shop

## Description
**Automatically generates visually similar product recommendations**

We offer testing with support for 10 days for free!

This plugin provides automatic creation of visually similar recommendations for all available products. The creation of these recommendations is possible using an innovative algorithm that automatically finds visually related products in all available categories. These visually related products will be displayed in the product detail page as a cross-selling tab.

In this plugin, the provided recommendations are created with a custom AI algorithm. This algorithm is running on an external server and a valid API key is needed to access this service.

Below is an example of visually similar recommendations of a red jacket. Other examples can be found in our demo store here: https://shopware.visualsearch.at

<img src="/demostore-jacket.jpg" alt="drawing" width="500px"/>

## Installation

* Install this plugin.
* Request your API key. Follow the link in the plugin configuration "Please click here to get your API credentials" or visit our website https://www.visualsearch.at/index.php/credentials/. Once you contact our office, we will provide you with an API key and you can test this plugin for 10 days for free!
* Please wait for an email with your API key.
* In the configuration, paste the API key you received, press "Save" and optionally you can use the "Validate API credentials" button to check this key.
* In the plug-in configuration, you can define the name of the cross-selling.
* In the plugin configuration, please select automatic updates.
* Please press "Save".
* Please wait for automatic updates to generate the similarity recommendations. The time for generation of recommendations depends on the size of your shop.

## Invoke Computation of Recommendations using Command

Alternatively, we provide you the possibility to manually computate product recommendations.

* Update of one category. This command will *check for missing cross-sellings* and perform update in two steps. First, it will search for the first category, which contains at least one product with missing cross-selling with the defined name (see 4. in Installation). Second, it will perform an update of the recommendations for all products in this category. You can invoke this update using e.g. this command with your sw-access-key: `curl --location --request POST 'https://YOUR_DOMAIN/api/v3/vis/update_one_category' --header 'Authorization: Bearer XYZ' --data-raw ''`
* Check the status of cross-sellings. You can check for missing cross-sellings with the defined name (see 4. in Installation) using e.g. this command: `curl --location --request POST 'https://YOUR_DOMAIN/store-api/v3/vis/status_cross' --header 'sw-access-key: XYZ' --data-raw ''`

### Contact
E-Mail: office@visualsearch.at, Web: www.visualsearch.at, Phone: +43 670 6017118

UID-Number: ATU74052259, Registration Number: FN 505045 p, Jurisdiction: Commercial court of Vienna, Austria
