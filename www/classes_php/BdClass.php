<?php
class BdClass
{
    private $mysqli;
    private $host;
    private $user;
    private $pass;
    private $db;
    private $table;

    function __construct($host, $user, $pass, $db, $table)
    {
        $this->host = $host;
        $this->user = $user;
        $this->pass = $pass;
        $this->db = $db;
        $this->table = $table;

        if($this->mysql_connect())
            if($this->bd_create())
                $this->table_create();
    }

    private function mysql_connect($db = ""){
        $this->mysqli = new mysqli($this->host, $this->user, $this->pass, $db);
        if ($this->mysqli->connect_errno && $db == "" ) {
            echo "<div class='bd_error'>Не удалось подключиться к MySQL: (" . $this->mysqli->connect_errno . ") " . $this->mysqli->connect_error."</div>";
            return false;
        }
        else if ($this->mysqli->connect_errno && $db != "" ) {
            echo "<div class='bd_error'>Не удалось подключиться к BD '".$db."': (" . $this->mysqli->connect_errno . ") " . $this->mysqli->connect_error."</div>";
            return false;
        }
        else{
            return true;
        }
    }

    private function bd_create(){
        $this->mysqli->real_query('CREATE DATABASE IF NOT EXISTS `'.$this->db.'`');
        if ($this-> mysql_connect($this->db)) {
            return true;
        }else{
            return false;
        }
    }

    private function table_create(){
        if (!$this->mysqli->query("CREATE TABLE IF NOT EXISTS ".$this->table."(
                                                `Id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
                                                `Name` VARCHAR( 50 ) NOT NULL,
                                                `Date_create` VARCHAR( 18 ) NOT NULL )")) {
            echo "<div class='bd_error'>Не удалось создать таблицу '".$this->table."': (" . $this->mysqli->errno . ") " . $this->mysqli->error."</div>";
        }
    }

    function insert_records($sql){
        if (!$this->mysqli->multi_query($sql)) {

            echo "<div class='bd_error'>Не удалось выполнить запись данных в таблицу '".$this->table."': (" . $this->mysqli->errno . ") " . $this->mysqli->error."</div>";
        }

        do {
            if ($res = $this->mysqli->store_result()) {
                var_dump($res->fetch_all(MYSQLI_ASSOC));
                $res->free();
            }
        } while ($this->mysqli->more_results() && $this->mysqli->next_result());
    }

    function select_records(){
        $res = $this->mysqli->query("SELECT * FROM ".$this->table);
        for ($row_no = $res->num_rows - 1; $row_no >= 0; $row_no--) {
        //for ($row_no = 0; $row_no < $res->num_rows; $row_no ++) {
            $res->data_seek($row_no);
            $row = $res->fetch_assoc();
            echo "<tr>";
            echo "<td>" . $row['Id'] ."</td><td>".  $row['Name']."</td><td>".  $row['Date_create']."</td>";
            echo "</tr>";
        }
    }

    function __destruct(){
        $this->mysqli->close;
    }
}

?>