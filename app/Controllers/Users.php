<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;
use App\Models\LogModel;

class Users extends Controller
{
    public function index() {
        $model = new UserModel();
        $data['users'] = $model->findAll();
        return view('users/index', $data);
    }

    public function save() {
        $userModel = new UserModel();
        $logModel = new LogModel();

        $name     = $this->request->getPost('name');
        $email    = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $role     = $this->request->getPost('role');
        $status   = $this->request->getPost('status');
        $phone    = $this->request->getPost('phone');

        if (!$email || !$password) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Email and password are required']);
        }

        // Check if email exists
        if ($userModel->where('email', $email)->first()) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Email is already in use']);
        }
        

        $data = [
            'name'       => $name,
            'email'      => $email,
            'password'   => password_hash($password, PASSWORD_DEFAULT),
            'role'       => $role,
            'status'     => $status,
            'phone'      => $phone,
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        if ($userModel->insert($data)) {
            $logModel->addLog('New User added: ' . $name, 'ADD');
            return $this->response->setJSON(['status' => 'success']);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Failed to save user']);
        }
    }

    public function update() {
        $model = new UserModel();
        $logModel = new LogModel();

        $userId   = $this->request->getPost('id');
        $name     = $this->request->getPost('name');
        $email    = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $role     = $this->request->getPost('role');
        $status   = $this->request->getPost('status');
        $phone    = $this->request->getPost('phone');

        if (empty($email)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Email is required']);
        }

        // Email check for other users
        $existingUser = $model->where('email', $email)->where('id !=', $userId)->first();
        if ($existingUser) {
            return $this->response->setJSON(['success' => false, 'message' => 'Email taken by another user.']);
        }

        $userData = [
            'name'       => $name,
            'email'      => $email,
            'role'       => $role,
            'status'     => $status,
            'phone'      => $phone,
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        if (!empty($password)) {
            $userData['password'] = password_hash($password, PASSWORD_BCRYPT);
        }

        if ($model->update($userId, $userData)) {
            $logModel->addLog('User updated: ' . $name, 'UPDATED');
            return $this->response->setJSON(['success' => true, 'message' => 'User updated successfully.']);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Error updating user.']);
        }
    }

    public function edit($id) {
        $model = new UserModel();
        $user = $model->find($id);

        if ($user) {
            return $this->response->setJSON(['data' => $user]);
        } else {
            return $this->response->setStatusCode(404)->setJSON(['error' => 'User not found']);
        }
    }

    public function delete($id) {
        $model = new UserModel();
        $logModel = new LogModel();

        if ($model->delete($id)) {
            $logModel->addLog('Deleted user ID: ' . $id, 'DELETED');
            return $this->response->setJSON(['success' => true, 'message' => 'User deleted successfully.']);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Failed to delete user.']);
        }
    }

    public function fetchRecords() {
        $request = service('request');
        $model = new UserModel();

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
                'email'      => $row['email'] ?? '',
                'role'       => $row['role'] ?? '',
                'status'     => $row['status'] ?? '',
                'phone'      => $row['phone'] ?? '',
                'created_at' => $row['created_at'] ?? '',
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