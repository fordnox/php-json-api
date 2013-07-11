<?php
namespace Fordnox;

class JsonApiServer
{
    protected $_handlers = array();

    public function register($method, \Closure $closure)
    {
        $this->_handlers[$method] = $closure;
    }

    public function handle($return = false)
    {
        try {
            $json_data = json_decode( file_get_contents('php://input'), true );
            if (!is_array($json_data)) {
                throw new Exception('POST body must be valid JSON', 101);
            }
            $result = $this->_run($json_data);
            $r = $this->_response($result);
        } catch(\Exception $e) {
            $r = $this->_response($e);
        }
        if($return) {
            return $r;
        }
        header('Content-Type: application/json');
        print json_encode($r);
    }

    private function _response($result)
    {
        $error = null;
        if ($result instanceof Exception) {
            $code = $result->getCode() ? (int)$result->getCode() : 901;
            $error = array('message'=>$result->getMessage(), 'code'=>$code);
            $result = null;
        }
        return array('result'=>$result, 'error'=>$error);
    }

    private function _run(array $params)
    {
        if(!isset($params['method'])) {
            throw new Exception('method not passed', 301);
        }

        if(!array_key_exists($params['method'], $this->_handlers)) {
            throw new Exception('method not registered', 302);
        }

        $payload = isset($params['params']) ? $params['params'] : null;
        return $this->_handlers[$params['method']]($payload);
    }

}