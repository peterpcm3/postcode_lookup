<?php

namespace App\Repository;

use App\Entity\Postcode;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Postcode|null find($id, $lockMode = null, $lockVersion = null)
 * @method Postcode|null findOneBy(array $criteria, array $orderBy = null)
 * @method Postcode[]    findAll()
 * @method Postcode[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostcodeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Postcode::class);
    }

    /**
     * @param int $lat
     * @param int $lon
     */
    public function searchByLatLon(int $lat, int $lon): array
    {
        $em = $this->getEntityManager();

        $query = '
            SELECT p.*, 
            (
               3959 *
               acos(cos(radians(:lat)) * 
               cos(radians(latitude)) * 
               cos(radians(longitude) - 
               radians(:lon)) + 
               sin(radians(:lat)) * 
               sin(radians(latitude)))
            ) AS distance 
            
            FROM postcode p
            HAVING distance < :distance
        ';

        $conn = $this->getEntityManager()
                    ->getConnection();
        $stmt = $conn->prepare($query);

        $stmt->execute(array('lat' => $lat, 'lon' => $lat, 'distance' => Postcode::NEAREST_DISTANCE));

        $postcodes = $stmt->fetchAll();

        $transformedData = [];
        foreach ($postcodes as $postcode) {
            $transformedData[] = [
                'postcode'  => $postcode['postcode'],
                'easting'   => $postcode['easting'],
                'northing'  => $postcode['northing'],
                'latitude'  => $postcode['latitude'],
                'longitude' => $postcode['longitude']
            ];
        }

        return $transformedData;
    }

    /**
     * @param string $phrase
     *
     * @return array
     */
    public function searchByPhrase(string $phrase): array
    {
        $postcodes = $this->createQueryBuilder('p')
            ->where('p.postcode LIKE :phrase')
            ->setParameter('phrase', "%$phrase%")
            ->getQuery()
            ->getResult();

        $transformedData = [];
        foreach ($postcodes as $postcode) {
            $transformedData[] = [
                'postcode'  => $postcode->getPostcode(),
                'easting'   => $postcode->getEasting(),
                'northing'  => $postcode->getNorthing(),
                'latitude'  => $postcode->getLatitude(),
                'longitude' => $postcode->getLongitude()
            ];
        }

        return $transformedData;
    }
}
