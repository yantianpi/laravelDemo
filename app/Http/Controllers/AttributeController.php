<?php

namespace Peteryan\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Peteryan\Attribute;
use Peteryan\Category;
use Peteryan\Http\Requests\AttributeValiateRequest;

class AttributeController extends Controller
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

    private $contentTypeArray = [
        'INT' => 'INT',
        'STRING' => 'STRING',
        'REGEX' => 'REGEX',
        'FLOAT' => 'FLOAT',
        'OTHER' => 'OTHER',
    ];

    /**
     * atribute list
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function attributeList(Request $request) {
        $formData = $request->input('formData', []);
        $pageLimit = $request->input('pageLimit', 5);
        $whereArray = [];
        if (isset($formData['Status']) && !empty($formData['Status'])) {
            $whereArray[] = ['Status', addslashes($formData['Status'])];
        }
        if (isset($formData['Id']) && !empty($formData['Id'])) {
            $whereArray[] = ['Id', addslashes($formData['Id'])];
        }
        if (isset($formData['CategoryId']) && !empty($formData['CategoryId'])) {
            $whereArray[] = ['CategoryId', addslashes($formData['CategoryId'])];
        }
        $tmpSort = isset($formData['sort']) ? $formData['sort'] : 'Id';
        $tmpOrder = isset($formData['order']) ? $formData['order'] : 'ASC';
        if (isset($this->sortArray[$tmpSort]) && isset($this->orderArray[$tmpOrder])) {
            $attributeCollection = Attribute::where($whereArray)->orderBy($tmpSort, $tmpOrder)->paginate($pageLimit);
        } else {
            $attributeCollection = Attribute::where($whereArray)->paginate($pageLimit);
        }
        $attributeCollection->load('category');
        $categoryCollection = Category::active()->get();

        /*
         * paging
         */
        if (isset($formData['Id'])) {
            $attributeCollection->appends(['formData[Id]' => $formData['Id']]);
        }
        if (isset($formData['Status'])) {
            $attributeCollection->appends(['formData[Status]' => $formData['Status']]);
        }
        if (isset($formData['CategoryId'])) {
            $attributeCollection->appends(['formData[CategoryId]' => $formData['CategoryId']]);
        }
        if (isset($formData['sort'])) {
            $attributeCollection->appends(['formData[sort]' => $formData['sort']]);
        }
        if (isset($formData['order'])) {
            $attributeCollection->appends(['formData[order]' => $formData['order']]);
        }

        /*
         * view
         */
        return view('attribute', [
            'title' => 'Attribute',
            'pageName' => 'Attribute List',
            'attributeCollection' => $attributeCollection,
            'notData' => 'not data',
            'formData' => $formData,
            'categoryCollection' => $categoryCollection,
            'statusArray' => $this->statusArray,
            'sortArray' => $this->sortArray,
            'orderArray' => $this->orderArray,

        ]);
    }

    /**
     * ajax attribute detail
     *
     * @param Request $request
     * @param $id attribute id
     */
    public function attributeDetail(Request $request, $id) {
        $attributeObject = Attribute::with('category')->findOrFail($id);
        echo view('modal.attribute', [
            'attributeObject' => $attributeObject,
        ]);
    }

    /**
     * 处理属性的添加于编辑
     *
     * @param AttributeValiateRequest $request 方法体执行前会进行一些数据校验，参考校验类AttributeValiateRequest
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function attributeEdit(AttributeValiateRequest $request, $id = 0) {
        $categoryCollection = Category::active()->get();
        if ($categoryCollection->isEmpty()) {
            die('without active category');
        }
        $action = $request->input('action', '');
        if (empty($action)) {
            $action = $request->input('act', '');
        }
        switch ($action) {
            case 'edit':
                $id = intval($id);
                $attributeObject = Attribute::with('category')->findOrFail($id);
                return view('attributeDetail', [
                    'contentTypeArray' => $this->contentTypeArray,
                    'statusArray' => $this->statusArray,
                    'title' => 'Attribute(Add | Edit)',
                    'pageName' => 'Attribute(Add | Edit)',
                    'requestPath' => url('/attribute/edit/' . $id),
                    'action' => 'doedit',
                    'categoryCollection' => $categoryCollection,
                    'attributeObject' => $attributeObject,
                ]);
                break;
            case 'doedit':
                $id = $request->input('id', 0);
                $attributeObject = Attribute::findOrFail($id);
                $formData = $request->input('formData', []);
                if (isset($formData['attributeCategory']) && $formData['attributeCategory'] != null) {
                    $attributeObject->CategoryId = intval($formData['attributeCategory']);
                }
                if (isset($formData['attributeName']) && $formData['attributeName'] != null) {
                    $attributeObject->Name = $formData['attributeName'];
                }
                if (isset($formData['attributeAlias']) && $formData['attributeAlias'] != null) {
                    $attributeObject->Alias = $formData['attributeAlias'];
                }
                if (isset($formData['attributeContentType']) && isset($this->contentTypeArray[$formData['attributeContentType']])) {
                    $attributeObject->ContentType = $formData['attributeContentType'];
                }
                if (isset($formData['attributeDefaultMessage']) && $formData['attributeDefaultMessage'] != null) {
                    $attributeObject->DefaultMessage = $formData['attributeDefaultMessage'];
                }
                if (isset($formData['attributeStatus']) && isset($this->statusArray[$formData['attributeStatus']])) {
                    $attributeObject->Status = $formData['attributeStatus'];
                }
                $attributeObject->UpdateTime = date('Y-m-d H:i:s');
                try {
                    $attributeObject->save();
                    return redirect("/attribute/edit/{$id}?action=edit");
                } catch (\Exception $e) {
                    return back()->withErrors($e->getMessage())->withInput();
                }
                break;
            case 'doadd':
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


}
