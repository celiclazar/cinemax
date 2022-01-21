<?php
    namespace Drupal\Core\Entity;
    namespace Drupal\Core\Ajax;
    namespace Drupal\movie_reservation\Controller;

    use Drupal\Core\Ajax\AjaxResponse;
    use Symfony\Component\HttpFoundation\Request;
    use Drupal\Core\Ajax\HtmlCommand;
    use Drupal\Core\Controller\ControllerBase;

    class MovieReservationController extends ControllerBase  {

      public function exportMovies() {

        $movie_genre = \Drupal::entityTypeManager()
          ->getStorage('taxonomy_term')
          ->loadTree('movie_genre');
        $movieGenreID = \Drupal::request()->query->get('genreID');
        $movie_query = \Drupal::entityQuery('node')
          ->condition('type','movie');
        if  (isset($movieGenreID) && $movieGenreID != 0){
          $movie_query->condition('field_movie_genre', $movieGenreID);
        }

        $movies = \Drupal\node\Entity\Node::loadMultiple($movie_query->execute());
        $customer_name = \Drupal::request()->request->get('customerName');
        $day = \Drupal::request()->request->get('day');
    
        if (isset($customer_name)){
        $database = \Drupal::service('database');
        $results = $database->insert('reservations')
          ->fields([
            'day_of_reservation' => $day,
            'customer_name' => $customer_name,
          ])
          ->execute();
        }

        return array(
          '#list_of_genres' => $movie_genre,
          '#theme' => 'movie_reservation_theme',
          '#movies' => $movies,
          '#title' => 'Reservation movies'
          );
        }
}
  