import './bootstrap';

import { Confirm } from './notiflix/build/notiflix-confirm-aio';

console.log('adsasdsads',Confirm);

window.util = {};

window.util.$get = async (url,data) => {

    let status = '';
    
    return fetch(url+'?'+ new URLSearchParams(data),
    {
        headers: {
            "X-CSRF-Token": document.querySelector('meta[name="csrf-token"]').content,
            "Accept": "application/json"
        },
        method: "GET"
    }).then((response) => {
        
        status = response.status;

        if(response.status == 401){
            return {
                    status:-1,
                    message:'Please sign in',
                    data:{}
            }
        };

        if(response.status == 500){

            console.error(response);
            return {
                    status:0,
                    message:'Something went wrong',
                    data:{}
            }
        };

        return response.json();
    }).catch(e=>{

        return {
            status:0,
            message:e.message,
            data:{
                httpStatus: status
            }
        }
    });
}

window.util.$post = async (url,formData) => {

    let status = '';

    return fetch(url,
    {
        headers: {
            "X-CSRF-Token": document.querySelector('meta[name="csrf-token"]').content,
            "Accept": "application/json",
        },
        body: formData  ?? {},
        method: "POST"
    }).then((response) => {
       
        status = response.status;
        
        if(status == 401){
          
            return {
                    status:-1,
                    message:'Please sign in',
                    data:{}
            }
        };

        if(status == 500){

            console.error(response);
            return {
                    status:0,
                    message:'Something went wrong',
                    data:{}
            }
        };

        return response.json();
    }).catch(e=>{

        return {
            status:0,
            message:e.message,
            data:{
                httpStatus: status
            }
        }
    });
}