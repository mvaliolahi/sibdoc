<?php
/**
 * Created by PhpStorm.
 * User: Mvaliolahi
 * Date: 1/12/19
 * Time: 6:19 PM
 */

namespace Tests\Unit;


use Mvaliolahi\SibDoc\SibDoc;
use Mvaliolahi\SibDoc\Schemas\Request\Request;
use Mvaliolahi\SibDoc\Schemas\Response\Response;
use Tests\Generators\FakeGenerator;
use Tests\TestCase;

/**
 * Class SibDocTest
 * @package Tests\Unit
 */
class SibDocTest extends TestCase
{
    /**
     * @var SibDoc
     */
    protected $api;

    /** @test */
    public function it_should_be_able_to_define_endpoint_using_GET()
    {
        $this->api->get('applications', function (Request $request) {

            $request->title('Get Application Lists.');

            $request->parameters([
                'token:required',
                'device_id',
            ]);

            $response = (new Response())
                ->title('When every things work!')
                ->code(200);

            $request->response('success', $response);

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
                ]
            ],

        ],
            $this->api->endpoints()[0]
        );
    }

    /** @test */
    public function it_should_be_able_to_define_endpoint_using_POST()
    {
        $this->api->post('applications', function (Request $request) {

            $request->title('Get Application Lists.');

            $request->parameters([
                'token:required',
                'device_id',
            ]);

            $response = (new Response())
                ->title('When every things work!')
                ->code(200);

            $request->response('success', $response);

        });

        $this->assertEquals([
            'url'    => 'applications',
            'method' => 'POST',
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
                ]
            ],

        ],
            $this->api->endpoints()[0]
        );
    }

    /** @test */
    public function it_should_be_able_to_define_endpoint_using_PUT()
    {
        $this->api->put('applications', function (Request $request) {

            $request->title('Get Application Lists.');

            $request->parameters([
                'token:required',
                'device_id',
            ]);

            $response = (new Response())
                ->title('When every things work!')
                ->code(200);

            $request->response('success', $response);

        });

        $this->assertEquals([
            'url'    => 'applications',
            'method' => 'PUT',
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
                ]
            ],

        ],
            $this->api->endpoints()[0]
        );
    }

    /** @test */
    public function it_should_be_able_to_define_endpoint_using_PATCH()
    {
        $this->api->patch('applications', function (Request $request) {

            $request->title('Get Application Lists.');

            $request->parameters([
                'token:required',
                'device_id',
            ]);

            $response = (new Response())
                ->title('When every things work!')
                ->code(200);

            $request->response('success', $response);

        });

        $this->assertEquals([
            'url'    => 'applications',
            'method' => 'PATCH',
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
                ]
            ],

        ],
            $this->api->endpoints()[0]
        );
    }

    /** @test */
    public function it_should_be_able_to_define_endpoint_using_DELETE()
    {
        $this->api->delete('applications', function (Request $request) {

            $request->title('Get Application Lists.');

            $request->parameters([
                'token:required',
                'device_id',
            ]);

            $response = (new Response())
                ->title('When every things work!')
                ->code(200);

            $request->response('success', $response);

        });

        $this->assertEquals([
            'url'    => 'applications',
            'method' => 'DELETE',
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
                ]
            ],

        ],
            $this->api->endpoints()[0]
        );
    }

    /** @test */
    public function it_should_be_able_to_define_endpoint_using_HEAD()
    {
        $this->api->head('applications', function (Request $request) {

            $request->title('Get Application Lists.');

            $request->parameters([
                'token:required',
                'device_id',
            ]);

            $response = (new Response())
                ->title('When every things work!')
                ->code(200);

            $request->response('success', $response);

        });

        $this->assertEquals([
            'url'    => 'applications',
            'method' => 'HEAD',
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
                ]
            ],

        ],
            $this->api->endpoints()[0]
        );
    }

    /** @test */
    public function it_should_be_able_to_define_endpoint_using_CONNECT()
    {
        $this->api->connect('applications', function (Request $request) {

            $request->title('Get Application Lists.');

            $request->parameters([
                'token:required',
                'device_id',
            ]);

            $response = (new Response())
                ->title('When every things work!')
                ->code(200);

            $request->response('success', $response);

        });

        $this->assertEquals([
            'url'    => 'applications',
            'method' => 'CONNECT',
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
                ]
            ],

        ],
            $this->api->endpoints()[0]
        );
    }

    /** @test */
    public function it_should_be_able_to_define_endpoint_using_OPTIONS()
    {
        $this->api->options('applications', function (Request $request) {

            $request->title('Get Application Lists.');

            $request->parameters([
                'token:required',
                'device_id',
            ]);

            $response = (new Response())
                ->title('When every things work!')
                ->code(200);

            $request->response('success', $response);

        });

        $this->assertEquals([
            'url'    => 'applications',
            'method' => 'OPTIONS',
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
                ]
            ],

        ],
            $this->api->endpoints()[0]
        );
    }

    /** @test */
    public function endpoint_can_has_version()
    {
        $this->api->get('applications', function (Request $request) {

            $request->title('Get Application Lists.');
            $request->version(1.2);

            $request->parameters([
                'token:required',
                'device_id',
            ]);

            $response = (new Response())
                ->title('When every things work!')
                ->code(200);

            $request->response('success', $response);

        });

        $this->assertEquals([
            'url'    => 'applications',
            'method' => 'GET',
            'http'   => [
                'request'  => [
                    'title'      => 'Get Application Lists.',
                    'version'    => 1.2,
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
                ]
            ],

        ],
            $this->api->endpoints()[0]
        );
    }

    /** @test */
    public function it_should_be_able_to_accept_custom_generator()
    {
        $api = new SibDoc([
            'url'         => 'http://127.0.0.1:8000',
            'title'       => 'SibDoc Document Generator',
            'description' => 'Generate API Document Using PHP.',
            'generator'   => [
                'fake_generator' => FakeGenerator::class
            ],
        ]);

        $this->assertEquals('fake generator!',  $api->saveTo(null, 'fake_generator'));
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