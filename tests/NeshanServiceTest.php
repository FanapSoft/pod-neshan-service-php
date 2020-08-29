<?php
use PHPUnit\Framework\TestCase;
use Pod\Neshan\Service\NeshanService;
use Pod\Base\Service\BaseInfo;
use Pod\Base\Service\Exception\ValidationException;
use Pod\Base\Service\Exception\PodException;

final class NeshanServiceTest extends TestCase
{
//    public static $apiToken;
    public static $neshanService;
    private $tokenIssuer;
    private $apiToken;
    private $searchScApiKey;
    private $reverseGeoScApiKey;
    private $directionScApiKey;
    private $noTrafficDirectionScApiKey;
    private $distanceMatrixScApiKey;
    private $noTrafficDistanceMatrixScApiKey;
    private $mapMatchingScApiKey;
    public function setUp(): void
    {
        parent::setUp();
        # set serverType to SandBox or Production
        BaseInfo::initServerType(BaseInfo::SANDBOX_SERVER);
        $neshanTestData =  require __DIR__ . '/neshanTestData.php';
        $this->apiToken = $neshanTestData['token'];
        $this->tokenIssuer =  $neshanTestData['tokenIssuer'];
        $this->searchScApiKey = $neshanTestData['searchScApiKey'];
        $this->reverseGeoScApiKey = $neshanTestData['reverseGeoScApiKey'];
        $this->directionScApiKey = $neshanTestData['directionScApiKey'];
        $this->noTrafficDirectionScApiKey = $neshanTestData['noTrafficDirectionScApiKey'];
        $this->distanceMatrixScApiKey = $neshanTestData['distanceMatrixScApiKey'];
        $this->noTrafficDistanceMatrixScApiKey = $neshanTestData['noTrafficDistanceMatrixScApiKey'];
        $this->mapMatchingScApiKey = $neshanTestData['mapMatchingScApiKey'];
        $baseInfo = new BaseInfo();
        $baseInfo->setTokenIssuer($this->apiToken);
        $baseInfo->setToken($this->apiToken);

        self::$neshanService = new NeshanService($baseInfo);
    }

    public function testSearchAllParameters()
    {
        $params =
            [
                ## ======================= *Required Parameters  ==========================
                'scApiKey'             => $this->searchScApiKey,
                'term'                 => 'انقلاب',
                'lat'                  => 25.34,
                'lng'                  => 34.49,
                ## ======================== Optional Parameters  ==========================
                'token'                => $this->apiToken,      # Api_Token | AccessToken
                'tokenIssuer'           => $this->tokenIssuer, # default is 1
//            'scVoucherHash'          => ["1234", "546"],
        ];

        try {
            $result = self::$neshanService->search($params);
            $this->assertFalse($result['hasError']);
            $this->assertEquals($result['result']['statusCode'], 200);
        } catch (ValidationException $e) {
            $this->fail('ValidationException: ' . $e->getErrorsAsString());
        } catch (PodException $e) {
            $error = $e->getResult();
            $this->fail('PodException: ' . $error['message']);
        }
    }

    public function testSearchRequiredParameters()
    {
        $params =
            [
                ## ======================= *Required Parameters  ==========================
                'scApiKey'             => $this->searchScApiKey,
                'term'                 => 'انقلاب',
                'lat'                  => 25.34,
                'lng'                  => 34.49,
            ];
        try {
            $result = self::$neshanService->search($params);
            $this->assertFalse($result['hasError']);
            $this->assertEquals($result['result']['statusCode'], 200);
        } catch (ValidationException $e) {
            $this->fail('ValidationException: ' . $e->getErrorsAsString());
        } catch (PodException $e) {
            $error = $e->getResult();
            $this->fail('PodException: ' . $error['message']);
        }
    }

    public function testSearchValidationError()
    {
        $paramsWithoutRequired = [];
        $paramsWrongValue = [
            'scApiKey'             => 1234,
            'term'                 => 1234,
            'lat'                  => '25.34',
            'lng'                  => '34.49',
        ];
        try {
            self::$neshanService->search($paramsWithoutRequired);
        } catch (ValidationException $e) {

            $validation = $e->getErrorsAsArray();
            $this->assertNotEmpty($validation);

            $result = $e->getResult();

            $this->assertArrayHasKey('scApiKey', $validation);
            $this->assertEquals('The property scApiKey is required', $validation['scApiKey'][0]);

            $this->assertArrayHasKey('term', $validation);
            $this->assertEquals('The property term is required', $validation['term'][0]);

            $this->assertArrayHasKey('lat', $validation);
            $this->assertEquals('The property lat is required', $validation['lat'][0]);

            $this->assertArrayHasKey('lng', $validation);
            $this->assertEquals('The property lng is required', $validation['lng'][0]);

            $this->assertEquals(887, $result['code']);
        } catch (PodException $e) {
            $error = $e->getResult();
            $this->fail('PodException: ' . $error['message']);
        }
        try {
            self::$neshanService->search($paramsWrongValue);
        } catch (ValidationException $e) {

            $validation = $e->getErrorsAsArray();
            $this->assertNotEmpty($validation);

            $result = $e->getResult();


            $this->assertArrayHasKey('scApiKey', $validation);
            $this->assertEquals('Integer value found, but a string is required', $validation['scApiKey'][1]);

            $this->assertArrayHasKey('term', $validation);
            $this->assertEquals('Integer value found, but a string is required', $validation['term'][1]);

            $this->assertArrayHasKey('lat', $validation);
            $this->assertEquals('String value found, but a number is required', $validation['lat'][1]);

            $this->assertArrayHasKey('lng', $validation);
            $this->assertEquals('String value found, but a number is required', $validation['lng'][1]);

            $this->assertEquals(887, $result['code']);
        } catch (PodException $e) {
            $error = $e->getResult();
            $this->fail('PodException: ' . $error['message']);
        }
    }

    public function testReverseGeoAllParameters()
    {
        $params =
            [
                ## ======================= *Required Parameters  ==========================
                'scApiKey'             => $this->reverseGeoScApiKey,
                'lat'                  => 35.698706335171835,
                'lng'                  => 51.39367565588236,
                ## ======================== Optional Parameters  ==========================
                'token'                => $this->apiToken,      # Api_Token | AccessToken
                'tokenIssuer'           => $this->tokenIssuer, # default is 1
//            'scVoucherHash'          => ["1234", "546"],
        ];

        try {
            $result = self::$neshanService->reverseGeo($params);
            $this->assertFalse($result['hasError']);
            $this->assertEquals($result['result']['statusCode'], 200);
        } catch (ValidationException $e) {
            $this->fail('ValidationException: ' . $e->getErrorsAsString());
        } catch (PodException $e) {
            $error = $e->getResult();
            $this->fail('PodException: ' . $error['message']);
        }
    }

    public function testReverseGeoRequiredParameters()
    {
        $params =
            [
                ## ======================= *Required Parameters  ==========================
                'scApiKey'             => $this->reverseGeoScApiKey,
                'lat'                  => 35.698706335171835,
                'lng'                  => 51.39367565588236,
            ];
        try {
            $result = self::$neshanService->reverseGeo($params);
            $this->assertFalse($result['hasError']);
            $this->assertEquals($result['result']['statusCode'], 200);
        } catch (ValidationException $e) {
            $this->fail('ValidationException: ' . $e->getErrorsAsString());
        } catch (PodException $e) {
            $error = $e->getResult();
            $this->fail('PodException: ' . $error['message']);
        }
    }

    public function testReverseGeoValidationError()
    {
        $paramsWithoutRequired = [];
        $paramsWrongValue = [
            'scApiKey'             => 1234,
            'lat'                  => '25.34',
            'lng'                  => '34.49',
        ];
        try {
            self::$neshanService->reverseGeo($paramsWithoutRequired);
        } catch (ValidationException $e) {

            $validation = $e->getErrorsAsArray();
            $this->assertNotEmpty($validation);

            $result = $e->getResult();

            $this->assertArrayHasKey('scApiKey', $validation);
            $this->assertEquals('The property scApiKey is required', $validation['scApiKey'][0]);

            $this->assertArrayHasKey('lat', $validation);
            $this->assertEquals('The property lat is required', $validation['lat'][0]);

            $this->assertArrayHasKey('lng', $validation);
            $this->assertEquals('The property lng is required', $validation['lng'][0]);

            $this->assertEquals(887, $result['code']);
        } catch (PodException $e) {
            $error = $e->getResult();
            $this->fail('PodException: ' . $error['message']);
        }
        try {
            self::$neshanService->reverseGeo($paramsWrongValue);
        } catch (ValidationException $e) {

            $validation = $e->getErrorsAsArray();
            $this->assertNotEmpty($validation);

            $result = $e->getResult();


            $this->assertArrayHasKey('scApiKey', $validation);
            $this->assertEquals('Integer value found, but a string is required', $validation['scApiKey'][1]);

            $this->assertArrayHasKey('lat', $validation);
            $this->assertEquals('String value found, but a number is required', $validation['lat'][1]);

            $this->assertArrayHasKey('lng', $validation);
            $this->assertEquals('String value found, but a number is required', $validation['lng'][1]);

            $this->assertEquals(887, $result['code']);
        } catch (PodException $e) {
            $error = $e->getResult();
            $this->fail('PodException: ' . $error['message']);
        }
    }

    public function testDirectionAllParameters()
    {
        $params =
            [
                ## ======================= *Required Parameters  ==========================
                'scApiKey'             => $this->directionScApiKey,
                'origin'                 =>
                    [
                        'lat' => 36.3141962,
                        'lng' => 59.5412054
                    ],
                'destination'           =>
                    [
                        'lat' => 36.307656,
                        'lng' => 59.530862,
                    ],
                ## ======================= Optional Parameters  ===========================
                'waypoints'=>[
                    [ 'lat'=>36.32203767, 'lng'=>59.4759665 ],
                    [ 'lat'=>36.32203768, 'lng'=>59.4759666 ]
                ],
                'avoidTrafficZone'=>false,
                'avoidOddEvenZone'=>true,
                'alternative'=>true,
                'token'                => $this->apiToken,      # Api_Token | AccessToken
                'tokenIssuer'           => $this->tokenIssuer, # default is 1
//            'scVoucherHash'          => ["1234", "546"],
        ];

        try {
            $result = self::$neshanService->direction($params);
            $this->assertFalse($result['hasError']);
            $this->assertEquals($result['result']['statusCode'], 200);
        } catch (ValidationException $e) {
            $this->fail('ValidationException: ' . $e->getErrorsAsString());
        } catch (PodException $e) {
            $error = $e->getResult();
            $this->fail('PodException: ' . $error['message']);
        }
    }

    public function testDirectionRequiredParameters()
    {
        $params =
            [
                ## ======================= *Required Parameters  ==========================
                'scApiKey'             => $this->directionScApiKey,
                'origin'                 =>
                    [
                        'lat' => 59.6157432,
                        'lng' => 36.2880443
                    ],
                'destination'           =>
                    [
                        'lat' => 36.307656,
                        'lng' => 59.530862,
                    ],
            ];
        try {
            $result = self::$neshanService->direction($params);
            $this->assertFalse($result['hasError']);
            $this->assertEquals($result['result']['statusCode'], 200);
        } catch (ValidationException $e) {
            $this->fail('ValidationException: ' . $e->getErrorsAsString());
        } catch (PodException $e) {
            $error = $e->getResult();
            $this->fail('PodException: ' . 'code: '.$error['code'] . ';;' . $error['message']);
        }
    }

    public function testDirectionValidationError()
    {
        $paramsWithoutRequired = [];
        $paramsWrongValue = [
            'scApiKey'             => 1234,
            'origin'                 =>
                [
                ],
            'destination'           => '',
        ];
        try {
            self::$neshanService->direction($paramsWithoutRequired);
        } catch (ValidationException $e) {

            $validation = $e->getErrorsAsArray();
            $this->assertNotEmpty($validation);

            $result = $e->getResult();

            $this->assertArrayHasKey('scApiKey', $validation);
            $this->assertEquals('The property scApiKey is required', $validation['scApiKey'][0]);

            $this->assertArrayHasKey('origin', $validation);
            $this->assertEquals('The property origin is required', $validation['origin'][0]);

            $this->assertArrayHasKey('destination', $validation);
            $this->assertEquals('The property destination is required', $validation['destination'][0]);

            $this->assertEquals(887, $result['code']);
        } catch (PodException $e) {
            $error = $e->getResult();
            $this->fail('PodException: ' . $error['message']);
        }
        try {
            self::$neshanService->direction($paramsWrongValue);
        } catch (ValidationException $e) {

            $validation = $e->getErrorsAsArray();
            $this->assertNotEmpty($validation);

            $result = $e->getResult();


            $this->assertArrayHasKey('scApiKey', $validation);
            $this->assertEquals('Integer value found, but a string is required', $validation['scApiKey'][1]);

            $this->assertArrayHasKey('origin', $validation);
            $this->assertEquals('There must be a minimum of 1 items in the array', $validation['origin'][1]);

            $this->assertArrayHasKey('destination', $validation);
            $this->assertEquals('String value found, but an array is required', $validation['destination'][1]);

            $this->assertEquals(887, $result['code']);
        } catch (PodException $e) {
            $error = $e->getResult();
            $this->fail('PodException: ' . $error['message']);
        }
    }

    public function testNoTrafficDirectionAllParameters()
    {
        $params =
            [
                ## ======================= *Required Parameters  ==========================
                'scApiKey'             => $this->noTrafficDirectionScApiKey,
                'origin'                 =>
                    [
                        'lat' => 36.3141962,
                        'lng' => 59.5412054
                    ],
                'destination'           =>
                    [
                        'lat' => 36.32203769,
                        'lng' => 59.4759667
                    ],
                ## ======================= Optional Parameters  ===========================
                'waypoints'=> [
                    [ 'lat'=>36.32203767, 'lng'=>59.4759665 ],
                    [ 'lat'=>36.32203768, 'lng'=>59.4759666 ]
                ],
                'avoidTrafficZone'=>false,
                'avoidOddEvenZone'=>true,
                'alternative'=>true,
                'token'                => $this->apiToken,      # Api_Token | AccessToken
                'tokenIssuer'           => $this->tokenIssuer, # default is 1
//            'scVoucherHash'          => ["1234", "546"],
        ];

        try {
            $result = self::$neshanService->noTrafficDirection($params);
            $this->assertFalse($result['hasError']);
            $this->assertEquals($result['result']['statusCode'], 200);
        } catch (ValidationException $e) {
            $this->fail('ValidationException: ' . $e->getErrorsAsString());
        } catch (PodException $e) {
            $error = $e->getResult();
            $this->fail('PodException: ' . $error['message']);
        }
    }

    public function testNoTrafficDirectionRequiredParameters()
    {
        $params =
            [
                ## ======================= *Required Parameters  ==========================
                'scApiKey'             => $this->noTrafficDirectionScApiKey,
                'origin'                 =>
                    [
                        'lat' => 36.3141962,
                        'lng' => 59.5412054
                    ],
                'destination'           =>
                    [
                        'lat' => 36.32203769,
                        'lng' => 59.4759667
                    ],
        ];
        try {
            $result = self::$neshanService->noTrafficDirection($params);
            $this->assertFalse($result['hasError']);
            $this->assertEquals($result['result']['statusCode'], 200);
        } catch (ValidationException $e) {
            $this->fail('ValidationException: ' . $e->getErrorsAsString());
        } catch (PodException $e) {
            $error = $e->getResult();
            $this->fail('PodException: ' . $error['message']);
        }
    }

    public function testNoTrafficDirectionValidationError()
    {
        $paramsWithoutRequired = [];
        $paramsWrongValue = [
            'scApiKey'             => 1234,
            'origin'                 =>
                [
                ],
            'destination'           => '',
        ];
        try {
            self::$neshanService->noTrafficDirection($paramsWithoutRequired);
        } catch (ValidationException $e) {

            $validation = $e->getErrorsAsArray();
            $this->assertNotEmpty($validation);

            $result = $e->getResult();

            $this->assertArrayHasKey('scApiKey', $validation);
            $this->assertEquals('The property scApiKey is required', $validation['scApiKey'][0]);

            $this->assertArrayHasKey('origin', $validation);
            $this->assertEquals('The property origin is required', $validation['origin'][0]);

            $this->assertArrayHasKey('destination', $validation);
            $this->assertEquals('The property destination is required', $validation['destination'][0]);

            $this->assertEquals(887, $result['code']);
        } catch (PodException $e) {
            $error = $e->getResult();
            $this->fail('PodException: ' . $error['message']);
        }
        try {
            self::$neshanService->noTrafficDirection($paramsWrongValue);
        } catch (ValidationException $e) {

            $validation = $e->getErrorsAsArray();
            $this->assertNotEmpty($validation);

            $result = $e->getResult();


            $this->assertArrayHasKey('scApiKey', $validation);
            $this->assertEquals('Integer value found, but a string is required', $validation['scApiKey'][1]);

            $this->assertArrayHasKey('origin', $validation);
            $this->assertEquals('There must be a minimum of 1 items in the array', $validation['origin'][1]);

            $this->assertArrayHasKey('destination', $validation);
            $this->assertEquals('String value found, but an array is required', $validation['destination'][1]);

            $this->assertEquals(887, $result['code']);
        } catch (PodException $e) {
            $error = $e->getResult();
            $this->fail('PodException: ' . $error['message']);
        }
    }

    public function testDistanceMatrixAllParameters()
    {
        $params =
            [
                ## ======================= *Required Parameters  ==========================
                'scApiKey'             => $this->distanceMatrixScApiKey,
                'origins'                =>
                    [[
                        'lat' => 36.3141962,
                        'lng' => 59.5412054
                    ],
                        [
                            'lat' => 36.32203767,
                            'lng' => 59.4759665
                        ]
                    ],
                'destinations'           =>[
                    [
                        'lat' => 36.32203769,
                        'lng' => 59.4759667
                    ],
                    [
                        'lat' => 36.12111,
                        'lng' => 59.324454
                    ]
                ],
                ## ======================== Optional Parameters  ==========================
                'token'                => $this->apiToken,      # Api_Token | AccessToken
                'tokenIssuer'           => $this->tokenIssuer, # default is 1
//            'scVoucherHash'          => ["1234", "546"],
        ];

        try {
            $result = self::$neshanService->distanceMatrix($params);
            $this->assertFalse($result['hasError']);
            $this->assertEquals($result['result']['statusCode'], 200);
        } catch (ValidationException $e) {
            $this->fail('ValidationException: ' . $e->getErrorsAsString());
        } catch (PodException $e) {
            $error = $e->getResult();
            $this->fail('PodException: ' . $error['message']);
        }
    }

    public function testDistanceMatrixRequiredParameters()
    {
        $params =
            [
                ## ======================= *Required Parameters  ==========================
                'scApiKey'             => $this->distanceMatrixScApiKey,
                'origins'                =>
                    [[
                        'lat' => 36.3141962,
                        'lng' => 59.5412054
                    ],
                        [
                            'lat' => 36.32203767,
                            'lng' => 59.4759665
                        ]
                    ],
                'destinations'           =>[
                    [
                        'lat' => 36.32203769,
                        'lng' => 59.4759667
                    ],
                    [
                        'lat' => 36.12111,
                        'lng' => 59.324454
                    ]
                ],
            ];
        try {
            $result = self::$neshanService->distanceMatrix($params);
            $this->assertFalse($result['hasError']);
            $this->assertEquals($result['result']['statusCode'], 200);
        } catch (ValidationException $e) {
            $this->fail('ValidationException: ' . $e->getErrorsAsString());
        } catch (PodException $e) {
            $error = $e->getResult();
            $this->fail('PodException: ' . $error['message']);
        }
    }

    public function testDistanceMatrixValidationError()
    {
        $paramsWithoutRequired = [];
        $paramsWrongValue = [
            'scApiKey' => 1234,
            'origins'  => [],
            'destinations' => [],
        ];
        try {
            self::$neshanService->distanceMatrix($paramsWithoutRequired);
        } catch (ValidationException $e) {

            $validation = $e->getErrorsAsArray();
            $this->assertNotEmpty($validation);

            $result = $e->getResult();

            $this->assertArrayHasKey('scApiKey', $validation);
            $this->assertEquals('The property scApiKey is required', $validation['scApiKey'][0]);

            $this->assertArrayHasKey('origins', $validation);
            $this->assertEquals('The property origins is required', $validation['origins'][0]);

            $this->assertArrayHasKey('destinations', $validation);
            $this->assertEquals('The property destinations is required', $validation['destinations'][0]);

            $this->assertEquals(887, $result['code']);
        } catch (PodException $e) {
            $error = $e->getResult();
            $this->fail('PodException: ' . $error['message']);
        }
        try {
            self::$neshanService->distanceMatrix($paramsWrongValue);
        } catch (ValidationException $e) {

            $validation = $e->getErrorsAsArray();
            $this->assertNotEmpty($validation);

            $result = $e->getResult();


            $this->assertArrayHasKey('scApiKey', $validation);
            $this->assertEquals('Integer value found, but a string is required', $validation['scApiKey'][1]);

            $this->assertArrayHasKey('origins', $validation);
            $this->assertEquals('There must be a minimum of 1 items in the array', $validation['origins'][1]);

            $this->assertArrayHasKey('destinations', $validation);
            $this->assertEquals('There must be a minimum of 1 items in the array', $validation['destinations'][1]);
            $this->assertEquals(887, $result['code']);
        } catch (PodException $e) {
            $error = $e->getResult();
            $this->fail('PodException: ' . $error['message']);
        }
    }

    public function testNoTrafficDistanceMatrixAllParameters()
    {
        $params =
            [
                ## ======================= *Required Parameters  ==========================
                'scApiKey'             => $this->noTrafficDistanceMatrixScApiKey,
                'origins'                =>
                    [[
                        'lat' => 36.3141962,
                        'lng' => 59.5412054
                    ],
                        [
                            'lat' => 36.32203767,
                            'lng' => 59.4759665
                        ]
                    ],
                'destinations'           =>[
                    [
                        'lat' => 36.32203769,
                        'lng' => 59.4759667
                    ],
                    [
                        'lat' => 36.12111,
                        'lng' => 59.324454
                    ]
                ],
                ## ======================== Optional Parameters  ==========================
                'token'                => $this->apiToken,      # Api_Token | AccessToken
                'tokenIssuer'           => $this->tokenIssuer, # default is 1
//            'scVoucherHash'          => ["1234", "546"],
        ];

        try {
            $result = self::$neshanService->noTrafficDistanceMatrix($params);
            $this->assertFalse($result['hasError']);
            $this->assertEquals($result['result']['statusCode'], 200);
        } catch (ValidationException $e) {
            $this->fail('ValidationException: ' . $e->getErrorsAsString());
        } catch (PodException $e) {
            $error = $e->getResult();
            $this->fail('PodException: ' . $error['message']);
        }
    }

    public function testNoTrafficDistanceMatrixRequiredParameters()
    {
        $params =
            [
                ## ======================= *Required Parameters  ==========================
                'scApiKey'             => $this->noTrafficDistanceMatrixScApiKey,
                'origins'                =>
                    [[
                        'lat' => 36.3141962,
                        'lng' => 59.5412054
                    ],
                        [
                            'lat' => 36.32203767,
                            'lng' => 59.4759665
                        ]
                    ],
                'destinations'           =>[
                    [
                        'lat' => 36.32203769,
                        'lng' => 59.4759667
                    ],
                    [
                        'lat' => 36.12111,
                        'lng' => 59.324454
                    ]
                ],
            ];
        try {
            $result = self::$neshanService->noTrafficDistanceMatrix($params);
            $this->assertFalse($result['hasError']);
            $this->assertEquals($result['result']['statusCode'], 200);
        } catch (ValidationException $e) {
            $this->fail('ValidationException: ' . $e->getErrorsAsString());
        } catch (PodException $e) {
            $error = $e->getResult();
            $this->fail('PodException: ' . $error['message']);
        }
    }

    public function testNoTrafficDistanceMatrixValidationError()
    {
        $paramsWithoutRequired = [];
        $paramsWrongValue = [
            'scApiKey' => 1234,
            'origins'  => [],
            'destinations' => [],
        ];
        try {
            self::$neshanService->noTrafficDistanceMatrix($paramsWithoutRequired);
        } catch (ValidationException $e) {

            $validation = $e->getErrorsAsArray();
            $this->assertNotEmpty($validation);

            $result = $e->getResult();

            $this->assertArrayHasKey('scApiKey', $validation);
            $this->assertEquals('The property scApiKey is required', $validation['scApiKey'][0]);

            $this->assertArrayHasKey('origins', $validation);
            $this->assertEquals('The property origins is required', $validation['origins'][0]);

            $this->assertArrayHasKey('destinations', $validation);
            $this->assertEquals('The property destinations is required', $validation['destinations'][0]);

            $this->assertEquals(887, $result['code']);
        } catch (PodException $e) {
            $error = $e->getResult();
            $this->fail('PodException: ' . $error['message']);
        }
        try {
            self::$neshanService->noTrafficDistanceMatrix($paramsWrongValue);
        } catch (ValidationException $e) {

            $validation = $e->getErrorsAsArray();
            $this->assertNotEmpty($validation);

            $result = $e->getResult();

            $this->assertArrayHasKey('scApiKey', $validation);
            $this->assertEquals('Integer value found, but a string is required', $validation['scApiKey'][1]);

            $this->assertArrayHasKey('origins', $validation);
            $this->assertEquals('There must be a minimum of 1 items in the array', $validation['origins'][1]);

            $this->assertArrayHasKey('destinations', $validation);
            $this->assertEquals('There must be a minimum of 1 items in the array', $validation['destinations'][1]);

            $this->assertEquals(887, $result['code']);
        } catch (PodException $e) {
            $error = $e->getResult();
            $this->fail('PodException: ' . $error['message']);
        }
    }

    public function testMapMatchingAllParameters()
    {
        $params =
            [
                ## ======================= *Required Parameters  ==========================
                'scApiKey'             => $this->mapMatchingScApiKey,
                'path'  => [
                    [
                        'lat'=> 36.297886,
                        'lng'=> 59.604335
                    ],
                    [
                        'lat'=> 36.297218,
                        'lng' =>  59.603496
                    ]
                ],
                ## ======================== Optional Parameters  ==========================
                'token'                => $this->apiToken,      # Api_Token | AccessToken
                'tokenIssuer'           => $this->tokenIssuer, # default is 1
//            'scVoucherHash'          => ["1234", "546"],
        ];

        try {
            $result = self::$neshanService->mapMatching($params);
            $this->assertFalse($result['hasError']);
            $this->assertEquals($result['result']['statusCode'], 200);
        } catch (ValidationException $e) {
            $this->fail('ValidationException: ' . $e->getErrorsAsString());
        } catch (PodException $e) {
            $error = $e->getResult();
            $this->fail('PodException: ' . $error['message']);
        }
    }

    public function testMapMatchingRequiredParameters()
    {
        $params =
            [
                ## ======================= *Required Parameters  ==========================
                'scApiKey'             => $this->mapMatchingScApiKey,
                'path'  => [
                    [
                        'lat'=> 36.297886,
                        'lng'=> 59.604335
                    ],
                    [
                        'lat'=> 36.297218,
                        'lng' =>  59.603496
                    ]
                ],
            ];
        try {
            $result = self::$neshanService->mapMatching($params);
            $this->assertFalse($result['hasError']);
            $this->assertEquals($result['result']['statusCode'], 200);
        } catch (ValidationException $e) {
            $this->fail('ValidationException: ' . $e->getErrorsAsString());
        } catch (PodException $e) {
            $error = $e->getResult();
            $this->fail('PodException: ' . $error['message']);
        }
    }

    public function testMapMatchingValidationError()
    {
        $paramsWithoutRequired = [];
        $paramsWrongValue = [
            'scApiKey'             => 1234,
            'path'  => [
            ],
        ];
        try {
            self::$neshanService->mapMatching($paramsWithoutRequired);
        } catch (ValidationException $e) {

            $validation = $e->getErrorsAsArray();
            $this->assertNotEmpty($validation);

            $result = $e->getResult();

            $this->assertArrayHasKey('scApiKey', $validation);
            $this->assertEquals('The property scApiKey is required', $validation['scApiKey'][0]);

            $this->assertArrayHasKey('path', $validation);
            $this->assertEquals('The property path is required', $validation['path'][0]);

            $this->assertEquals(887, $result['code']);
        } catch (PodException $e) {
            $error = $e->getResult();
            $this->fail('PodException: ' . $error['message']);
        }
        try {
            self::$neshanService->mapMatching($paramsWrongValue);
        } catch (ValidationException $e) {

            $validation = $e->getErrorsAsArray();
            $this->assertNotEmpty($validation);

            $result = $e->getResult();


            $this->assertArrayHasKey('scApiKey', $validation);
            $this->assertEquals('Integer value found, but a string is required', $validation['scApiKey'][1]);

            $this->assertArrayHasKey('path', $validation);
            $this->assertEquals('There must be a minimum of 2 items in the array', $validation['path'][1]);

            $this->assertEquals(887, $result['code']);
        } catch (PodException $e) {
            $error = $e->getResult();
            $this->fail('PodException: ' . $error['message']);
        }
    }
}