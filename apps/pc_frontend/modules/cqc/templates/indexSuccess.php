<?php use_javascript("http://ajax.googleapis.com/ajax/libs/jquery/1.6.3/jquery.min.js") ?>

<script type="text/javascript">
$(function(){
   loadConfig();

  $("#update_action").click(function(){

    var invalue = $("#configarea").val();
    jQuery.get("cqc/updateConfig",{name: "test" , value: invalue}, function(data){  
      //$("#configarea").text(data);
      $("#configarea").val(data);
      alert("UPDATE SUCCESS");
    }); 
  });
});


function createConfigHTML(){
  template = $(".activity.sample").clone().removeClass("sample");
  return template;
}
function loadConfig(){
 jQuery.get("cqc/loadconfig",{name: "test"}, function(data){  
   $("#configarea").val(data);
 }); 
  template = createConfigHTML();
  $("#box").html(template);
}
</script>

<div id="box">
</div>

<div style="display: none;">
<li class="activity sample">
<div class="box_body">
<p>

CQC USER PRIORITY SETTING<br>

<textarea id="configarea" name="configarea" rows="11" cols="80" style="font-size: large">
</textarea>

<div id="update_action" style="font-size: x-large">UPDATE</div>


</p>
</div>
</li>
</div>
