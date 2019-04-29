<?php

namespace App\Listeners;

use App\Events\NewProductEvent;
use App\Models\Product;
use Elasticsearch\ClientBuilder;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewProductListener
{
    protected $client;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        $this->client = ClientBuilder::create()->build();
    }

    /**
     * Handle the event.
     *
     * @param  NewProductEvent  $event
     * @return void
     */
    public function handle(NewProductEvent $event)
    {
        $this->addProductToElasticSearch($event->product);
    }

    private function addProductToElasticSearch(Product $product)
    {
        // Fill array with product data
        $data = [
            'body' => [
                'id'            => $product->id,
                'title'          => $product->title,
                'stock'          => $product->stock,
                'description'   => $product->description,
                'price'        => $product->price
            ],
            'index' => Product::ELASTIC_INDEX,
            'type'  => Product::ELASTIC_TYPE,
        ];

        // Send request to index new product
        $response = $this->client->index($data);

        return $response;
    }
}
