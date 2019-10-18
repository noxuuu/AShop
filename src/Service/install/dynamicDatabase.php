<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 12/04/2019
 * Time: 00:22
 */

namespace App\Service\install;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

class dynamicDatabase
{
    public function getManager($host, $user, $password, $dbname)
    {
        // preparing the config
        $config = Setup::createAnnotationMetadataConfiguration(array(__DIR__."/src"), true);

        // filling db connection info
        $conn = array(
            'driver' => 'pdo_mysql',
            'host' => $host,
            'port' => '3306',
            'user' => $user,
            'password' => $password,
            'dbname' => $dbname
        );

        // obtaining the entity manager
        $entityManager = EntityManager::create($conn, $config);

        // returns entity manager
        return $entityManager;
    }

    public function getConnectionStatus($host, $user, $password, $dbname)
    {
        $dynamicEm = $this->getManager($host, $user, $password, $dbname);
        $message = "";

        try {
            $dynamicEm->getConnection()->connect();
            $connected = $dynamicEm->getConnection()->isConnected();
        } catch(\Doctrine\DBAL\DBALException $e) {
            $message = ltrim($e->getMessage(), 'An exception occurred in driver: SQLSTATE');
            $connected = false;
        }

        return array('status' => $connected ? 'OK' : 'FAIL', 'message' => $message);
    }
}