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
            soldPerDayResult: [],
            soldPerDayResultTotal: 0,
            soldPerDayDate: null,

            visClickedProductsResult: [],
            visClickedProductsTotal: 0,
            visClickedProductsDate: null,

            visSoldProductsResult: [],
            visSoldProductsTotal: 0,
            visSoldProductsDate: null,

            visSoldClickedProductsResult: [],
            visSoldClickedProductsTotal: 0,
            visSoldClickedProductsDate: null,
        };
    },

    computed: {
        logRepository() {
            return this.repositoryFactory.create('s_plugin_vis_log');
        },
        orderRepository() {
            return this.repositoryFactory.create('order');
        },
        visClickedRepository() {
            return this.repositoryFactory.create('s_plugin_vis_clicked_products');
        },
        visSoldRepository() {
            return this.repositoryFactory.create('s_plugin_vis_sold_products');
        },
        visSoldClickedRepository() {
            return this.repositoryFactory.create('s_plugin_vis_sold_clicked_products');
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

        soldPerDayColumns() {
            return [{
                property: 'orderNumber',
                label: 'sw-customer.detailOrder.columnNumber',
                align: 'center'
            }, {
                property: 'stateMachineState.name',
                label: 'sw-customer.detailOrder.columnOrderState'
            }, {
                property: 'orderDateTime',
                label: 'sw-customer.detailOrder.columnOrderDate',
                align: 'center'
            },{
                property: 'amountTotal',
                label: 'sw-customer.detailOrder.columnAmount',
                align: 'right'
            }];
        },

        visClickedPerDayColumns() {
            return [{
                property: 'product.name',
                label: 'vis-log.visClickedPerDayColumns.productName',
                align: 'center'
            }, {
                property: 'numberClick',
                label: 'vis-log.visClickedPerDayColumns.numberClicks',
            }, {
                property: 'date',
                label: 'vis-log.visClickedPerDayColumns.date',
                align: 'center'
            }];
        },

        visSoldPerDayColumns() {
            return [{
                property: 'product.name',
                label: 'vis-log.visSoldPerDayColumns.productName',
                align: 'center'
            }, {
                property: 'customer.firstName',
                dataIndex: 'customer.lastName,customer.firstName',
                label: 'vis-log.visSoldPerDayColumns.customerName',
                align: 'left'
            }, {
                property: 'date',
                label: 'vis-log.visSoldPerDayColumns.date',
                align: 'center'
            }];
        },

        visSoldClickedPerDayColumns() {
            return [
            {
                property: 'numberClick',
                label: 'vis-log.visSoldClickedPerDayColumns.numberClicks',
            },
            {
                property: 'date',
                label: 'vis-log.visSoldClickedPerDayColumns.date',
                align: 'center'
            }
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

        getOrders() {
            this.isLoading = true;
            const criteria = new Criteria(this.page, this.limit);
            if (this.soldPerDayDate) {
                criteria.addFilter(Criteria.multi('AND', [
                    Criteria.range('orderDateTime',
                        {gte: this.formatDate(new Date(this.soldPerDayDate), -1)}
                    ),
                    Criteria.range('orderDateTime',
                        {lte: this.formatDate(new Date(this.soldPerDayDate), 1)}
                    )
                ]));
            }

            this.orderRepository.search(criteria, Shopware.Context.api).then(soldPerDayResult => {
                this.soldPerDayResult = soldPerDayResult;
                this.soldPerDayResultTotal = soldPerDayResult.total;
                this.isLoading = false;
            }).catch(() => {
                this.isLoading = false;
            });
        },

        getVisClickedProducts() {
            this.isLoading = true;
            const criteria = new Criteria(this.page, this.limit);
            criteria.addAssociation('product');
            if (this.visClickedProductsDate) {
                criteria.addFilter(Criteria.multi('AND', [
                    Criteria.range('date',
                        {gte: this.formatDate(new Date(this.visClickedProductsDate), -1)}
                    ),
                    Criteria.range('date',
                        {lte: this.formatDate(new Date(this.visClickedProductsDate), 1)}
                    )
                ]));
            }

            this.visClickedRepository.search(criteria, Shopware.Context.api).then(visClickedProductsResult => {
                this.visClickedProductsResult = visClickedProductsResult;
                this.visClickedProductsTotal = visClickedProductsResult.total;
                this.isLoading = false;
            }).catch(() => {
                this.isLoading = false;
            });
        },

        getVisSoldProducts() {
            this.isLoading = true;
            const criteria = new Criteria(this.page, this.limit);
            criteria.addAssociation('product');
            criteria.addAssociation('customer');
            if (this.visSoldProductsDate) {
                criteria.addFilter(Criteria.multi('AND', [
                    Criteria.range('date',
                        {gte: this.formatDate(new Date(this.visSoldProductsDate), -1)}
                    ),
                    Criteria.range('date',
                        {lte: this.formatDate(new Date(this.visSoldProductsDate), 1)}
                    )
                ]));
            }

            this.visSoldRepository.search(criteria, Shopware.Context.api).then(visSoldProductsResult => {
                this.visSoldProductsResult = visSoldProductsResult;
                this.visSoldProductsTotal = visSoldProductsResult.total;
                this.isLoading = false;
            }).catch(() => {
                this.isLoading = false;
            });
        },

        getVisSoldClickedProducts() {
            this.isLoading = true;
            const criteria = new Criteria(this.page, this.limit);
            if (this.visSoldClickedProductsDate) {
                criteria.addFilter(Criteria.multi('AND', [
                    Criteria.range('date',
                        {gte: this.formatDate(new Date(this.visSoldClickedProductsDate), -1)}
                    ),
                    Criteria.range('date',
                        {lte: this.formatDate(new Date(this.visSoldClickedProductsDate), 1)}
                    )
                ]));
            }

            this.visSoldClickedRepository.search(criteria, Shopware.Context.api).then(visSoldClickedProductsResult => {
                this.visSoldClickedProductsResult = visSoldClickedProductsResult;
                this.visSoldClickedProductsTotal = visSoldClickedProductsResult.total;
                this.isLoading = false;
            }).catch(() => {
                this.isLoading = false;
            });
        },

        formatDate(date, days) {
            return `${date.getFullYear()}-${(`0${date.getMonth() + 1}`).slice(-2)}-${(`0${date.getDate() + days}`).slice(-2)}`;
        },
    }
});
