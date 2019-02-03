<?php
    
    namespace App\Http\Controllers\API;
    
    use Illuminate\Database\Eloquent\ModelNotFoundException;
    use Illuminate\Http\Request;
    use App\Http\Controllers\Controller;
    use Illuminate\Http\JsonResponse;
    use App\Subcription;
    use Validator;
    use App\Products;
    use App\CustomerPhones;
    
    class SubscriptionController extends Controller
    {
        
        /** Gets all subscription
         *
         * @return JsonResponse
         */
        public static function getAll(): JsonResponse
        {
            return response()->json(Subcription::all()->toArray(), 200);
        }
        
        public static function subscribe(SubscribePosts $request): JsonResponse
        {
            $validated = Validator::make($request->all(), $request->rules(),
                $request->messages());
            if ($validated->fails()) {
                response()->json(['UnprocessableEntity:' => $request->messages()], 422);
            }
            // Type casting array to object
            $data = (object)$validated->getData();
            try {
                $existingPhone = CustomerPhones::isPhoneExist($data->msisdn);
            } catch (ModelNotFoundException $e) {
                throwException($e);
            }
            try {
                $existingProduct = Products::findOrFail($data->product_id);
            } catch (ModelNotFoundException $e) {
                throwException($e);
            }
            
            $subcription = SubscribePosts::create([
                'msisdn'     => $data->msisdn,
                'product_id' => $data->product_id,
                'subscribe_date' => now()->toDateTimeString()
            ]);
            return response()->json(['id' => $subcription->id], 200);
        }
    }
