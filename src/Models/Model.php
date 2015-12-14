<?php namespace Models;
// CRUD -> Create Read Update Destroy

class Model{

    use \DebugTrait;

    protected  $pdo = null;
    protected  $table = "";
    private    $where = [];
    private    $select = "";
    private    $res;
    protected $fillable = [];
    protected $order = 'id';
    protected $orderDirection = 'DESC';
    protected $limit = 10;


    public function __construct() {

        if(!class_exists('\Connect')) throw new \RuntimeException("class Connect doesn't exists !");

        $this->pdo = \Connect::$pdo;
    }

    public function select($args='*'){

        //  todo améliorer les beug utilisateurs
        if($args == '*') {
            $this->select = $args;

            return $this;
        }
        if(is_array($args)) {
            $this->select = implode(', ', $args);

            return $this;
        }
    }

    public function where($fields, $operator, $value) {
        $operators=['=','>','<','!=','<>','>=','>='];

        if(!in_array($operator, $operators)){
            die(printf('invalid SQL operator, %s', $operator));
        }

        if(!is_numeric($value)){
            $value = $this->pdo->quote($value);
        }

        $this->where[] = "`$fields` $operator $value";

        return $this;
    }

    public function get(){

        $where = $this->buildWhere();

        //clean les variables de classes pour la prochaines requetes
        $this->where= [];
        $select = $this->select;
        $this->select = '';

        $sql = sprintf('SELECT %s FROM %s WHERE %s ORDER BY %s %s LIMIT 0, %s',
            $select,
            $this->table,
            $where,
            $this->order,
            $this->orderDirection,
            $this->limit
        );

        //var_dump($sql);
        //$this->debug($sql);

        return $this->pdo->query($sql);
    }

    public function count(){

        $where = $this->buildWhere();
        $this->where= [];

        $sql = sprintf('SELECT count(*) FROM %s WHERE %s',
            $this->table,
            $where
        );

        var_dump($sql);

        $res = $this->pdo->query($sql);

        return $res->fetchColumn();
    }

    public function create($data){

        // INSERT INTO $table ($fields) VALUES ($values)
        $fields = [];
        $values = [];

        foreach($data as $f => $v){
            $v = (is_numeric($v)) ? $v : $this->pdo->quote($v);
            if(!in_array($f, $this->fillable)) continue;

            $values[]=$v;
            $fields[]=$f;
        }

        $fields = '`'.implode('`,`', $fields).'`';
        $values = '('.implode(',', $values).')';

        $sql = sprintf('INSERT INTO %s %s VALUES %s',
            $this->table,
            $fields,
            $values
        );

        return $this->pdo->query($sql);
    }

    public function update($data){

    }

    private function buildWhere(){
        $where = '1 = 1';

        if(!empty($this->where)){
            $where.=' AND '.implode(' AND ', $this->where);
        }

        return $where;
        //clean les variables de classes pour la prochaines requetes
    }

    public function all($args='*'){
        $stmt =  $this->select($args)->get();

        return $stmt->fetchAll();
    }

    public function find($id, $args="*"){
        $stmt =  $this->select($args)->where('id', '=', $id)->get();

        return $stmt->fetch();
    }

}