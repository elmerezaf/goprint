<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="GoPrint API",
 *      description="API documentation for GoPrint printing service",
 *      @OA\Contact(
 *          email="sales@giftandpremium.com.hk"
 *      ),
 *      @OA\License(
 *          name="MIT",
 *          url="https://opensource.org/licenses/MIT"
 *      )
 * )
 *
 * @OA\Server(
 *      url="http://localhost:8000",
 *      description="Local API Server"
 * )
 *
 * @OA\SecurityScheme(
 *      securityScheme="bearerAuth",
 *      type="http",
 *      scheme="bearer"
 * )
 *
 * @OA\Tag(
 *     name="Products",
 *     description="API Endpoints of Products"
 * )
 *
 * @OA\Tag(
 *     name="Auth",
 *     description="API Endpoints of Authentication"
 * )
 *
 * @OA\Tag(
 *     name="Orders",
 *     description="API Endpoints of Orders"
 * )
 */
class ProductController extends Controller
{
    /**
     * @OA\Get(
     *      path="/api/products",
     *      operationId="getProductsList",
     *      tags={"Products"},
     *      summary="Get list of products",
     *      description="Returns list of all products",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *      )
     * )
     */
    public function index()
    {
        $products = Product::all();
        return response()->json($products);
    }

    /**
     * @OA\Get(
     *      path="/api/products/{id}",
     *      operationId="getProductById",
     *      tags={"Products"},
     *      summary="Get product information",
     *      description="Returns product data",
     *      @OA\Parameter(
     *          name="id",
     *          description="Product id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Product not found"
     *      )
     * )
     */
    public function show($id)
    {
        $product = Product::find($id);
        
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }
        
        return response()->json($product);
    }

    /**
     * @OA\Post(
     *      path="/api/products",
     *      operationId="storeProduct",
     *      tags={"Products"},
     *      summary="Create new product",
     *      description="Create a new product",
     *      security={{"bearerAuth":{}}},
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              @OA\Property(property="pro_name", type="string", example="Business Card"),
     *              @OA\Property(property="pro_price", type="number", format="float", example=50.00),
     *              @OA\Property(property="pro_category", type="string", example="Cards"),
     *              @OA\Property(property="pro_description", type="string", example="High quality business cards"),
     *              @OA\Property(property="pro_size", type="string", example="85x55mm"),
     *              @OA\Property(property="pro_material", type="string", example="300gsm Art Card"),
     *              @OA\Property(property="pro_specification", type="string", example="Full color both sides")
     *          )
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Product created successfully",
     *          @OA\JsonContent()
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Validation error"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthorized"
     *      )
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'pro_name' => 'required|string|max:255',
            'pro_price' => 'required|numeric|min:0',
            'pro_category' => 'required|string|max:100',
            'pro_description' => 'nullable|string',
            'pro_size' => 'nullable|string|max:50',
            'pro_material' => 'nullable|string|max:50',
            'pro_specification' => 'nullable|string',
        ]);

        $product = Product::create($request->all());

        return response()->json($product, 201);
    }

    /**
     * @OA\Put(
     *      path="/api/products/{id}",
     *      operationId="updateProduct",
     *      tags={"Products"},
     *      summary="Update existing product",
     *      description="Update an existing product",
     *      security={{"bearerAuth":{}}},
     *      @OA\Parameter(
     *          name="id",
     *          description="Product id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              @OA\Property(property="pro_name", type="string", example="Business Card"),
     *              @OA\Property(property="pro_price", type="number", format="float", example=55.00),
     *              @OA\Property(property="pro_category", type="string", example="Cards"),
     *              @OA\Property(property="pro_description", type="string", example="Premium quality business cards"),
     *              @OA\Property(property="pro_size", type="string", example="85x55mm"),
     *              @OA\Property(property="pro_material", type="string", example="350gsm Art Card"),
     *              @OA\Property(property="pro_specification", type="string", example="Full color both sides")
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Product updated successfully",
     *          @OA\JsonContent()
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Product not found"
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Validation error"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthorized"
     *      )
     * )
     */
    public function update(Request $request, $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $request->validate([
            'pro_name' => 'string|max:255',
            'pro_price' => 'numeric|min:0',
            'pro_category' => 'string|max:100',
            'pro_description' => 'nullable|string',
            'pro_size' => 'nullable|string|max:50',
            'pro_material' => 'nullable|string|max:50',
            'pro_specification' => 'nullable|string',
        ]);

        $product->update($request->all());

        return response()->json($product);
    }

    /**
     * @OA\Delete(
     *      path="/api/products/{id}",
     *      operationId="deleteProduct",
     *      tags={"Products"},
     *      summary="Delete existing product",
     *      description="Delete an existing product",
     *      security={{"bearerAuth":{}}},
     *      @OA\Parameter(
     *          name="id",
     *          description="Product id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Product deleted successfully"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Product not found"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthorized"
     *      )
     * )
     */
    public function destroy($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $product->delete();

        return response()->json(['message' => 'Product deleted successfully'], 200);
    }
}
