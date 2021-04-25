import './extension/sw-settings-index';
import './components/vis-log';

import enGB from '../../snippets/en_GB.json';
import deDE from '../../snippets/de_DE.json';

const { Module } = Shopware;

Module.register('vis-log', {
    type: 'plugin',
    name: 'visLog',
    title: 'vis-log.title',
    description: 'vis-log.title',
    version: '1.0.0',
    targetVersion: '1.0.0',
    color: '#9AA8B5',
    icon: 'default-device-server',

    snippets: {
        'de-DE': deDE,
        'en-GB': enGB
    },

    routes: {
        index: {
            component: 'vis-log',
            path: 'index',
        }
    }
});
