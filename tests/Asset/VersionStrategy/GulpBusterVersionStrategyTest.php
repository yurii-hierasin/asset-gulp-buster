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
}
