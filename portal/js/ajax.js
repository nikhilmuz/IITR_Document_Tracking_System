function send_ajax(url,params,callbkfn){
var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
			window[callbkfn](this.responseText,this.status,this.readyState);
        };
        xmlhttp.open("POST", url, true);
        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlhttp.send(params);
}