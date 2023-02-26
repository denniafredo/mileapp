<?php

namespace App\Http\Controllers;

use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

  
class PackageController extends Controller
{
    /**
     * @OA\Get(
     *     path="api/packages",
     *     tags={"Package"},
     *     summary="Get list of packages",
     *     description="Return list of packages",
     *     @OA\Response(
     *         response="200",
     *         description="successful operation",
     *         @OA\JsonContent(
    *                @OA\Property(property="message", type="string", format="array", example="{data:[package_data]}"),
    *           )
    *       ),
     * 
     * )
     */
    public function index()
    {
        $package = Package::with('connote','koli_data')->get();
        $package = $this->rename_id($package);
        return response()->json([
            'data' => $package
        ], Response::HTTP_OK);     
    }


    /**
     * @OA\Get(
     *     path="api/package/{id}",
     *     tags={"Package"},
     *     operationId="getPackageById",
     *     summary="Get package information",
     *     description="Return package information",
     *     @OA\Parameter(
     *          name="id",
     *          description="Package id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="successful operation",
     *         @OA\JsonContent(
    *                @OA\Property(property="message", type="string", format="array", example="{data:package_data}"),
    *           )
    *       ),
     *    )
     * )
     */
    public function show($id)
    {   
        $package = Package::with('connote','koli_data')->where('_id',$id)->get();
        if(count($package) > 0){
            $package = $this->rename_id($package);
            return response()->json([
                'data' => $package
            ], Response::HTTP_OK);        
        }
        else{
            return response()->json([
                'message' => 'Package Not Found',
                'data' => $package
            ], Response::HTTP_OK);
        }
    }
    
    /**
     * @OA\Post(
     *     path="api/package",
     *     tags={"Package"},
     *     operationId="storePackage",
     *     summary="Store new package",
     *     description="Request Body Credential",
    * @OA\RequestBody(
    *    required=true,
    *    description="Pass user credentials",
    *    @OA\JsonContent(
    *       required={"transaction_id","customer_name","customer_code",
    *                 "transaction_amount","transaction_discount","transaction_additional_field",
    *               "transaction_payment_type","transaction_state","transaction_code","transaction_order",
    *               "location_id","organization_id","created_at","updated_at","transaction_payment_type_name",
    *               "transaction_cash_amount","transaction_cash_change","customer_attribute","connote_id","origin_data","destination_data","custom_field","currentLocation"
    *               },
    *       @OA\Property(property="transaction_id", type="string", example="d0090c40-539f-479a-8274-899b9970bddc"),
    *       @OA\Property(property="customer_name", type="string", example="PT. AMARA PRIMATIGA"),
    *       @OA\Property(property="customer_code", type="string", example="1678593"),
    *       @OA\Property(property="transaction_amount", type="string", example="70700"),
    *       @OA\Property(property="transaction_discount", type="string", example="0"),
    *       @OA\Property(property="transaction_additional_field", type="string", example=""),
    *       @OA\Property(property="transaction_payment_type", type="string", example="29"),
    *       @OA\Property(property="transaction_state", type="string", example="PAID"),
    *       @OA\Property(property="transaction_code", type="string", example="CGKFT20200715121"),
    *       @OA\Property(property="transaction_order", type="string", example="121"),
    *       @OA\Property(property="location_id", type="string", example="5cecb20b6c49615b174c3e74"),
    *       @OA\Property(property="organization_id", type="number", example=6),
    *       @OA\Property(property="created_at", type="date", example="2020-07-15T04:11:12.000000Z"),
    *       @OA\Property(property="updated_at", type="date", example="2020-07-15T04:11:12.000000Z"),
    *       @OA\Property(property="transaction_payment_type_name", type="string", example="Invoice"),
    *       @OA\Property(property="transaction_cash_amount", type="number", example=0),
    *       @OA\Property(property="transaction_cash_change", type="number", example=0),
    *       @OA\Property(property="customer_attribute", type="string", format="array", example={"Nama_Sales":"Radit Fitrawikarsa","TOP":"14 Hari","Jenis_Pelanggan":"B2B"}),  
    *       @OA\Property(property="connote_id", type="string" , example="f70670b1-c3ef-4caf-bc4f-eefa702092ed"),
    *       @OA\Property(property="origin_data", type="string", format="array", example={"customer_name":"PT. NARA OKA PRAKARSA","customer_address":"JL. KH. AHMAD DAHLAN NO. 100, SEMARANG TENGAH 12420","customer_email":"info@naraoka.co.id","customer_phone":"024-1234567","customer_address_detail":null,"customer_zip_code":"12420","zone_code":"CGKFT","organization_id":"6","location_id":"5cecb20b6c49615b174c3e74"}), 
    *       @OA\Property(property="destination_data", type="string", format="array", example={"customer_name":"PT AMARIS HOTEL SIMPANG LIMA","customer_address":"JL. KH. AHMAD DAHLAN NO. 01, SEMARANG TENGAH","customer_email":"null","customer_phone":"0248453499","customer_address_detail":"KOTA SEMARANG SEMARANG TENGAH KARANGKIDUL","customer_zip_code":"50241","zone_code":"SMG","organization_id":"6","location_id":"5cecb20b6c49615b174c3e74"}), 
    *       @OA\Property(property="custom_field", type="string", format="array", example={"catatan_tambahan":"JANGAN DI BANTING \\/ DI TINDIH"}), 
    *       @OA\Property(property="currentLocation", type="string", format="array", example={"name":"Hub Jakarta Selatan","code":"JKTS01","type":"Agent"}), 
    *    ),
    * ),
    * @OA\Response(
    *    response=201,
    *    description="Package created",
    *    @OA\JsonContent(
    *       @OA\Property(property="message", type="string", example="Package created"),
    *       @OA\Property(property="data", type="boolean", example="1")
    *        )
    *     ),
    * @OA\Response(
    *    response=409,
    *    description="Conflict",
    *    @OA\JsonContent(
    *       @OA\Property(property="message", type="string", example="Error : Conflict message")
    *        )
    *     ),
    * @OA\Response(
    *    response=422,
    *    description="Unprocessable Request Body",
    *    @OA\JsonContent(
    *       @OA\Property(property="message", type="string", example="Error validation"),
    *        )
    *     )
    * )
    *      
    * )
    */
    public function store(Request $request)
    {
        
        $validator = Validator::make($request->all(), $this->rules($request));
        if($validator->fails()){
            return response()->json($validator->errors(),
            Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        try {
            // $package = Package::create($request->all());
            $package = DB::connection('mongodb')->collection('package')
                        ->insert($request->all());
            $response = [
                'message' => 'Package created',
                'data' => $package
            ];
            return response()->json($response,Response::HTTP_CREATED);
        } catch (\Exception $e) {
            $response = [
                'message' => 'Error : ' . $e->getMessage()
            ];
            return response()->json($response,Response::HTTP_CONFLICT);
        }
    }

    /**
     * @OA\Put(
     *     path="api/package",
     *     tags={"Package"},
     *     operationId="updatePackage",
     *     summary="Update existing package",
     *     description="Return update status",
    * @OA\RequestBody(
    *    required=true,
    *    description="Request Body Credential",
    *    @OA\JsonContent(
    *       required={"transaction_id","customer_name","customer_code",
    *                 "transaction_amount","transaction_discount","transaction_additional_field",
    *               "transaction_payment_type","transaction_state","transaction_code","transaction_order",
    *               "location_id","organization_id","created_at","updated_at","transaction_payment_type_name",
    *               "transaction_cash_amount","transaction_cash_change","customer_attribute","connote_id","origin_data","destination_data","custom_field","currentLocation"
    *               },
    *       @OA\Property(property="transaction_id", type="string", example="d0090c40-539f-479a-8274-899b9970bddc"),
    *       @OA\Property(property="customer_name", type="string", example="PT. AMARA PRIMATIGA"),
    *       @OA\Property(property="customer_code", type="string", example="1678593"),
    *       @OA\Property(property="transaction_amount", type="string", example="70700"),
    *       @OA\Property(property="transaction_discount", type="string", example="0"),
    *       @OA\Property(property="transaction_additional_field", type="string", example=""),
    *       @OA\Property(property="transaction_payment_type", type="string", example="29"),
    *       @OA\Property(property="transaction_state", type="string", example="PAID"),
    *       @OA\Property(property="transaction_code", type="string", example="CGKFT20200715121"),
    *       @OA\Property(property="transaction_order", type="string", example="121"),
    *       @OA\Property(property="location_id", type="string", example="5cecb20b6c49615b174c3e74"),
    *       @OA\Property(property="organization_id", type="number", example=6),
    *       @OA\Property(property="created_at", type="date", example="2020-07-15T04:11:12.000000Z"),
    *       @OA\Property(property="updated_at", type="date", example="2020-07-15T04:11:12.000000Z"),
    *       @OA\Property(property="transaction_payment_type_name", type="string", example="Invoice"),
    *       @OA\Property(property="transaction_cash_amount", type="number", example=0),
    *       @OA\Property(property="transaction_cash_change", type="number", example=0),
    *       @OA\Property(property="customer_attribute", type="string", format="array", example={"Nama_Sales":"Radit Fitrawikarsa","TOP":"14 Hari","Jenis_Pelanggan":"B2B"}),  
    *       @OA\Property(property="connote_id", type="string" , example="f70670b1-c3ef-4caf-bc4f-eefa702092ed"),
    *       @OA\Property(property="origin_data", type="string", format="array", example={"customer_name":"PT. NARA OKA PRAKARSA","customer_address":"JL. KH. AHMAD DAHLAN NO. 100, SEMARANG TENGAH 12420","customer_email":"info@naraoka.co.id","customer_phone":"024-1234567","customer_address_detail":null,"customer_zip_code":"12420","zone_code":"CGKFT","organization_id":"6","location_id":"5cecb20b6c49615b174c3e74"}), 
    *       @OA\Property(property="destination_data", type="string", format="array", example={"customer_name":"PT AMARIS HOTEL SIMPANG LIMA","customer_address":"JL. KH. AHMAD DAHLAN NO. 01, SEMARANG TENGAH","customer_email":"null","customer_phone":"0248453499","customer_address_detail":"KOTA SEMARANG SEMARANG TENGAH KARANGKIDUL","customer_zip_code":"50241","zone_code":"SMG","organization_id":"6","location_id":"5cecb20b6c49615b174c3e74"}), 
    *       @OA\Property(property="custom_field", type="string", format="array", example={"catatan_tambahan":"JANGAN DI BANTING \\/ DI TINDIH"}), 
    *       @OA\Property(property="currentLocation", type="string", format="array", example={"name":"Hub Jakarta Selatan","code":"JKTS01","type":"Agent"}), 
    *    ),
    * ),
    * @OA\Response(
    *    response=200,
    *    description="Package updated",
    *    @OA\JsonContent(
    *       @OA\Property(property="message", type="string", example="Package updated"),
    *       @OA\Property(property="data", type="boolean", example="1")
    *        )
    *     ),
    * @OA\Response(
    *    response=409,
    *    description="Conflict",
    *    @OA\JsonContent(
    *       @OA\Property(property="message", type="string", example="Error : Conflict message")
    *        )
    *     ),
    * @OA\Response(
    *    response=422,
    *    description="Unprocessable Request Body",
    *    @OA\JsonContent(
    *       @OA\Property(property="message", type="string", example="Error validation"),
    *        )
    *     )
    *   )
    *      
    * )
    */
    public function update(Request $request,$id)
    {
        $package = Package::with('connote','koli_data')->where('_id',$id)->get();
        if(count($package) == 0){
            return response()->json([
                'message' => 'Package not found',
                'data' => $package
            ],
            Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $validator = Validator::make($request->all(), $this->rules($request));
        if($validator->fails()){
            return response()->json($validator->errors(),
            Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        try {
            // $package = Package::create($request->all());
            $package = DB::connection('mongodb')->collection('package')
                        ->where('_id',$id)->update($request->all());
            $response = [
                'message' => 'Package updated',
                'data' => $package
            ];
            return response()->json($response,Response::HTTP_OK);
        } catch (\Exception $e) {
            $response = [
                'message' => 'Error : ' . $e->getMessage()
            ];
            return response()->json($response,Response::HTTP_CONFLICT);
        }
    }

    /**
     * @OA\Patch(
     *     path="api/package",
     *     tags={"Package"},
     *     operationId="patchPackage",
     *     summary="Patch existing package",
     *     description="Return patch status",
    * @OA\RequestBody(
    *    required=true,
    *    description="Request Body Credential",
    *    @OA\JsonContent(
    *       @OA\Property(property="customer_name", type="string", example="PT. AMARA PRIMATIGA"),
    *        )
    *     ),
    * @OA\Response(
    *    response=200,
    *    description="Package patched",
    *    @OA\JsonContent(
    *       @OA\Property(property="message", type="string", example="Package patched"),
    *       @OA\Property(property="data", type="boolean", example="1")
    *        )
    *     ),
    * @OA\Response(
    *    response=409,
    *    description="Conflict",
    *    @OA\JsonContent(
    *       @OA\Property(property="message", type="string", example="Error : Conflict message")
    *        )
    *     ),
    * @OA\Response(
    *    response=422,
    *    description="Unprocessable Request Body",
    *    @OA\JsonContent(
    *       @OA\Property(property="message", type="string", example="Error validation"),
    *        )
    *     )
    *   )
    *      
    * )
    */
    public function patch(Request $request,$id)
    {
        // return $this->rules($request);
        $package = Package::with('connote','koli_data')->where('_id',$id)->get();
        if(count($package) == 0){
            return response()->json([
                'message' => 'Package not found',
                'data' => $package
            ],
            Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $validator = Validator::make($request->all(), $this->rules($request));
        if($validator->fails()){
            return response()->json($validator->errors(),
            Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        try {
            $package = DB::connection('mongodb')->collection('package')
                        ->where('_id',$id)->update($request->all());
            $response = [
                'message' => 'Package patched',
                'data' => $package
            ];
            return response()->json($response,Response::HTTP_OK);
        } catch (\Exception $e) {
            $response = [
                'message' => 'Error : ' . $e->getMessage()
            ];
            return response()->json($response,Response::HTTP_CONFLICT);
        }
    }

    /**
     * @OA\Delete(
     *     path="api/package/{id}",
     *     tags={"Package"},
     *     operationId="deletePackageById",
     *     summary="Delete package information",
     *     description="Return delete status",
     *     @OA\Parameter(
     *          name="id",
     *          description="Package id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Package deleted",
     *      @OA\JsonContent(
    *            @OA\Property(property="message", type="string", example="Package deleted"),
    *            @OA\Property(property="data", type="boolean", example=true),
    *        )
     *     ),
     *   @OA\Response(
    *    response=409,
    *    description="Conflict",
    *    @OA\JsonContent(
    *       @OA\Property(property="message", type="string", example="Error : Conflict message")
    *        )
    *     ),
     *   @OA\Response(
    *    response=422,
    *    description="Unprocessable Request Body",
    *    @OA\JsonContent(
    *       @OA\Property(property="message", type="string", example="Error validation"),
    *        )
    *     )
     * )
     */
    public function destroy($id)
    {
        $package = Package::with('connote','koli_data')->where('_id',$id)->get();
        if(count($package) == 0){
            return response()->json([
                'message' => 'Package not found',
                'data' => $package
            ],
            Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        try {
            $package = Package::with('connote','koli_data')->where('_id',$id)->delete();
            $response = [
                'message' => 'Package deleted',
                'data' => $package
            ];
            return response()->json($response,Response::HTTP_OK);
        } catch (\Exception $e) {
            $response = [
                'message' => 'Error : ' . $e->getMessage()
            ];
            return response()->json($response,Response::HTTP_CONFLICT);
        }
    }

    public function rename_id($package){
        foreach($package as $pkg){
            $pkg->connote->connote_id = $pkg->connote->_id;
            unset($pkg->connote->_id);
            foreach($pkg->koli_data as $kd){
                $kd->koli_id = $kd->_id;
                unset($kd->_id);
            }
        }
        return $package;
    }
    public function rules($request){
            $arr = [
                'customer_name'=> 'required|string|max:255|min:3',
                'customer_code'=> 'required|numeric',
                'transaction_amount'=> 'required|numeric',
                'transaction_discount'=> 'required|numeric',
                'transaction_additional_field'=> "string|nullable",
                'transaction_payment_type'=> 'required|numeric',
                'transaction_state'=> 'required|string|max:255',
                'transaction_code'=> 'required|string|max:255',
                'transaction_order'=> 'required|numeric',
                'location_id'=> 'required|string|max:255',
                'organization_id'=> 'required|numeric',
                'created_at'=> 'required|date',
                'updated_at'=> 'required|date',
                'transaction_payment_type_name'=> 'required|string|max:255',
                'transaction_cash_amount'=> 'required|numeric',
                'transaction_cash_change'=> 'required|numeric',
                'customer_attribute.Nama_Sales' => 'required|string|max:255',
                'customer_attribute.TOP' => 'required|string|max:255',
                'customer_attribute.Jenis_Pelanggan' => 'required|string|max:255',
                'connote_id'=> 'required|string|max:255',
                'origin_data.customer_name'=> 'required|string|max:255',
                'origin_data.customer_address'=> 'required|string|max:255',
                'origin_data.customer_email'=> 'required|string|email|max:255',
                'origin_data.customer_phone'=> 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
                'origin_data.customer_address_detail'=> 'nullable',
                'origin_data.customer_zip_code'=> 'required|numeric',
                'origin_data.zone_code'=> 'required|string|max:255',
                'origin_data.organization_id'=> 'required|numeric',
                'origin_data.location_id'=>'required|string|max:255',
                'destination_data.customer_name'=> 'required|string|max:255',
                'destination_data.customer_address'=> 'required|string|max:255',
                'destination_data.customer_email'=> 'nullable|string|email|max:255',
                'destination_data.customer_phone'=> 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
                'destination_data.customer_address_detail'=> 'nullable',
                'destination_data.customer_zip_code'=> 'required|numeric',
                'destination_data.zone_code'=> 'required|string|max:255',
                'destination_data.organization_id'=> 'required|numeric',
                'destination_data.location_id'=>'required|string|max:255',
                'custom_field.catatan_tambahan'=>'nullable|string',
                'currentLocation.name'=>'required|string',
                'currentLocation.code'=>'required|string',
                'currentLocation.type'=>'required|string',
            ];
            if($request->isMethod('patch')){
                $newRules = new \stdClass;
                foreach ($request->all() as $key => $part) {
                    $newRules->$key = $arr[$key];
                }
                return (array)$newRules;
            }
        return $arr;
    }
}
