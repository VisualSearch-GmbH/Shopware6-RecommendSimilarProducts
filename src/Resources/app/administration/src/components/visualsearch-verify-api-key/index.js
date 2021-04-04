const {Component, Mixin} = Shopware;

import template from './visualsearch-verify-api-key.html.twig';

Component.register('vis-verify-api-key', {
    template,
    mixins: [
        Mixin.getByName('notification')
    ],

    inject: [
        'ApiKeyVerifyService'
    ],

    data() {
        return {
            isLoading: false,
        };
    },
    methods: {
        async check() {
            this.isLoading = true;

            await this.ApiKeyVerifyService.verifyKey().then((response) => {
                if(response.data.success == true) {
                    // Success
                    this.createNotificationSuccess({
                        title: 'VisualSearch',
                        message: this.$tc('vis-verify-api-key.success')
                    });
                } else  {
                    // Error
                    this.createNotificationError({
                        title: 'VisualSearch',
                        message: this.$tc('vis-verify-api-key.error')
                    });
                }
            }).catch((exception) => {

            });

            this.isLoading = false;

            return;
        }
    }
});
