<?php

namespace Peteryan\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Peteryan\Http\Requests\MailValidateRequest;
use Peteryan\Mail;

class MailController extends Controller
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

    public function mailList(Request $request) {
        $formData = $request->input('formData', []);
        $pageLimit = $request->input('pageLimit', 5);
        $whereArray = [];
        if (isset($formData['Status']) && !empty($formData['Status'])) {
            $whereArray[] = ['Status', addslashes($formData['Status'])];
        }
        if (isset($formData['Id']) && !empty($formData['Id'])) {
            $whereArray[] = ['Id', addslashes($formData['Id'])];
        }
        $tmpSort = isset($formData['sort']) ? $formData['sort'] : 'Id';
        $tmpOrder = isset($formData['order']) ? $formData['order'] : 'ASC';
        if (isset($this->sortArray[$tmpSort]) && isset($this->orderArray[$tmpOrder])) {
            $dataCollection = Mail::where($whereArray)->orderBy($tmpSort, $tmpOrder)->paginate($pageLimit);
        } else {
            $dataCollection = Mail::where($whereArray)->paginate($pageLimit);
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
        return view('mail', [
            'title' => 'Mail',
            'pageName' => 'Mail List',
            'dataCollection' => $dataCollection,
            'notData' => 'not data',
            'formData' => $formData,
            'statusArray' => $this->statusArray,
            'sortArray' => $this->sortArray,
            'orderArray' => $this->orderArray,
            'pageLimit' => $pageLimit,

        ]);
    }

    public function mailEdit(MailValidateRequest $request, $id = 0) {
        $action = $request->input('action', '');
        if (empty($action)) {
            $action = $request->input('act', '');
        }
        switch ($action) {
            case 'edit':
                $id = intval($id);
                $dataObject = Mail::findOrFail($id);
                return view('mailDetail', [
                    'statusArray' => $this->statusArray,
                    'title' => 'Mail(Add | Edit)',
                    'pageName' => 'Mail(Add | Edit)',
                    'requestPath' => url('/mail/edit/' . $id),
                    'action' => 'doedit',
                    'dataObject' => $dataObject,
                ]);
                break;
            case 'doedit':
                $id = $request->input('id', 0);
                $dataObject = Mail::findOrFail($id);
                $formData = $request->input('formData', []);
                if (isset($formData['mailName']) && $formData['mailName'] != null) {
                    $dataObject->Name = $formData['mailName'];
                }
                if (isset($formData['mailMail']) && $formData['mailMail'] != null) {
                    $tmpObject = Mail::where(
                        [
                            ['Id', '!=', $id],
                            ['Mail', $formData['mailMail']]
                        ]
                    )->first();
                    if (!empty($tmpObject)) {
                        return back()->withErrors("邮箱重复")->withInput();
                    } else {
                        $dataObject->Mail = $formData['mailMail'];
                    }
                }
                if (isset($formData['mailStatus']) && isset($this->statusArray[$formData['mailStatus']])) {
                    $dataObject->Status = $formData['mailStatus'];
                }
                $dataObject->UpdateTime = date('Y-m-d H:i:s');
                try {
                    $dataObject->save();
                    return redirect("/mail/edit/{$id}?action=edit");
                } catch (\Exception $e) {
                    return back()->withErrors($e->getMessage())->withInput();
                }
                break;
            case 'doadd':
                $mailName = $request->input('formData.mailName', '');
                $mailMail = $request->input('formData.mailMail', '');
                $mailStatus = $request->input('formData.mailStatus', 'ACTIVE');
                $tmpWhereArray = [
                    ['Mail', $mailMail],
                ];
                $tmpCollection = Mail::where($tmpWhereArray)->get();
                if (!$tmpCollection->isEmpty()) {
                    return back()->withErrors('邮箱重复')->withInput();
                } else {
                    try {
                        $tmpArray = [];
                        if (!empty($mailName)) {
                            $tmpArray['Name'] = $mailName;
                        }
                        if (!empty($mailMail)) {
                            $tmpArray['Mail'] = $mailMail;
                        }
                        if (isset($this->statusArray[$mailStatus])) {
                            $tmpArray['Status'] = $mailStatus;
                        }
                        $tmpTime = date('Y-m-d H:i:s');
                        $tmpArray['AddTime'] = $tmpTime;
                        $tmpArray['UpdateTime'] = $tmpTime;
                        $mailId = DB::table('mail_list')->insertGetId($tmpArray);
                        return redirect("/mail/edit/{$mailId}?action=edit");
                    } catch (\Exception $e) {
                        return back()->withErrors([$e->getMessage()])->withInput();
                    }
                }
                break;
            case 'add':
            default:
            return view('mailDetail', [
                'statusArray' => $this->statusArray,
                'title' => 'Mail(Add | Edit)',
                'pageName' => 'Mail(Add | Edit)',
                'requestPath' => url('/mail/edit'),
                'action' => 'doadd',
            ]);
        }
    }

    public function validateMail(Request $request) {
        $id = $request->input('id', 0);
        $mail = $request->input('mail', '');
        if (!empty($mail)) {
            $tmpObject = Mail::where(
                [
                    ['Id', '!=', $id],
                    ['Mail', $mail]
                ]
            )->first();
            if (!empty($tmpObject)) {
                echo json_encode(['flag' => false, 'message' => '<div class="panel panel-default"><div class="panel-heading"><h3 class="panel-title">error</h3></div><div class="panel-body"><div class="alert alert-danger"><ul><li>duplicate mail</li></ul></div></div></div>']);
            } else {
                echo json_encode(['flag' => true, 'message' => '']);
            }
        } else {
            echo json_encode(['flag' => false, 'message' => 'mail is empty']);
        }
    }
}
