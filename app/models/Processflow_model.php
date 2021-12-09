<?php

class Processflow_model{

    private $db;

    public function __construct()
    {
		  $this->db = new Database;
    }

    public function getAll(){
        $this->db->query("SELECT * FROM t_process_sequence");
		return $this->db->resultSet();
    }

    public function save($data){
        $query = "UPDATE t_process_sequence SET username=:username WHERE id=:id";
        $this->db->query($query);

        $this->db->bind('id',       $data['processid']);
        $this->db->bind('username', $data['pic']);
        $this->db->execute();

        return $this->db->rowCount();
    }
}