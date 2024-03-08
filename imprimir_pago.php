<?php
	session_start(); // crea una sesion
	include("include/configuration.php");
	include("conf/conecta.inc.php");
	include("conf/config.inc.php");
	
	date_default_timezone_set('America/Mexico_City');
	if(!isset($_SESSION['id_usuario'])){
		header("Location: index.php");
	}
    require "fpdf/fpdf.php";    
	$fecha = date("Y-m-d");
  	$hora = date("G:i:s");
    
    $id_pago = $_GET['id'];
/*

	//echo $_POST['password'];
    $credito			= $_POST['credito'];
    $monto_pago 		= $_POST['monto-pago'];
    $tipo_pago		= $_POST['tipo-pago'];
	$fecha_pago		= $_POST['fecha-pago'];
    $comentarios			= $_POST['comentarios'];
    $fecha_captura	= $fecha." ".$hora;
	$usuario_captura	= $_SESSION['id_usuario'];
	


    $query= "INSERT INTO pagos (id_usuario,fecha_captura,id_credito,fecha_pago,monto,tipo_pago,comentarios)
   				VALUES
			('$usuario_captura',
				'$fecha_captura',
				'$credito',
				'$fecha_pago',
				'$monto_pago',
				'$tipo_pago',
				'$comentarios');";
    			$resultado= mysqli_query($mysqli,$query) or die(mysqli_error());
        
//$id_cliente = mysqli_insert_id($mysqli);

 header('Location: pagos.php?info=1');
*/
$pdf= new FPDF();


$pdf->AddPage();

$pdf->SetFont("Arial", "", 14);
$pdf->Image('img/logo-credinieto-large.png',15,15,45,23);


$pdf-> Cell(18,10,"",0);
$pdf->Cell(100,10,'',0);
$pdf->SetFont("Arial","",9);
$pdf->Cell(10,1,'Fecha Hora Impresion: '.$fecha." ".$hora."",0);
$pdf->Ln(15);
$pdf->SetFont("Arial","B",11);
$pdf->Cell(150,8,'',0);
$pdf->Cell(70,8,'Folio: '.$id_pago,0);
$pdf->Ln(15);
$pdf->Cell(70,8,'',0);
$pdf->Cell(100,8,'Impresion de Recibos',0);

$pdf->Ln(15);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(15,8,'#',0);
$pdf->Cell(30,8,'Numero de Credito',0);
$pdf->Cell(40,8,'Cliente',0);
$pdf->Cell(30,8,'Aplicado a',0);
$pdf->Cell(40,8,'Fecha Correspondiente',0);
$pdf->Cell(10,8,'Monto',0);
$pdf->Ln(8);
$pdf->SetFont('Arial','',8);

//consulta
            $consulta_productos = "SELECT 
                        pagos.id_pagos,
                        pagos.id_credito,
                        clientes.nombres,
                        clientes.apaterno,
                        clientes.amaterno,
                        pagos.monto,
                        pagos.fecha_pago,
                        pagos.fecha_captura,
                        pagos.tipo_pago,
                        pagos.comentarios   
                    FROM
                        creditos
                    INNER JOIN
                        pagos
                    ON
                        creditos.id_creditos = pagos.id_credito
                    INNER JOIN
                        clientes
                    ON
                      creditos.id_cliente = clientes.id_clientes 
                      WHERE pagos.id_pagos=$id_pago;";
            $resultado= mysqli_query($mysqli,$consulta_productos) or die(mysqli_error());

            $item=0;
            
              while($row = mysqli_fetch_array($resultado)){
                $item= $item+1;
                $pdf->Cell(15,8,$item,0);
                $pdf->Cell(30,8, $row[0],0);
                $pdf->Cell(40,8, $row[2]." ".$row[3]." ".$row[4],0);
                $cliente= $row[2]." ".$row[3]." ".$row[4];
                if($row[8] ==1){
                    $tipo_pago = "Pago de Intereses";
                }
                if($row[8] ==2){
                    $tipo_pago = "Abono a Capital";
                }
                
                $pdf->Cell(30,8, $tipo_pago,0);
                $fecha_aplicacion = date("d/m/Y",strtotime($row[6]));
                $pdf->Cell(40,8, $fecha_aplicacion,0);
                $monto_pago = number_format(($row[5]),2);
                $pdf->Cell(10,8, "$ ".$monto_pago,0);
                $pdf->Ln(8);
                }

$pdf->Ln(8);
$pdf-> Cell(30,8,"",0);
$pdf->Cell(80,8,"_________________________________",0);
$pdf->Cell(100,8,"_________________________________",0);
$pdf->Ln(8);

$pdf->SetFont('Arial','B',8);
$pdf-> Cell(50,8,"",0);
$pdf->Cell(76,8,"Cliente",0);
$pdf->Cell(100,8,"Recibido por",0);
$pdf->Ln(4);
$pdf->SetFont('Arial','',8);
$pdf-> Cell(40,1,"",0);
$pdf->Cell(90,8,$cliente,0);
$pdf->Cell(100,8,"Credinieto",0);
    $pdf -> Output();
?>
