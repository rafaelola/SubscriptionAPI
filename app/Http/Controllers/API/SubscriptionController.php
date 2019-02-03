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
            return response()->json(Subcription::where('deleted_at', null)->get(), 200);
        }
        
        
        /** Susbcribes customer phone number to a product
         *
         * @param Request $request
         *
         * @return JsonResponse
         * @throws \Illuminate\Validation\ValidationException
         */
        public function subscribe(Request $request): JsonResponse
        {
            $this->validate($request, [
                'msisdn'     => 'required|integer',
                'product_id' => 'required|integer'
            ], [
                'msisdn.required'     => 'Id is required',
                'msisdn.integer'      => 'This entry can only contain integer',
                'product_id.required' => 'Id is required',
                'product_id.integer'  => 'This entry can only contain integer',
            ]);
            
            
            try {
                CustomerPhones::findOrFail($request->msisdn);
            } catch (ModelNotFoundException $e) {
                return response()->json(['ModelNotFound' => $e->getMessage()], 404);
            }
            try {
                Products::findOrFail($request->product_id);
            } catch (ModelNotFoundException $e) {
                return response()->json(['ModelNotFound' => $e->getMessage()], 404);
            }
            $subcription = new Subcription();
            $subcription->msisdn = $request->msisdn;
            $subcription->product_id = $request->product_id;
            $subcription->subscribe_date = now();
            $subcription->save();
            
            return response()->json($subcription->id, 200);
        }
        
        
        public function unsubscribe(Request $request): JsonResponse
        {
            $this->validate($request, [
                'msisdn'     => 'required|integer',
                'product_id' => 'nullable|integer'
            ], [
                'msisdn.required'    => 'Id is required',
                'msisdn.integer'     => 'This entry can only contain integer',
                'product_id.integer' => 'This entry can only contain integer',
            ]);
            try {
                CustomerPhones::findOrFail($request->msisdn);
            } catch (ModelNotFoundException $e) {
                return response()->json(['ModelNotFound' => $e->getMessage()], 404);
            }
            if (isset($request->product_id)) {
                try {
                    Products::findOrFail($request->product_id);
                    
                } catch (ModelNotFoundException $e) {
                    return response()->json(['ModelNotFound' => $e->getMessage()], 404);
                }
                try {
                    $foundMSIDNProId = Subcription::findByMsisdnProId($request->msisdn,$request->product_id);
                } catch (ModelNotFoundException $e) {
                    return response()->json(['ModelNotFound' => $e->getMessage()], 404);
                }
                if(null !== $foundMSIDNProId){
                    $qrySubMPro = Subcription::findOrFail($foundMSIDNProId[0]['id']);
                    $qrySubMPro->unsubscribe_date = now();
                    $qrySubMPro->deleted_at = now();
                    $qrySubMPro->save();
                    return response()->json(null, 200);
                }
                return response()->json(['ModelNotFound'], 404);
            }
            
            
            try {
                $foundMSIDN = Subcription::findByMsisdn($request->msisdn);
            } catch (ModelNotFoundException $e) {
                return response()->json(['ModelNotFound' => $e->getMessage()], 404);
            }
            
            if (null !== $foundMSIDN) {
                if (\count($foundMSIDN) > 1) {
                
                    foreach ($foundMSIDN as $id) {
                        $massSub = Subcription::findOrFail($id['id']);
                        $massSub->unsubscribe_date = now();
                        $massSub->deleted_at = now();
                        $massSub->save();
                    }
        
                    return response()->json(null, 200);
                }
                $qrySub = Subcription::findOrFail($foundMSIDN[0]['id']);
                $qrySub->unsubscribe_date = now();
                $qrySub->deleted_at = now();
                $qrySub->save();
    
                return response()->json(null, 200);
    
            }
            return response()->json(['ModelNotFound'], 404);
            
        }
        
        
    }
