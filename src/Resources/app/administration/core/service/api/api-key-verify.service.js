import ApiService from 'src/core/service/api.service';

class ApiKeyVerifyService extends ApiService {
    constructor(httpClient, loginService, apiEndpoint = '') {
        super(httpClient, loginService, apiEndpoint);
    }

    verifyKey() {
        const apiRoute = `${this.getApiBasePath()}/vis/sim/api_key_verify`
        return this.httpClient.post(
            apiRoute,  {
            }, {
                headers: this.getBasicHeaders()
            }
        ).then((response) => {
            // console.log(response);
            return response;
            // return ApiService.handleResponse(response);
        });
    }

}

export default ApiKeyVerifyService;
