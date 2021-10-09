<?php

namespace App\Class;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class MetaDataGetter {

  private Response $response;

  public function __construct(string $urn) {

    $query = <<<GQL
      query {
        dataset(urn: "$urn") {
          urn
          name
          origin
          description
          platformNativeType
          platform {
            info {
              displayName
            }
          }
          uri
          properties {
            customProperties {
              key
              value
            }
          }
          schemaMetadata(version: 0) {
            fields {
              description
              nativeDataType
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
