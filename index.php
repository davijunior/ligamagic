<?php
header('Content-Type: application/json');
require "autoloader.php";

send_to_correct_method();

function send_to_correct_method(){
    $url_array = explode('/', $_SERVER['REQUEST_URI']);
    $class_name = ucwords($url_array[1]);
    $id = array_key_exists(2, $url_array) ? $url_array[2] : null;

    $class = new $class_name();
    switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            # localhost:8000/edition/scryfall pra cadastrar todas as edições da API
            if($class_name == 'Edition' && $id == "scryfall"){ 
                $class->save_editions_from_scryfall();
                break;
            }
            if($id){
                $class->selectById($id);
            }else{
                $class->select();
            }
            
            break;
        case 'POST':
            $class->create();
            break;
        case 'PUT':
            $class->update($id);
            break;
        case  'DELETE':
            $class->delete($id);
            break;
    }
}

?>