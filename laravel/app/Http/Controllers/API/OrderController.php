<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * @OA\Get(
     *      path="/api/orders",
     *      operationId="getOrdersList",
     *      tags={"Orders"},
     *      summary="Get list of orders",
     *      description="Returns list of authenticated user's orders",
     *      security={{"bearerAuth":{}}},
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthorized"
     *      )
     * )
     */
    public function index(Request $request)
    {
        $orders = Order::where('email', $request->user()->email)->orderBy('created_at', 'desc')->get();
        return response()->json($orders);
    }

    /**
     * @OA\Get(
     *      path="/api/orders/{id}",
     *      operationId="getOrderById",
     *      tags={"Orders"},
     *      summary="Get order information",
     *      description="Returns order data",
     *      security={{"bearerAuth":{}}},
     *      @OA\Parameter(
     *          name="id",
     *          description="Order id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Order not found"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthorized"
     *      )
     * )
     */
    public function show(Request $request, $id)
    {
        $order = Order::find($id);

        if (!$order || $order->email !== $request->user()->email) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        return response()->json($order);
    }

    /**
     * @OA\Post(
     *      path="/api/orders",
     *      operationId="storeOrder",
     *      tags={"Orders"},
     *      summary="Create new order",
     *      description="Create a new order",
     *      security={{"bearerAuth":{}}},
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              @OA\Property(property="product", type="string", example="Business Cards"),
     *              @OA\Property(property="size", type="string", example="85x55mm"),
     *              @OA\Property(property="material", type="string", example="300gsm Art Card"),
     *              @OA\Property(property="quantity", type="integer", example=100),
     *              @OA\Property(property="price", type="number", format="float", example=50.00),
     *              @OA\Property(property="name", type="string", example="John Doe"),
     *              @OA\Property(property="phone", type="string", example="+852 1234 5678"),
     *              @OA\Property(property="email", type="string", format="email", example="john@example.com"),
     *              @OA\Property(property="file", type="string", nullable=true, example="design.pdf")
     *          )
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Order created successfully"
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
            'product' => 'required|string|max:255',
            'size' => 'required|string|max:50',
            'material' => 'required|string|max:50',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'name' => 'required|string|max:255',
            'phone' => 'required|string',
            'email' => 'required|email',
            'file' => 'nullable|string',
        ]);

        $order = Order::create([
            'product' => $request->product,
            'size' => $request->size,
            'material' => $request->material,
            'quantity' => $request->quantity,
            'price' => $request->price,
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'file' => $request->file,
            'status' => 'pending',
        ]);

        return response()->json($order, 201);
    }
}
