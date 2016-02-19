<?php
class LoadFilesClass{

    private $dir;
    private $file_name_mask;
    private $file_extension;
    private $table;
    private $sql="";

    function __construct($dir, $file_name_mask, $file_extension, $table){
        $this->dir = $dir;
        $this->file_name_mask = $file_name_mask;
        $this->file_extension = $file_extension;
        $this->table = $table;
        $this->folder_create();
    }

    private function folder_create(){
        if(!is_dir($this->dir))
            mkdir($this->dir);
    }

    function load_files()
    {
        if (isset($_POST['submitFiles'])) {
            foreach ((array)$_FILES['userfile']['error'] as $key => $error) {
                if ($error == UPLOAD_ERR_OK) {
                    $name = $_FILES["userfile"]["name"][$key];
                    if (!file_exists("$this->dir/$name")) {
                        if($this->name_inspection($name)) {
                            $tmp_name = $_FILES["userfile"]["tmp_name"][$key];
                            $this->load_file($tmp_name, $name);
                        }
                    }
                    else {
                        echo "<div class='load_error'>Файл с именем " .$name. " уже был загружен!" . "</div>";
                    }
                }
            }
        }
        return $this->sql;
    }

    private function name_inspection($name){
        if (preg_match('/\w*('.$this->file_name_mask.')+\w*[.]('.$this->file_extension.')$/', $name))
            return true;
        else{
            echo "<div class='load_error'>Загрузка файла " .$name. " не выполнена!" . "</div>";
            return false;
        }

    }

    private function load_file($tmp_name, $name ){
        if(move_uploaded_file($tmp_name, "$this->dir/$name")){
            $mane = mysql_escape_string(htmlspecialchars(strip_tags($name)));
            $this->sql.= "INSERT INTO " . $this->table . "(Name, Date_create) VALUES ('" . $name . "','".gmdate('d.m.Y H:i',time())."');";
        }
    }
}
?>