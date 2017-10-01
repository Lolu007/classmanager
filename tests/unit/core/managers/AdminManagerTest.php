<?php

namespace tests\unit\core;

use classmanager\core\db\repositories\AdminRepository;
use classmanager\core\db\repositories\Repository;
use classmanager\core\managers\AdminManager;
use Codeception\Specify;
use \Codeception\Test\Unit;
use Mockery;

class AdminManagerTest extends Unit
{
    use Specify;

    /** @var AdminManager $adminManager */
    private $adminManager;

    public function setUp()
    {
        return parent::setUp();
    }

    public function testGetAdminDetails()
    {
        $this->adminManager = new AdminManager(
            $this->getMockedRepository('get', 1, ['id' => 1, 'name' => 'test name'])
        );

        $adminDetails = $this->adminManager->getAdminDetails(1);

        $this->specify('It returns Admin details', function () use ($adminDetails) {
            expect($adminDetails)->notEmpty();
            expect($adminDetails['id'])->equals(1);
            expect($adminDetails['name'])->equals('test name');
        });
    }

    public function testSaveAdminDetails()
    {
        $this->adminManager = new AdminManager(
            $this->getMockedRepository('save', 1, true)
        );

        $isSaved = $this->adminManager->createAdmin([
            'name'  => 'name'
        ]);

        $this->specify('It saves Admin details', function () use ($isSaved) {
            expect($isSaved)->true();
        });
    }

    public function testUpdateAdminDetails()
    {
        $this->adminManager = new AdminManager(
            $this->getMockedRepository('update', 1, true)
        );

        $isUpdated = $this->adminManager->updateAdminDetails(1, [
            'name'  => 'name'
        ]);

        $this->specify('It updates Admin details', function () use ($isUpdated) {
            expect($isUpdated)->true();
        });
    }

    /**
     * @param $method
     * @param $callTimes
     * @param $returnData
     * @return Mockery\MockInterface|Repository
     */
    public function getMockedRepository($method, $callTimes, $returnData)
    {
        /** @var Mockery\MockInterface|Repository $mock */
        $mock = Mockery::mock(AdminRepository::class);
        $mock->shouldReceive($method)->times($callTimes)->andReturn($returnData);

        return $mock;
    }

    public function tearDown()
    {
        Mockery::close();
    }
}