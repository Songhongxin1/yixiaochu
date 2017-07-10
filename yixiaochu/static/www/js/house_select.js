// JavaScript Document
$(function() {     
     //input placeholder
	 $(".house_id").change(function(){
         var _obj = $(this);
         var url = "/usercenter/get_ajax_house";
         var str = "----请选择楼栋----";
         html = '<option value="">----请选择户型----</option>';
         $(".model_id").html(html);
         getinfo(_obj,url,str);
     });
	
     $(".building_id").change(function(){
         var _obj = $(this);
         var url = "/usercenter/get_ajax_units";
         var str = "----请选择单元----";
         getinfo(_obj,url,str);
     });
     
     $(".unit_id").change(function(){
         var _obj = $(this);
         var url = "/usercenter/get_ajax_floor";
         var str = "----请选择楼层----";
         getinfo(_obj,url,str);
     });

     $(".floor").change(function(){
         var _obj = $(this);
         var unit = $(".unit_id").val();
         var url = "/usercenter/get_ajax_room_number/"+unit;
         var str = "----请选择房间----";
         getinfo(_obj,url,str);
     });
	

  
});

function getinfo(_obj,url,str){
    $.ajax( {
        url:url,
        data: {
            'id': _obj.val()
        },
        type:'POST',
        dataType:'json',
        success:function(data) {
            html = "";
            html += '<option value="">'+str+'</option>';

            if(data.status == 0){
                for(var i= 0; i<data.data.length;i++){
                    html += ' <option value="'+data.data[i]['id']+'">'+data.data[i]['name']+'</option>';
                }
                _obj.parent().next().find("select").html(html);

            }

        }

    });
}
