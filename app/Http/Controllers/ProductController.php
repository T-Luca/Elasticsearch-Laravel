<?php

namespace App\Http\Controllers;

use App\Events\NewProductEvent;
use App\Models\Product;
use Elasticsearch\ClientBuilder;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $client;

    public function __construct()
    {
        $this->client = ClientBuilder::create()->build();
    }

    public function index()
    {
        $products = Product::get();

        return view('products.index', ['products' => $products]);
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'stock' => 'required',
            'price' => 'required'
        ]);

        $product              = new Product();
        $product->title        = $validatedData['title'];
        $product->description = $validatedData['description'];
        $product->stock = $validatedData['stock'];
        $product->price = $validatedData['price'];
        $product->save();


        // Trigger an event to index new product in Elasticsearch
        event(new NewProductEvent($product));

        return redirect()->route('products');
    }

    public function search(Request $request)
    {
        if($request->has('text') && $request->input('text')) {

            // Search for given text and return data
            $data = $this->searchProducts($request->input('text'));
            $productsArray = [];

            // If there are any products that match given search text "hits" fill their id's in array
            if($data['hits']['total'] > 0) {

                foreach ($data['hits']['hits'] as $hit) {
                    $productsArray[] = $hit['_source']['id'];
                }
            }

            // Retrieve found products from database
            $products = Product::whereIn('id', $productsArray)
                           ->get();

            // Return to view with data
            return view('products.index', ['products' => $products]);
        } else {
            return redirect()->route('products');
        }
    }

    private function searchProducts($text)
    {
        $params = [
            'index' => Product::ELASTIC_INDEX,
            'type' => Product::ELASTIC_TYPE,
            'body' => [
                'sort' => [
                    '_score'
                ],
                'query' => [
                    'bool' => [
                        'should' => [
                            ['match' => [
                                'title' => [
                                    'query'     => $text,
                                    'fuzziness' => '1'
                                ]
                            ]],
                            ['match' => [
                                'description' => [
                                    'query'     => $text,
                                    'fuzziness' => '0'
                                ]
                            ]],
                        ]
                    ],
                ],
            ]
        ];

        $data = $this->client->search($params);
        return $data;
    }
}
