<?php
    require_once("config.php");
    require_once("funciones.php");
    function cabecera($seccion){
        global $nombreEmpresa;
        $s1 ="";
        $s2 = "";
        $s3 = "";
        $s4 = "";

        if($seccion == "inicio"){
            $s1 = 'active';
        }
        if($seccion == "preferencias"){
            $s2 = 'active';
        }
        if($seccion == "premios"){
            $s3 = 'active';
        }
        if($seccion == "leads"){
            $s4 = 'active';
        }

        ?>  
        <head>
        <meta charset="utf-8">
        <meta name="robots" content="noindex" />

            <script
            src="https://code.jquery.com/jquery-3.4.1.js"
            
            crossorigin="anonymous"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <script src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" type="text/javascript"></script>
        <link href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
              rel="stylesheet">
              <link rel="stylesheet" href="css/animate.css">
           
             <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
            <title><?php echo $seccion; ?> | Promoción <?php echo $nombreEmpresa ?> </title>
            <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
                  rel="stylesheet">
                  <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
            <link rel="stylesheet" href="css/general.css">
      </head>
      <body class="bg-gris">
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
            <a class="navbar-brand" href="#"><?php echo $nombreEmpresa ?></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarColor01">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item <?php echo $s1; ?>">
                            <a class="nav-link" href="index.php">Inicio </a>
                        </li>
                        <li class="nav-item <?php echo $s2; ?>">
                            <a class="nav-link" href=preferencias.php>Preferencias </a>
                        </li>
                        <li class="nav-item <?php echo $s3; ?>">
                            <a class="nav-link" href=premios.php>Premios</a>
                        </li>
                        <li class="nav-item <?php echo $s4; ?>">
                            <a class="nav-link" href=leads.php>Leads</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-secondary p-2" id="btn-exportar" href="php/funciones.php?exportar">Exportar</a>
                        </li>
                           
                    </ul>
                          
                </div>
        </nav>
        <?php
    }
?>