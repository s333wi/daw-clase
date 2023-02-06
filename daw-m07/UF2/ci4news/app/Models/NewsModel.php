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
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['title', 'slug', 'body', 'data_pub'];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'title' => 'required|min_length[3]|max_length[255]',
        'slug' => 'required|min_length[3]|max_length[255]|is_unique[news.slug,id,{id}]',
        'body' => 'required'
    ];
    protected $validationMessages   = [
        'title' => [
            'required' => 'El titol es obligatori',
            'min_length' => 'El titol ha de tenir com a mínim 3 caràcters',
            'max_length' => 'El titol ha de tenir com a màxim 255 caràcters'
        ],
        'slug' => [
            'required' => 'El slug es obligatori',
            'min_length' => 'El slug ha de tenir com a mínim 3 caràcters',
            'max_length' => 'El slug ha de tenir com a màxim 255 caràcters',
            'is_unique' => 'El slug ja existeix'
        ],
        'body' => [
            'required' => 'El body de la noticia es obligatori'
        ]
    ];
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
     * Metodes de la classe NewsModel
     */

    /**
     * Afegeix una noticia a la base de dades
     * @param array $data
     * 
     * @return void
     */
    public function insertNews($data)
    {
        $this->insert($data);
    }

    /**
     * Retorna totes les noticies si no se li passa cap slug
     * Si se li passa un slug retorna la noticia amb aquest slug
     * @param string $slug
     * @return array
     */
    public function getNews($slug = false)
    {
        if ($slug === false) {
            return $this->findAll();
        }
        return $this->asArray()
            ->where(['slug' => $slug])
            ->first();
    }
}
