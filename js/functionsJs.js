function submitObjectData(idForm,idResponse,object){
    var div ='<img src="../images/flyingdots.gif" style="width:90%;">'
    jQuery.ajax({
        method:  $("#"+idForm).attr("method"),
        url:     $("#"+idForm).attr("action"),
        data:object,
        async:false,
        cache:false,
        success:function(response){
            $('#'+idResponse).html(div);
            $('#'+idResponse).fadeOut("slow", function(){
                $('#'+idResponse).fadeIn("slow").html(response);
            })
            
        }
    })
}


