<?php

require 'env.php';

use \Slim\Http\Request as Request;
use \Slim\Http\Response as Response;

require 'vendor/autoload.php';

// include the frame work
require(__DIR__ . '/vendor/cclark61/phpopenfw2/framework/phplitefw.inc.php');

// Start the liteFW controller and load the form engine and the database engine
$pco = new phplitefw_controller();
$pco->load_db_engine();
$pco->load_db_config(__DIR__ . "/db.php", true);
$pco->default_data_source('main');

$pco->load_plugin('content_gen');

$pco->set_plugin_folder(dirname(__FILE__) . '/classes');
spl_autoload_register('load_plugin');


$GLOBALS['data1'] = $data1 = new data_trans('main');
$data1->set_opt('make_bind_params_refs', 1);
$data1->set_opt('charset', 'utf8');

$app = new \Slim\App();

$app->options('/{routes:.+}', function ($request, $response, $args) {
    return $response;
});
$app->add(function ($req, $res, $next) {
    $response = $next($req, $res);

    return $response
        ->withHeader('Access-Control-Allow-Origin', '*')
        ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
        ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
});

/**
 * Winning Numbers Enpoint
 */
$app->group('/winningNumbers', function () {
    $this->map(['GET', 'DELETE', 'PATCH', 'PUT', 'POST'], '', function ($request, $response, $args) {
        // Find, delete, patch or replace user identified by $args['id']
    })->setName('winningNumbers');



    /**
     * @apiVersion 1.0.0
     * @api {get} /winningNumbers/powerballAll powerballAll
     * @apiDescription This will get All the powerball winings since 2010
     *
     * @apiName powerballAll
     *
     * @apiGroup winningNumbers
     *
     * @apiSuccess {String} status Status of the request. ok or fail
     * @apiSuccess {String} message Generic message about the response
     * @apiSuccess {String[]} data More information about the response

     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
    {
        "status":"ok",
        "message":"Returned",
        "data":[
            {
                "powerball_id":"1",
                "draw_num1":"7",
                "draw_num2":"9",
                "draw_num3":"14",
                "draw_num4":"45",
                "draw_num5":"49",
                "draw_num6":"23",
                "multiplier":"4",
                "draw_date":"2010-03-03 22:59:00",
                "insert_date":"2017-04-06 17:44:33"
            }
        ]
    }
     */
    $this->get('/powerballAll', function (Request $request, Response $response) {

        $winningNumbers = new WinningNumbers();
        $response = $response->withJson($winningNumbers->powerballAll());

        return $response;
    })->setName('winningNumbers-powerballAll');



    /**
     * @apiVersion 1.0.0
     * @api {get} /winningNumbers/powerballCurrent powerballCurrent
     * @apiDescription This will get the latest powerball drawing numbers
     *
     * @apiName powerballCurrent
     *
     * @apiGroup winningNumbers
     *
     * @apiSuccess {String} status Status of the request. ok or fail
     * @apiSuccess {String} message Generic message about the response
     * @apiSuccess {String[]} data More information about the response

     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
    {
        "status":"ok",
        "message":"Returned",
        "data":{
            "powerball_id":"739",
            "draw_num1":"8",
            "draw_num2":"15",
            "draw_num3":"31",
            "draw_num4":"36",
            "draw_num5":"62",
            "draw_num6":"11",
            "multiplier":"3",
            "draw_date":"2017-03-29 00:00:00",
            "insert_date":"2017-04-06 17:47:33"
        }
    }
     */
    $this->get('/powerballCurrent', function (Request $request, Response $response) {

        $winningNumbers = new WinningNumbers();
        $response = $response->withJson($winningNumbers->powerballCurrent());

        return $response;
    })->setName('winningNumbers-powerballCurrent');

});

/**
 * Powerball Enpoint
 */
$app->group('/powerball', function () {
    $this->map(['GET', 'DELETE', 'PATCH', 'PUT', 'POST'], '', function ($request, $response, $args) {
        // Find, delete, patch or replace user identified by $args['id']
    })->setName('powerball');



    /**
     * @apiVersion 1.0.0
     * @api {get} /powerball/getUsedNumbers getUsedNumbers
     *
     * @apiName getUsedNumbers
     *
     * @apiGroup powerball
     *
     * @apiSuccess {String} status Status of the request. ok or fail
     * @apiSuccess {String} message Generic message about the response
     * @apiSuccess {String[]} data More information about the response

     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
    {
        "status":"ok",
        "message":"Returned",
        "data":[
            {
                "total":"9",
                "number_used":"65"
            },
            {
                "total":"10",
                "number_used":"60"
            },
            {
                "total":"12",
                "number_used":"63"
            },
            {
                "total":"12",
                "number_used":"66"
            }
        ]
    }
     */
    $this->get('/getUsedNumbers', function (Request $request, Response $response) {

        $powerball = new Powerball();
        $response = $response->withJson($powerball->getUsedNumbers());

        return $response;
    })->setName('powerball-fewestUsedNumbers');



    /**
     * @apiVersion 1.0.0
     * @api {get} /powerball/getUsedPowerNumbers getUsedPowerNumbers
     *
     * @apiName getUsedPowerNumbers
     *
     * @apiGroup powerball
     *
     * @apiSuccess {String} status Status of the request. ok or fail
     * @apiSuccess {String} message Generic message about the response
     * @apiSuccess {String[]} data More information about the response

     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
    {
        "status":"ok",
        "message":"Returned",
        "data":[
            {
                "total":"15",
                "number_used":"21"
            },
            {
                "total":"16",
                "number_used":"26"
            },
            {
                "total":"16",
                "number_used":"4"
            },
            {
                "total":"18",
                "number_used":"14"
            },
            {
                "total":"19",
                "number_used":"9"
            },
            {
                "total":"20",
                "number_used":"13"
            }
        ]
    }
     */
    $this->get('/getUsedPowerNumbers', function (Request $request, Response $response) {

        $powerball = new Powerball();
        $response = $response->withJson($powerball->getUsedPowerNumbers());

        return $response;
    })->setName('powerball-fewestUsedPowerNumbers');



    /**
     * @apiVersion 1.0.0
     * @api {get} /powerball/generateSelectionByMostUsed generateSelectionByMostUsed
     *
     * @apiName generateSelectionByMostUsed
     *
     * @apiGroup powerball
     *
     * @apiSuccess {String} status Status of the request. ok or fail
     * @apiSuccess {String} message Generic message about the response
     * @apiSuccess {String[]} data More information about the response

     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
    {
        "status":"ok",
        "message":"Returned",
        "data":[
            "12",
            "41",
            "52",
            "28",
            "23",
            "25"
        ]
    }
     */
    $this->get('/generateSelectionByMostUsed', function (Request $request, Response $response) {

        $powerball = new Powerball();
        $response = $response->withJson($powerball->generateSelectionByMostUsed());

        return $response;
    })->setName('powerball-generateSelectionByMostUsed');


    /**
     * @apiVersion 1.0.0
     * @api {get} /powerball/generateSelectionByLeastUsed generateSelectionByLeastUsed
     *
     * @apiName generateSelectionByLeastUsed
     *
     * @apiGroup powerball
     *
     * @apiSuccess {String} status Status of the request. ok or fail
     * @apiSuccess {String} message Generic message about the response
     * @apiSuccess {String[]} data More information about the response

     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
    {
        "status":"ok",
        "message":"Returned",
        "data":[
            "67",
            "61",
            "62",
            "69",
            "64",
            "26"
        ]
    }
     */
    $this->get('/generateSelectionByLeastUsed', function (Request $request, Response $response) {

        $powerball = new Powerball();
        $response = $response->withJson($powerball->generateSelectionByLeastUsed());

        return $response;
    })->setName('powerball-generateSelectionByLeastUsed');


    /**
     * @apiVersion 1.0.0
     * @api {get} /powerball/generateRandomSelectionByMostUsed generateRandomSelectionByMostUsed
     *
     * @apiName generateRandomSelectionByMostUsed
     *
     * @apiGroup powerball
     *
     * @apiSuccess {String} status Status of the request. ok or fail
     * @apiSuccess {String} message Generic message about the response
     * @apiSuccess {String[]} data More information about the response

     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
    {
        "status":"ok",
        "message":"Returned",
        "data":[
            "52",
            "28",
            "13",
            "31",
            "41",
            "20"
        ]
    }
     */
    $this->get('/generateRandomSelectionByMostUsed', function (Request $request, Response $response) {

        $powerball = new Powerball();
        $response = $response->withJson($powerball->generateRandomSelectionByMostUsed());

        return $response;
    })->setName('powerball-generateRandomSelectionByMostUsed');


});


/**
 * Run the app
 */
$app->run();