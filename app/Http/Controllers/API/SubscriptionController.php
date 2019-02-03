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
    use App\Http\Requests\SubscriptionCrud\SubscribePosts;
    
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
    
    
        /** Susbcribes customer phone number to a product
         * @param Request $request
         *
         * @return JsonResponse
         * @throws \Illuminate\Validation\ValidationException
         */
        public function subscribe(Request $request): JsonResponse
        {
            $this->validate($request,['msisdn' => 'required|integer',
                                'product_id' => 'required|integer'
                ],['msisdn.required' => 'Id is required',
                   'msisdn.integer'  => 'This entry can only contain integer',
                   'product_id.required' => 'Id is required',
                   'product_id.integer'  => 'This entry can only contain integer',]);
      
            
            try {
                CustomerPhones::findOrFail($request->msisdn);
            } catch (ModelNotFoundException $e) {
                return response()->json(['ModelNotFound' => $e->getMessage()],404);
            }
            try {
               Products::findOrFail($request->product_id);
            } catch (ModelNotFoundException $e) {
                return response()->json(['ModelNotFound' => $e->getMessage()],404);
            }
            $subcription = new Subcription();
            $subcription->msisdn = $request->msisdn;
            $subcription->product_id = $request->product_id;
            $subcription->subscribe_date = now();
            $subcription->save();
           
            return response()->json($subcription->id, 201);
        }
        
        
        public function unsubscribe(Request $request): JsonResponse
        {
        
        }
        
        
        
    }
