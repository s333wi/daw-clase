<?php

namespace App\Models;

use CodeIgniter\Model;

class NewsModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'news';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = ['title', 'slug', 'body', 'data_pub', 'created_at', 'updated_at', 'deleted_at'];

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

    /**
     * addNoticia
     * $title    string  128
     * $slug     string  128
     * $body     text      
     * $data_pub datetime
     */
    public function addNoticia($title, $slug, $body)
    {

        $data = [
            'title' => $title,
            'slug' =>  $slug,
            'body' =>  $body,
        ];

        $this->insert($data);
    }

    /**
     * getNews
     * $slug=false
     */
    public function getNews($slug = false)
    {
        if ($slug === false) {
            return $this->findAll();
        }


        return $this->where('slug', $slug)->first();

        // return $this->where(['slug'=>$slug])->first();

    }
}
