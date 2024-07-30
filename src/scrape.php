<?php

require 'vendor/autoload.php';

use Symfony\Component\DomCrawler\Crawler;

$client = new Client();

$url = 'https://www.plus.nl/producten/snoep-koek-chocolade-chips-noten/';

// Maak een request naar de URL
$client->request('GET', $url);

// Crawl de inhoud van de pagina
$crawler = new Crawler($client->getResponse()->getContent());

// Scrape de producten
$products = $crawler->filter('#b9-ProductsList > a')->each(function (Crawler $node) {
    $name = $node->filter('.list-item-content-center h3')->text();
    $price = $node->filter('.plp-item-price')->text();
    $imageUrl = $node->filter('.list-item-content-left img')->attr('src');
    $brand = ''; // niet aan toegekomen
    $promotion = ''; // niet aan toegekomen

    return [
        'name' => $name,
        'price' => $price,
        'image_url' => $imageUrl,
        'brand' => $brand,
        'promotion' => $promotion,
    ];
});


foreach ($products as $product) {
    echo "Naam: " . $product['name'] . "\n";
    echo "Prijs: " . $product['price'] . "\n";
    echo "Afbeelding URL: " . $product['image_url'] . "\n";
    echo "Merk: " . $product['brand'] . "\n";
    echo "Promotie: " . $product['promotion'] . "\n";
    echo "-----------------------\n";
}
