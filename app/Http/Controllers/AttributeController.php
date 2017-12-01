<?php

namespace Peteryan\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Peteryan\Attribute;
use Peteryan\Category;

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

    public function attributeEdit(Request $request, $id = 0) {
        $categoryCollection = Category::active()->get();
        if ($categoryCollection->isEmpty()) {
            die('without active category');
        }
        $id = intval($id);
        $action = $request->input('action', '');
        if (empty($action)) {
            $action = $request->input('act', '');
        }
        if (empty($id)) {
            $action = '';
        }
        switch ($action) {
            case 'edit':
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
                break;
            case 'doadd':
                break;
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
