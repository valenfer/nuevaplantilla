<?php
	session_start();
	
	if(ISSET($_SESSION["token"])){
		require( 'clases/ssp.class.php' );


		// Database connection info
		$dbDetails = array(
		    'host' => 'localhost',
		    'user' => 'promoa1_2019',
		    'pass' => 'Hq8ue2%9	',
		    'db'   => 'promo_app_utrera'
		);

		// DB table to use
		$table = 'participantes';

		// Table's primary key
		$primaryKey = 'id';

		// Array of database columns which should be read and sent back to DataTables.
		// The `db` parameter represents the column name in the database. 
		// The `dt` parameter represents the DataTables column identifier.
		$columns = array(
			array( 'db' => 'id', 'dt' => 0 ),
		    array( 'db' => 'nombre', 'dt' => 1 ),
		    array( 'db' => 'premio',  'dt' => 2 ),
		    array( 'db' => 'telefono',      'dt' => 3 ),
		    array( 'db' => 'email',     'dt' => 4 ),
		    array( 'db' => 'edad',    'dt' => 5 ),
		    array( 'db' => 'municipio',    'dt' => 6 ),
		    array( 'db' => 'direccion',    'dt' => 7 ),
		    array( 'db' => 'cod_postal',    'dt' => 8 ),
		    array( 'db' => 'fecha_jugada',    'dt' => 9 ),
		    array( 'db' => 'canjeado',    'dt' => 10 ),
		    array( 'db' => 'cod_juego',    'dt' => 11 ),
		    array( 'db' => 'cod_canjeo',    'dt' => 12 ),
		    array( 'db' => 'estado_mail',    'dt' => 13 )
		    
		);



		// Output data as json format
		echo json_encode(
		    SSP::simple( $_GET, $dbDetails, $table, $primaryKey, $columns )
		);
	}
	

?>