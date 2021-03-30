<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

use App\Repository\PostcodeRepository;

class ApiPostcodeController extends AbstractController
{
    /**
     * @Route("/postcode/search/{lat}/{lon}", name="postcode_search")
     */
    public function search(float $lat, float $lon, PostcodeRepository $repo): JsonResponse
    {
        return new JsonResponse($repo->searchByLatLon($lat, $lon));
    }

    /**
     * @Route("/postcode/search_by_phrase/{phrase}", name="postcode_search_by_phrase")
     */
    public function searchByPhrase(string $phrase, PostcodeRepository $repo): JsonResponse
    {
        $data = [];

        if (strlen($phrase) > 2) {
            $data = $repo->searchByPhrase($phrase);
        }

        return new JsonResponse($data);
    }
}
