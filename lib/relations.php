<?/*    <link rel="stylesheet" href="/kms/lib/bootstrap/3.3.7/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>   
    <script src="/kms/lib/components/treeview/bower_components/jquery/dist/jquery.js"></script>
*/?>
<script src="/kms/lib/components/treeview/js/bootstrap-treeview.js"></script>
<style>
.list-group-item {
    padding: 7px 10px !important;
}
</style>
<?php
//new relation
?>
<script>

function update_target_id(v) {
        var obj =  getObject('',v,fill_target_id);
        $('button#target_id').html("Loading...");
}

function fill_target_id(obj) {
        var v;
        var key;
        $('ul#target_id_ul').empty();
        $.each(obj, function(index,value) {
                //row
                v="";
               // console.log(this);
                key = Object.keys(this)[0];
                val = this[Object.keys(this)[0]];
		
//              if (this.name!=undefined) { val=this.name; }
//              if (this.title!=undefined) { val=this.title;}


		if ($('#target_mod').val()=="lib_pictures") {
		var filepath=this[Object.keys(this)[3]]+"/"+this[Object.keys(this)[0]];
                $('ul#target_id_ul').append("<li role=\"presentation\" value=\""+this.id+"\"><a rule=\"menuitem\" tabindex=\"-1\" href=\"#\"><img src='"+filepath+"' height=85 title=\""+val.substring(0,50)+"\"></a></li>\n<li role=\"presentation\" class=\"divider\"></li>");
		} else {
		$('ul#target_id_ul').append("<li role=\"presentation\" value=\""+this.id+"\"><a rule=\"menuitem\" tabindex=\"-1\" href=\"#\">"+val.substring(0,50)+"</a></li>");

		}
        });
	$("ul.dropdown-menu li").on("click",function() {
				console.log('li click');
                                update_target_field($('#target_mod').val()); //$(this).html(),$(this).attr('value'));
			        $('#target_id').html($(this).html());
				$('#target_id').attr('value',$(this).val());
				console.log($('#target_id').val());

        });
	$('button#target_id').html("Selecciona");

}


function update_target_field(str) {
//	console.log('update_target_field '+str);
	var type=str.substring(0,str.indexOf("_"));
	var mod=str.substr(str.indexOf("_")+1);
        var obj =  getFields(type,mod,fill_target_field);
}

function fill_target_field(obj) {
        var v;
        $('select#target_field').find('option').remove().end();
	$('select#target_field').append(new Option('',''));
        $.each(obj, function(index,value) {
                //row
                v="";
                if (this.name!=undefined) {  v=this.name; }
                if (this.title!=undefined) {  v=this.title;}
                $('select#target_field').append(new Option(v.substring(0,50),this.id));
        });
}


</script>


<div id="current_relations">
        <h3>Relacions definides</h3>
<br>
<ul id="relations_list">
<? $sel="select * from kms_sys_relations where source_mod='{$_GET['mod']}' and source_id='{$_GET['id']}'";
$res=mysql_query($sel);
$n=0;
while ($row=mysql_fetch_assoc($res)) {
        $human="";
        $sel="select * from kms_".$row['target_mod']." where id=".$row['target_id'];
        $res2=mysql_query($sel);
        $data=mysql_fetch_assoc($res2);
        if ($data[$row['target_field']]!="") $human=substr($data[$row['target_field']],0,100);
        if ($human==""&&$data['name']!="") $human=$data['name'];
        if ($human==""&&$data['title']!="") $human=$data['title'];
        if ($human==""&&$data['description']!="") $human=$data['description'];
        echo "<li id='".$row['id']."'><div title='Eliminar relació' class='customButton delete_relation fl' value=\"".$row['id']."\">x</div><div class='fl'>".$row['source_field']." ---> ".$row['target_mod']."(".$row['target_id'].").".$row['target_field']." <b>".$human."</b></div></li>";
	$n++;
}
echo "</ul>";
if ($n==0) echo "No hi ha relacions definides per aquest objecte.";
?>

</div>


<div id="new_relation">
<br><h3>Afegeix una nova relaci&oacute;</h3>
<br>
<form id="new_relation">
<input type="hidden" id="creation_date" value="<?=date('Y-m-d')?>">
	<div style="float:left;width:auto">
	<b>Objecte actual:</b><br><br>
	<div style="width:auto;float:left">
		Tipus objecte:<br>
		<input id="source_mod"  name="source_mod" value="<?=$_GET['mod']?>" readonly>
	</div>
	<div style="width:auto;float:left">
		Objecte:<br>
		<input id="source_id" name="source_id" value="<?=$_GET['id']?>" readonly>
	</div>
	 <div style="width:auto;float:left">
		Camp (opcional):<br>
		<input id="source_field" name="source_field" value="id" readonly>
	</div>
	</div>

	<div style="clear:left;width:auto;padding-top:20px">
	<b>Objecte relacionat: </b><br><br>
	<div style="width:auto;float:left">
		Selecciona el tipus d'objecte:<br>
	  
          <div id="treeview" class="" style="padding-top:5px"></div>
	  <input id="target_mod" name="target_mod" type="text" value="" style="cursor:pointer;display:none"></input>
<script>	

        var defaultData = [
          {
<?
		$cur_type=substr($_GET['mod'],0,strpos($_GET['mod'],"_"));
		$cur_objt=substr($_GET['mod'],strpos($_GET['mod'],"_")+1);


                $sel="select * from kms_sys_mod where (`type`!='sys' and name!='relations') and `type`!='events' order by `type`,name";
                $res_=mysql_query($sel);
		$current_type="";$close=false;
                while ($row=mysql_fetch_array($res_)) {
		
			if ($row['type']==$cur_type&&$row['name']==$cur_objt) {
				//skip same type
			} else { 

			if ($current_type!=$row['type']) {
				$current_type=$row['type'];
				if ($close) { ?>
]
			},
			{
<? } ?>
				text: '<?=$row['type']?>',
				tags: [''],
				nodes: [
	        {
                                        text: '<?=$row['name']?>',
					mod: '<?=$row['type']?>_<?=$row['name']?>',
                                    },<?
			$close=true;
			} else { ?>
	{
					text: '<?=$row['name']?>',
					mod: '<?=$row['type']?>_<?=$row['name']?>',
  				    },<?
		 	} 
			}?>	
                <? }
                ?>
	]
		}
	];

        $('#treeview').treeview({
	  levels: 1,
          data: defaultData,
          onNodeSelected: function(event, node) {
		//console.log(node.mod);
		if (node.mod!=undefined) {
		$('#target_mod').val(node.mod);
		$('#treeview').hide();
		$('#target_mod').show();
		update_target_id(node.mod);
		$('#target_id_div').show();
		$('#target_field_div').show();
		}
            },
        });
	$('#target_mod').click(function (obj) {
		 $('#treeview').hide();
                $('#target_mod').hide();
		$('#treeview').show();
		$('#target_id_div').hide();
		$('#target_field_div').hide();

	});


</script>

        </div>
        <div id="target_id_div" style="width:auto;float:left;margin-left:5px;display:none">
                Selecciona l'objecte:<br>
<?/*		<select id="target_id" name="target_id" style="margin-bottom:3px" onchange="update_target_field($('#target_mod').val())"></select>*/?>

		 <div class="dropdown">
    		 <button class="btn btn-default dropdown-toggle" type="button" id="target_id" data-toggle="dropdown" >Selecciona<span class="caret"></span></button>
		    <ul id="target_id_ul" name="target_id_ul" class="dropdown-menu" role="menu" aria-labelledby="menu1" style="max-height:300px;overflow:auto">
		    </ul>
		  </div>

        </div>  
        <div id="target_field_div" style="display:none;width:auto;float:left;margin-left:5px">
                Camp (opcional):<br>
		<select id="target_field" name="target_field" style="margin-bottom:3px"></select>
        </div>

	</div>
	</div>

	<div style="clear:left;padding-top:30px">
	<input id="add_relation" type="button" value="Afegeix relaci&oacute;" class="customButton highlight big">
	</div>

	</form>
</div>


<script>

function addToList(id) {
        $('ul#relations_list').append("<li id='"+id+"'><div title='Eliminar relació' class='customButton delete_relation fl' value=\""+id+"\">x</div><div class='fl'>"+$('#source_field').val()+" --> "+$('#target_mod').val()+"("+$('#target_id').val()+")."+$('#target_field').val()+"</div></li>");
}


$('input#add_relation').click(function() {
	//console.log('add');
	if ($('#target_id').val()!=undefined) {
	id=addObject("sys_relations","creation_date,source_mod,source_field,source_id,target_mod,target_field,target_id",addToList);
	} else { alert('Defineix abans la relació'); }
});

function removeFromList(id) {
        //console.log("removeFromList "+id);
        $("ul#relations_list li[value='"+id+"']").remove();
}

$('div.delete_relation').click(function() {
	//console.log('delete object '+$(this).attr('value'));
	removeObject("sys_relations",$(this).attr('value'),removeFromList);
	
});



</script>
