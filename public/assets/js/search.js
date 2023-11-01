 
 var tr='';
 var opctbl='';
 var dnmetbl='';
 var gb='';
//  var selectdevice='';
//  var opcresult='';
 
 
 function selectopc(){
  gb = 'opcserver';
  var opc_id = $("#opcserver").val();
  $("#nsub,#esub,#dname,#hdata,#hevent").find('option').remove();
  var dev = '';

  $.ajax({
  url: 'opcall',
  headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
  type: 'post',
  data:{opc_id},
  success: function(data){
    var parse_data = JSON.parse(data); 
    $.each(parse_data,function(index,value){
    dev+= '<option value="'+value.device_name+'">' + value.device_name + '</option>';

  })

    // response.devicelist.forEach(function(dvice){
      
    //   dev+= '<option value="'+dvice.device_name+'">' + dvice.device_name + '</option>';
    //dev+= '<option data-id="'+nodes.opc_server+'" data-nodeid="'+dvice.id+'" data-node="'+nodes.nodes_to_subscribe+'" value="'+nodes.device_name+'">' + dvice.device_name + '</option>';

    // })
    $('#dname').prepend('<option selected="" disabled="disabled">--select--</option>'); 
    $('#dname').append(dev);
   
    }
    });
   
    }
 
 function selectdev(){
   gb='devicename'
    $("#esub,#hdata,#nsub,#hevent").val(0)
    //get matcged all
    var dname = $("#dname").val();
    var opcn = $("#opcserver option:selected").val();

    $("#nsub,#esub,#hdata,#hevent").find('option').remove();
    
    var node = '';
    var eventsub = '';
    var hdata = '';
    var hevent = '';
    $.ajax({
        url: 'dname_all',
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: 'post',
        data: {dname,opcn},
        success: function(data){
          var parse = JSON.parse(data); 
          $.each(parse,function(index,value){
   

               $("#nsub").append('<option data-opc="'+value.opc_server+'" data-device="'+value.device_name+'" data-nodeid="'+value.id+'" value="'+value.nodes_to_subscribe+'">' + value.nodes_to_subscribe + '</option>');          
               
                if(value.events_to_subscribe !== null){
                  eventsub+= '<option data-opc="'+value.opc_server+'" data-device="'+value.device_name+'" data-nodeid="'+value.id+'" value="'+value.events_to_subscribe+'">' + value.events_to_subscribe + '</option>';          
                }
                if(value.history_data_nodes !== null){
                hdata+= '<option data-opc="'+value.opc_server+'" data-device="'+value.device_name+'" data-nodeid="'+value.id+'" value="'+value.history_data_nodes+'">' + value.history_data_nodes + '</option>';          
                }
                if(value.history_event_nodes !== null){
                hevent+= '<option data-opc="'+value.opc_server+'" data-device="'+value.device_name+'" data-nodeid="'+value.id+'" value="'+value.history_event_nodes+'">' + value.history_event_nodes + '</option>';            
                }
              })

            $('#nsub').prepend('<option selected="" disabled="disabled">--select--</option>');
            $('#esub').prepend('<option selected="" disabled="disabled">--select--</option>');
            $('#hdata').prepend('<option selected="" disabled="disabled">--select--</option>');
            $('#hevent').prepend('<option selected="" disabled="disabled">--select--</option>');
            
            // $('#nsub').append(node);
            $('#esub').append(eventsub);
            $('#hdata').append(hdata);
            $('#hevent').append(hevent);
        }
        });

  };
 
    function selectnodsub(){
        $("#esub,#hdata,#hevent").val($("option:first").val()); 
        gb='nodestosub'
    };
    
    function selectevesub(){
     $("#hdata,#nsub,#hevent").val($("option:first").val());
     gb='eventosub'
    };
 
    function selecthdata(){
     $("#esub,#nsub,#hevent").val($("option:first").val());
     gb='hdatanodes'
    };
 
    function selecthevent(){
     $("#esub,#hdata,#nsub").val($("option:first").val());
     gb='hevntnodes'
    
    };
 
    function check(){
     $('input[type="checkbox"]').on('change', function() {
     $('input[name="' + this.name + '"]').not(this).prop('checked', false);
   
  //    var id= $("#checkbox:checked").val();
  //  alert(id);
     });
     }
  
 
  function renderTemplate(){

    if(gb == 'opcserver'){
      var opc=$("#opcserver").val();
   $.ajax({
     url: 'srchopc',
     headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
     type: 'post',
     data : {opc},
     success: function(data){
       var parse = JSON.parse(data); 
       $.each(parse,function(index,opcres){

       if((opcres.status) === 'active'){
         var  status='inactive';
        }else{
          var status='active';
        }
       if( (opcres.security) === 'username'){
         opctbl = (
             '<tr class="theader" id="opcss"><th>Opc server</th><th>Security</th><th>Username</th><th>password</th><th>Mqtt Topic</th><th>status</th></tr>'+
                       '<tr>' +
                       '<td><input  id="opc-name" class="opcserver read" name="jdev" data-nodeid="'+ opcres.opc_id +'" value="'+ opcres.opc_server +'" readonly/></td>'+
                       '<td><input  id="opc-sec" class="opcserver read" name="jdev" value="'+ opcres.security +'" readonly/></td>'+
                       '<td><input  id="opc-uname" class="opcserver" name="vijay" value="'+ opcres.username +'"/></td>'+
                       '<td><input  type="password" id="opc-pwd"  minlength="1" name="vk" value="" class="opcserver"/></td>'+
                       '<td><input  id="opc-mqtt" class="opcserver" name="kv" value="'+ opcres.mqtt_topic +'"/></td>'+
                       // '<td><input  id="opc-status" class="opcserver" name="jnode"  value="'+ opcres.status +'"/></td>'+
                       '<td><select  id="opc-status" class="statusupt"><option value="'+opcres.status+'">'+opcres.status+'</option><option value="'+status+'">'+status+'</option></select></td>'+
                       '</tr>'
                     );
                   }
                   if ((opcres.security) === 'certificate'){
                     opctbl = (
             '<tr class="theader" id="opcss"><th>Opc server</th><th>Security</th><th>Policy</th><th>Mode</th><th>Certificate key</th><th>Private Key</th><th>Mqtt Topic</th><th>status</th></tr>'+
                       '<tr>' +
                       '<td><input  id="opc-name" class="opcserver read" name="jdev" data-nodeid="'+ opcres.opc_id +'" value="'+ opcres.opc_server +'" readonly/></td>'+
                       '<td><input  id="opc-sec" class="opcserver read" name="jdev" value="'+ opcres.security +'" readonly/></td>'+
                       '<td><input  id="opc-policy" class="opcserver" name="jdev" value="'+ opcres.policy +'"/></td>'+
                       '<td><input type="text" id="opc-mode" class="opcserver" name="jdev" value="'+ opcres.mode +'" /></td>'+
                       '<td><input  id="opc-ckey" class="opcserver" name="jdev" value="'+ opcres.c_key +'" ></td>'+
                       '<td><input  id="opc-pkey" class="opcserver" name="jdev" value="'+ opcres.p_key +'" /></td>'+
                       '<td><input  id="opc-mqtt" class="opcserver" name="jdev" value="'+ opcres.mqtt_topic +'" /></td>'+
                       '<td><select  id="opc-status" class="statusupt"><option value="'+opcres.status+'">'+opcres.status+'</option><option value="'+status+'">'+status+'</option></select></td>'+
                       '</tr>'
                     );
                   }
                   if ((opcres.security) === 'anonymous'){
                     opctbl = (
             '<tr class="theader" id="opcss"><th>Opc server</th><th>Security</th><th>Mqtt Topic</th><th>status</th></tr>'+
                       '<tr>' +
                       '<td><input  id="opc-name" class="opcserver read" name="jdev" data-nodeid="'+ opcres.opc_id +'" value="'+ opcres.opc_server +'" readonly/></td>'+
                       '<td><input  id="opc-sec" class="opcserver read" name="jdev" value="'+ opcres.security +'" readonly/></td>'+
                       '<td><input  id="opc-mqtt" class="opcserver" name="jdev" value="'+ opcres.mqtt_topic +'"/></td>'+
                       '<td><select  id="opc-status" class="statusupt"><option value="'+opcres.status+'">'+opcres.status+'</option><option value="'+status+'">'+status+'</option></select></td>'+
                       '</tr>'
                     );
                   }
        });
        $("#tab1").show().empty().append(opctbl);
        $("#save,#reset,#cancel").show();
  
        $(".opcserver").css({"width":"100%", "height":"40px","border":"1px solid #ccc","font-size":"13px","font-family":"inherit"});  
        $(".theader").css({"height":"40px","background-color":"#eaeaea","padding":"20px","width":"50%"});
        $("#opc-status").css({"height":"40px","width":"100%","font-size":"13px"});
        $(".read").css({"background-color":" #f4f7Fa"});

        }
     
      })
    
    }

    if(gb == 'devicename'){
      var dname=$("#dname").val();
      var opcname= $("#opcserver option:selected").attr('data-opc');
      $.ajax({
        url: 'dnameresult',
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: 'post',
        async:true,
        data:{dname,opcname},
        success: function(data){
          dnmetbl=''
          dnmetbl+='<tr class="thead" id="opcss"><th>#</th><th>Device name</th><th>Nodes to subscribe</th><th>Events to subscribe</th><th>History Data Nodes</th><th>History Event Nodes</th></tr>'
          var parse = JSON.parse(data); 
          $.each(parse,function(index,dnameresult){
               dnmetbl += (
                '<tr id="paginate">' +
                '<td><input id="checkbox" class="checkbox" name="checkbox" value="'+dnameresult.id+'" type="checkbox" onclick="check()"></td>'+
                '<td><input  id="dname-name" class="opcserver read" name="dname-dname'+dnameresult.id+'" value="'+ dnameresult.device_name +'"/></td>'+
                '<td><input  id="dname-node" class="opcserver" name="dname-node'+dnameresult.id+'" value="'+ dnameresult.nodes_to_subscribe +'"/></td>'+
                '<td><input  id="dname-evnt" class="opcserver" name="dname-event'+dnameresult.id+'" value="'+ dnameresult.events_to_subscribe +'"/></td>'+
                '<td><input  id="dname-hdata" class="opcserver" name="dname-hdata'+dnameresult.id+'" value="'+ dnameresult.history_data_nodes +'"/></td>'+
                '<td><input  id="dname-hevnt" class="opcserver" name="dname-hevent'+dnameresult.id+'" value="'+ dnameresult.history_event_nodes +'"/></td>'+
                '</tr>'
           );
          })
          $("#tab1").show().empty().append(dnmetbl);
          $("#save,#reset,#cancel").show();

          $(".opcserver").css({"width":"100%", "height":"40px","border":"1px solid #ccc","font-size":"13px","font-family":"inherit"});
          $(".thead").css({"height":"40px","background-color":"#eaeaea","margin-left":"10%","width":"50%","font-weight":"500"});
          $(".read").css({"background-color":" #f4f7Fa"});
       }
      })
    }

   if(gb == 'hevntnodes'){
       var hevent = $("#hevent").val();
       var opc = $("#hevent option:selected").attr('data-opc');
       var id = $("#hevent option:selected").attr('data-nodeid');
       var dev = $("#hevent option:selected").attr('data-device');
        tr = (
         '<tr class="thead"><th>Device Name</th><th>History Event Nodes</th></tr>'+
                   '<tr>' +
                   '<td><input  id="hevent-opc" class="hevent css read" name="jdev" data-opc="'+opc+'" value="'+ dev +'" readonly/></td>'+
                   '<td><input  id="hevent-val" class="hevent css" name="heventname" data-nodeid="'+ id +'" value="'+ hevent +'"/></td>'+
                   '</tr>'
                 );
     }
     if(gb == 'hdatanodes'){
       var hdata = $("#hdata").val();
     var opc = $("#hdata option:selected").attr('data-opc');
     var id = $("#hdata option:selected").attr('data-nodeid');
     var dev = $("#hdata option:selected").attr('data-device');
 
     tr = (
       '<tr class="thead"><th>Device Name</th><th>History Data Nodes</th></tr>'+
                 '<tr>' +
                 '<td><input  id="hdata-opc" class="hdata css read" name="hdata-opc" data-opc="'+opc+'" value="'+ dev +'" readonly/></td>'+
                 '<td><input  id="hdata-val" class="hdata css" name="hisdata" data-nodeid="'+ id +'" value="'+ hdata +'"/></td>'+
                 '</tr>'
               );
     }
     if(gb == 'eventosub'){
       var event = $("#esub").val();
       var opc = $("#esub option:selected").attr('data-opc');
       var id = $("#esub option:selected").attr('data-nodeid');
       var dev = $("#esub option:selected").attr('data-device');
       tr=''
       tr = (
         '<tr class="thead"><th>Device Name</th><th>Events to subscribe</th></tr>'+
                   '<tr>' +
                   '<td><input  id="event-opc" class="esub css read" name="jdev" data-opc="'+opc+'" value="'+ dev +'" readonly/></td>'+
                   '<td><input  id="event-name" class="esub css" name="jnode" data-nodeid="'+ id +'" value="'+ event +'" /></td>'+
                   '</tr>'
                 );
     }
     if(gb == 'nodestosub'){
       var node = $("#nsub option:selected").val();
       var dev = $("#nsub option:selected").attr('data-device');
       var opc = $("#nsub option:selected").attr('data-id');
        var id = $("#nsub option:selected").attr('data-nodeid');
        tr = (
         '<tr class="thead"><th>Device name</th><th>Nodes to Subscribe</th></tr>'+
                   '<tr>' +
                   '<td ><input  id="dev-name" class="nsub css read" name="jdev" value="'+ dev +'" readonly/></td>'+
                   '<td><input  id="nod-name" class="nsub css" name="jnode" data-opc="'+opc+'" data-nodeid="'+ id +'" value="'+ node +'"/></td>'+
                   '</tr>'
                 );
     }
   
     if(gb == ''){
     return false;  
     }
     else{
       $("#tab1").show().empty().append(tr);
        $("#save,#reset,#cancel").show();
 
     $(".thead").css({"height":"40px","background-color":"#eaeaea","margin-left":"10%","width":"50%","font-weight":"500"});
     $(".css").css({"width":"50%","background-color":"white" ,"height":"40px","border":"1px solid #ccc","border-radius":"5px","margin-left":"25%","font-size":"13px","font-family":"inherit"});
     $(".read").css({"background-color":" #f4f7Fa"});
     }
   }
 
 function save(){ 
 
   if(gb == 'devicename'){
   if ($('input.checkbox').is(':checked')) {
     
       var id= $("#checkbox:checked").val();
       var dnamename =$("input[name='dname-dname" +id+ "']").val();
       var dnamenode =$("input[name='dname-node" +id+ "']").val();
       var dnameevent =$("input[name='dname-event" +id+ "']").val();
       var hisdata =$("input[name='dname-hdata" +id+ "']").val();
       var hisevent =$("input[name='dname-hevent" +id+ "']").val();
       var opc = $("#opcserver option:selected").attr('data-opc');
       if(dnamenode.length === 0 || dnamenode === 'null'){
         alert('Nodes to Subscribe should not be empty/null')
         return false;
       }else{
     $.ajax({
     url: 'dnameupdt',
     method: 'post',
     async:true,
     headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
     data: {id,dnamename,dnamenode,dnameevent,hisdata,hisevent,opc},
     success:function(response){
     console.log(response);       
     alert(response);
     }
     });
   
   }
   }else {
       alert('please check the row you are update')
     return false;
   }
   
   }
 
   if(gb == 'opcserver'){
 
     if($('#opc-sec').val() == 'anonymous'){
       if( $("#opc-mqtt").val().length === 0 ||$("#opc-mqtt").val() === 'null'){
         alert('Value should not be empty/null')
         return false;
       }
     }
     if($('#opc-sec').val() == 'username'){
         if( $("#opc-mqtt").val().length === 0 ||$("#opc-mqtt").val() === 'null' ||
         $("#opc-uname").val().length === 0 ||$("#opc-uname").val() === 'null' || 
         $("#opc-pwd").val().length === 0 ||$("#opc-pwd").val() === 'null' ){
         alert('Value should not be empty/null')
     return false;
       }
     }
     if($('#opc-sec').val() == 'certificate'){
       if( $("#opc-mqtt").val().length === 0 ||$("#opc-mqtt").val() === 'null' ||
       $("#opc-policy").val().length === 0 ||$("#opc-policy").val() === 'null' || 
       $("#opc-mode").val().length === 0 ||$("#opc-mode").val() === 'null' || 
       $("#opc-ckey").val().length === 0 ||$("#opc-ckey").val() === 'null' || 
       $("#opc-pkey").val().length === 0 ||$("#opc-pkey").val() === 'null'){
       alert('Value should not be empty/null')
   return false;
     }
   }
 
 
     var opcf = $('#opc-name').val();
     var security = $('#opc-sec').val();
     var uname = $('#opc-uname').val();
     var pwd = $('#opc-pwd').val();
     var policy = $('#opc-policy').val();
     var mode = $('#opc-mode').val();
     var ckey = $('#opc-ckey').val();
     var pkey = $('#opc-pkey').val();
     var mqtt = $('#opc-mqtt').val();
     var status = $('#opc-status').val();
     var opc_id = $('#opc-name').attr('data-nodeid');
     //  alert(mqtt);
 
     $.ajax({
     url: 'opcresupdate',
     method: 'post',
     async:true,
     headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
     data: {opcf,security,uname,pwd,mqtt,status,opc_id,policy,mode,ckey,pkey},
     success:function(response){
     console.log(response);
     alert(response);
     // window.location.href = '/opcsearch'; 
     }
     });
   }
 
     //nodes to subscribe search result update
   if(gb == 'nodestosub'){
     if($('#nod-name').val().length === 0 || $('#nod-name').val() === 'null'){
       alert('Value should not be empty/null')
       return false;
     }else{
     var nodesub = $('#nod-name').val();
     var dname = $('#dev-name').val();
     var opc = $('#opcserver option:selected').text();
     var nodeid = $('#nod-name').attr('data-nodeid');
     // alert(nodesub);
 
     $.ajax({
     url: 'nsubupdt',
     method: 'post',
     async:true,
     headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
     data: {nodesub,dname,opc,nodeid},
     success:function(response){
     console.log(response);       
     alert(response);
     }
     });
   }
   }
 
   if(gb == 'eventosub'){
     if($('#event-name').val().length === 0 || $('#event-name').val() === 'null'){
       alert('Value should not be empty/null')
       return false;
     }else{
     var eventsub = $('#event-name').val();
     var dname = $('#event-opc').val();
     var opcname = $('#event-opc').attr('data-opc');
     var eventid = $('#event-name').attr('data-nodeid');
       // alert(1)
       // return false;
     $.ajax({
     url: 'eventupdate',
     method: 'post',
     async:true,
     headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
     data: {eventsub,eventid,opcname,dname},
     success:function(response){
     console.log(response);       
     alert(response);
     }
     });
   }
   }
 
 
   if(gb == 'hdatanodes'){
     if($('#hdata-val').val().length === 0 || $('#hdata-val').val() === 'null'){
       alert('Value should not be empty/null')
       return false;
     }else{
 var opcname = $('#hdata-opc').attr('data-opc');
 var dname = $('#hdata-opc').val();
 var hdata = $('#hdata-val').val();
 var hdataid = $('#hdata-val').attr('data-nodeid');
   
 $.ajax({
 url: 'hdataupdate',
 method: 'post',
 async:true,
 headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
 data: {opcname,hdata,hdataid,dname},
 success:function(response){
 console.log(response); 
 alert(response);
 }
 });
 }
 }
 
   if(gb == 'hevntnodes'){
     if($('#hevent-val').val().length === 0 || $('#hevent-val').val() === 'null'){
       alert('Value should not be empty/null')
       return false;
     }else{
     //history event nodes search result update
  var opcname = $('#hevent-opc').attr('data-opc');
  var dname = $('#hevent-opc').val();
  var hevent = $('#hevent-val').val();
  var heventid = $('#hevent-val').attr('data-nodeid');
  $.ajax({
  url: 'heventupdate',
  method: 'post',
  async:true,
  headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
  data: {opcname,hevent,heventid,dname},
  success:function(response){
  console.log(response);          
  alert(response);
 //  window.location.href = '/opcsearch'; 
  }
  });
 }
 }
             
 
    };
 
    function cancel(){
     $("#tab1,#save,#reset,#cancel").hide();
    }
 