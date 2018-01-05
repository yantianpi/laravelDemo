<?php

namespace Peteryan\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Peteryan\Category;
use Peteryan\Http\Requests\CategoryValidateRequest;

class CategoryController extends Controller
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

    /**
     * category list
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function categoryList(Request $request) {
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
            $dataCollection = Category::where($whereArray)->orderBy($tmpSort, $tmpOrder)->paginate($pageLimit);
        } else {
            $dataCollection = Category::where($whereArray)->paginate($pageLimit);
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
        return view('category', [
            'title' => 'Category',
            'pageName' => 'Category List',
            'dataCollection' => $dataCollection,
            'notData' => 'not data',
            'formData' => $formData,
            'statusArray' => $this->statusArray,
            'sortArray' => $this->sortArray,
            'orderArray' => $this->orderArray,
            'pageLimit' => $pageLimit,

        ]);
    }

    /**
     * category detail
     *
     * @param Request $request
     * @param $id
     */
    public function categoryDetail(Request $request, $id) {
        $dataObject = Category::findOrFail($id);
        echo view('modal.category', [
            'dataObject' => $dataObject,
        ]);
    }

    /**
     * relation attribute
     *
     * @param Request $request
     * @param $id
     */
    public function categoryAttributeList(Request $request, $id) {
        $dataObject = Category::findOrFail($id)->attributeList()->active()->get();
//        $dataObject = Category::findOrFail($id)->attributeList;
//        dd($dataObject);
        echo view('modal.categoryAttributeList', [
            'dataObject' => $dataObject,
        ]);
    }

    public function categoryEdit(CategoryValidateRequest $request, $id = 0) {
        $action = $request->input('action', '');
        if (empty($action)) {
            $action = $request->input('act', '');
        }
        switch ($action) {
            case 'edit':
                $id = intval($id);
                $dataObject = Category::findOrFail($id);
                return view('categoryDetail', [
                    'statusArray' => $this->statusArray,
                    'title' => 'Category(Add | Edit)',
                    'pageName' => 'Category(Add | Edit)',
                    'requestPath' => url('/category/edit/' . $id),
                    'action' => 'doedit',
                    'dataObject' => $dataObject,
                ]);
                break;
            case 'doedit':
                $id = $request->input('id', 0);
                $categoryObject = Category::findOrFail($id);
                $formData = $request->input('formData', []);
                if (isset($formData['categoryName']) && $formData['categoryName'] != null) {
                    $tmpObject = Category::where(
                        [
                            ['Id', '!=', $id],
                            ['Name', $formData['categoryName']]
                        ]
                    )->first();
                    if (!empty($tmpObject)) {
                        return back()->withErrors("分类名重复")->withInput();
                    } else {
                        $categoryObject->Name = $formData['categoryName'];
                    }
                }
                if (isset($formData['categoryAlias']) && $formData['categoryAlias'] != null) {
                    $categoryObject->Alias = $formData['categoryAlias'];
                }
                if (isset($formData['categoryScript']) && $formData['categoryScript'] != null) {
                    $categoryObject->Script = $formData['categoryScript'];
                }
                if (isset($formData['categoryStatus']) && isset($this->statusArray[$formData['categoryStatus']])) {
                    $categoryObject->Status = $formData['categoryStatus'];
                }
                $categoryObject->UpdateTime = date('Y-m-d H:i:s');
                try {
                    $categoryObject->save();
                    return redirect("/category/edit/{$id}?action=edit");
                } catch (\Exception $e) {
                    return back()->withErrors($e->getMessage())->withInput();
                }
                break;
            case 'doadd':
                $categoryName = $request->input('formData.categoryName', '');
                $categoryAlias = $request->input('formData.categoryAlias', '');
                $categoryScript = $request->input('formData.categoryScript', '');
                $categoryStatus = $request->input('formData.categoryStatus', 'ACTIVE');
                $tmpWhereArray = [
                    ['Name', $categoryName],
                ];
                $tmpCollection = Category::where($tmpWhereArray)->get();
                if (!$tmpCollection->isEmpty()) {
                    return back()->withErrors('duplicate record')->withInput();
                } else {
                    try {
                        $tmpArray = [];
                        if (!empty($categoryName)) {
                            $tmpArray['Name'] = $categoryName;
                        }
                        if (!empty($categoryAlias)) {
                            $tmpArray['Alias'] = $categoryAlias;
                        }
                        if (!empty($categoryScript)) {
                            $tmpArray['Script'] = $categoryScript;
                        }
                        if (isset($this->statusArray[$categoryStatus])) {
                            $tmpArray['Status'] = $categoryStatus;
                        }
                        $tmpTime = date('Y-m-d H:i:s');
                        $tmpArray['AddTime'] = $tmpTime;
                        $tmpArray['UpdateTime'] = $tmpTime;
                        $categoryId = DB::table('category_list')->insertGetId($tmpArray);
                        return redirect("/category/edit/{$categoryId}?action=edit");
                    } catch (\Exception $e) {
                        return back()->withErrors([$e->getMessage()])->withInput();
                    }
                }
                break;
            case 'add':
            default:
                return view('categoryDetail', [
                    'statusArray' => $this->statusArray,
                    'title' => 'Category(Add | Edit)',
                    'pageName' => 'Category(Add | Edit)',
                    'requestPath' => url('/category/edit/'),
                    'action' => 'doadd',
                ]);
        }

    }

    public function validateName(Request $request) {
        $id = $request->input('id', 0);
        $name = $request->input('name', '');
        if (!empty($name)) {
            $tmpObject = Category::where(
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
