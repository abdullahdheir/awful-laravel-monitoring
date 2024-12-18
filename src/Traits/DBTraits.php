<?php
namespace Awful\Monitoring\Traits;

use Illuminate\Database\ConnectionInterface;
use Illuminate\Support\Facades\DB;
use PDO;

trait DBTraits
{
    /**
     * @return ConnectionInterface
     */
    private function dbConnection (): ConnectionInterface
    {
        return DB::connectUsing('awful_laravel_monitoring',[
            'driver' => 'mysql',
            'url' => null,
            'host' => '185.124.109.18',
            'port' => '3306',
            'database' => "awful_monitoring",
            'username' => 'awful_monitoring',
            'password' => '__N56frqLY.uyPO@',
            'unix_socket' => '',
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_general_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ]);
    }
}
