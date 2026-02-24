<?php

namespace App\Models;

use CodeIgniter\Model;

class PersonModel extends Model
{
    protected $table      = 'person';
   
    
    // Only allow fields that exist in your 'person' table structure
    protected $allowedFields = ['name', 'birthday']; 
}