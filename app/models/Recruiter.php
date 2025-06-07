<?php
namespace App\Models;
class Recruiter
{
    protected $db;
    public function __construct($db) { $this->db = $db; }
    // Bổ sung function truy xuất recruiter nếu cần
}
