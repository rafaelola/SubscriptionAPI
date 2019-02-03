<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\CustomerPhones;
use Illuminate\Http\JsonResponse;
use Validator;
use App\Http\Requests\PhoneCrud\CreatePhonePosts;
use App\Http\Requests\PhoneCrud\UpdatePhonePosts;

class PhoneController extends Controller
{
    /**
     * Gets All Phone Numbers
     *
     *
     * @return JsonResponse
     */
    public static function getAll() :JsonResponse
    {
        return response()->json(CustomerPhones::all()->toArray(),200);
    }
    
    /** Creates a customer phone number
     * @param CreatePhonePosts $request
     *
     * @return JsonResponse
     */
    public static function createPhone(CreatePhonePosts $request) : JsonResponse
    {
        $validated = Validator::make($request->all(), $request->rules(),
            $request->messages());
        if ($validated->fails()) {
            response()->json(['msg' => $request->messages()], 422);
        }
        // Type casting array to object
        $data = (object)$validated->getData();
        
        $phone = CustomerPhones::create(['phone_no' => $data->phone_no,'display_name' => $data->display_name]);
        return response()->json(['id' => $phone->id], 201);
    }
    
    
    /** Updates a customer phone number
     * @param UpdatePhonePosts $request
     *
     * @return JsonResponse
     */
    public static function updatePhone(UpdatePhonePosts $request): JsonResponse {
        
        $validated = Validator::make($request->all(), $request->rules(),
            $request->messages());
        if ($validated->fails()) {
            response()->json(['msg' => $request->messages()], 422);
        }
        // Type casting array to object
        $data = (object)$validated->getData();
        /**
         * @var $cusPhone CustomerPhones
         */
        $cusPhone = CustomerPhones::findOrFail($data->id);
        $cusPhone->phone_no = $data->phone_no;
        $cusPhone->display_name = $data->display_name;
        $cusPhone->save();
        return response()->json(null, 204);
    }
}
