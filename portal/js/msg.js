function generate_message(elementid,type,text,msgid,dismisstype,action){
	var content='<div style="text-align: center;" class="alert alert-dismissable fade in alert-'+type+'"><a href="#" id="'+msgid+'" '+dismisstype+' class="close" data-dismiss="alert" aria-label="close">&times;</a><strong style="font-size: 100%">'+text+'</strong></div>';
	if (action=="merge"){
	$('#'+elementid).html($('#'+elementid).html()+content);}
	else if (action==="clear"){
	$('#'+elementid).html(content);}
}