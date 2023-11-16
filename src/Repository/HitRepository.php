<?php

namespace App\Repository;

use App\Entity\Hit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Hit>
 *
 * @method Hit|null find($id, $lockMode = null, $lockVersion = null)
 * @method Hit|null findOneBy(array $criteria, array $orderBy = null)
 * @method Hit[]    findAll()
 * @method Hit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Hit::class);
    }

    public function hasSameIdentifier(string $identifier): ?Hit
    {
        return $this->findOneBy(['identifier' => $identifier]);
    }

    public function upsert(array $data): void
    {

        $sql = "
            INSERT INTO hit (ip, useragent, identifier, updated_at)
            VALUES (:ip, :useragent, :identifier, :updated_at)
            ON CONFLICT (identifier) DO UPDATE
            SET ip = CASE WHEN hit.ip <> EXCLUDED.ip THEN EXCLUDED.ip ELSE hit.ip END,
            useragent = CASE WHEN hit.useragent <> EXCLUDED.useragent THEN EXCLUDED.useragent ELSE hit.useragent END,
            updated_at = EXCLUDED.updated_at
            WHERE hit.ip <> EXCLUDED.ip OR hit.useragent <> EXCLUDED.useragent
        ";

        $this->_em->getConnection()->executeStatement($sql, [
            'ip' => $data['ip'],
            'useragent' => $data['useragent'],
            'identifier' => $data['identifier'],
            'updated_at' => $data['date']
        ]);
    }

    public function insert(array $data): void
    {

        $sql = "
            INSERT INTO hit (ip, useragent, identifier, created_at) 
            VALUES (:ip, :useragent, :identifier, :created_at)
            ON CONFLICT (ip, useragent, identifier) DO NOTHING
        ";

        $this->_em->getConnection()->executeStatement($sql, [
            'ip' => $data['ip'],
            'useragent' => $data['useragent'],
            'identifier' => $data['identifier'],
            'created_at' => $data['date'],
            'updated_at' => isset($data['date']) ?: null,
        ]);
    }
}
