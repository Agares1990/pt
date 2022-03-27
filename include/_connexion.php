<?php

    function getPDO() {
      $credentials = fopen("config.csv", "r");

      if ($credentials)
      {
      // Le fichier de configuration doit exister.
      $credentials = fgetcsv($credentials);
      }

        $host = $credentials[0];
        $db   = $credentials[1];
        $user = $credentials[2];
        $pass = $credentials[3];
        $charset = $credentials[4];
        $port = $credentials[5];

        $dsn = "mysql:host=$host;dbname=$db;charset=$charset;port=$port";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        try {
            return new PDO($dsn, $user, $pass, $options);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
    }
    /** Pour changer la langue **/
    if ( isset ($_GET['lang'] ) )
    $lang = $_GET['lang'];
    else {
      $lang = 'fr';
    }


?>
