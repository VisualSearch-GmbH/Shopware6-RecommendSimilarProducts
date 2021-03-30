const {Component, Mixin} = Shopware;

import template from './visualsearch-verify-api-key.html.twig';

Component.register('vis-verify-api-key', {
    template,
    mixins: [
        Mixin.getByName('notification')
    ],
    data() {
        return {
            isLoading: false,
        };
    },
    methods: {
        check() {

            this.isLoading = true;

            //
            //
            // Check API credentials HERE
            //
            //
            // Method: Get
            //const headers = {'Content-Type' : 'application/json', 'Vis-API-KEY': apiKey from config.xml};
            // Header:
            // Url: https://api.visualsearch.wien/api_key_verify

            // Success
            this.createNotificationSuccess({
                title: 'VisualSearch',
                message: this.$tc('vis-verify-api-key.success')
            });

            // Error
            this.createNotificationError({
                title: 'VisualSearch',
                message: this.$tc('vis-verify-api-key.error')
            });

            this.isLoading = false;

            return;
        }
    }
});
