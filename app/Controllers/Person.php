<?php

namespace App\Controllers;

use App\Models\LogModel;
use App\Models\PersonModel;

class Person extends BaseController
{
    public function index()
    {
        $personModel = new PersonModel();
        $data['person'] = $personModel->findAll(); 
        return view('person/person', $data);
    }

    public function save()
    {
        $personModel = new \App\Models\PersonModel();
        $logModel = new LogModel(); // Fixed variable casing

        $name = $this->request->getPost('name');
        $data = [
            'name'     => $name,
            'birthday' => $this->request->getPost('birthday'),
        ];

        if ($personModel->save($data)) {
            // --- ADDED LOGGING HERE ---
            $logModel->addLog("Added new person: " . $name, "PERSON");
            return $this->response->setJSON(['status' => 'success']);
        }
        
        return $this->response->setJSON([
            'status' => 'error', 
            'message' => implode(', ', $personModel->errors())
        ]);
    }

    public function delete($id)
    {
        $personModel = new \App\Models\PersonModel();
        $logModel = new LogModel();

        // Fetch name before deleting so we can record it in the log
        $person = $personModel->find($id);
        $name = $person ? $person['name'] : "Unknown ID: " . $id;

        if ($personModel->delete($id)) {
            // --- ADDED LOGGING HERE ---
            $logModel->addLog("Deleted person: " . $name, "PERSON");
            return $this->response->setJSON(['status' => 'success']);
        }
        return $this->response->setJSON(['status' => 'error', 'message' => 'Delete failed']);
    }

    public function edit($id)
    {
        $personModel = new \App\Models\PersonModel();
        $data = $personModel->find($id);

        if ($data) {
            return $this->response->setJSON([
                'status' => 'success',
                'data'   => $data
            ]);
        }

        return $this->response->setJSON([
            'status'  => 'error',
            'message' => 'Record not found'
        ]);
    }

    public function update_person()
    {
        $personModel = new \App\Models\PersonModel();
        $logModel = new \App\Models\LogModel();

        $id = $this->request->getPost('id');
        $name = $this->request->getPost('name');

        $data = [
            'name'     => $name,
            'birthday' => $this->request->getPost('birthday'),
        ];

        if ($personModel->update($id, $data)) {
            // This records the update activity
            $logModel->addLog("Updated Person: " . $name . " (ID: " . $id . ")", "PERSON");
            return $this->response->setJSON(['status' => 'success']);
        }
    }
}