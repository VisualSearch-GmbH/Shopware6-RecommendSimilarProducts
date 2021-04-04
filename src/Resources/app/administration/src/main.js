import './../init/api-service.init'
import './components/visualsearch-get-credentials'
import './components/visualsearch-support'
import './components/visualsearch-verify-api-key'

import localeDE from './snippets/de_DE.json';
import localeEN from './snippets/en_GB.json';

Shopware.Locale.extend('de-DE', localeDE);
Shopware.Locale.extend('en-GB', localeEN);
