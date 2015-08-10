<?php
$app = SE\Application::getInstance();
$routes = array(
    array(
        'name' => 'listTeachers',
        'method' => 'get',
        'path' => '/',
        'controller' => 'teacher.ctr:listAction'
    ),
    array(
        'name' => 'specialListTeachers',
        'method' => 'get',
        'path' => '/teacher/special',
        'controller' => 'teacher.ctr:specialListAction'
    ),
    array(
        'name' => 'createTeacher',
        'method' => 'get',
        'path' => '/teacher',
        'controller' => 'teacher.ctr:createAction'
    ),
    array(
        'name' => 'createTeacherDone',
        'method' => 'post',
        'path' => '/teacher',
        'controller' => 'teacher.ctr:createAction'
    ),
    array(
        'name' => 'assignStudentDone',
        'method' => 'post',
        'path' => '/teacher/assign',
        'controller' => 'teacher.ctr:assignAction'
    ),
    array(
        'name' => 'createStudent',
        'method' => 'get',
        'path' => '/student',
        'controller' => 'student.ctr:createAction'
    ),
    array(
        'name' => 'createStudentDone',
        'method' => 'post',
        'path' => '/student',
        'controller' => 'student.ctr:createAction'
    ),
    array(
        'name' => 'mostIntersects',
        'method' => 'get',
        'path' => '/teacher/intersects',
        'controller' => 'teacher.ctr:mostIntersectsAction'
    ),
);
foreach($routes as $route){
    $method = $route['method'] ? $route['method'] : 'get';
    $app->$method($route['path'], $route['controller'])->bind($route['name']);
}