<?php

namespace App\Models;

use CodeIgniter\Model;

class LinkModel extends Model
{

    protected $DBGroup          = 'default';
    protected $table            = 'links';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['link', 'custom_link', 'description', 'user_id', 'created_at', 'updated_at', 'deleted_at', 'expires_at'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function checkCustomLink($link)
    {
        $this->where('custom_link', $link);
        $this->where('deleted_at', null);
        $this->where('expires_at >', date('Y-m-d H:i:s'));
        $query = $this->get();
        if ($query->getResult()) {
            return true;
        } else {
            return false;
        }
    }

    public function getLink($link)
    {
        $query = $this->builder()->getWhere(['custom_link' => $link, 'deleted_at' => null]);
        if ($dbLink = $query->getResult()[0]) {
            //Comprovo que no hagi expirat el link
            if ($dbLink->expires_at > date('Y-m-d H:i:s') || $dbLink->expires_at == null) {
                return $dbLink;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}
