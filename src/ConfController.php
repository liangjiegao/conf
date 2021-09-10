<?php


namespace Yiyu\Conf;



use Superl\Permission\Controller;
use Superl\Permission\UtilsClass;
use Illuminate\Http\Request;


class ConfController extends Controller
{

    public function __construct(){

    }

    public function addOne(Request $request, ConfService $service){

        $params[] = ['input' => 'key',      'type' => 'string', 'empty' => true, 'length' => 32];
        $params[] = ['input' => 'content',  'type' => 'array',  'empty' => true];
        $params[] = ['input' => 'type',     'type' => 'string', 'length' => 1];

        $params[] = ['input' => 'comp_id',  'type' => 'string'];
        $params[] = ['input' => 'uid',      'type' => 'string'];
        $requestParams = $this->paramsFilter($params, $request, $service);
        if ($requestParams['code'] != CodeConf::SUCCESS){
            return UtilsClass::getCallbackJson($requestParams['code']);
        }

        $result = $requestParams['result'];

        $return = $service->addOne($result);
        $code = $service->getCode();

        return UtilsClass::getCallbackJson($code, ['data' => $return]);
    }

    public function getOne(Request $request, ConfService $service){

        $params[] = ['input' => 'key',      'type' => 'string'];

        $requestParams = $this->paramsFilter($params, $request, $service);
        if ($requestParams['code'] != CodeConf::SUCCESS){
            return UtilsClass::getCallbackJson($requestParams['code']);
        }

        $result = $requestParams['result'];

        $info = $service->getOne($result['key']);
        $code = $service->getCode();

        return UtilsClass::getCallbackJson($code, ['data' => $info]);
    }

    public function getList(Request $request, ConfService $service){

        $params[] = ['input' => 'keyword',  'type' => 'string', 'empty' => true];
        $params[] = ['input' => 'unit',     'type' => 'string', 'empty' => true];
        $params[] = ['input' => 'type',     'type' => 'string'];
        $params[] = ['input' => 'comp_id',  'type' => 'string'];
        $params[] = ['input' => 'uid',      'type' => 'string'];
        $requestParams = $this->paramsFilter($params, $request, $service);
        if ($requestParams['code'] != CodeConf::SUCCESS){
            return UtilsClass::getCallbackJson($requestParams['code']);
        }

        $result = $requestParams['result'];

        $list = $service->getList($result);
        $code = $service->getCode();

        return UtilsClass::getCallbackJson($code, ['data' => ['list' => $list]]);
    }

    public function delOne(Request $request, ConfService $service){

        $params[] = ['input' => 'key',      'type' => 'string'];
        $params[] = ['input' => 'comp_id',  'type' => 'string'];
        $params[] = ['input' => 'uid',      'type' => 'string'];
        $requestParams = $this->paramsFilter($params, $request, $service);
        if ($requestParams['code'] != CodeConf::SUCCESS){
            return UtilsClass::getCallbackJson($requestParams['code']);
        }

        $result = $requestParams['result'];

        $service->delOne($result['key']);
        $code = $service->getCode();

        return UtilsClass::getCallbackJson($code);
    }

}
