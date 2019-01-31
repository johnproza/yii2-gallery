/**
 * Created by john one on 16.10.2018.
 */
import csrf from './csrf.js';
var promise = (params) => new Promise((resolve, reject) => {
    //console.log('test params',params,csrf)
    var data = {};
    if (params.csrf === true || params.csrf===undefined ){
        data[csrf.param] = csrf.token;
    }

    var ajax = $.ajax({
        url: params.url,
        header: params.headers ? params.headers : 0,
        type: params.method,
        data: Object.assign(params.data!==undefined ? params.data : {},data),
        beforeSend : function(e){
            if (location.pathname.indexOf('login')!=-1){
                return false;
            }
        },
        success: function(response, textStatus, jqXHR) {
            if(params.headers){
                console.log('Debug all ResponseHeaders', ajax.getAllResponseHeaders())
            }
            resolve({
                status : textStatus,
                response :response
            });
        }
    })

});

export default promise;