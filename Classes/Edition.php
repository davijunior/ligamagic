<?php
    class Edition extends DB{
        public function __construct() {
            parent::__construct('edition');
        }

        public function save_editions_from_scryfall(){
            $response = file_get_contents("https://api.scryfall.com/sets");
            $decoded = JSON_decode($response);
            $data = $decoded->data;
            foreach($data as $edition) {
                
                $to_save = [
                    "portuguese_name" => $edition->name,
                    "english_name"    => $edition->name,
                    "release_date"    => $edition->released_at,
                    "card_quantity"   => $edition->card_count,
                ];
                $this->create_internal($to_save);
            }
            
        }
    }