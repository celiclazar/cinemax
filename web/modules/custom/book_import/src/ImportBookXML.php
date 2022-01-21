<?php

namespace Drupal\book_import;
use SimpleXMLElement;
use Drupal\node\Entity\Node;

class ImportBookXML {

    public function getBooksFromXML(){

        $xml_url_request = \Drupal::request()->query->get('extURL');
        if(!empty($xml_url_request)) {
            $url = $xml_url_request;
            $xml_content = simplexml_load_file($url) or die("Can't connect");
            
           
            foreach ($xml_content->book as $knjiga ){
                $niz_knjiga[] = [
                    "isbn" => $knjiga->attributes()->{"ISBN"}, 
                    "price" => $knjiga->price, 
                    "title" => $knjiga->title, 
                    "comments" => $knjiga->comments,
                ];    
            }

            $arr_len = count($niz_knjiga);
            $i = 0;

            while ( $i < $arr_len ) {
                $node = Node::create([
                    'type' => 'book',
                    'title' => $niz_knjiga[$i]['title'],
                    'field_book_title' => $niz_knjiga[$i]['title'],
                    'field_book_price' => $niz_knjiga[$i]['price'],
                    'field_book_isbn' => $niz_knjiga[$i]['isbn'],
                    'field_book_comments' => $niz_knjiga[$i]['comments']
                
                ]);
                $node->save();
                $i++;
            }

        return $niz_knjiga;

        }
    }
}
 