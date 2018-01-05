<?php

namespace Peteryan\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Peteryan\Batch;
use Peteryan\Http\Requests\BatchValidateRequest;

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

    public function batchList(Request $request) {
        $formData = $request->input('formData', []);
        $pageLimit = $request->input('pageLimit', 5);
        $whereArray = [];
        if (isset($formData['Status']) && !empty($formData['Status'])) {
            $whereArray[] = ['Status', $formData['Status']];
        }
        if (isset($formData['Id']) && !empty($formData['Id'])) {
            $whereArray[] = ['Id', $formData['Id']];
        }
        $tmpSort = isset($formData['sort']) ? $formData['sort'] : 'Id';
        $tmpOrder = isset($formData['order']) ? $formData['order'] : 'ASC';
        if (isset($this->sortArray[$tmpSort]) && isset($this->orderArray[$tmpOrder])) {
            $dataCollection = Batch::where($whereArray)->orderBy($tmpSort, $tmpOrder)->paginate($pageLimit);
        } else {
            $dataCollection = Batch::where($whereArray)->paginate($pageLimit);
        }
        /*
         * paging
         */
        $dataCollection->appends(['pageLimit' => $pageLimit]);
        if (isset($formData['Id'])) {
            $dataCollection->appends(['formData[Id]' => $formData['Id']]);
        }
        if (isset($formData['Status'])) {
            $dataCollection->appends(['formData[Status]' => $formData['Status']]);
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
        return view('batch', [
            'title' => 'Batch',
            'pageName' => 'Batch List',
            'dataCollection' => $dataCollection,
            'notData' => 'not data',
            'formData' => $formData,
            'statusArray' => $this->statusArray,
            'sortArray' => $this->sortArray,
            'orderArray' => $this->orderArray,
            'pageLimit' => $pageLimit,

        ]);
    }

    public function batchEdit(BatchValidateRequest $request, $id = 0) {
        $action = $request->input('action', '');
        if (empty($action)) {
            $action = $request->input('act', '');
        }
        switch ($action) {
            case 'edit':
                $id = intval($id);
                $dataObject = Batch::findOrFail($id);
                return view('batchDetail', [
                    'statusArray' => $this->statusArray,
                    'title' => 'Batch(Add | Edit)',
                    'pageName' => 'Batch(Add | Edit)',
                    'requestPath' => url('/batch/edit/' . $id),
                    'action' => 'doedit',
                    'dataObject' => $dataObject,
                ]);
                break;
            case 'doedit':
                $id = $request->input('id', 0);
                $dataObject = Batch::findOrFail($id);
                $formData = $request->input('formData', []);
                if (isset($formData['batchName']) && $formData['batchName'] != null) {
                    $tmpObject = Batch::where(
                        [
                            ['Id', '!=', $id],
                            ['Name', $formData['batchName']]
                        ]
                    )->first();
                    if (!empty($tmpObject)) {
                        return back()->withErrors("批次名重复")->withInput();
                    } else {
                        $dataObject->Name = $formData['batchName'];
                    }
                }
                if (isset($formData['batchAlias']) && $formData['batchAlias'] != null) {
                    $dataObject->Alias = $formData['batchAlias'];
                }
                if (isset($formData['batchCrontime']) && $formData['batchCrontime'] != null) {
                    $dataObject->Crontime = $formData['batchCrontime'];
                }
                if (isset($formData['batchThroughput']) && $formData['batchThroughput'] != null) {
                    $dataObject->Throughput = intval($formData['batchThroughput']);
                }
                if (isset($formData['batchStatus']) && isset($this->statusArray[$formData['batchStatus']])) {
                    $dataObject->Status = $formData['batchStatus'];
                }
                $dataObject->UpdateTime = date('Y-m-d H:i:s');
                try {
                    $oldObject = Batch::findOrFail($id);
                    $dataObject->save();
                    $tmpContent = $oldObject->toJson() . ' >>> ' . $dataObject->toJson();
                    CommonController::logRecord('BASIC', $id, __FILE__, 'batch update batch update', $tmpContent);
                    return redirect("/batch/edit/{$id}?action=edit");
                } catch (\Exception $e) {
                    return back()->withErrors($e->getMessage())->withInput();
                }
                break;
            case 'doadd':
                $batchName = $request->input('formData.batchName', '');
                $batchAlias = $request->input('formData.batchAlias', '');
                $batchCrontime = $request->input('formData.batchCrontime', '');
                $batchThroughput = intval($request->input('formData.batchThroughput', 1));
                $batchStatus = $request->input('formData.batchStatus', 'ACTIVE');
                $tmpWhereArray = [
                    ['Name', $batchName],
                ];
                $tmpCollection = Batch::where($tmpWhereArray)->get();
                if (!$tmpCollection->isEmpty()) {
                    return back()->withErrors('duplicate record')->withInput();
                } else {
                    try {
                        $tmpArray = [];
                        if (!empty($batchName)) {
                            $tmpArray['Name'] = $batchName;
                        }
                        if (!empty($batchAlias)) {
                            $tmpArray['Alias'] = $batchAlias;
                        }
                        if (!empty($batchCrontime)) {
                            $tmpArray['Crontime'] = $batchCrontime;
                        }
                        if (!empty($batchThroughput)) {
                            $tmpArray['Throughput'] = $batchThroughput;
                        }
                        if (isset($this->statusArray[$batchStatus])) {
                            $tmpArray['Status'] = $batchStatus;
                        }
                        $tmpTime = date('Y-m-d H:i:s');
                        $tmpArray['AddTime'] = $tmpTime;
                        $tmpArray['UpdateTime'] = $tmpTime;
                        $batchId = DB::table('batch_list')->insertGetId($tmpArray);
                        $tmpObject = Batch::findOrFail($batchId);
                        $tmpContent = $tmpObject->toJson();
                        CommonController::logRecord('BASIC', $batchId, __FILE__, 'batch add batch add', $tmpContent);
                        return redirect("/batch/edit/{$batchId}?action=edit");
                    } catch (\Exception $e) {
                        return back()->withErrors([$e->getMessage()])->withInput();
                    }
                }
                break;
            case 'add':
            default:
                return view('batchDetail', [
                    'statusArray' => $this->statusArray,
                    'title' => 'Batch(Add | Edit)',
                    'pageName' => 'Batch(Add | Edit)',
                    'requestPath' => url('/batch/edit'),
                    'action' => 'doadd',
                ]);
        }

    }

    public function validateName(Request $request) {
        $id = $request->input('id', 0);
        $name = $request->input('name', '');
        if (!empty($name)) {
            $tmpObject = Batch::where(
                [
                    ['Id', '!=', $id],
                    ['Name', $name]
                ]
            )->first();
            if (!empty($tmpObject)) {
                echo json_encode(['flag' => false, 'message' => '<div class="panel panel-default"><div class="panel-heading"><h3 class="panel-title">error</h3></div><div class="panel-body"><div class="alert alert-danger"><ul><li>duplicate name</li></ul></div></div></div>']);
            } else {
                echo json_encode(['flag' => true, 'message' => '']);
            }
        } else {
            echo json_encode(['flag' => false, 'message' => 'name is empty']);
        }
    }
}
