<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="description" content="Dashboard - Credinieto">
<meta name="author" content="Pablo Cortes Arzaluz">
<!-- CSS -->
<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
<link href="css/font-awesome.min.css" rel="stylesheet" type="text/css">
<link href="css/main.css" rel="stylesheet" type="text/css">
<link href="css/my-custom-styles.css" rel="stylesheet" type="text/css">
<!--[if lte IE 9]>
    <link href="css/main-ie.css" rel="stylesheet" type="text/css"/>
    <link href="css/main-ie-part2.css" rel="stylesheet" type="text/css"/>
<![endif]-->

<!-- Fav and touch icons -->
<link rel="apple-touch-icon-precomposed" sizes="144x144" href="ico/apple-icon-144x144.png">
<link rel="apple-touch-icon-precomposed" sizes="114x114" href="ico/apple-icon-114x114.png">
<link rel="apple-touch-icon-precomposed" sizes="72x72" href="ico/apple-icon-72x72.png">
<link rel="apple-touch-icon-precomposed" sizes="57x57" href="ico/apple-icon-57x57.png">
<link rel="shortcut icon" href="ico/favicon.ico">
<script type="text/javascript">
	function busqueda(){
		var buscar = document.getElementById("busqueda").value;
		window.location.href = "buscar.php?v="+buscar;
		
	}

	function handleEnter(e){
	    var keycode = (e.keyCode ? e.keyCode : e.which);
	    if (keycode == '13') {
	    	var buscar = document.getElementById("busqueda").value;
	    	
	        window.location.href = "buscar.php?v="+buscar;
	        
	    }
}

</script>
