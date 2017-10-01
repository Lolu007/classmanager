<?php

namespace classmanager\core\managers;

use classmanager\core\db\repositories\Repository;

/**
 * Class AdminManager
 * @package classmanager\core\managers
 */
class AdminManager
{
    /**
     * @var Repository $adminRepository
     */
    private $adminRepository;

    /**
     * AdminManager constructor.
     * @param Repository $adminRepository
     */
    public function __construct(Repository $adminRepository)
    {
        $this->adminRepository = $adminRepository;
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function getAdminDetails(int $id): array
    {
        return $this->adminRepository->get($id);
    }

    /**
     * @param $data
     * @return mixed
     */
    public function createAdmin(array $data): bool
    {
        return $this->adminRepository->save($data);
    }

    public function updateAdminDetails(int $id, array $data): bool
    {
        return $this->adminRepository->update($id, $data);
    }
}