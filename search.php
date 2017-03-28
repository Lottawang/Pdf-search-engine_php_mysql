<?php
include("connector.php");
$input=$_POST["input"];
$language=$_POST['language'];
$output='';
 	$sql="SELECT company.com_id AS id,company.com_risk AS name,LIABILITY.liab_name AS liability,PROPERTY.pro_name AS property, EO.eo_name AS eo, EXCESS.exc_name AS excess,UMBRELLA.umb_name AS umbrella
    FROM company,LIABILITY,PROPERTY,EO,EXCESS,UMBRELLA, business
   	WHERE 
    company.com_risk LIKE '%".$input."%'
    AND company.language='$language'
   	AND company.com_id = business.com_id
   	AND LIABILITY.liab_id = business.liab_id
   	AND PROPERTY.pro_id = business.pro_id
   	AND EO.eo_id = business.eo_id
   	AND EXCESS.exc_id=business.exc_id
   	AND UMBRELLA.umb_id = business.umb_id
   	ORDER BY company.com_id";
$result=$obj->query($sql);
$count=$result->num_rows;
if($count>0)
{
    $output .='<table class="tables table-hover table-condensed table-bordered table-rounded">';
    $output .='         <thead>
            <tr style="background-color:LightBlue;">
            <th width="25%">Description of Risk</th>
            <th width="15%">Liability</th>
            <th width="15%">Property</th>
            <th width="15%">E&O</th>
            <th width="15%">Excess</th>
            <th width="15%">Umbrella</th>
            </tr>
            </thead>';
    while($row=$result->fetch_assoc()){
      $output .='<tr>
  									<td><a href="#" target=_blank> '.$row['name'].'</a></td>
  									<td>'.parse($row['liability']).'</td>
  									<td>'.parse($row['property']).'</td>
  									<td><img src="icon.png" width="30" height="30"title='.$row['eo'].'></td>
                			<td><img src="icon.png" width="30" height="30"title='. $row['excess'].'></td>
                			<td><img src="icon.png" width="30" height="30"title='.$row['umbrella'].'></td> 
  								</tr>';
    }
    echo $output;
}
else{
  echo 'Sorry, No Records.';
}

  function parse($string){

    $output1='';

    if(count($array=preg_split("/\s(and)\s/", "$string"))==1){
      if(count($array=preg_split("/\s(or)\s/","$string"))==1){
        $output1 .='<img src="icon.png" width="30" height="30"title="'.$array[0].'">';

      }else{

        $output1 .='<table class="table table-striped table-condensed table-bordered table-rounded"><tr style="background-color:yellow"><td><img src="icon.png" width="30" height="30"title="'.$array[0].'"></td><br></tr><tr style="background-color:green"><td><img src="pdf.png" width="30" height="30"title="'.$array[1].'"></td></tr></table>';

      }
 	
   	//$output1 .='<img src="icon.png" width="30" height="30"title="'.$array[0].'">';
   	return $output1;
   }

   else {
   	$output1 .='<img src="icon.png" width="30" height="30"title="'.$array[0].'">';
   	$output1 .='<img src="icon.png" width="30" height="30"title="'.$array[1].'">';
   	//retrun array
   	return $output1;
   } 
}
?>