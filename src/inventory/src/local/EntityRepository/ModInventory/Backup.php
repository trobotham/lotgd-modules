<?php

namespace Lotgd\Local\EntityRepository\ModInventory;

use Tracy\Debugger;

/**
 * Functions for backup data.
 */
trait Backup
{
    /**
     * Get all mail to account.
     *
     * @param int $accountId
     *
     * @return array
     */
    public function backupGetDataFromAccount(int $accountId): array
    {
        $query = $this->createQueryBuilder('u');

        try
        {
            return $query->where('u.userId = :acct')

                ->setParameter('acct', $accountId)

                ->getQuery()
                ->getResult()
            ;
        }
        catch (\Throwable $th)
        {
            Debugger::log($th);

            return [];
        }
    }

    /**
     * Delete comments of account.
     *
     * @param int $accountId
     *
     * @return int
     */
    public function backupDeleteDataFromAccount(int $accountId): int
    {
        $query = $this->_em->createQueryBuilder();

        try
        {
            return $query->delete($this->_entityName, 'u')
                ->where('u.userId = :acct')
                ->setParameter('acct', $accountId)
                ->getQuery()
                ->execute()
            ;
        }
        catch (\Throwable $th)
        {
            Debugger::log($th);

            return 0;
        }
    }
}
