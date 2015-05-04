<?php

namespace Berd\EventLogsBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * DeviceRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class DeviceRepository extends EntityRepository
{
	/**
	* Cette fonction a pour objectif de trouver dans la table Device le deviceId passer comme argument.
	* @param  string deviceId le deviceId qu'on souhaite rechercher.
	* @return response retourne l'id du résultat. 
	*/
	public function findByDeviceInTable($deviceId){
		$query = $this->getEntityManager()
               ->createQuery('SELECT d FROM Berd\EventLogsBundle\Entity\Device d
                        WHERE d.deviceId = :deviceId')
		->setParameter('deviceId', $deviceId);

		try {
			$response = $query->getResult();
		} catch (\Doctrine\Orm\NoResultException $e) {
			$response = null;
		}
		
        return $response;
	}
}
 
