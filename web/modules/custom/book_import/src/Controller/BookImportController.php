<?php

namespace Drupal\book_import\Controller;

use SimpleXMLElement;
use Drupal\Core\Controller\ControllerBase;
use Drupal\book_import\ImportBookXML;
use Symfony\Component\DependencyInjection\ContainerInterface;

class BookImportController extends ControllerBase {

    protected $test_var;

        public function __construct(ImportBookXML $test_var){
            $this->test_var = $test_var;
        }

        public static function create(ContainerInterface $container) {
            return new static(
                $container->get('book_import.xml')
            );
        }    

    public function importBooks() {

        $knjiga = $this->test_var->getBooksFromXML();
        return array (
            '#theme' => 'book_import_theme',
            '#title' => 'Book import title',
            '#knjiga' => $knjiga,
        );
    }
}
 