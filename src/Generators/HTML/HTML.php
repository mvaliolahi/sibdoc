<?php
/**
 * Created by PhpStorm.
 * User: Mvaliolahi
 * Date: 12/30/18
 * Time: 12:48 PM
 */

namespace Mvaliolahi\SibDoc\Generators\HTML;


use Mvaliolahi\SibDoc\Contracts\DocumentGenerator;
use Mvaliolahi\SibDoc\Exceptions\ExportPathNotSetException;
use Twig_Environment;
use Twig_Loader_Filesystem;
use Twig_SimpleTest;

/**
 * Class HTML
 * @package Mvaliolahi\SibDoc\Generators\HTML
 */
class HTML extends DocumentGenerator
{
    /**
     * @param string $path
     * @return mixed
     * @throws ExportPathNotSetException
     */
    public function format($path = null)
    {
        if (is_null($path)) {
            throw new ExportPathNotSetException('Please pick a valid path to generate document.html');
        }

        try {
            $twig = $this->initialTwig();
            $view = $this->loadView($twig);
            $this->writeDocumentToFile($path, $view);

        } catch (\Exception $exception) {
            $this->writeDocumentToFile($path, $exception->getMessage());
        }
    }

    /**
     * @return Twig_Environment
     */
    protected function initialTwig(): Twig_Environment
    {
        $loader = new Twig_Loader_Filesystem(__DIR__ . '/Template');
        $twig = new Twig_Environment($loader, [
            'cache' => false,
        ]);

        $twig->addTest($this->isString());
        $twig->addFilter((new \Twig_Filter('md5', function ($value) {
            return md5($value);
        })));

        return $twig;
    }

    /**
     * If endpoint index is string then endpoint is a group,
     * otherwise endpoint is just an endpoint.
     *
     * @return Twig_SimpleTest
     */
    protected function isString(): Twig_SimpleTest
    {
        return new Twig_SimpleTest('string', function ($value) {
            return is_string($value);
        });
    }

    /**
     * @param $twig
     * @return mixed
     */
    protected function loadView($twig)
    {
        return $twig->render('template.twig', [
            'title'           => $this->title,
            'description'     => $this->description,
            'groups'          => $this->groups(),
            'endpoints'       => $this->endpoints(),
            'models'          => $this->models(),
            'baseUrl'         => $this->baseUrl,
            'backgroundColor' => $this->backgroundColor(),
        ]);
    }

    /**
     * @param $path
     * @param $data
     */
    private function writeDocumentToFile($path, $data)
    {
        file_put_contents(rtrim($path, '/') . '/document.html', $data);
    }
}