<?php

namespace Peteryan\Http\Controllers;

use Illuminate\Http\Request;
use Peteryan\Batch;

class BatchController extends Controller
{
    private $statusArray = [
        'ACTIVE' => 'ACTIVE',
        'INACTIVE' => 'INACTIVE',
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

    public function batchDetail(Request $request, $type, $id) {
        $dataObject = Batch::active()->findOrFail($id);
        switch ($type) {
            case 'ajax':
                $tmpArray = $dataObject->toArray();
                $tmpArray['flag'] = true;
                echo json_encode($tmpArray);
                break;
            case 'detail':
//                echo view('modal.batch', [
//                    'dataObject' => $dataObject,
//                ]);
                break;
            default:
        }
    }
}
