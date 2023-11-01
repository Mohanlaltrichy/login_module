var globvar='';

function selectcountry(){
    var cntry = $("#country").val();
    var zon = '';
    $("#zone").find('option').remove();

    $.ajax({
    url: 'country_zone',
    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
    type: 'post',
    data:{cntry},
    success: function(data){
      var parse_data = JSON.parse(data); 
      $.each(parse_data,function(index,value){
      zon+= '<option value="'+value.time_zone+'">' + value.time_zone + '</option>';
  
    })
  
      $('#zone').prepend('<option selected="" disabled="disabled">select</option>');
      $('#zone').append(zon);
     
      }
      });
}

function selectopic(){
    var topic = $("#topic").val();
    var dev = '';
    $("#dname,#tag,#alias").find('option').remove();

    $.ajax({
    url: 'topic_dname',
    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
    type: 'post',
    data:{topic},
    success: function(data){
      var parse_data = JSON.parse(data); 
      $.each(parse_data,function(index,value){
      dev+= '<option value="'+value.device_id+'">' + value.device_id + '</option>';
  
    })
  
      $('#dname').prepend('<option selected="" disabled="disabled">select</option>');
      $('#dname').append(dev);
     
      }
      });
}

function selectdev(){
  $('#security').prop('checked', false);
         $("#tag,#alias").val(0)
         //get matcged all
         var dname = $("#dname").val();
         var topic = $("#topic option:selected").val();

     
         $("#tag,#alias").find('option').remove();
         
         var tag = '';
         var alias = '';
         $.ajax({
             url: 'dname_tag',
             headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
             type: 'post',
             data: {dname,topic},
             success: function(data){
               var parse = JSON.parse(data); 
               $.each(parse,function(index,value){
            
                     if(value.tag !== null){
                       tag+= '<option value="'+value.tag+'">' + value.tag + '</option>';     
                     }
                     if(value.alias !== null){
                     alias+= '<option value="'+value.alias+'">' + value.alias + '</option>';            
                     }
                   })
     
                 $('#tag').prepend('<option selected="" disabled="disabled">select</option>');
                 $('#alias').prepend('<option selected="" disabled="disabled">select</option>');
                 
                 $('#tag').append(tag);
                 $('#alias').append(alias);
             }
             });
}

function selecttag(){
  $('#security').prop('checked', false);
  var tag = $("#tag").val();
  var topic = $("#topic").val();
  var alias = '';
  $("#alias").find('option').remove();

  $.ajax({
  url: 'tag_alias',
  headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
  type: 'post',
  data:{tag,topic},
  success: function(data){
    var parse_data = JSON.parse(data); 
    $.each(parse_data,function(index,value){

      if(value.alias !== null){
    alias+= '<option value="'+value.alias+'">' + value.alias + '</option>';
      }
  })

    $('#alias').prepend('<option selected="" disabled="disabled">select</option>');
    $('#alias').append(alias);
   
    }
    });
}

function check(){
  $('input[type="checkbox"]').on('change', function() {
  $('input[name="' + this.name + '"]').not(this).prop('checked', false);
  });
  }

  function change_security(){
    var topic= $("#topic").val();
    var sec= $("#mqt-security").val();
    if(sec == 'username'){
      sectbl = (
        '<tr class="thead"><th>Topic</th><th>Security</th><th>Username</th><th>password</th></tr>'+
                  '<tr>' +
                  '<td><input  id="hevent-opc" class="hevent css read" name="jdev" value="'+ topic +'" readonly/></td>'+
                  '<td><input  id="mqt-security" class="hevent css" name="heventname" value="'+ sec +'" readonly/></td>'+
                  '<td><input id="uname" class="hevent css" name="heventname" required/></td>'+
                  '<td><input type="password" id="password" class="hevent css" name="heventname" required/></td>'+
                  '</tr>'
                );
    }
    if(sec == 'anonymous'){
      sectbl = (
        '<tr class="thead"><th>Topic</th><th>Security</th></tr>'+
                  '<tr>' +
                  '<td><input  id="hevent-opc" class="hevent css read" name="jdev" value="'+ topic +'" readonly/></td>'+
                  '<td><input  id="mqt-security" class="hevent css" name="heventname" value="'+ sec +'" readonly/></td>'+
                  '</tr>'
                );
      }
                $("#tab1").show().empty().append(sectbl);
                $(".thead").css({"height":"40px","background-color":"#eaeaea","padding":"20px","width":"50%"});
                $(".read").css({"background-color":" #f4f7Fa"});
          
                $("#save,#reset,#cancel").show();
                $(".css").css({"width":"100%", "height":"40px","border":"1px solid #ccc","font-size":"13px","font-family":"inherit"});  

  }


function renderTemplate(){
  if ($('#security').is(':checked')) {
    var topic= $("#topic").val();

    $.ajax({
      url: 'getsecurity',
      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      type: 'post',
      data : {topic},
      success: function(data){
        var parse = JSON.parse(data); 
        $.each(parse,function(index,secur){
          if((secur.security) === 'username'){
            var  security_opt='anonymous';
           }  if((secur.security) === 'anonymous'){
             var security_opt='username';
           }
        if( (secur.security) === 'username'){
        sectbl = (
         '<tr class="thead"><th>Topic</th><th>Security</th><th>Username</th><th>password</th></tr>'+
                   '<tr>' +
                   '<td><input  id="hevent-opc" class="hevent css read" name="jdev" value="'+ topic +'" readonly/></td>'+
                   '<td><select  id="mqt-security" class="statusupt" onchange="change_security()"><option value="'+secur.security+'">'+secur.security+'</option><option value="'+security_opt+'">'+security_opt+'</option></select></td>'+
                  //  '<td><input  id="sec-dd" class="hevent css" name="heventname" value="'+ secur.security +'" onchange="sectype()"/></td>'+
                   '<td><input  id="uname" class="hevent css" name="heventname" value="'+ secur.username +'"/></td>'+
                   '<td><input type="password" id="password" class="hevent css" name="heventname" value="'+ secur.password +'"/></td>'+
                   '</tr>'
                 );  
        }        if( (secur.security) === 'anonymous'){
          sectbl = (
            '<tr class="thead"><th>Topic</th><th>Security</th></tr>'+
                      '<tr>' +
                      '<td><input  id="hevent-opc" class="hevent css read" name="jdev" value="'+ topic +'" readonly/></td>'+
                      '<td><select  id="mqt-security" class="statusupt" onchange="change_security()"><option value="'+secur.security+'">'+secur.security+'</option><option value="'+security_opt+'">'+security_opt+'</option></select></td>'+
                      '</tr>'
                    );  
        }
                 $("#tab1").show().empty().append(sectbl);
                 $(".thead").css({"height":"40px","background-color":"#eaeaea","padding":"20px","width":"50%"});
                 $(".read").css({"background-color":" #f4f7Fa"});
           
                 $("#save,#reset,#cancel").show();
                 $(".css").css({"width":"100%", "height":"40px","border":"1px solid #ccc","font-size":"13px","font-family":"inherit"});  
                 $(".statusupt").css({"height":"40px","width":"100%","font-size":"13px"});
                
              })
            }
          })
        }
            else{
  var alias= $("#alias").val();
  var tag= $("#tag").val();
  var dname= $("#dname").val();
  var topic= $("#topic").val();
    if(topic == null || dname == null){
    alert("Select Topic and Device ID");
    $("#save,#reset,#cancel,#tab1").hide();
    return false;

  }else{
  $.ajax({
    url: 'mqtt_srchresult',
    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
    type: 'post',
    async:true,
    data:{dname,topic,tag,alias},
    success: function(data){
      dnmetbl=''
      dnmetbl+='<tr class="thead" id="opcss"><th>#</th><th>Topic</th><th>Device ID</th><th>Tag</th><th>Alias</th><th>TimeZone</th><th>Date Format</th><th>Status</th></tr>'
      var parse = JSON.parse(data); 
      $.each(parse,function(i,dnameresult){
        if((dnameresult.status) === 'active'){
          var  status='inactive';
         }else{
           var status='active';
         }
           dnmetbl += (
            '<td><input id="checkbox" class="checkbox" name="checkbox" value="'+dnameresult.id+'" type="checkbox" onclick="check()"></td>'+
            '<td><input  id="mqttres-topic" class="mqtbrokerclass read" name="mqt-topic" data-topic="'+dnameresult.topic+'" value="'+ dnameresult.topic +'" readonly/></td>'+
            '<td><input  id="mqttres-devid" class="mqtbrokerclass read" name="mqt-devid" data-dev="'+dnameresult.device_id+'"  value="'+ dnameresult.device_id +'" readonly/></td>'+
            '<td><input  id="mqttres-tag" class="mqtbrokerclass" name="mqt-tag'+dnameresult.id+'" data-tag="'+dnameresult.tag+'" value="'+ dnameresult.tag +'"/></td>'+
            '<td><input  id="mqttres-alias" class="mqtbrokerclass" name="mqt-alias'+dnameresult.id+'" data-alias="'+dnameresult.alias+'" value="'+ dnameresult.alias +'"/></td>'+
            '<td><input  id="mqttres-zone" class="mqtbrokerclass" name="mqt-zone" data-zone="'+dnameresult.time_zone+'" value="'+ dnameresult.timezone +'"/></td>'+
            '<td><input  id="mqttres-datetime" class="mqtbrokerclass" name="mqt-datetime" data-date="'+dnameresult.datetime_local+'" value="'+ dnameresult.datetime_local +'"/></td>'+
            // '<td><input  id="mqttres-hevnt" class="mqtbrokerclass" name="mqt-hevent" data-sts="'+dnameresult.status+'" value="'+ dnameresult.status +'"/></td>'+
            '<td><select  id="mqt-status" class="statusupt"><option value="'+dnameresult.status+'">'+dnameresult.status+'</option><option value="'+status+'">'+status+'</option></select></td>'+
            // '<td><input type="button"  id="mqttres-topic" class="mqtbrokerclass read" name="mqt-topic" value="delete"/></td>'+
            '</tr>'
       );
      })

      $("#tab1").show().empty().append(dnmetbl);
      $("#save,#reset,#cancel").show();

      $(".mqtbrokerclass").css({"width":"100%", "height":"40px","border":"1px solid #ccc","font-size":"13px","font-family":"inherit"});
      $(".thead").css({"height":"40px","background-color":"#eaeaea","margin-left":"10%","width":"50%","font-weight":"500"});
      $(".read").css({"background-color":" #f4f7Fa"});
      $(".statusupt").css({"height":"40px","width":"100%","font-size":"13px"});

   }
  })
 }
}
}



function save(){
  if ($('#security').is(':checked')) {
    var topic= $("#topic").val();
    var securit= $("#mqt-security").val();
    var uname= $("#uname").val();
    var password= $("#password").val();

    if((securit) == 'username'){
      if(uname.length == 0 || uname == 'null' || password.length == 0 || password == 'null' ){
        alert('Username and password required')
        return false;
      }
    }

    $.ajax({
      url: 'security_update',
      method: 'post',
      async:true,
      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      data: {topic,securit,uname,password},
      success:function(response){
      console.log(response);
      alert(response);
      }
  });
  }else{
  var rows = $('#tab1 tr').length
  if(rows == 2){
    $('.checkbox').prop('checked', true);
  }
   
        if ($('input.checkbox').is(':checked')) {
          var id= $("#checkbox:checked").val();
          var tag =$("input[name='mqt-tag" +id+ "']").val();
          var alias =$("input[name='mqt-alias" +id+ "']").val();
         
      var topic = $('#mqttres-topic').val();
      var dname = $('#mqttres-devid').val();
      var status = $('#mqt-status').val();
      // var tag = $('#mqttres-tag').val();
      // var alias = $('#mqttres-alias').val();
      if(tag.length == 0 || tag == 'null' || alias.length == 0 || alias == 'null' ){
        alert('Value should not be empty/null')
        return false;
      } 
      $.ajax({
      url: 'mqttresultupdate',
      method: 'post',
      async:true,
      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      data: {topic,dname,tag,alias,id,status},
      success:function(response){
      console.log(response);
      alert(response);
      }
  });
  }else{
  alert('please check the row you are update')
}
}
}

function mqtt_delete(){
  var rows = $('#tab1 tr').length
  if(rows == 2){
    $('.checkbox').prop('checked', true);
  }
   
        if ($('input.checkbox').is(':checked')) {
          // var id= $("#checkbox:checked").val();
          var dname = $('#mqttres-devid').val();
        
          let text;
          if (confirm("are you sure to want delete") == true) {

           alert(dname);
          } else {
          alert("no");
          }
}else{
  alert('please check the row you are delete')
}
}

