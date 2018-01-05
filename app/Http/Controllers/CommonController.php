<?php

namespace Peteryan\Http\Controllers;

use Illuminate\Http\Request;
use Peteryan\Log;

class CommonController extends Controller
{
    public static function logRecord($logType, $mapId, $program, $keyword, $content, $hasAlert = 'NO') {
        $tmpTime = date('Y-m-d H:i:s');
        $logObject = new Log();
        $logObject->LogType = $logType;
        $logObject->MapId = $mapId;
        $logObject->Program = $program;
        $logObject->Keyword = $keyword;
        $logObject->Content = $content;
        $logObject->HasAlert = $hasAlert;
        $logObject->AddTime = $tmpTime;
        $logObject->UpdateTime = $tmpTime;
        @$logObject->save();
    }
}
