<?php

namespace Asus\Project\Models;

use Asus\Project\Commons\Helper;
use Asus\Project\Commons\Model;

class Product extends Model
{
    protected string $tableName = 'products';

    public function all(){
        return $this->queryBuilder
        ->select(
            'p.id','p.category_id','p.name','p.img_thumbnail','p.created_at','p.update_at',
            'c.name as c_name'
        )
        ->from($this->tableName,'p')
        ->innerJoin('p','categories','c','c.id = p.category_id')
        ->orderBy('p.id','desc')
        ->fetchAllAssociative();
    }
    public function paginate($page=1,$parPage =5) {
          $queryBuilder= clone ($this->queryBuilder);
          $totalpage = ceil($this->count() / $parPage);
        
          $offset =$parPage * ($page -1);
          $data =$queryBuilder
          ->select(
            'p.id','p.category_id','p.name','p.img_thumbnail','p.created_at','p.update_at',
            'c.name as c_name'
          )
          ->from($this->tableName,'p')
          ->innerJoin('p','categories','c','c.id = p.category_id')
          ->setFirstResult($offset)
          ->setMaxResults($parPage)
          ->orderBy('p.id','desc')
          ->fetchAllAssociative();
          
            return [$data, $totalpage];
       }

       public function findByID($id)
       {
        return $this->queryBuilder
           ->select(
            'p.id','p.category_id','p.name','p.img_thumbnail','p.created_at','p.update_at',
            'p.overview','p.content',
            'c.name as c_name'
           )
           ->from($this->tableName,'p')
           ->innerJoin('p','categories','c','c.id = p.category_id')
           ->where('p.id = ?') 
           ->setParameter(0, $id)
           ->fetchAssociative();
       }
     
}