<?php


namespace app\controllers;


class IndexController extends BaseController
{
    public function getAction()
    {
        return [
            'input' => $this->request->getQuery('input')
        ];
    }

    public function postAction()
    {
        return [
            'input' => $this->request->getJsonRawBody(true)
        ];
    }

    public function putAction()
    {
        return [
            'input' => $this->request->getJsonRawBody(true)
        ];
    }

    public function deleteAction()
    {
        return [
            'input' => $this->request->getQuery('input')
        ];
    }
}