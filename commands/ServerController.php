<?php
namespace app\commands;

use app\daemons\StoreImportServer;
use yii\console\Controller;

class ServerController extends Controller
{
    public function actionStart($port = null)
    {
        $server = new StoreImportServer();
        if ($port) {
            $server->port = $port;
        }

        $server->start();
    }
}