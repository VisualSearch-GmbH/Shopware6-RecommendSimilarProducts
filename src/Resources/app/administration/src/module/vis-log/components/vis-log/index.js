import template from './vis-log.html.twig';

const { Component, Mixin } = Shopware;
const { Criteria } = Shopware.Data;
const { createId } = Shopware.Utils;

Component.register('vis-log', {
    template,

    name: 'visLog',

    inject: [
        'repositoryFactory',
    ],

    mixins: [
        Mixin.getByName('notification'),
    ],

    created() {
        this.createdComponent();
    },

    data() {
        return {
            isLoading: false,
            logData: [],
            total: 0,
            limit: 10,
            page: 1,
            sortBy: 's_plugin_vis_log.createdAt',
            sortDirection: 'DESC',
        };
    },

    computed: {
        logRepository() {
            return this.repositoryFactory.create('s_plugin_vis_log');
        },
        visLogColumns() {
            return [
                {
                    property: 'createdAt',
                    dataIndex: 'createdAt',
                    label: 'vis-log.created',
                    inlineEdit: 'date',
                    allowResize: true,
                    primary: true
                },
                {
                    property: 'message',
                    dataIndex: 'message',
                    label: 'vis-log.message',
                    allowResize: true,
                },
            ];
        },
    },

    methods: {
        createdComponent() {
            this.isLoading = true;
            const criteria = new Criteria(this.page, this.limit);
            this.logRepository.search(criteria, Shopware.Context.api).then(logData => {
                this.logData = logData;
                this.total = logData.total;
                this.isLoading = false;
            }).catch(() => {
                this.isLoading = false;
            });
        },
    }
});
