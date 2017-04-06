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
     * @api {post} /auth/login login
     *
     * @apiName PostLogin
     *
     * @apiGroup auth
     *
     * @apiParam {String} username Username of the user
     * @apiParam {String} password Password of the user
     *
     * @apiSuccess {String} status Status of the request. ok or fail
     * @apiSuccess {String} message Generic message about the response
     * @apiSuccess {String[]} data More information about the response

     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
    {
    "status": "ok",
    "data": {
    "users_id": 109,
    "username": "apitest7",
    "password": "a94a8fe5ccb19ba61c4c0873d391e987982fbbd3",
    "first_name": "Lucas",
    "last_name": "Hoezee",
    "email_address": "lukeap72i@thecodify.com",
    "create_date": "2017-02-22 14:08:04",
    "is_admin": 0,
    "referral_id": 0,
    "company_id": 0,
    "viewed_welcome_video": 1,
    "email_confirmed": null,
    "is_support": null,
    "intercom_id": null,
    "forgot_password_token": null,
    "api_token": null
    },
    "message": "User Authenticated!"
    }
     */
    $this->get('/powerball', function (Request $request, Response $response) {

        $winningNumbers = new WinningNumbers($this);
        $response = $response->withJson($winningNumbers->powerball());

        return $response;
    })->setName('winningNumbers-powerball');

});


/**
 * Run the app
 */
$app->run();