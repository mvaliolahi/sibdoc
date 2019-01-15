<?php
/**
 * Created by PhpStorm.
 * User: Mvaliolahi
 * Date: 12/29/18
 * Time: 12:23 PM
 */

namespace Tests\Feature;


use Mvaliolahi\SibDoc\Exceptions\ExportPathNotSetException;
use Mvaliolahi\SibDoc\Schemas\Request\Request;
use Mvaliolahi\SibDoc\Schemas\Response\Response;
use Mvaliolahi\SibDoc\SibDoc;
use Tests\TestCase;

/**
 * Class SibDocTest
 * @package Tests\Feature
 */
class SibDocTest extends TestCase
{
    /**
     * @var SibDoc
     */
    protected $api;

    /** @test */
    public function it_should_be_able_to_define_group()
    {
        $this->api->group('users', function (SibDoc $api) {
            $api->get('applications', function (Request $request) {

                $request->title('Get Application Lists.');

                $request->parameters([
                    'token:required',
                    'device_id',
                ]);

                $response = (new Response())
                    ->title('When every things work!')
                    ->code(200);
                $request->headers([
                    'Client' => "Linux"
                ]);

                $request->response('success', $response);

            });
            $api->get('transactions', function (Request $request) {
                $request->title('Get Transactions.');
            });
        });

        $this->assertEquals([
            'users' => [
                0 => [
                    'url'    => 'applications',
                    'method' => 'GET',
                    'http'   => [
                        'request'  => [
                            'title'      => 'Get Application Lists.',
                            'headers'    => [
                                'Client' => 'Linux'
                            ],
                            'parameters' => [
                                'token:required',
                                'device_id',
                            ],
                            'body'       => []
                        ],
                        'response' => [
                            'success' => [
                                'title'   => 'When every things work!',
                                'headers' => [],
                                'code'    => 200,
                            ],
                        ]
                    ],
                ],
                1 => [
                    'url'    => 'transactions',
                    'method' => 'GET',
                    'http'   => [
                        'request'  => [
                            'title'      => 'Get Transactions.',
                            'headers'    => [],
                            'parameters' => [],
                            'body'       => []
                        ],
                        'response' => []
                    ],
                ]
            ]
        ],
            $this->api->endpoints()
        );
    }

    /** @test */
    public function it_should_be_able_to_define_multiple_response_for_endpoint()
    {
        $this->api->get('applications', function (Request $request) {

            $request->title('Get Application Lists.');

            $request->parameters([
                'token:required',
                'device_id',
            ]);

            // Success Response.
            $success = new Response();
            $success->title('When every things work!');
            $success->code(200);

            // Fail Response.
            $fail = new Response();
            $fail->title('Internal Error!');
            $fail->code(500);

            $request->response('success', $success);
            $request->response('fail', $fail);

        });

        $this->assertEquals([
            'url'    => 'applications',
            'method' => 'GET',
            'http'   => [
                'request'  => [
                    'title'      => 'Get Application Lists.',
                    'headers'    => [],
                    'parameters' => [
                        'token:required',
                        'device_id',
                    ],
                    'body'       => []
                ],
                'response' => [
                    'success' => [
                        'title'   => 'When every things work!',
                        'headers' => [],
                        'code'    => 200,
                    ],
                    'fail'    => [
                        'title'   => 'Internal Error!',
                        'headers' => [],
                        'code'    => 500,
                    ],
                ]
            ],

        ],
            $this->api->endpoints()[0]
        );
    }

    /** @test */
    public function it_should_be_able_to_define_multiple_endpoints()
    {
        // Show Application endpoint
        $this->api->get('applications/{id}', function (Request $request) {

            $request->title('Show Single Application.');

            $request->parameters([
                'application_id:required'
            ]);

            $success = new Response();
            $success->title('Application Shows successfully.');

            $request->response('success', $success);

        });

        // Applications endpoint
        $this->api->get('applications', function (Request $request) {

            $request->title('Get Application Lists.');

            $request->parameters([
                'token:required',
                'device_id',
            ]);

            // Success Response.
            $success = new Response();
            $success->title('When every things work!');
            $success->code(200);

            // Fail Response.
            $fail = new Response();
            $fail->title('Internal Error!');
            $fail->code(500);

            $request->response('success', $success);
            $request->response('fail', $fail);

        });

        // Assert First endpoint
        $this->assertEquals([
            'url'    => 'applications/{id}',
            'method' => 'GET',
            'http'   => [
                'request'  => [
                    'title'      => 'Show Single Application.',
                    'headers'    => [],
                    'parameters' => [
                        'application_id:required',
                    ],
                    'body'       => [],
                ],
                'response' => [
                    'success' => [
                        'title'   => 'Application Shows successfully.',
                        'headers' => [],
                        'code'    => 200,
                    ],
                ],
            ]
        ], $this->api->endpoints()[0]);

        // Assert Second endpoint
        $this->assertEquals([
            'url'    => 'applications',
            'method' => 'GET',
            'http'   => [
                'request'  => [
                    'title'      => 'Get Application Lists.',
                    'headers'    => [],
                    'parameters' => [
                        'token:required',
                        'device_id',
                    ],
                    'body'       => []
                ],
                'response' => [
                    'success' => [
                        'title'   => 'When every things work!',
                        'headers' => [],
                        'code'    => 200,
                    ],
                    'fail'    => [
                        'title'   => 'Internal Error!',
                        'headers' => [],
                        'code'    => 500,
                    ],
                ]
            ],

        ],
            $this->api->endpoints()[1]
        );
    }

    /**
     * @test
     */
    public function it_should_be_able_to_define_model()
    {
        $this->api->model('user', [
            'id'     => 'numeric',
            'name'   => 'string',
            'family' => 'string',
            'age'    => 'numeric',
            'images' => 'url',
        ]);

        $this->api->get('user/profile', function (Request $request) {

            $request->title('User Profile.');

            $request->parameters([
                'user_id:required'
            ]);

            $response = new Response();
            $response->title('Success');
            $response->body([
                'status'   => 'success',
                'messages' => 'Operation was successful.',
                'data'     => $this->api->model('user')
            ]);

            $request->response('success', $response);

        });

        $body = [
            'status'   => 'success',
            'messages' => 'Operation was successful.',
            'data'     => [
                'id'     => 'numeric',
                'name'   => 'string',
                'family' => 'string',
                'age'    => 'numeric',
                'images' => 'url',
            ]
        ];

        $this->assertEquals($body, $this->api->endpoints()[0]['http']['response']['success']['body']);
    }

    /**
     * @test
     */
    public function requests_should_use_base_header()
    {
        $this->api->requestHeaders([
            'Content-Type' => 'application/json',
        ]);

        $this->api->get('user/{id}', function (Request $request) {

            $request->title('Show Single User.');
            $request->parameters([
                'user_id:required'
            ]);

            $response = new Response();
            $response->body([
                'status' => 'success',
                'data'   => [],
            ]);

            $request->response('success', $response);

        });


        // Assertion

        $expectedRequest = [
            'title'      => 'Show Single User.',
            'parameters' => [
                'user_id:required'
            ],
            'body'       => [],
            'headers'    => [
                'Content-Type' => 'application/json'
            ]
        ];

        $this->assertEquals($expectedRequest, $this->api->endpoints()[0]['http']['request']);
    }

    /**
     * @test
     */
    public function responses_should_use_base_header()
    {
        $this->api->responseHeaders([
            'Server' => 'Ubuntu-18.04',
        ]);

        $this->api->get('user/{id}', function (Request $request) {

            $request->title('Show Single User.');
            $request->parameters([
                'user_id:required'
            ]);

            $response = new Response();
            $response->body([
                'status' => 'success',
                'data'   => [],
            ]);

            $request->response('success', $response);

        });

        // Assertion

        $expectedResponse = [
            'code'    => 200,
            'headers' => [
                'Server' => 'Ubuntu-18.04',
            ],
            'body'    => [
                'status' => 'success',
                'data'   => []
            ],
        ];

        $this->assertEquals($expectedResponse, $this->api->endpoints()[0]['http']['response']['success']);
    }

    /**
     * @test
     */
    public function request_may_have_body_as_form_data()
    {
        $this->api->get('user/products', function (Request $request) {

            $request->title('Get User Products');

            $request->body()->formData([
                'token:required',
                'user_id:required'
            ]);

        });

        $r = [
            'title'      => 'Get User Products',
            'headers'    => [],
            'parameters' => [],
            'body'       => [
                'form-data' => [
                    'token:required',
                    'user_id:required'
                ]
            ]
        ];

        $this->assertEquals($r, $this->api->endpoints()[0]['http']['request']);
    }

    /**
     * @test
     */
    public function request_may_have_body_as_x_www_form_urlencode()
    {
        $this->api->get('user/products', function (Request $request) {

            $request->title('Get User Products');

            $request->body()->xWWWFormUrlEncode([
                'token:required',
                'user_id:required'
            ]);

        });

        $r = [
            'title'      => 'Get User Products',
            'headers'    => [],
            'parameters' => [],
            'body'       => [
                'x-www-form-urlencode' => [
                    'token:required',
                    'user_id:required'
                ]
            ]
        ];

        $this->assertEquals($r, $this->api->endpoints()[0]['http']['request']);
    }

    /**
     * @test
     */
    public function request_may_have_body_as_raw()
    {
        $this->api->get('user/products', function (Request $request) {

            $request->title('Get User Products');

            $request->body()->raw([
                'token:required',
                'user_id:required'
            ]);

        });

        $r = [
            'title'      => 'Get User Products',
            'headers'    => [],
            'parameters' => [],
            'body'       => [
                'raw' => [
                    'token:required',
                    'user_id:required'
                ]
            ]
        ];

        $this->assertEquals($r, $this->api->endpoints()[0]['http']['request']);
    }

    /**
     * @test
     */
    public function request_may_have_body_as_binary()
    {
        $this->api->get('user/products', function (Request $request) {

            $request->title('Get User Products');

            $request->body()->binary([
                'token:required',
                'user_id:required'
            ]);

        });

        $r = [
            'title'      => 'Get User Products',
            'headers'    => [],
            'parameters' => [],
            'body'       => [
                'binary' => [
                    'token:required',
                    'user_id:required'
                ]
            ]
        ];

        $this->assertEquals($r, $this->api->endpoints()[0]['http']['request']);
    }

    /** @test */
    public function it_should_be_able_to_generate_html_document()
    {
        $this->api->model('user', [
            'id'     => 'numeric',
            'name'   => 'string',
            'family' => 'string',
            'avatar' => 'url',
        ]);
        $this->api->model('transaction', [
            'id'         => 'numeric',
            'status'     => 'PAID | UNPAID',
            'created_at' => 'timestamp'
        ]);
        $this->api->group('finance', function (SibDoc $api) {

            // Transactions
            $api->get('transactions', function (Request $request) {
                $request->title('Get All Transactions.');
                $request->version("v1");

                $request->headers([
                    'Content-Type'    => 'application/json',
                    'Client-Language' => 'En',
                    'Authorization'   => 'Bearer xxx'
                ]);

                $success = (new Response())
                    ->title('Success')
                    ->description('Success Description!')
                    ->headers([
                        'Server' => 'Linux'
                    ])
                    ->body([
                        'id'     => 'numeric',
                        'status' => "PAID"
                    ]);

                $fail = (new Response())
                    ->title('Fail')
                    ->body([
                        'id'     => 'numeric',
                        'status' => "UNPAID"
                    ]);

                $request->response($success);
                $request->response($fail);

            });

            // Show Transaction
            $api->post('transactions/{id}', function (Request $request) {
                $request->title('Show Transaction.');
                $request->version("v1");

                $request->parameters([
                    'token'          => 'required',
                    'transaction_id' => 'required',
                ]);

                $success = (new Response());
                $success->title('Success');
                $success->body([
                    'id'         => 'numeric',
                    'status'     => 'PAD | UNPAID',
                    'created_at' => 'timestamp',
                ]);
                $request->response($success);

            });

        });
        $this->api->get('/users/', function (Request $request) {
            $request->title('Get All Users.');

            $request->parameters([
                'token' => 'required',
            ]);


            $response = new Response();
            $response->headers([
                'Server' => 'Ubuntu-18.04',
                'Cache'  => true
            ]);

            $response->body([
                'data' => $this->api->model('user'),
            ]);

            $request->response('success', $response);
        });
        $this->api->put('/users/devices', function (Request $request) {
            $request->title('Get User Devices.');

            $request->parameters([
                'token' => 'required',
            ]);


            $response = new Response();
            $response->headers([
                'Server' => 'Ubuntu-18.04',
                'Cache'  => true
            ]);

            $response->body([
                'data' => $this->api->model('user'),
            ]);

            $request->response('success', $response);
        });
        $this->api->delete('post/{id}', function (Request $request) {
            $request->title('Delete post');
            $request->version("v2");
            $request->description("Request DESCRIPTION");

            $success = (new Response());
            $success->title('Success');
            $success->description("در صورتی که حذف انجام شود.");
            $success->body([
                'id' => 'numeric',
            ]);

            $request->response($success);
        });
        $this->api->group('analytic', function (SibDoc $api) {

            // Transactions
            $api->get('transactions', function (Request $request) {
                $request->title('Get All Transactions.');
                $request->version(1);

                $request->headers([
                    'Content-Type'  => 'application/json',
                    'Lang'          => 'En',
                    'Authorization' => 'Brear xxx'
                ]);


                $success = (new Response());
                $success->title('Success');
                $success->description('Success Description!');
                $success->headers([
                    'Server' => 'Linux'
                ]);
                $success->body([
                    'id'     => 'numeric',
                    'status' => "PAID"
                ]);

                $fail = (new Response());
                $fail->title('Fail');
                $fail->body([
                    'id'     => 'numeric',
                    'status' => "UNPAID"
                ]);

                $request->response($success);
                $request->response($fail);

            });

            // Show Transaction
            $api->post('transactions/{id}', function (Request $request) {
                $request->title('Show Transaction.');
                $request->version(2.0);

                $request->parameters([
                    'token'          => 'required',
                    'transaction_id' => 'required',
                    'device_id'      => 'required',
                ]);

                $success = (new Response());
                $success->title('Success');
                $request->response($success);

            });

        });
        $this->api->saveTo($path = __DIR__ . '/../temp/');

        $this->assertFileExists($path .= '/document.html');

        unlink($path);
    }

    /**
     * @tst
     * @expectedException ExportPathNotSetException
     */
    public function it_should_throws_an_exception_when_path_not_defined_for_generate_method()
    {
        $this->api->saveTo();
    }

    /**
     *
     */
    protected function setUp()
    {
        parent::setUp();

        $this->api = new SibDoc([
            'url'         => 'http://127.0.0.1:8000',
            'title'       => 'SibDoc Document Generator',
            'description' => 'Generate SibDoc Document Using PHP.',
        ]);
    }
}