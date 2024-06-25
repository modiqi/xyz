function send_request(url,data,success=null,error=null,token=null)
{
    $.ajax({
        url: url,
        type: "POST",
        headers: {
            'X-WP-Nonce': token
        },
        data:data,
        success: function(res){
            if(res.code == 200 ){
                (typeof(success)=='function') && success(res);
            } else {
                (typeof(error)=='function')  &&  error(res);
            }
        }
    });
}