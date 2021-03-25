# Shopware6-RecommendSimilarProducts
Recommends visually similar products in the product detail page using Deep Learning.

The purpose of this plugin is
* Efficient search for desired product
* Optimized conversion rate for the webshop
* Longer time spent in the webshop

Below is an example of visually similar recommendations of a red jacket. Other examples can be found in our demo store here: https://shopware.visualsearch.at

<img src="/demostore-jacket.jpg" alt="drawing" width="500px"/>

## Installation

This plugin provides automatic or manual computation of recommendations for all products in the webshop. All products are analyzed using custom Deep Learning algorithms and visually similar products are displayed in the cross-selling tabs. The analytics of products is performed on an external server. Please follow these installation instructions and obtain a **valid API key**.

##### 1. Install the plugin from Shopware marketplace.
We will provide a link to the plugin soon.
##### 2. Contact please office@visualsearch.at to obtain your API key.
Once you contact our office, we will provide you the suitable subscription plan according to the size of your webshop.
##### 3. In the plugin config, enter please the received API key.
The plugin can work only with valid API key.
##### 4. In the plugin config, you can define the name of the cross-selling.
The name of the cross-selling is used for the tab in the product detail page.

## Invoke Computation of Recommendations using Shopware 6 ScheduledTasks

The plugin can periodically and automatically check, if all of your products have cross-sellings with the defined name (see 4. in Installation). If one product does not have the cross-selling with the defined name, then all products within this category are selected for an update. The products' ID's, name's, image url's and category will be sent to an external server. On the server, for every product the visually closest ones will be automatically computed. Afterwards, the computed cross-sellings will be automatically uploaded back to your webshop.

##### 1. Follow Shopware tutorial to setup scheduled tasks
You can find instructions here: https://docs.shopware.com/en/shopware-6-en/tutorials-and-faq/creating-scheduled-tasks

An example of the setup of Shopware 6 scheduled tasks in Ubuntu 20.04, which will run every 5min for 295sec:
* Open crontab config file using `sudo -u www-data crontab -e`
* Write two following lines of code
* `*/5 * * * * php /var/www/html/shopware/bin/console scheduled-task:run --time-limit=295`
* `*/5 * * * * php /var/www/html/shopware/bin/console messenger:consume --time-limit=295`

##### 2. Enable the automatic computation of recommendations
Check the "Automatic Updates Enabled" box in the plugin config.

## Invoke Computation of Recommendations using Command

Alternatively, we provide you two possibilities to manually computate product recommendations. First, you can update all recommendations regardless if they already exist or not. Second, only categories with missing recommendations will be updated.

* Update of all products. This command will *not check for missing cross-sellings* and will update all products in the catalogue. You can invoke this update using e.g. this command with your sw-access-key: `curl --location --request POST 'https://YOUR_DOMAIN/store-api/v3/vis/update_categories' --header 'sw-access-key: YOUR_SW_KEY' --data-raw ''`
* Update of one category. This command will *check for missing cross-sellings* and perform update in two steps. First, it will search for the first category, which contains at least one product with missing cross-selling with the defined name (see 4. in Installation). Second, it will perform an update of the recommendations for all products in this category. You can invoke this update using e.g. this command with your sw-access-key: `curl --location --request POST 'https://YOUR_DOMAIN/store-api/v3/vis/update_one_category' --header 'sw-access-key: YOUR_SW_KEY' --data-raw ''`
* Check the status of cross-sellings. You can check for missing cross-sellings with the defined name (see 4. in Installation) using e.g. this command: `curl --location --request POST 'https://YOUR_DOMAIN/store-api/v3/vis/status_cross' --header 'sw-access-key: YOUR-SW-KEY' --data-raw ''`
* Delete cross-sellings with defined name. You can delete all cross-sellings with the defined name (see 4. in Installation) using e.g. this command: `curl --location --request POST 'https://YOUR_DOMAIN/store-api/v3/vis/delete_cross' --header 'sw-access-key: YOUR-SW-KEY' --header 'Content-Type: application/json' --data-raw '{"name": "Product Recommendations"}'`

### Contact
E-Mail: office@visualsearch.at, Web: www.visualsearch.at, Phone: +43 670 6017118

UID-Number: ATU74052259, Registration Number: FN 505045 p, Jurisdiction: Commercial court of Vienna, Austria
