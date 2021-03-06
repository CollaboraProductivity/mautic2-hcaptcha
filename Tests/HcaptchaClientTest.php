<?php

/*
 * @copyright   2018 Konstantin Scheumann. All rights reserved
 * @author      Konstantin Scheumann
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

namespace MauticPlugin\MauticHcaptchaBundle\Tests;

use PHPUnit_Framework_MockObject_MockBuilder;
use Mautic\PluginBundle\Helper\IntegrationHelper;
use MauticPlugin\MauticHcaptchaBundle\Integration\HcaptchaIntegration;
use MauticPlugin\MauticHcaptchaBundle\Service\HcaptchaClient;

class HcaptchaClientTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var PHPUnit_Framework_MockObject_MockBuilder|IntegrationHelper
     */
    private $integrationHelper;

    /**
     * @var PHPUnit_Framework_MockObject_MockBuilder|HcaptchaIntegration
     */
    private $integration;

    protected function setUp()
    {
        parent::setUp();

        $this->integrationHelper = $this->createMock(IntegrationHelper::class);
        $this->integration       = $this->createMock(HcaptchaIntegration::class);
    }

    public function testVerifyWhenPluginIsNotInstalled()
    {
        $this->integrationHelper->expects($this->once())
            ->method('getIntegrationObject')
            ->willReturn(null);

        $this->integration->expects($this->never())
            ->method('getKeys');

        $this->createHcaptchaClient()->verify('');
    }

    public function testVerifyWhenPluginIsNotConfigured()
    {
        $this->integrationHelper->expects($this->once())
            ->method('getIntegrationObject')
            ->willReturn($this->integration);

        $this->integration->expects($this->once())
            ->method('getKeys')
            ->willReturn(['site_key' => 'test', 'secret_key' => 'test']);

        $this->createHcaptchaClient()->verify('');
    }

    /**
     * @return HcaptchaClient
     */
    private function createHcaptchaClient()
    {
        return new HcaptchaClient(
            $this->integrationHelper
        );
    }
}
