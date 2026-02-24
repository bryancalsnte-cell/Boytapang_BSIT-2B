<?php

namespace App\Controllers;
use CodeIgniter\Controller;
use App\Models\LogModel;
use App\Models\StudentModel;


class Student extends Controller
{
    public function index() {
        $model = new StudentModel();
        $data['student'] = $model->findAll();
        return view('student/index', $data);
    }


    public function fetchRecords() {
        $request = service('request');
        $model = new StudentModel();

        $start = $request->getPost('start') ?? 0;
        $length = $request->getPost('length') ?? 10;
        $searchValue = $request->getPost('search')['value'] ?? '';

        $totalRecords = $model->countAll();
        $result = $model->getRecords($start, $length, $searchValue);

        $data = [];
        $counter = $start + 1;
        foreach ($result['data'] as $row) {
            $data[] = [
                'row_number' => $counter++,
                'id'         => $row['id'],
                'name'       => $row['name'] ?? '',
                'bday'      => $row['bday'] ?? '',
                'address'      => $row['address'] ?? '',
           
            ];
        }

        return $this->response->setJSON([
            'draw'            => intval($request->getPost('draw')),
            'recordsTotal'    => $totalRecords,
            'recordsFiltered' => $result['filtered'],
            'data'            => $data,
        ]);
    }
    
}