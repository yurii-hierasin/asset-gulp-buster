<?php

namespace YuriiOrg\Tests\Asset\VersionStrategy;

use YuriiOrg\Asset\VersionStrategy\GulpBusterVersionStrategy;

class GulpBusterVersionStrategyTest extends \PHPUnit_Framework_TestCase
{
    public function testGetVersion()
    {
        $manifestPath = __DIR__ . '/../../Resources/busters.json';
        $versionStrategy = new GulpBusterVersionStrategy($manifestPath);

        $this->assertEquals('f9c7afd05729f10f55b689f36bb20172', $versionStrategy->getVersion('js/script.js'));
        $this->assertEquals('91cd067f79a5839536b46c494c4272d8', $versionStrategy->getVersion('css/style.css'));

        $this->assertEquals('js/script.js?f9c7afd05729f10f55b689f36bb20172', $versionStrategy->applyVersion('js/script.js'));
        $this->assertEquals('css/style.css?91cd067f79a5839536b46c494c4272d8', $versionStrategy->applyVersion('css/style.css'));
    }

    public function testTwigExtension()
    {
        $manifestPath = __DIR__ . '/../../Resources/busters.json';
        $versionStrategy = new GulpBusterVersionStrategy($manifestPath);

        $loader = new \Twig_Loader_Filesystem(__DIR__ . '/../../Resources/');
        $twig = new \Twig_Environment($loader);
        $twig->addGlobal('asset', $versionStrategy);
        $this->assertEquals(
            '<script src="js/script.js?f9c7afd05729f10f55b689f36bb20172"></script>',
            $twig->render('test1.html.twig')
        );
    }

    public function testTwigExtensionFunction()
    {
        $manifestPath = __DIR__ . '/../../Resources/busters.json';
        $versionStrategy = new GulpBusterVersionStrategy($manifestPath);

        $loader = new \Twig_Loader_Filesystem(__DIR__ . '/../../Resources/');
        $twig = new \Twig_Environment($loader);
        $function = new \Twig_SimpleFunction('asset', array($versionStrategy, 'applyVersion'));
        $twig->addFunction($function);

        $this->assertEquals(
            '<script src="js/script.js?f9c7afd05729f10f55b689f36bb20172"></script>',
            $twig->render('test2.html.twig')
        );
    }
}
