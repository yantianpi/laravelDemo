<?php

namespace Peteryan\Http\Controllers;

use Illuminate\Http\Request;
use Peteryan\Log;

class LogController extends Controller
{
    private $typeArray = [
        'BASIC' => 'BASIC',
        'EXECUTE' => 'EXECUTE',
        'NOTIFY' => 'NOTIFY',
        'OTHER' => 'OTHER',
    ];

    private $sortArray = [
        'Id' => 'Id',
        'AddTime' => 'AddTime',
        'UpdateTime' => 'UpdateTime',
    ];
    private $orderArray = [
        'ASC' => 'ASC',
        'DESC' => 'DESC',
    ];

    public function logList(Request $request) {
        $formData = $request->input('formData', []);
        $pageLimit = $request->input('pageLimit', 5);
        $whereArray = [];
        if (isset($formData['LogType']) && isset($this->typeArray[$formData['LogType']])) {
            $whereArray[] = ['LogType', $formData['LogType']];
        }
        if (isset($formData['Id']) && !empty($formData['Id'])) {
            $whereArray[] = ['Id', $formData['Id']];
        }
        if (isset($formData['MapId']) && !empty($formData['MapId'])) {
            $whereArray[] = ['MapId', $formData['MapId']];
        }
        if (isset($formData['Keyword']) && !empty($formData['Keyword'])) {
            $whereArray[] = ['Keyword', 'like', "%{$formData['Keyword']}%"];
        }
        $tmpSort = isset($formData['sort']) ? $formData['sort'] : 'Id';
        $tmpOrder = isset($formData['order']) ? $formData['order'] : 'ASC';
        if (isset($this->sortArray[$tmpSort]) && isset($this->orderArray[$tmpOrder])) {
            $dataCollection = Log::where($whereArray)->orderBy($tmpSort, $tmpOrder)->paginate($pageLimit);
        } else {
            $dataCollection = Log::where($whereArray)->paginate($pageLimit);
        }
        /*
         * paging
         */
        $dataCollection->appends(['pageLimit' => $pageLimit]);
        if (isset($formData['LogType'])) {
            $dataCollection->appends(['formData[LogType]' => $formData['LogType']]);
        }
        if (isset($formData['Id'])) {
            $dataCollection->appends(['formData[Id]' => $formData['Id']]);
        }
        if (isset($formData['MapId'])) {
            $dataCollection->appends(['formData[MapId]' => $formData['MapId']]);
        }
        if (isset($formData['Keyword'])) {
            $dataCollection->appends(['formData[Keyword]' => $formData['Keyword']]);
        }
        if (isset($formData['sort'])) {
            $dataCollection->appends(['formData[sort]' => $formData['sort']]);
        }
        if (isset($formData['order'])) {
            $dataCollection->appends(['formData[order]' => $formData['order']]);
        }

        /*
         * view
         */
        return view('log', [
            'title' => 'Log',
            'pageName' => 'Log List',
            'dataCollection' => $dataCollection,
            'notData' => 'not data',
            'formData' => $formData,
            'typeArray' => $this->typeArray,
            'sortArray' => $this->sortArray,
            'orderArray' => $this->orderArray,
            'pageLimit' => $pageLimit,

        ]);
    }

    public function logDetail(Request $request, $id) {
        $dataObject = Log::findOrFail($id);
        echo view('modal.log', [
            'dataObject' => $dataObject,
        ]);
    }


}
