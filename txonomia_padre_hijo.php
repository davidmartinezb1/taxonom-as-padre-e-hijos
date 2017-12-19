<meta charset="utf-8">
<?php

/*conexion a la base de datos*/
$host="";
$user="";
$pwd="";
$db="";
$vid=8; // id del vocabulario

$mysqli = new mysqli($host, $user, $pwd, $db);




/*consulta padre*/
$sql = "SELECT t.tid, vid,name,weight,parent,h.tid AS tid_h 
FROM taxonomy_term_data t 
INNER JOIN taxonomy_term_hierarchy h ON t.tid=h.tid
WHERE t.vid=$vid and parent=0";


/*Fin consulta para articulos*/

$retval_1 = $mysqli->query($sql);
if (!$retval_1) {
     echo "Lo sentimos, este sitio web está experimentando problemas. ";
}

$table = '<table><tr><td>Termino ID</td><td>Vocabulario ID</td><td>Termino</td><td>Weigth</td><td>Parent</td><td>Jerarquia</td></tr>';
while ($res1=$retval_1->fetch_assoc()) {
	$table .= '<tr>';
		$table .= '<td>'.$res1['tid'].'</td>';
		$table .= '<td>'.$res1['vid'].'</td>';
		$table .= '<td>'.utf8_encode($res1['name']).'</td>';
		$table .= '<td>'.$res1['weight'].'</td>';
		$table .= '<td>'.$res1['parent'].'</td>';
		$table .= '<td>Padre</td>';
		$table .= '</tr>';
		$parent=$res1['tid'];
		$sql_2 = "SELECT t.tid, vid,name,weight,parent,h.tid AS tid_h 
		FROM taxonomy_term_data t 
		INNER JOIN taxonomy_term_hierarchy h ON t.tid=h.tid
		WHERE t.vid=$vid and parent=$parent";
		//echo $sql_2;
		
		/* Inicio consulta para videos*/
		$retval_2 = $mysqli->query($sql_2);
		if (!$retval_2) { echo "Lo sentimos, este sitio web está experimentando problemas video. ";
		} 
		else{
		
			while ($res2=$retval_2->fetch_assoc()) {
				$table .= '<tr>';
					//print "Hijo: ".$res2['name']."<br>";
					$table .= '<td>'.$res2['tid'].'</td>';
					$table .= '<td>'.$res2['vid'].'</td>';
					$table .= '<td>'.utf8_encode($res2['name']).'</td>';
					$table .= '<td>'.$res2['weight'].'</td>';
					$table .= '<td>'.$res2['parent'].'</td>';
				$table .= '</tr>';
			}
		}
	
}
$table .= '</table>';
print $table;

?>