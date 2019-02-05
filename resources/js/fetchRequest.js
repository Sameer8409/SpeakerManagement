 
var fetchRequest=function(url){

    "use strict";

    var constructed_url=url;

    var headers=new Headers();

    headers.append("X-Requested-With", "XMLHttpRequest");
    
    headers.append("X-XSRF-TOKEN", document.querySelector('meta[name="csrf-token"]').content);

    var params={
        headers:headers,
        credentials: 'same-origin',
        cache: 'no-cache'
    };

    var searchParams=new URLSearchParams();
   
    return {
        post:function(){
            params.method='POST';
            return fetch(constructed_url,params);
        },
        get:function(){
            params.method='GET';
            if(searchParams.toString()){
                constructed_url=constructed_url+'?'+searchParams.toString();
            }
            return fetch(constructed_url,params);
        },
        setBody:function(body){
            params.body=body;
        },
        setSearchParams:function(key,value){
            searchParams.set(key,value);
        },
        setHeaders:function(key,value){
            headers.append(key,value);
        },
    };
}