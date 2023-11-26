<html>
<head>
</head>
<body>
	
<?php
		require('fpdf/fpdf.php');
		$con=mysqli_connect("localhost","root","","ajax_crud");
		ob_start (); 
		$pdf=new FPDF("P","mm","A4");
		$pdf->AddPage();
		$pdf->SetFont('Arial','B',12);	
		$pdf->Cell(190,15,"User details",0,1,'C');

    	$pdf->Cell(20,10,'name',1,0,'C');
		$pdf->Cell(20,10,'gender',1,0,'C');
    	$pdf->Cell(60,10,'email',1,0,'C');
    	$pdf->Cell(60,10,'image',1,1,'C');
		 $id = $_GET['id'];   	
	
    	$sql="select * from users where ID='{$id}'";
		$res=$con->query($sql);
    	if($res->num_rows>0)
		{
			while($row =$res->fetch_assoc())
			{
			
				$pdf->Cell(20,15,"{$row['NAME']}",1,0,'C');
				$pdf->Cell(20,15,"{$row['GENDER']}",1,0,'C');
				$pdf->Cell(60,15,"{$row['EMAIL']}",1,0,'C');			
				$pdf->image("image1/{$row['image']}",130,36,20,15);
			}
		}
		else
		{
			$this->Cell(10,6,"no records found",1,0,'C');
		}
 		
    // while($row=$res->fetch_assoc()){
    // }
 			

$pdf->Output('D','user.pdf');
ob_end_flush();
?>
</body>
</html>