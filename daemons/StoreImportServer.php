<?php

namespace app\daemons;

use app\core\services\StoreImportService;
use consik\yii2websocket\events\WSClientMessageEvent;
use consik\yii2websocket\WebSocketServer;
use Yii;

class StoreImportServer extends WebSocketServer
{
    public function init()
    {
        parent::init();

        $storeImportService = Yii::$container->get(StoreImportService::class);

        $this->on(self::EVENT_CLIENT_MESSAGE, function (WSClientMessageEvent $e) use ($storeImportService) {
            if(is_numeric($e->message)) {
                $storeImportService->addImportToProcessId((int)$e->message);
                $storeImportService->import();
            }

            $e->client->send( json_encode($storeImportService->getImportToProcessIds()) );
        });
    }

}