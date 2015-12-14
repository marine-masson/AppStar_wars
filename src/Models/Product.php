<?php namespace Models;

class Product extends Model{

    protected $table = 'products';
    protected $order = 'published_at'; // astuce pour ordonné par ordre de date inverse
    protected $limit = 20;

    public function productId($product_id){
        $sql = sprintf("SELECT * FROM %s WHERE id=%d", $this->table, (int) $product_id);
        $stmt = $this->pdo->query($sql);
        if(!$stmt) return false;
        return $stmt->fetchAll();
    }
}