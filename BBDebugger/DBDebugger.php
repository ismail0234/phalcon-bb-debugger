<?php
namespace BBDebugger;

class DBDebugger 
{

    public function beforeQuery($event, $connection)
    {

        $connection->log = [
            "starttime" => microtime(1),
            "sql" => [
                "raw" => $connection->getRealSQLStatement(),
                "val" => $connection->getSQLVariables(),
            ],

        ];

    }

    public function afterQuery($event, $connection)
    {
        for($i = 1; $i < 2; $i++)
        {

            $connection->log["endtime"] = microtime(1);
            $connection->log["speed"]   = number_format($connection->log["endtime"] - $connection->log["starttime"] , 25 , ".",  "");
            BBDebugger::$logList['db'][] = $connection->log;

        }
        
    }

}