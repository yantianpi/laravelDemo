<?php

namespace Peteryan\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Peteryan\Http\Requests\ProjectValidateRequest;
use Peteryan\Project;

class ProjectController extends Controller
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

    public function projectList(Request $request) {
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
            $dataCollection = Project::where($whereArray)->orderBy($tmpSort, $tmpOrder)->paginate($pageLimit);
        } else {
            $dataCollection = Project::where($whereArray)->paginate($pageLimit);
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
        return view('project', [
            'title' => 'Project',
            'pageName' => 'Project List',
            'dataCollection' => $dataCollection,
            'notData' => 'not data',
            'formData' => $formData,
            'statusArray' => $this->statusArray,
            'sortArray' => $this->sortArray,
            'orderArray' => $this->orderArray,
            'pageLimit' => $pageLimit,

        ]);
    }




    public function validateName(Request $request) {
        $id = $request->input('id', 0);
        $name = $request->input('name', '');
        if (!empty($name)) {
            $tmpObject = Project::where(
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
