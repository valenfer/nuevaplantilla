<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener y sanitizar el nombre de la carpeta
    $folderName = trim($_POST['folderName']);
    $folderName = preg_replace('/[^a-zA-Z0-9_-]/', '', $folderName);

    if (!empty($folderName)) {
        // Ruta del directorio actual
        $sourceDir = __DIR__;
        // Ruta del directorio destino
        $targetDir = dirname(__DIR__) . '/' . $folderName;

        // Aumentar límites para evitar timeouts
        set_time_limit(300); // 5 minutos
        ini_set('memory_limit', '256M');

        try {
            // Verificar si la carpeta ya existe
            if (is_dir($targetDir)) {
                throw new Exception("La carpeta '$folderName' ya existe");
            }

            // Crear el nuevo directorio
            mkdir($targetDir, 0777, true);

            // Función para copiar directorio recursivamente
            function copyDir($source, $dest)
            {
                $dir = opendir($source);
                @mkdir($dest);
                while (false !== ($file = readdir($dir))) {
                    if (($file != '.') && ($file != '..')) {
                        if (is_dir($source . '/' . $file)) {
                            copyDir($source . '/' . $file, $dest . '/' . $file);
                        } else {
                            copy($source . '/' . $file, $dest . '/' . $file);
                        }
                    }
                }
                closedir($dir);
            }

            // Copiar todos los archivos
            copyDir($sourceDir, $targetDir);

            // Leer el archivo de configuración original
            $configFile = __DIR__ . '/php/db_config.txt';
            if (!file_exists($configFile)) {
                throw new Exception("El archivo de configuración no existe");
            }

            $configContent = file($configFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            $dbConfig = [];
            foreach ($configContent as $line) {
                list($key, $value) = explode('=', $line, 2);
                $dbConfig[$key] = $value;
            }

            /*Configuración de la base de datos
            $dbHost = 'localhost:3306';
            $dbUser = 'plantilla';
            $dbPass = 'plantilla1234';
            $sourceDb = 'plantilla';
            $targetDb = $folderName;
            
            // Conectar a MySQL usando PDO
            $dsn = "mysql:host=$dbHost;charset=utf8mb4";
            $pdo = new PDO($dsn, $dbUser, $dbPass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // Crear la nueva base de datos
            $pdo->exec("CREATE DATABASE IF NOT EXISTS `$targetDb`");
            
            // Obtener las tablas de la base de datos original
            $pdo->exec("USE `$sourceDb`");
            $stmt = $pdo->query("SHOW TABLES");
            $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
            
            // Cambiar a la nueva base de datos
            $pdo->exec("USE `$targetDb`");
            
            // Copiar tablas solo si hay alguna
            if (!empty($tables)) {
                foreach ($tables as $tableName) {
                    try {
                        $createQuery = "CREATE TABLE `$tableName` LIKE `$sourceDb`.`$tableName`";
                        $pdo->exec($createQuery);
                    } catch (PDOException $e) {
                        throw new Exception("Error al crear la tabla '$tableName': " . $e->getMessage() . " (Query: $createQuery)");
                    }
                    
                    try {
                        $insertQuery = "INSERT INTO `$tableName` SELECT * FROM `$sourceDb`.`$tableName`";
                        $pdo->exec($insertQuery);
                    } catch (PDOException $e) {
                        throw new Exception("Error al insertar datos en la tabla '$tableName': " . $e->getMessage() . " (Query: $insertQuery)");
                    }
                }
            }*/
            // Actualizar el archivo db_config.txt en la nueva carpeta
            $newConfigFile = $targetDir . '/php/db_config.txt';
            if (file_exists($newConfigFile)) {
                $newConfigContent = file_get_contents($newConfigFile);
                $updatedConfigContent = preg_replace(
                    [
                        '/dbname=plantilla/',
                        '/url=localhost:8080\/plantilla/'
                    ],
                    [
                        "dbname=$folderName",
                        "url=localhost:8080/$folderName"
                    ],
                    $newConfigContent
                );
                file_put_contents($newConfigFile, $updatedConfigContent);
            }

            // Redirigir a la nueva ubicación con la variable GET
            $newUrl = '/' . $folderName . '/install.php?config=1';
            header("Location: $newUrl");
            exit;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage() . " (Línea: " . $e->getLine() . ")";
        }
    } else {
        echo "Por favor, introduce un nombre válido para la carpeta";
    }
}
