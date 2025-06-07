<?php
namespace App\Models;

class User
{
    protected $db;
    public function __construct($db) { $this->db = $db; }

    public function findByEmail($email)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function create($email, $name, $password, $role = 'candidate')
    {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->db->prepare("INSERT INTO users (email, name, password, role) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$email, $name, $hash, $role]);
    }

    public function findById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    // Nếu có searchCandidates thì thêm luôn ở đây
    public function searchCandidates($q)
    {
        $sql = "SELECT * FROM users WHERE role = 'candidate' 
                AND (name LIKE ? OR email LIKE ?)";
        $q2 = '%' . $q . '%';
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$q2, $q2]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
