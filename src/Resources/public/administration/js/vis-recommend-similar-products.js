(this.webpackJsonp=this.webpackJsonp||[]).push([["vis-recommend-similar-products"],{"9/SL":function(e,t,n){var i=n("h56c");"string"==typeof i&&(i=[[e.i,i,""]]),i.locals&&(e.exports=i.locals);(0,n("SZ7m").default)("7b441ec5",i,!0,{})},CkOj:function(e,t,n){"use strict";n.d(t,"a",(function(){return u}));var i=n("lSNA"),r=n.n(i),a=n("lO2t"),s=n("lYO9");function o(e,t){var n=Object.keys(e);if(Object.getOwnPropertySymbols){var i=Object.getOwnPropertySymbols(e);t&&(i=i.filter((function(t){return Object.getOwnPropertyDescriptor(e,t).enumerable}))),n.push.apply(n,i)}return n}function c(e){for(var t=1;t<arguments.length;t++){var n=null!=arguments[t]?arguments[t]:{};t%2?o(Object(n),!0).forEach((function(t){r()(e,t,n[t])})):Object.getOwnPropertyDescriptors?Object.defineProperties(e,Object.getOwnPropertyDescriptors(n)):o(Object(n)).forEach((function(t){Object.defineProperty(e,t,Object.getOwnPropertyDescriptor(n,t))}))}return e}function u(e){var t=function(e){var t;if(a.a.isString(e))try{t=JSON.parse(e)}catch(e){return!1}else{if(!a.a.isObject(e)||a.a.isArray(e))return!1;t=e}return t}(e);if(!t)return null;if(!0===t.parsed||!function(e){return void 0!==e.data||void 0!==e.errors||void 0!==e.links||void 0!==e.meta}(t))return t;var n=function(e){var t={links:null,errors:null,data:null,associations:null,aggregations:null};if(e.errors)return t.errors=e.errors,t;var n=function(e){var t=new Map;if(!e||!e.length)return t;return e.forEach((function(e){var n="".concat(e.type,"-").concat(e.id);t.set(n,e)})),t}(e.included);if(a.a.isArray(e.data))t.data=e.data.map((function(e){var i=l(e,n);return Object(s.g)(i,"associationLinks")&&(t.associations=c(c({},t.associations),i.associationLinks),delete i.associationLinks),i}));else if(a.a.isObject(e.data)){var i=l(e.data,n);Object.prototype.hasOwnProperty.call(i,"associationLinks")&&(t.associations=c(c({},t.associations),i.associationLinks),delete i.associationLinks),t.data=i}else t.data=null;e.meta&&Object.keys(e.meta).length&&(t.meta=p(e.meta));e.links&&Object.keys(e.links).length&&(t.links=e.links);e.aggregations&&Object.keys(e.aggregations).length&&(t.aggregations=e.aggregations);return t}(t);return n.parsed=!0,n}function l(e,t){var n={id:e.id,type:e.type,links:e.links||{},meta:e.meta||{}};if(e.attributes&&Object.keys(e.attributes).length>0){var i=p(e.attributes);n=c(c({},n),i)}if(e.relationships){var r=function(e,t){var n={},i={};return Object.keys(e).forEach((function(r){var s=e[r];if(s.links&&Object.keys(s.links).length&&(i[r]=s.links.related),s.data){var o=s.data;a.a.isArray(o)?n[r]=o.map((function(e){return h(e,t)})):a.a.isObject(o)?n[r]=h(o,t):n[r]=null}})),{mappedRelations:n,associationLinks:i}}(e.relationships,t);n=c(c(c({},n),r.mappedRelations),{associationLinks:r.associationLinks})}return n}function p(e){var t={};return Object.keys(e).forEach((function(n){var i=e[n],r=n.replace(/-([a-z])/g,(function(e,t){return t.toUpperCase()}));t[r]=i})),t}function h(e,t){var n="".concat(e.type,"-").concat(e.id);return t.has(n)?l(t.get(n),t):e}},E50F:function(e,t){e.exports='<div>\n    <sw-button-process\n        :isLoading="isLoading"\n        @click="check"\n    >{{ $tc(\'vis-verify-api-key.apiButton\') }}</sw-button-process>\n</div>\n'},EIxa:function(e,t,n){},"JPr/":function(e){e.exports=JSON.parse('{"vis-get-credentials":{"title":"Please click here to get your API credentials"},"vis-verify-api-key":{"success":"Connection was successfully established.","error":"Connection could not be established. Please check your API credentials.","apiButton":"Validate API credentials"},"vis-support":{"documentation":"Documentation","api_documentation":"API Documentation","read_docs":"Read our documentation for more information about VisualSearch and how to get started","manual":"Manual","changelog":"Changelog","faq":"FAQ","for_developers":"For developers","account":"Account","e-mail":"E-mail","telephone":"Telephone","contact":"Contact","visualsearch_assistance_integration_team":"Need assistance? Feel free to contact our integration team:"}}')},SwLI:function(e,t,n){"use strict";n.r(t);var i=n("lwsE"),r=n.n(i),a=n("W8MJ"),s=n.n(a),o=n("CkOj"),c=function(){function e(t,n,i){var a=arguments.length>3&&void 0!==arguments[3]?arguments[3]:"application/vnd.api+json";r()(this,e),this.httpClient=t,this.loginService=n,this.apiEndpoint=i,this.contentType=a}return s()(e,[{key:"getList",value:function(t){var n=t.page,i=void 0===n?1:n,r=t.limit,a=void 0===r?25:r,s=t.sortBy,o=t.sortDirection,c=void 0===o?"asc":o,u=t.sortings,l=t.queries,p=t.term,h=t.criteria,d=t.aggregations,g=t.associations,f=t.headers,v=t.versionId,y=t.ids,m=t["total-count-mode"],b=void 0===m?0:m;this.showDeprecationWarning("getList");var k=this.getBasicHeaders(f),O={page:i,limit:a};return u?O.sort=u:s&&s.length&&(O.sort=("asc"===c.toLowerCase()?"":"-")+s),y&&(O.ids=y.join("|")),p&&(O.term=p),h&&(O.filter=[h.getQuery()]),d&&(O.aggregations=d),g&&(O.associations=g),v&&(k=Object.assign(k,e.getVersionHeader(v))),l&&(O.query=l),b&&(O["total-count-mode"]=b),O.term&&O.term.length||O.filter&&O.filter.length||O.aggregations||O.sort||O.queries||O.associations?this.httpClient.post("".concat(this.getApiBasePath(null,"search")),O,{headers:k}).then((function(t){return e.handleResponse(t)})):this.httpClient.get(this.getApiBasePath(),{params:O,headers:k}).then((function(t){return e.handleResponse(t)}))}},{key:"getById",value:function(t){var n=arguments.length>1&&void 0!==arguments[1]?arguments[1]:{},i=arguments.length>2&&void 0!==arguments[2]?arguments[2]:{};if(this.showDeprecationWarning("getById"),!t)return Promise.reject(new Error("Missing required argument: id"));var r=n,a=this.getBasicHeaders(i);return this.httpClient.get(this.getApiBasePath(t),{params:r,headers:a}).then((function(t){return e.handleResponse(t)}))}},{key:"updateById",value:function(t,n){var i=arguments.length>2&&void 0!==arguments[2]?arguments[2]:{},r=arguments.length>3&&void 0!==arguments[3]?arguments[3]:{};if(this.showDeprecationWarning("updateById"),!t)return Promise.reject(new Error("Missing required argument: id"));var a=i,s=this.getBasicHeaders(r);return this.httpClient.patch(this.getApiBasePath(t),n,{params:a,headers:s}).then((function(t){return e.handleResponse(t)}))}},{key:"deleteAssociation",value:function(e,t,n,i){if(this.showDeprecationWarning("deleteAssociation"),!e||!n||!n)return Promise.reject(new Error("Missing required arguments."));var r=this.getBasicHeaders(i);return this.httpClient.delete("".concat(this.getApiBasePath(e),"/").concat(t,"/").concat(n),{headers:r}).then((function(e){return e.status>=200&&e.status<300?Promise.resolve(e):Promise.reject(e)}))}},{key:"create",value:function(t){var n=arguments.length>1&&void 0!==arguments[1]?arguments[1]:{},i=arguments.length>2&&void 0!==arguments[2]?arguments[2]:{};this.showDeprecationWarning("create");var r=n,a=this.getBasicHeaders(i);return this.httpClient.post(this.getApiBasePath(),t,{params:r,headers:a}).then((function(t){return e.handleResponse(t)}))}},{key:"delete",value:function(e){var t=arguments.length>1&&void 0!==arguments[1]?arguments[1]:{},n=arguments.length>2&&void 0!==arguments[2]?arguments[2]:{};if(this.showDeprecationWarning("delete"),!e)return Promise.reject(new Error("Missing required argument: id"));var i=Object.assign({},t),r=this.getBasicHeaders(n);return this.httpClient.delete(this.getApiBasePath(e),{params:i,headers:r})}},{key:"clone",value:function(t){return this.showDeprecationWarning("clone"),t?this.httpClient.post("/_action/clone/".concat(this.apiEndpoint,"/").concat(t),null,{headers:this.getBasicHeaders()}).then((function(t){return e.handleResponse(t)})):Promise.reject(new Error("Missing required argument: id"))}},{key:"versionize",value:function(e){var t=arguments.length>1&&void 0!==arguments[1]?arguments[1]:{},n=arguments.length>2&&void 0!==arguments[2]?arguments[2]:{};this.showDeprecationWarning("versionize");var i="/_action/version/".concat(this.apiEndpoint,"/").concat(e),r=Object.assign({},t),a=this.getBasicHeaders(n);return this.httpClient.post(i,{},{params:r,headers:a})}},{key:"mergeVersion",value:function(t,n,i,r){if(this.showDeprecationWarning("mergeVersion"),!t)return Promise.reject(new Error("Missing required argument: id"));if(!n)return Promise.reject(new Error("Missing required argument: versionId"));var a=Object.assign({},i),s=Object.assign(e.getVersionHeader(n),this.getBasicHeaders(r)),o="_action/version/merge/".concat(this.apiEndpoint,"/").concat(n);return this.httpClient.post(o,{},{params:a,headers:s})}},{key:"getApiBasePath",value:function(e){var t=arguments.length>1&&void 0!==arguments[1]?arguments[1]:"",n="";return t&&t.length&&(n+="".concat(t,"/")),e&&e.length>0?"".concat(n).concat(this.apiEndpoint,"/").concat(e):"".concat(n).concat(this.apiEndpoint)}},{key:"getBasicHeaders",value:function(){var e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:{},t={Accept:this.contentType,Authorization:"Bearer ".concat(this.loginService.getToken()),"Content-Type":"application/json"};return Object.assign({},t,e)}},{key:"showDeprecationWarning",value:function(e){Shopware.Utils.debug.warn("".concat(this.apiEndpoint," - Api Service"),"The ".concat(e," function is deprecated. Please use the 'repository.data.js' class for data handling of entities."))}},{key:"getApiVersion",value:function(){return Shopware.Context.api.apiVersion-1}},{key:"apiEndpoint",get:function(){return this.endpoint},set:function(e){this.endpoint=e}},{key:"httpClient",get:function(){return this.client},set:function(e){this.client=e}},{key:"contentType",get:function(){return this.type},set:function(e){this.type=e}}],[{key:"handleResponse",value:function(t){if(null===t.data||void 0===t.data)return t;var n=t.data,i=t.headers;return i&&i["content-type"]&&"application/vnd.api+json"===i["content-type"]&&(n=e.parseJsonApiData(n)),n}},{key:"parseJsonApiData",value:function(e){return Object(o.a)(e)}},{key:"getVersionHeader",value:function(e){return{"sw-version-id":e}}}]),e}();t.default=c},fNE8:function(e,t){e.exports='<template>\n    <div id="visualsearch-support">\n        <h2 class="visualsearch-title">{{ $tc("vis-support.documentation") }}</h2>\n        <p>{{ $tc("vis-support.read_docs") }}:</p>\n        <p class="mt-1">{{ $tc("vis-support.for_developers") }}:\n            <a href="https://github.com/VisualSearch-GmbH/Shopware6-RecommendSimilarProducts" target="_blank" rel="noopener">\n                VisualSearch Github\n            </a>\n        </p>\n        <h2 class="mt-2">{{ $tc("vis-support.contact") }}</h2>\n        <p>\n            {{ $tc("vis-support.visualsearch_assistance_integration_team") }}\n        </p>\n        <ul class="visualsearch-ul-none">\n            <li>\n                {{ $tc("vis-support.telephone") }}:\n                <a href="tel:+43 670 6017118">\n                    +43 670 6017118\n                </a>\n            </li>\n            <li>\n                {{ $tc("vis-support.e-mail") }}:\n                <a href="mailto:office@visualsearch.at">\n                    office@visualsearch.at\n                </a>\n            </li>\n        </ul>\n    </div>\n\n</template>\n'},h56c:function(e,t,n){},kRqn:function(e,t,n){var i=n("EIxa");"string"==typeof i&&(i=[[e.i,i,""]]),i.locals&&(e.exports=i.locals);(0,n("SZ7m").default)("a7dee90a",i,!0,{})},lO2t:function(e,t,n){"use strict";n.d(t,"b",(function(){return S}));var i=n("GoyQ"),r=n.n(i),a=n("YO3V"),s=n.n(a),o=n("E+oP"),c=n.n(o),u=n("wAXd"),l=n.n(u),p=n("Z0cm"),h=n.n(p),d=n("lSCD"),g=n.n(d),f=n("YiAA"),v=n.n(f),y=n("4qC0"),m=n.n(y),b=n("Znm+"),k=n.n(b),O=n("Y+p1"),j=n.n(O),w=n("UB5X"),P=n.n(w);function S(e){return void 0===e}t.a={isObject:r.a,isPlainObject:s.a,isEmpty:c.a,isRegExp:l.a,isArray:h.a,isFunction:g.a,isDate:v.a,isString:m.a,isBoolean:k.a,isEqual:j.a,isNumber:P.a,isUndefined:S}},lYO9:function(e,t,n){"use strict";n.d(t,"h",(function(){return k})),n.d(t,"i",(function(){return O})),n.d(t,"a",(function(){return j})),n.d(t,"d",(function(){return w})),n.d(t,"k",(function(){return P})),n.d(t,"j",(function(){return S})),n.d(t,"g",(function(){return A})),n.d(t,"b",(function(){return E})),n.d(t,"c",(function(){return B})),n.d(t,"f",(function(){return D})),n.d(t,"e",(function(){return C}));var i=n("lSNA"),r=n.n(i),a=n("QkVN"),s=n.n(a),o=n("JBE3"),c=n.n(o),u=n("BkRI"),l=n.n(u),p=n("mwIZ"),h=n.n(p),d=n("D1y2"),g=n.n(d),f=n("JZM8"),v=n.n(f),y=n("lO2t");function m(e,t){var n=Object.keys(e);if(Object.getOwnPropertySymbols){var i=Object.getOwnPropertySymbols(e);t&&(i=i.filter((function(t){return Object.getOwnPropertyDescriptor(e,t).enumerable}))),n.push.apply(n,i)}return n}function b(e){for(var t=1;t<arguments.length;t++){var n=null!=arguments[t]?arguments[t]:{};t%2?m(Object(n),!0).forEach((function(t){r()(e,t,n[t])})):Object.getOwnPropertyDescriptors?Object.defineProperties(e,Object.getOwnPropertyDescriptors(n)):m(Object(n)).forEach((function(t){Object.defineProperty(e,t,Object.getOwnPropertyDescriptor(n,t))}))}return e}s.a,s.a,l.a,h.a,g.a,v.a;var k=s.a,O=c.a,j=l.a,w=h.a,P=g.a,S=v.a;function A(e,t){return Object.prototype.hasOwnProperty.call(e,t)}function E(){var e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:{};return JSON.parse(JSON.stringify(e))}function B(){var e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:{},t=arguments.length>1&&void 0!==arguments[1]?arguments[1]:{};return O(e,t,(function(e,t){if(Array.isArray(e))return e.concat(t)}))}function D(e,t){return e===t?{}:y.a.isObject(e)&&y.a.isObject(t)?y.a.isDate(e)||y.a.isDate(t)?e.valueOf()===t.valueOf()?{}:t:Object.keys(t).reduce((function(n,i){if(!A(e,i))return b(b({},n),{},r()({},i,t[i]));if(y.a.isArray(t[i])){var a=C(e[i],t[i]);return Object.keys(a).length>0?b(b({},n),{},r()({},i,t[i])):n}if(y.a.isObject(t[i])){var s=D(e[i],t[i]);return!y.a.isObject(s)||Object.keys(s).length>0?b(b({},n),{},r()({},i,s)):n}return e[i]!==t[i]?b(b({},n),{},r()({},i,t[i])):n}),{}):t}function C(e,t){if(e===t)return[];if(!y.a.isArray(e)||!y.a.isArray(t))return t;if(e.length<=0&&t.length<=0)return[];if(e.length!==t.length)return t;if(!y.a.isObject(t[0]))return t.filter((function(t){return!e.includes(t)}));var n=[];return t.forEach((function(i,r){var a=D(e[r],t[r]);Object.keys(a).length>0&&n.push(t[r])})),n}},pAdO:function(e,t,n){"use strict";n.r(t);var i=n("SwLI");class r extends i.default{constructor(e,t,n=""){super(e,t,n)}verifyKey(){const e=this.getApiBasePath()+"/vis/api_key_verify";return this.httpClient.post(e,{},{headers:this.getBasicHeaders()}).then(e=>e)}}var a=r;const{Application:s}=Shopware;s.addServiceProvider("ApiKeyVerifyService",e=>{const t=s.getContainer("init");return new a(t.httpClient,e.loginService)});n("9/SL");var o=n("vjLC"),c=n.n(o);const{Component:u}=Shopware;u.register("vis-get-credentials",{template:c.a});n("kRqn");var l=n("fNE8"),p=n.n(l);const{Component:h}=Shopware;h.register("vis-support",{template:p.a});var d=n("E50F"),g=n.n(d);const{Component:f,Mixin:v}=Shopware;f.register("vis-verify-api-key",{template:g.a,mixins:[v.getByName("notification")],inject:["ApiKeyVerifyService"],data:()=>({isLoading:!1}),methods:{async check(){this.isLoading=!0,await this.ApiKeyVerifyService.verifyKey().then(e=>{1==e.data.success?this.createNotificationSuccess({title:"VisualSearch",message:this.$tc("vis-verify-api-key.success")}):this.createNotificationError({title:"VisualSearch",message:this.$tc("vis-verify-api-key.error")})}).catch(e=>{}),this.isLoading=!1}}});var y=n("pIQn"),m=n("JPr/");Shopware.Locale.extend("de-DE",y),Shopware.Locale.extend("en-GB",m)},pIQn:function(e){e.exports=JSON.parse('{"vis-get-credentials":{"title":"Klicken Sie bitte hier, um Ihre API-Zugangsdaten zu erhalten"},"vis-verify-api-key":{"success":"Die Verbindung wurde erfolgreich hergestellt.","error":"Verbindung konnte nicht hergestellt werden. Überprüfen Sie bitte Ihre API-Zugangsdaten.","apiButton":"API-Zugangsdaten testen"},"vis-support":{"documentation":"Dokumentation","api_documentation":"API Dokumentation","read_docs":"Lesen Sie in unserem Dokumentationen mehr über VisualSearch und wie Sie mit uns starten können","manual":"Anleitung","changelog":"Änderungsprotokoll","faq":"FAQ","for_developers":"Für Entwickler","account":"Account","e-mail":"E-Mail","telephone":"Telefon","contact":"Kontakt","visualsearch_assistance_integration_team":"Sie brauchen Hilfe? Kontaktieren Sie unser Integrations-Team:"}}')},vjLC:function(e,t){e.exports='<template>\n    <div id="visualsearch-get-credentials">\n        <p class="mt-1">\n        <a href="https://www.visualsearch.at/index.php/credentials" target="_blank" rel="noopener">\n            {{ $tc("vis-get-credentials.title") }}\n        </a>\n        </p>\n    </div>\n</template>\n'}},[["pAdO","runtime","vendors-node"]]]);