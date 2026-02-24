<?php

namespace App\Controllers;
use App\Models\LogModel;
use App\Models\UserModel;

class Dashboard extends BaseController
{
   public function index()
   
{
    if (!session()->get('user_id')) {
        return redirect()->to('/login');
    }

    $logModel = model(LogModel::class);

    $data = [
        'totalRegistrations'=> $logModel->countAllResults(),
        'lastUpdate' => date('h:i:s A'),
        'systemStatus' => 'Optimal',
        // Fetch only the 5 most recent activities for the dashboard
        'recentLogs' => $logModel->orderBy('DATELOG', 'DESC')
                                         ->orderBy('TIMELOG', 'DESC')
                                         ->findAll(7), 
    ];
    // We sort by date first, then time, to get the most recent entries
 $logModel->orderBy('DATELOG', 'DESC')
                       ->orderBy('TIMELOG', 'DESC')
                       ->limit(7)
                       ->find();

    return view('Dashboard/dashboard', $data);

}

    public function newOrders()
{
    // You can fetch specific data from an OrderModel here later
    return view('Dashboard/new_orders_details');
}
public function bounceRate()
{
    return view('Dashboard/bounce_rate_details');
}
public function uniqueVisitors()
{
    return view('Dashboard/unique_visitors_details');
}
public function userRegistrations() 
{
    $logModel = model(LogModel::class);

    $data = [
        // Sort by Date first (DESC = newest first), then by Time
        'userLogs' => $logModel->orderBy('DATELOG', 'DESC')
                               ->orderBy('TIMELOG', 'DESC')
                               ->findAll(),
    ];

    return view('Dashboard/user_registrations_details', $data);
}
public function store()
{
    $userModel = model(UserModel::class);
    $logModel = model(LogModel::class);

    $name = $this->request->getPost('name');
    $email = $this->request->getPost('email');

    $userData = [
        'name'   => $name,
        'email'  => $email,
        'role'   => $this->request->getPost('role'),
        'status' => 'Active',
    ];

    if ($userModel->insert($userData)) {
        
        // MATCHING YOUR VIEW FIELDS:
        $registrationData = [
    'DATELOG'         => date('Y-m-d'), // e.g., 2024-05-20
    'TIMELOG'         => date('H:i:s'), // e.g., 14:30:05
    'USER_NAME'       => $name, 
    'ACTION'          => 'Added new user: ' . $email,
    'user_ip_address' => $this->request->getIPAddress()
];
        $logModel->insert($registrationData);

        return redirect()->to(base_url('userRegistrations'))->with('success', 'Activity Logged!');
    }
}
public function log()
{
    return view('dashboard/user-regstration');
}


    
}
