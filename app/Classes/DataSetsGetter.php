<?php

namespace App\Classes;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class DataSetsGetter {

  private Response $response;

  public function __construct() {

    $query = <<<GQL
          {
      search(input: {type: DATASET, query: "fct_users_created", start: 0, count: 10}) {
        start
        count
        total
        searchResults {
          entity {
            urn
            type
            ... on Dataset {
              name
            }
          }
        }
      }
    }
    GQL;

    $this->response = Http::withHeaders([
      'Cookie' => 'bid=26cff670-f4fe-4ff4-9929-e40c54c55e8e; PLAY_SESSION=669be67ce71855799441548a73a0d8a4293d0b89-actor=urn%3Ali%3Acorpuser%3Adatahub; actor=urn:li:corpuser:datahub',
    ])
      ->post('http://datahub.yc.pbd.ai:9002/api/v2/graphql', [
        'query' => $query
      ]);
  }


  public function data() {
    return $this->response->json();
  }
}
