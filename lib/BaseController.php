<?php

namespace SE;

use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\ORM\EntityManager;
use Knp\Component\Pager\Paginator;
use Silex\Application as SilexApplication;

class BaseController
{
    /**
     * @var SilexApplication
     */
    protected $app = null;
    protected $pageLimit = 20;

    /**
     * @param SilexApplication $app
     */
    public function __construct(SilexApplication $app)
    {
        $this->app = $app;
    }

    /**
     * @param $key
     * @param null $default
     * @return mixed
     */
    protected function getParam($key, $default = null)
    {
        return $this->app['request']->get($key, $default);
    }

    /**
     * @param QueryBuilder $qb
     * @return Paginator
     */
    protected function preparePager(QueryBuilder $qb)
    {
        return $this->app['dezull.dbal_paginator']->paginate(
            $qb,
            (int) $this->getParam('page', 1),
            $this->pageLimit
        );
    }

    /**
     * @param $templateName
     * @param array $data
     * @return mixed
     */
    protected function render($templateName, $data = array())
    {
        if (strpos($templateName, '.twig') === false)
            $templateName .= '.twig';
        // пробрасываем объект request в шаблоны
        if (!isset($data['request']))
            $data['request'] = $this->app['request'];
        if (!isset($data['routeName']))
            $data['routeName'] = $this->app['request']->attributes->get('_route');
        return $this->app['twig']->render($templateName, $data);
    }

    /**
     * @param $routeName
     * @param array $params
     * @return mixed
     */
    protected function path($routeName, $params = array())
    {
        return $this->app['url_generator']->generate($routeName, $params);
    }

    /**
     * @param $routeName
     * @param array $params
     * @return string
     */
    protected function url($routeName, $params = array())
    {
        return $this->app['url_generator']->generate($routeName, $params, true);
    }

    /**
     * @return EntityManager
     */
    protected function getEntityManager()
    {
        return $this->app['orm.em'];
    }

    /**
     * @param $repositoryName
     * @return \Doctrine\ORM\EntityRepository
     */
    protected function getRepository($repositoryName)
    {
        return $this->getEntityManager()->getRepository($repositoryName);
    }
}