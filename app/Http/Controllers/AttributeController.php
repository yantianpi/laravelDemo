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
            $attributeList = Attribute::where($whereArray)->orderBy($tmpSort, $tmpOrder)->paginate($pageLimit);
        } else {
            $attributeList = Attribute::where($whereArray)->paginate($pageLimit);
        }
        $attributeList->load('category');
        $categoryArray = Category::all();

        /*
         * paging
         */
        if (isset($formData['Id'])) {
            $attributeList->appends(['formData[Id]' => $formData['Id']]);
        }
        if (isset($formData['Status'])) {
            $attributeList->appends(['formData[Status]' => $formData['Status']]);
        }
        if (isset($formData['CategoryId'])) {
            $attributeList->appends(['formData[CategoryId]' => $formData['CategoryId']]);
        }
        if (isset($formData['sort'])) {
            $attributeList->appends(['formData[sort]' => $formData['sort']]);
        }
        if (isset($formData['order'])) {
            $attributeList->appends(['formData[order]' => $formData['order']]);
        }

        /*
         * view
         */
        return view('attribute', [
            'title' => 'Attribute',
            'pageName' => 'Attribute List',
            'attributeList' => $attributeList,
            'notData' => 'not data',
            'formData' => $formData,
            'categoryArray' => $categoryArray,
            'statusArray' => $this->statusArray,
            'sortArray' => $this->sortArray,
            'orderArray' => $this->orderArray,

        ]);
    }

    public function attributeDetail(Request $request, $id) {
        $attributeInfo = Attribute::with('category')->find($id);
        echo view('modal.attribute', [
            'attributeInfo' => $attributeInfo,
        ]);
    }
}
