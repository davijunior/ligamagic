<?php

class DB{
    function __construct($table){
        $this->table = $table;
        $this->conn = new PDO('mysql:host=localhost;dbname=ligamagic', 'root', 'root');
    }

    function create(){
        $jsonString = file_get_contents('php://input');
        $data_decoded = json_decode($jsonString);
        [$fields, $values] = $this->create_sql_insert_data($data_decoded);

        $sql = "INSERT INTO {$this->table} ($fields) VALUES ({$values})";
        $this->conn->query($sql);
        return $this->conn->lastInsertId();
    }

    function create_internal($data){
        [$fields, $values] = $this->create_sql_insert_data($data);

        $sql = "INSERT INTO {$this->table} ($fields) VALUES ({$values})";
        $this->conn->query($sql);
        return $this->conn->lastInsertId();
    }

    function update($id){
        $jsonString = file_get_contents('php://input');
        $data_decoded = json_decode($jsonString);
        $data = $this->create_sql_update_data($data_decoded);

        $sql = "UPDATE {$this->table} SET {$data} WHERE id = {$id}";
        $this->conn->query($sql);
    }

    function delete($id){
        $sql = "DELETE FROM {$this->table} WHERE id = {$id}";
        $this->conn->query($sql);
    }

    function select(){
        $sql = "SELECT * FROM {$this->table}";
        echo json_encode($this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC));
    }

    function selectById($id){
        $sql = "SELECT * FROM {$this->table} WHERE id = {$id}";
        echo json_encode($this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC)[0]);
    }

    function create_sql_insert_data($data_decoded){
        $fields = '';
        $values = '';
        foreach ($data_decoded as $key => $value) {
            $value = str_replace("'","", $value);
            $fields.= "{$key}, ";
            $values.= "'{$value}', ";
        }
        $fields = substr($fields, 0, -2);
        $values = substr($values, 0, -2);
        return [$fields, $values];
    }

    function create_sql_update_data($data_decoded){
        $fields = '';
        foreach ($data_decoded as $key => $value) {
            if(is_numeric($value)){
                $fields.= "{$key} = {$value}, ";
            }else{
                $fields.= "{$key} = '{$value}', ";
            }
        }
        $fields = substr($fields, 0, -2);
        return $fields;
    }

}