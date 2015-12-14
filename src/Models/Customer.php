<?php  namespace Models;

class Customer extends Model{

    protected $table='customers';
    protected  $fillable = ['email', 'number', 'adresse'];


}