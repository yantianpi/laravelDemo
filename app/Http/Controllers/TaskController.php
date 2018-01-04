<?php

namespace Peteryan\Http\Controllers;

use Illuminate\Http\Request;
use Peteryan\Attribute;
use Peteryan\Batch;
use Peteryan\Category;
use Peteryan\Http\Requests\TaskValidateRequest;
use Peteryan\Mail;
use Peteryan\Project;
use Peteryan\Task;

class TaskController extends Controller
{
    private $statusArray = [
        'ACTIVE' => 'ACTIVE',
        'INACTIVE' => 'INACTIVE',
    ];

    private $notifyTypeArray = [
        'MAIL' => 'MAIL',
        'OTHER' => 'OTHER',
    ];

    private $currentStatusArray = [
        'PENDING' => 'PENDING',
        'PROCESSING' => 'PROCESSING',
        'RESLOVED' => 'RESLOVED',
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

    public function taskList(Request $request) {
        $formData = $request->input('formData', []);
        $pageLimit = $request->input('pageLimit', 5);
        $whereArray = [];
        if (isset($formData['Id']) && !empty($formData['Id'])) {
            $whereArray[] = ['Id', addslashes($formData['Id'])];
        }
        if (isset($formData['ProjectId']) && !empty($formData['ProjectId'])) {
            $whereArray[] = ['ProjectId', addslashes($formData['ProjectId'])];
        }
        if (isset($formData['CategoryId']) && !empty($formData['CategoryId'])) {
            $whereArray[] = ['CategoryId', addslashes($formData['CategoryId'])];
        }
        if (isset($formData['CurrentStatus']) && isset($this->currentStatusArray[$formData['CurrentStatus']])) {
            $whereArray[] = ['CurrentStatus', addslashes($formData['CurrentStatus'])];
        }
        if (isset($formData['NotifyType']) && isset($this->notifyTypeArray[$formData['NotifyType']])) {
            $whereArray[] = ['NotifyType', addslashes($formData['NotifyType'])];
        }
        if (isset($formData['Status']) && isset($this->statusArray[$formData['Status']])) {
            $whereArray[] = ['Status', addslashes($formData['Status'])];
        }
        $tmpSort = isset($formData['sort']) ? $formData['sort'] : 'Id';
        $tmpOrder = isset($formData['order']) ? $formData['order'] : 'ASC';
        if (isset($this->sortArray[$tmpSort]) && isset($this->orderArray[$tmpOrder])) {
            $dataCollection = Task::where($whereArray)->orderBy($tmpSort, $tmpOrder)->paginate($pageLimit);
        } else {
            $dataCollection = Task::where($whereArray)->paginate($pageLimit);
        }
        $dataCollection->load('category');
        $dataCollection->load('project');
        $categoryCollection = Category::active()->get();
        $projectCollection = Project::active()->get();

        /*
         * paging
         */
        $dataCollection->appends(['pageLimit' => $pageLimit]);
        foreach ($formData as $key => $value) {
            switch ($key) {
                case 'Id':
                    $dataCollection->appends(['formData[Id]' => $value]);
                    break;
                case 'ProjectId':
                    $dataCollection->appends(['formData[ProjectId]' => $value]);
                    break;
                case 'CategoryId':
                    $dataCollection->appends(['formData[CategoryId]' => $value]);
                    break;
                case 'CurrentStatus':
                    $dataCollection->appends(['formData[CurrentStatus]' => $value]);
                    break;
                case 'NotifyType':
                    $dataCollection->appends(['formData[NotifyType]' => $value]);
                    break;
                case 'Status':
                    $dataCollection->appends(['formData[Status]' => $value]);
                    break;
                case 'sort':
                    $dataCollection->appends(['formData[sort]' => $value]);
                    break;
                case 'order':
                    $dataCollection->appends(['formData[order]' => $value]);
                    break;
                default:
            }
        }

        /*
         * view
         */
        return view('task', [
            'title' => 'Task',
            'pageName' => 'Task List',
            'dataCollection' => $dataCollection,
            'notData' => 'not data',
            'formData' => $formData,
            'categoryCollection' => $categoryCollection,
            'projectCollection' => $projectCollection,
            'currentStatusArray' => $this->currentStatusArray,
            'notifyTypeArray' => $this->notifyTypeArray,
            'statusArray' => $this->statusArray,
            'sortArray' => $this->sortArray,
            'orderArray' => $this->orderArray,
            'pageLimit' => $pageLimit,

        ]);
    }

    public function taskDetail(Request $request, $id) {
        $taskObject = Task::with(['category', 'project'])->findOrFail($id);
        $taskObject->ContentArray = json_decode($taskObject->Content, true);
        $taskObject->NotifyContentArray = json_decode($taskObject->NotifyContent, true);
//        dd($taskObject->ContentArray);
//        dd($taskObject->NotifyContentArray);
        // todo 通知内容里，id转成邮箱
        return view('modal.task', [
            'taskObject' => $taskObject,
        ]);
    }

    public function taskEdit(TaskValidateRequest $request, $id = 0) {
        $categoryCollection = Category::active()->get();
        $projectCollection = Project::active()->get();
        $batchCollection = Batch::active()->get();
        if ($categoryCollection->isEmpty()) {
            die('without active category');
        }
        if ($projectCollection->isEmpty()) {
            die('without active project');
        }
        $action = $request->input('action', '');
        if (empty($action)) {
            $action = $request->input('act', '');
        }
        switch ($action) {
            case 'edit':
                $id = intval($id);
                $dataObject = Task::with(['category', 'project'])->findOrFail($id);
                return view('taskDetail', [
                    'statusArray' => $this->statusArray,
                    'notifyTypeArray' => $this->notifyTypeArray,
                    'title' => 'Task(Add | Edit)',
                    'pageName' => 'Task(Add | Edit)',
                    'requestPath' => url('/task/edit/' . $id),
                    'action' => 'doedit',
                    'categoryCollection' => $categoryCollection,
                    'projectCollection' => $projectCollection,
                    'batchCollection' => $batchCollection,
                    'dataObject' => $dataObject,
                ]);
                break;
            case 'doedit':
//                dd($request->all());
                $id = $request->input('id', 0);
                $dataObject = Task::findOrFail($id);
                $formData = $request->input('formData', []);
                if (isset($formData['taskProject']) && $formData['taskProject'] != null) {
                    $dataObject->ProjectId = intval($formData['taskProject']);
                }
                if (isset($formData['taskName']) && $formData['taskName'] != null) {
                    $dataObject->Name = $formData['taskName'];
                }
                if (isset($formData['taskDescription']) && $formData['taskDescription'] != null) {
                    $dataObject->Description = $formData['taskDescription'];
                }
                if (isset($formData['taskCronTime']) && $formData['taskCronTime'] != null) {
                    $dataObject->CronTime = $formData['taskCronTime'];
                }
                if (isset($formData['Batch']) && $formData['Batch'] != null) {
                    $dataObject->Batch = intval($formData['Batch']);
                }
                if (isset($formData['taskCategory']) && $formData['taskCategory'] != null) {
                    $dataObject->CategoryId = intval($formData['taskCategory']);
                }
                if (isset($formData['content']) && !empty($formData['content'])) {
                    $dataObject->Content = json_encode($formData['content']);
                }
                if (isset($formData['taskAlertLimit']) && $formData['taskAlertLimit'] != null) {
                    $dataObject->AlertLimit = intval($formData['taskAlertLimit']);
                }
                if (isset($formData['taskNotifyType']) && isset($this->notifyTypeArray[$formData['taskNotifyType']])) {
                    $dataObject->NotifyType = $formData['taskNotifyType'];
                }
                if (isset($formData['notify']) && !empty($formData['notify'])) {
                    $dataObject->NotifyContent = json_encode($formData['notify']);
                } else {
                    $dataObject->NotifyContent = '';
                }
                if (isset($formData['taskStatus']) && isset($this->statusArray[$formData['taskStatus']])) {
                    $dataObject->Status = $formData['taskStatus'];
                }
                $dataObject->UpdateTime = date('Y-m-d H:i:s');
                try {
                    $dataObject->save();
                    return redirect("/task/edit/{$id}?action=edit");
                } catch (\Exception $e) {
                    return back()->withErrors($e->getMessage())->withInput();
                }
                break;
            case 'doadd':
                dd($request->all());
                $categoryId = $request->input('formData.attributeCategory', 0);
                $attributeName = $request->input('formData.attributeName', '');
                $attributeAlias = $request->input('formData.attributeAlias', '');
                $attributeContentType = $request->input('formData.attributeContentType', 'OTHER');
                $attributeDefaultMessage = $request->input('formData.attributeDefaultMessage', '');
                $attributeStatus = $request->input('formData.attributeStatus', 'ACTIVE');
                $tmpWhereArray = [
                    ['CategoryId', $categoryId],
                    ['Name', $attributeName],
                ];
                $tmpCollection = Attribute::where($tmpWhereArray)->get();
                if (!$tmpCollection->isEmpty()) {
                    $validateObject = Validator::make([], []);
                    $validateObject->errors()->add('errorinfo', 'duplicate record');
                    return back()->withErrors($validateObject)->withInput();
                } else {
                    try {
                        $tmpArray = [];
                        if (!empty($categoryId)) {
                            $tmpArray['CategoryId'] = $categoryId;
                        }
                        if (!empty($attributeName)) {
                            $tmpArray['Name'] = $attributeName;
                        }
                        if (!empty($attributeAlias)) {
                            $tmpArray['Alias'] = $attributeAlias;
                        }
                        if (isset($this->contentTypeArray[$attributeContentType])) {
                            $tmpArray['ContentType'] = $attributeContentType;
                        }
                        if (!empty($attributeDefaultMessage)) {
                            $tmpArray['DefaultMessage'] = $attributeDefaultMessage;
                        }
                        if (isset($this->statusArray[$attributeStatus])) {
                            $tmpArray['Status'] = $attributeStatus;
                        }
                        $tmpTime = date('Y-m-d H:i:s');
                        $tmpArray['AddTime'] = $tmpTime;
                        $tmpArray['UpdateTime'] = $tmpTime;
                        $attributeId = DB::table('attribute_list')->insertGetId($tmpArray);
                        return redirect("/attribute/edit/{$attributeId}?action=edit");
                    } catch (\Exception $e) {
                        return back()->withErrors([$e->getMessage()])->withInput();
                    }
                }
                break;
            case 'add':
            default:
                dd($request->all());
                return view('attributeDetail', [
                    'contentTypeArray' => $this->contentTypeArray,
                    'statusArray' => $this->statusArray,
                    'title' => 'Attribute(Add | Edit)',
                    'pageName' => 'Attribute(Add | Edit)',
                    'requestPath' => url('/attribute/edit/'),
                    'action' => 'doadd',
                    'categoryCollection' => $categoryCollection,
                ]);
        }

    }

    public function taskFill(Request $request, $type, $id = 0) {
        switch ($type) {
            case 'mail':
                $nofityInfo = array();
                $taskObject = Task::find($id, ['NotifyContent']);
                if (!empty($taskObject)) {
                    $nofityInfo = json_decode($taskObject->NotifyContent, true);
                }
                $mailCollection = Mail::active()->get();
                return view('modal.formMail', [
                    'nofityInfo' => $nofityInfo,
                    'mailCollection' => $mailCollection,
                ]);
                break;
            case 'content':
                $contentInfo = array();
                $contentObject = Task::find($id, ['Content']);
                if (!empty($contentObject)) {
                    $contentInfo = json_decode($contentObject->Content, true);
                }
                $categoryId = $request->input('categoryId', 0);
                $dataCollection = Attribute::active()->where('CategoryId', $categoryId)->get();
//                dd($dataCollection->toArray());
                return view('modal.formContent', [
                    'contentInfo' => $contentInfo,
                    'dataCollection' => $dataCollection,
                ]);
                break;
            default:
        }
    }
}
