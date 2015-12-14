<?php  namespace Models;

class History extends Model{

    protected $table='histories';
    protected $fillable = ['quantity', 'product_id', 'customer_id', 'price', 'total', 'commended_at'];

}