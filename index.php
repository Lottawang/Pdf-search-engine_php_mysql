<!DOCTYPE html> 
<html lang="en"> 
<head>
	<title>Danfeng Wang AMF program</title>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<?php
include("connector.php");

$sql="SELECT company.com_id AS id,company.com_risk AS name,LIABILITY.liab_name AS liability,PROPERTY.pro_name AS property, EO.eo_name AS eo, EXCESS.exc_name AS excess,UMBRELLA.umb_name AS umbrella
   	FROM company,LIABILITY,PROPERTY,EO,EXCESS,UMBRELLA, business
   	WHERE company.language = 'E' 
  	AND company.com_id = business.com_id
  	AND LIABILITY.liab_id = business.liab_id
  	AND PROPERTY.pro_id = business.pro_id
  	AND EO.eo_id = business.eo_id
  	AND EXCESS.exc_id=business.exc_id
  	AND UMBRELLA.umb_id = business.umb_id
  	ORDER BY company.com_id";

$result=$obj->query($sql);

$count=$result->num_rows;


function parse($string){
$output1='';
if(count($array=preg_split("/\s(and)\s/", "$string"))==1){

 	$array=preg_split("/\s(or)\s/","$string");

 	$output1 .='<img src="icon.png" width="25" height="25" title="'.$array[0].'">';
 	return $output1;
}else {

 	$output1 .='<img src="icon.png" width="25" height="25" title="'.$array[0].'">';
 	$output1 .='<img src="icon.png" width="25" height="25" title="'.$array[1].'">';

 	return $output1;
   } 
}
?>

<body>
<div style="background-color:grey">
<br>
<br>
<form id="form" class="form-inline" style="margin-left:10%; margin-right:10%;">
	<span class="custom-control-description"><font color="white", size="4">Please input here </font></span>
	<input type="text" class="form-control mb-2 mr-sm-2 mb-sm-0" id="input" name="input" placeholder="company type...">

	<label class="custom-control custom-radio">
	  <input id="language1" name="language" type="radio" class="custom-control-input" value="E">
	  <span class="custom-control-indicator"></span>
	  <span class="custom-control-description"><font size="4">English</font></span>
	</label>
	<label class="custom-control custom-radio ">
	  <input id="language2" name="language" type="radio" class="custom-control-input" value="F">
	  <span class="custom-control-indicator"></span>
	  <span class="custom-control-description"><font size="4">French</font></span>
	</label>

  <button type="submit"  value="submit" class="btn btn-primary">Search</button>
</form>
<br>
<hr size="10" color="black">
</div>
</div>

<div id="return" style="margin-left:10%; margin-right:10%; margin-bottom:5%">
    <table class="tables table-hover table-condensed table-bordered table-rounded">
       <thead>
            <tr style="background-color:LightBlue;">
            <th width="25%">Description of Risk</th>
            <th width="15%">Liability</th>
            <th width="15%">Property</th>
            <th width="15%">E&O</th>
            <th width="15%">Excess</th>
            <th width="15%">Umbrella</th>
            </tr>
            </thead>
                <tbody>
                <?php
               	 while($row=$result->fetch_assoc()): ?>
   					<tr>
          			  	<td><a href="#" target=_blank>  <?php  echo $row['name']; ?>  </a></td>
            			<td><? echo parse($row['liability']); ?></td>
           				<td><? echo parse($row['property']); ?></td>
           				<td><img src="icon.png" width="25" height="25" title=<? echo $row['excess'] ?>></td>
            			<td><img src="icon.png" width="25" height="25" title=<? echo $row['excess'] ?>></td>
            			<td><img src="icon.png" width="25" height="25" title=<? echo $row['umbrella'] ?>></td> 
    				</tr>
				<?php endwhile; ?>
				</tbody>
    </table>
</div>


</body> 
<script>
	$(document).ready(function(){
		$('form').submit(function(e){
			var input = $('input[name=input]').val();

			var radios=document.getElementsByName("language");
	        for(var i=0;i<radios.length;i++){
	            if(radios[i].checked==true){
	                var lan=radios[i].value;
	            }
	        }

	        if(lan == null){
	        	alert("Please input the key word and select the Language.");
	        }
	        else{
	        	var data = {input:input, language:lan}

	        	$.ajax({
					type: "POST",
 					url: "search.php",
					data: data,
					success: function(data){
						document.getElementById("return").innerHTML=(data)
					}
	        	})
	        }
			

			e.preventDefault();
		})

	})


</script>

</html>