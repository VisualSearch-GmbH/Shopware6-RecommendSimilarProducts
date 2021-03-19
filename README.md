# Shopware6-RecommendSimilarProducts
Recommends visually similar products in the product detail page using Deep Learning.

The purpose of this plugin is
* Easy search for desired product
* Longer time spent in the webshop
* Increased sales for the webshop

Below is an example of visually similar recommendations of a red jacket. Other examples can be found in our demo store here: https://shopware.visualsearch.at

<img src="/demostore-jacket.jpg" alt="drawing" width="500px"/>

## Installation

This plugin provides automatic or manual computation of recommendations for all products in the webshop. All products are analyzed using custom Deep Learning algorithms and visually similar products are displayed in the cross-selling tabs. The analytics of products is performed on an external server. Please follow these installation instructions and obtain a **valid API key**.

##### 1. Install the plugin from Shopware marketplace.
We will provide a link to the plugin soon.
##### 2. Contact office@visualsearch.at to obtain your API key.
Once you contact our office, we will provide you the suitable subscription plan according to the size of your webshop.
##### 3. In the plugin config, enter the received API key.
The plugin can work only with valid API key.
##### 4. In the plugin config, you can define the name of the cross-selling.
The name of the cross-selling is used for the tab in the product detail page.

## Automatic Computation of Recommendations

The plugin will periodically and automatically check, if all of your products have cross-sellings with the defined name (see 4. in Installation). If one product does not have the cross-selling with the defined name, then all products within this category are selected for an update. These products' IDs, names, image urls and category will be sent to an external server. On the server, for every product the visually closest ones will be automatically computed. Afterwards, the computed cross-sellings will be automatically uploaded back to your webshop.

##### 1. Follow Shopware tutorial to setup scheduled tasks
You can find complete instructions here: https://docs.shopware.com/de/shopware-6-de/tutorials-und-faq/scheduled-tasks-anlegen

An example of setup of scheduled tasks in Ubuntu 20.04, which will run every 5min for 295sec:
* sudo -u www-data crontab -e
* */5 * * * * php /var/www/html/shopware/bin/console scheduled-task:run --time-limit=295
* */5 * * * * php /var/www/html/shopware/bin/console messenger:consume --time-limit=295

##### 2. Enable the automatic computation of recommendations
Check the "Enabled" box in the plugin config.

## Manual Computation of Recommendations

adf

### Contact
E-Mail: office@visualsearch.at, Web: www.visualsearch.at, Phone: +43 670 6017118

UID-Number: ATU74052259, Registration Number: FN 505045 p, Jurisdiction: Commercial court of Vienna, Austria
