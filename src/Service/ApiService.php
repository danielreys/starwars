<?php
namespace App\Service;

use App\Entity\Character;
use Symfony\Component\HttpClient\HttpClient;
use Doctrine\ORM\EntityManagerInterface;
class ApiService
{
    const BASE_URL = 'https://swapi.dev/api/';
    const LIMIT_REQUESTS = 3;
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    public function syncData(string $endpoint): void
    {
        $client = HttpClient::create();
        $nextPage = '';
        $count = 0;
        do {
            $finalUrl = !empty($nextPage) ? $nextPage :  self::BASE_URL . $endpoint;
            $response = $client->request('GET', $finalUrl);
            $content = $response->getContent();

            $people = json_decode($content, true);

            foreach ($people['results'] as $character) {
                $product = $this->entityManager->getRepository(Character::class)->findOneBy(['name' => $character['name']]);

                if (!$product) {
                    $newCharacter = new Character();
                    $newCharacter->setName($character['name']);
                    $newCharacter->setMass((float)$character['mass']);
                    $newCharacter->setHeight((float)$character['height']);
                    $newCharacter->setGender($character['gender']);
                    $this->entityManager->persist($newCharacter);
                } else {
                    $product->setName($character['name']);
                    $product->setMass((float)$character['mass']);
                    $product->setHeight((float)$character['height']);
                    $product->setGender($character['gender']);
                    $this->entityManager->persist($product);
                }

            }
            $this->entityManager->flush();
            $nextPage = $people['next'];
            $count++;
        } while ($count < self::LIMIT_REQUESTS);
    }
}