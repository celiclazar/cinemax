<?php

namespace Drupal\movie_exporter\Controller;
use Drupal\Core\Controller\ControllerBase;
use Drupal\serialization\Encoder\XmlEncoder;
use SimpleXMLElement;
use Drupal\Core\Ajax\HtmlCommand;



class MovieExporterController {

    public function exportMovies(){
    
     $export_query = \Drupal::entityQuery('node')
        ->condition('type', 'movie')
        ->condition('field_include_in_exporter', 1)
        ->execute();
     $exported_movies = \Drupal\node\Entity\Node::loadMultiple($export_query);
     $file_type = \Drupal::request()->query->get('fileType');
     $file_type_response = "";
      if (isset($file_type)){
        if ( $file_type == 'csv' ) {
            $this->CreateCSV ($exported_movies);
            $file_type_response = "csv";
        }
        else if($file_type == "xml"){
            $this->CreateXML($exported_movies);
            $file_type_response = "xml";
        }    
        }
        return array (
            '#theme' => 'movie_exporter_theme',
            '#file_type_response' => $file_type_response,
            '#title' => 'Export movies'
        );    
    }

    public function createXML($exported_movies) {

     $xml = new SimpleXMLElement('<xml/>');
       
        foreach ($exported_movies as $node) {

         $movie = $xml->addChild('movie');
         $movie->addChild('title', $node->title->value);
         $movie->addChild('description', $node->field_movie_description->value);
      }

     $movie_xml_content = $xml->asXML();
     $file_movieXML = fopen("movies.xml", "w");
     fwrite($file_movieXML, $movie_xml_content);
     fclose($file_movieXML);
    }

    public function createCSV($exported_movies) {
    
     foreach ($exported_movies as $node){
         $csv_content[] = array (
            array($node->title->value),
            array($node->field_movie_description->value) 
        );
        
     $file_movieCSV = fopen ("movies.csv", "w");
        foreach ($csv_content as $row) {
            foreach ($row as $value){
             fputcsv($file_movieCSV, $value);
                }
             }
             fclose($file_movieCSV);
        }
    }
}
 