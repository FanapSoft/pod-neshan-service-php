<?php
/**
 * Created by PhpStorm.
 * User :  keshtgar
 * Date :  6/19/19
 * Time : 12:29 PM
 *
 * $baseInfo BaseInfo
 */

namespace Pod\Neshan\Service;

use Pod\Base\Service\BaseService;
use Pod\Base\Service\BaseInfo;

class NeshanService extends BaseService
{
    private $header;
    private static $neshanApi;
    private static $jsonSchema;
    private static $serviceProductId;

    public function __construct($baseInfo)
    {
        BaseInfo::initServerType(BaseInfo::PRODUCTION_SERVER);
        parent::__construct();
        $this->header = [
            '_token_issuer_'    =>  $baseInfo->getTokenIssuer(),
            '_token_'           => $baseInfo->getToken()
        ];
        self::$jsonSchema = json_decode(file_get_contents(__DIR__ . '/../config/validationSchema.json'), true);
        self::$neshanApi = require __DIR__ . '/../config/apiConfig.php';
        self::$serviceProductId = require __DIR__ . '/../config/serviceProductId.php';
    }

    public function search($params) {
        $apiName = 'search';
        $header = $this->header;
        $optionHasArray = false;
        array_walk_recursive($params, 'self::prepareData');

        $paramKey = self::$neshanApi[$apiName]['method'] == 'GET' ? 'query' : 'form_params';

        // set tokenIssuer in header
        if (isset($params['tokenIssuer'])) {
            $header['_token_issuer_'] = $params['tokenIssuer'];
            unset($params['tokenIssuer']);
        }

        // set token in header
        if (isset($params['token'])) {
            $header['_token_'] = $params['token'];
            unset($params['token']);
        }

        $option = [
            'headers' => $header,
            $paramKey => $params,
        ];

        self::validateOption($option, self::$jsonSchema[$apiName], $paramKey);

        // prepare params to send
        $option[$paramKey]['scProductId'] = self::$serviceProductId[$apiName];
        if (isset($params['scVoucherHash'])) {
            $option['withoutBracketParams'] =  $option[$paramKey];
            $optionHasArray = true;
            unset($option[$paramKey]);
        }

        return  NeshanApiRequestHandler::Request(
            self::$config[self::$serverType][self::$neshanApi[$apiName]['baseUri']],
            self::$neshanApi[$apiName]['method'],
            self::$neshanApi[$apiName]['subUri'],
            $option,
            false,
            $optionHasArray
        );
    }

    public function reverseGeo($params) {
        $apiName = 'reverseGeo';
        $header = $this->header;
        $optionHasArray = false;

        array_walk_recursive($params, 'self::prepareData');
        $paramKey = self::$neshanApi[$apiName]['method'] == 'GET' ? 'query' : 'form_params';
        // set tokenIssuer in header
        if (isset($params['tokenIssuer'])) {
            $header['_token_issuer_'] = $params['tokenIssuer'];
            unset($params['tokenIssuer']);
        }

        // set token in header
        if (isset($params['token'])) {
            $header['_token_'] = $params['token'];
            unset($params['token']);
        }

        $option = [
            'headers' => $header,
            $paramKey => $params,
        ];

        self::validateOption($option, self::$jsonSchema[$apiName], $paramKey);

        // prepare params to send
        $option[$paramKey]['scProductId'] = self::$serviceProductId[$apiName];
        if (isset($params['scVoucherHash'])) {
            $option['withoutBracketParams'] =  $option[$paramKey];
            $optionHasArray = true;
            unset($option[$paramKey]);
        }

        return  NeshanApiRequestHandler::Request(
            self::$config[self::$serverType][self::$neshanApi[$apiName]['baseUri']],
            self::$neshanApi[$apiName]['method'],
            self::$neshanApi[$apiName]['subUri'],
            $option,
            false,
            $optionHasArray
        );
    }

    public function direction($params) {
        $apiName = 'direction';
        $header = $this->header;
        $optionHasArray = false;
        array_walk_recursive($params, 'self::prepareData');
        $paramKey = self::$neshanApi[$apiName]['method'] == 'GET' ? 'query' : 'form_params';
        // set tokenIssuer in header
        if (isset($params['tokenIssuer'])) {
            $header['_token_issuer_'] = $params['tokenIssuer'];
            unset($params['tokenIssuer']);
        }

        // set token in header
        if (isset($params['token'])) {
            $header['_token_'] = $params['token'];
            unset($params['token']);
        }

        $option = [
            'headers' => $header,
            $paramKey => $params,
        ];

        self::validateOption($option, self::$jsonSchema[$apiName], $paramKey);

        // prepare params to send
        $option[$paramKey]['scProductId'] = self::$serviceProductId[$apiName];
        $option[$paramKey]['origin'] = implode(',', $params['origin']);
        $option[$paramKey]['destination'] = implode(',', $params['destination']);
        if(isset($params['waypoints'])) {
            $option[$paramKey]['waypoints'] = '';
            foreach ($params['waypoints'] as $wayPoint){
                $option[$paramKey]['waypoints'] .= implode(',', $wayPoint) . '|';
            }
            if (!empty($option[$paramKey]['waypoints'])) {
                $option[$paramKey]['waypoints'] = substr($option[$paramKey]['waypoints'], 0, -1);
            }
        }


        if (isset($params['scVoucherHash'])) {
            $option['withoutBracketParams'] =  $option[$paramKey];
            $optionHasArray = true;
            unset($option[$paramKey]);
        }

        return  NeshanApiRequestHandler::Request(
            self::$config[self::$serverType][self::$neshanApi[$apiName]['baseUri']],
            self::$neshanApi[$apiName]['method'],
            self::$neshanApi[$apiName]['subUri'],
            $option,
            false,
            $optionHasArray
        );
    }

    public function noTrafficDirection($params) {
        $apiName = 'noTrafficDirection';
        $header = $this->header;
        $optionHasArray = false;
        array_walk_recursive($params, 'self::prepareData');
        $paramKey = self::$neshanApi[$apiName]['method'] == 'GET' ? 'query' : 'form_params';

        // set tokenIssuer in header
        if (isset($params['tokenIssuer'])) {
            $header['_token_issuer_'] = $params['tokenIssuer'];
            unset($params['tokenIssuer']);
        }

        // set token in header
        if (isset($params['token'])) {
            $header['_token_'] = $params['token'];
            unset($params['token']);
        }

        $option = [
            'headers' => $header,
            $paramKey => $params,
        ];

        self::validateOption($option, self::$jsonSchema[$apiName], $paramKey);

        // prepare params to send
        $option[$paramKey]['scProductId'] = self::$serviceProductId[$apiName];
        $option[$paramKey]['origin'] = implode(',', $params['origin']);
        $option[$paramKey]['destination'] = implode(',', $params['destination']);
        if(isset($params['waypoints'])) {
            $option[$paramKey]['waypoints'] = '';
            foreach ($params['waypoints'] as $wayPoint){
                $option[$paramKey]['waypoints'] .= implode(',', $wayPoint) . '|';
            }
            $option[$paramKey]['waypoints'] = substr($option[$paramKey]['waypoints'], 0, -1);
        }

        if (isset($params['scVoucherHash'])) {
            $option['withoutBracketParams'] =  $option[$paramKey];
            $optionHasArray = true;
            unset($option[$paramKey]);
        }

        return  NeshanApiRequestHandler::Request(
            self::$config[self::$serverType][self::$neshanApi[$apiName]['baseUri']],
            self::$neshanApi[$apiName]['method'],
            self::$neshanApi[$apiName]['subUri'],
            $option,
            false,
            $optionHasArray
        );

    }

    public function distanceMatrix($params) {
        $apiName = 'distanceMatrix';
        $header = $this->header;
        $optionHasArray = false;
        array_walk_recursive($params, 'self::prepareData');
        $paramKey = self::$neshanApi[$apiName]['method'] == 'GET' ? 'query' : 'form_params';

        // set tokenIssuer in header
        if (isset($params['tokenIssuer'])) {
            $header['_token_issuer_'] = $params['tokenIssuer'];
            unset($params['tokenIssuer']);
        }

        // set token in header
        if (isset($params['token'])) {
            $header['_token_'] = $params['token'];
            unset($params['token']);
        }

        $option = [
            'headers' => $header,
            $paramKey => $params,
        ];

        self::validateOption($option, self::$jsonSchema[$apiName], $paramKey);
        // prepare params to send
        $option[$paramKey]['scProductId'] = self::$serviceProductId[$apiName];
        $option[$paramKey]['origins'] = '';
        foreach ($params['origins'] as $origin){
            $option[$paramKey]['origins'] .= implode(',', $origin) . '|';
        }
        if (!empty($option[$paramKey]['origins'])) {
            $option[$paramKey]['origins'] = substr($option[$paramKey]['origins'], 0, -1);
        }

        $option[$paramKey]['destinations'] = '';
        foreach ($params['destinations'] as $destinations){
            $option[$paramKey]['destinations'] .= implode(',', $destinations) . '|';
        }
        if (!empty($option[$paramKey]['destinations'])) {
            $option[$paramKey]['destinations'] = substr($option[$paramKey]['destinations'], 0, -1);
        }

        if (isset($params['scVoucherHash'])) {
            $option['withoutBracketParams'] =  $option[$paramKey];
            $optionHasArray = true;
            unset($option[$paramKey]);
        }

        return  NeshanApiRequestHandler::Request(
            self::$config[self::$serverType][self::$neshanApi[$apiName]['baseUri']],
            self::$neshanApi[$apiName]['method'],
            self::$neshanApi[$apiName]['subUri'],
            $option,
            false,
            $optionHasArray
        );
    }

    public function noTrafficDistanceMatrix($params) {
        $apiName = 'noTrafficDistanceMatrix';
        $header = $this->header;
        $optionHasArray = false;
        array_walk_recursive($params, 'self::prepareData');
        $paramKey = self::$neshanApi[$apiName]['method'] == 'GET' ? 'query' : 'form_params';

        // set tokenIssuer in header
        if (isset($params['tokenIssuer'])) {
            $header['_token_issuer_'] = $params['tokenIssuer'];
            unset($params['tokenIssuer']);
        }

        // set token in header
        if (isset($params['token'])) {
            $header['_token_'] = $params['token'];
            unset($params['token']);
        }

        $option = [
            'headers' => $header,
            $paramKey => $params,
        ];

        self::validateOption($option, self::$jsonSchema[$apiName], $paramKey);

        // prepare params to send
        # set productId
        $option[$paramKey]['scProductId'] = self::$serviceProductId[$apiName];
        # prepare origins
        $option[$paramKey]['origins'] = '';
        foreach ($params['origins'] as $origin){
            $option[$paramKey]['origins'] .= implode(',', $origin) . '|';
        }
        if (!empty($option[$paramKey]['origins'])) {
            $option[$paramKey]['origins'] = substr($option[$paramKey]['origins'], 0, -1);
        }
        # prepare destinations
        $option[$paramKey]['destinations'] = '';
        foreach ($params['destinations'] as $destinations){
            $option[$paramKey]['destinations'] .= implode(',', $destinations) . '|';
        }
        if (!empty($option[$paramKey]['destinations'])) {
            $option[$paramKey]['destinations'] = substr($option[$paramKey]['destinations'], 0, -1);
        }

        if (isset($params['scVoucherHash'])) {
            $option['withoutBracketParams'] =  $option[$paramKey];
            $optionHasArray = true;
            unset($option[$paramKey]);
        }

        return  NeshanApiRequestHandler::Request(
            self::$config[self::$serverType][self::$neshanApi[$apiName]['baseUri']],
            self::$neshanApi[$apiName]['method'],
            self::$neshanApi[$apiName]['subUri'],
            $option,
            false,
            $optionHasArray
        );
    }

    public function mapMatching($params) {
        $apiName = 'mapMatching';
        $header = $this->header;
        $optionHasArray = false;
        array_walk_recursive($params, 'self::prepareData');
        $paramKey = self::$neshanApi[$apiName]['method'] == 'GET' ? 'query' : 'form_params';

        // set tokenIssuer in header
        if (isset($params['tokenIssuer'])) {
            $header['_token_issuer_'] = $params['tokenIssuer'];
            unset($params['tokenIssuer']);
        }

        // set token in header
        if (isset($params['token'])) {
            $header['_token_'] = $params['token'];
            unset($params['token']);
        }

        $option = [
            'headers' => $header,
            $paramKey => $params,
        ];

        self::validateOption($option, self::$jsonSchema[$apiName], $paramKey);
        // prepare params to send
        # set productId
        $option[$paramKey]['scProductId'] = self::$serviceProductId[$apiName];
        # prepare path points
        $option[$paramKey]['path'] = '';
        foreach ($params['path'] as $point){
            $option[$paramKey]['path'] .= implode(',', $point) . '|';
        }
        if (!empty($option[$paramKey]['path'])) {
            $option[$paramKey]['path'] = substr($option[$paramKey]['path'], 0, -1);
        }

        if (isset($params['scVoucherHash'])) {
            $option['withoutBracketParams'] =  $option[$paramKey];
            $optionHasArray = true;
            unset($option[$paramKey]);
        }

        return  NeshanApiRequestHandler::Request(
            self::$config[self::$serverType][self::$neshanApi[$apiName]['baseUri']],
            self::$neshanApi[$apiName]['method'],
            self::$neshanApi[$apiName]['subUri'],
            $option,
            false,
            $optionHasArray
        );
    }
}