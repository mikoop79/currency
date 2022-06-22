import axios from 'axios';

class Auth {
    constructor () {
        // set csrf token via sanctum this allows for a authorised user with laravel
        axios.get('/sanctum/csrf-cookie').then((response) => {

        });
        let userData = window.localStorage.getItem('user');
        this.user = userData ? userData : null;
        this.checkRequest();
    }

    // set the local storage of the logged in user
    setUser (token, user) {
        window.localStorage.setItem('user', JSON.stringify(user));
        this.user = user;
    }
    check () {
        return !!this.user;
    }
    logout () {
        window.localStorage.clear();
        this.user = null;
        window.routerInstance.push('/login');
    }
    checkRequest(){

        axios.interceptors.request.use(
            function(successfulReq) {
                return successfulReq;
            },
            function(error) {
                return Promise.reject(error);
            }
        );

        let that = this;
        // check response to check if logout is required
        axios.interceptors.response.use(
            function(successfulResp) {

                return successfulResp;
            },
            function(error) {

                if (error.response.status === 401){
                    that.logout();
                }
                return Promise.reject(error)
            }
        );
    }

    getUser()
    {
        return this.user;
    }
}
export default new Auth();