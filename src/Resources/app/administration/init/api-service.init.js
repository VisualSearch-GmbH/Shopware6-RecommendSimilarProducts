import ApiKeyVerifyService from '../../administration/core/service/api/api-key-verify.service';

const { Application } = Shopware;

Application.addServiceProvider('ApiKeyVerifyService', (container) => {
    const initContainer = Application.getContainer('init');
    return new ApiKeyVerifyService(initContainer.httpClient, container.loginService);
});
