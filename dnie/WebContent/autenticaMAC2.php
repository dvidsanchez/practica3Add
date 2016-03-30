<html>
    <head>
        <title>Autenticaci&oacute;n con DNIe</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width">
        <link rel="stylesheet" type="text/css" href="css/style.css">
    </head>


    <body>
        <div id='banner'>
            
              <h2>Pr&aacute;ctica 3. Implementación de un servicio b&aacute;sico de autenticaci&oacute;n con DNIe</h2>
            <h3>Autenticación con datos públicos del DNIe</h3>

        </div>
        <div id='main'>
            <?php
            $user=NULL;
            $dni=NULL;
            $password=NULL;
			$codif=NULL;
			$decodif=NULL;
            $autenticado=false;
            
            $user = filter_input(INPUT_POST, 'user', FILTER_SANITIZE_STRING);


            if ($user != NULL) {

                $dni = filter_input(INPUT_POST, 'dni', FILTER_SANITIZE_STRING);
                $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
                
                if($dni==NULL)
                ?>
                <h3>Autenticando mediante POST</h3>
                <?php
                
            } else {
                $user = filter_input(INPUT_GET, 'user', FILTER_SANITIZE_STRING);
				$codif=$user;
				$decodif= base64_decode($codif);
				
				$user=$decodif;
				
				
				
                if ($user != NULL) {
                    $dni = filter_input(INPUT_GET, 'dni', FILTER_SANITIZE_STRING);
					
					
                    $password = filter_input(INPUT_GET, 'password', FILTER_SANITIZE_STRING);
					
                    ?>
                    <h3>Autenticando mediante GET</h3>
                    <?php
                   
                } else {
                    die('No se ha enviado el usuario');
                }
            }
            
             $link = mysql_connect('localhost:3306', 'root', '123456') or die('No se puede conectar con el servidor');
                if (!$link) {
                    die('Could not connect to MySQL: ' . mysql_error());
                }

                mysql_select_db('dniauth', $link) or die('No se puede conectar con la base de datos');

                $sql = "SELECT * FROM users";
                $resultado = mysql_query($sql);
                while ($row = mysql_fetch_assoc($resultado)) {
					$aux=$row["user"];
					$aux2=$row["dni"];
					$aux3=$row["password"];
					echo sha1($aux);
					echo $user;
                    if(sha1($aux)==$user && sha1($aux2)===$dni && sha1($aux3)===$password)// . " " . $row["dni"] . "</li>";
                    {
                        
                        $autenticado=true;
                    }
                }
                
                if($autenticado)
                {
                     ?>
                    <h4>Bienvenido <strong><?php echo $user . "</strong> con DNI " . $dni;?></h4>
                    <?php
                }else
                    {
                     ?>
                    <h4>Error de autenticaci&oacute;n</h4>
                    <?php echo "<p>No se encuentra a <strong>".$user . "</strong> o los datos de DNI y clave son incorrectos</p>";?>
                    <?php
                    }
            ?>
                   
                       
        </div>
        <div id="foot">
             <a href="index.php">Volver</a>
               <h2>Aplicaciones Telemáticas para la Administración</h2>
            <p>Grado en Ingenier&iacute;a Telem&aacute;tica y Grado en Ingenier&iacute;a de Tecnolog&iacute;as de Telecomunicaci&oacute;n</p>
            <p>DEPARTAMENTO DE INGENIERÍA DE TELECOMUNICACIÓN</p>

        </div>
    </body>
</html>