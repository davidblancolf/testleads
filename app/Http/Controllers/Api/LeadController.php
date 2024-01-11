<?php

namespace App\Http\Controllers\Api;

use App\Models\Lead;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\LeadResource;
use App\Http\Requests\CreateLeadRequest;
use App\Http\Requests\UpdateLeadRequest;
use Illuminate\Http\JsonResponse;

class LeadController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/leads",
     *     summary="index",
     *     tags={"Leads"},
     *     description="get leads",
     *     @OA\Parameter(name="search",description="Search name or email or phone",@OA\Schema(type="string"),in="query"),
     *     @OA\Parameter(name="skip", description="Number of records to skip for pagination", @OA\Schema(type="integer"), in="query"),
     *     @OA\Parameter(name="limit", description="Number of records to display per page", @OA\Schema(type="integer"), in="query"),
     *     @OA\Parameter(name="per_page", description="Number of records per page (alternative to 'limit')", @OA\Schema(type="integer"), in="query"),
     *     @OA\Response(response=200,description="successful operation",@OA\JsonContent(type="object",@OA\Property(property="data",type="string"))),
     *     @OA\Response(response=401,description="Unauthenticated",@OA\JsonContent(type="object",@OA\Property(property="message",type="string"))),
     *     @OA\Response(response=403,description="does not have permissions",@OA\JsonContent(type="object",@OA\Property(property="message",type="string"))),
     *     @OA\Response(response=404,description="Leads not found",@OA\JsonContent(type="object",@OA\Property(property="message",type="string"))),
     * )
     */
    public function index(Request $request)
    {
        $query = Lead::query();
        if ($request->get('search')) $query->skip($request->get('search'));
        if ($request->get('skip')) $query->skip($request->get('skip'));
        if ($request->get('limit')) $query->limit($request->get('limit'));
        if ($request->get('search')) $query->search($request->get('search'));
        $per_page = ($request->get('per_page')) ? $request->get('per_page') : config('paginate.leads');
        $leads = $query->paginate($per_page);
        return  LeadResource::collection($leads);
    }
    /**
     *   @OA\Post(
     *      path="/api/leads",
     *      summary="store",
     *      tags={"Leads"},
     *      description="Create Cliente",
     *      @OA\RequestBody(
     *        required=true,
     *        description="Body Cliente",
     *        @OA\MediaType(
     *            mediaType="multipart/form-data",
     *            @OA\Schema(
     *              type="object",
     *              required={"name","email"},
     *              @OA\Property(property="name", type="string", format="string",description ="Nombre"),
     *              @OA\Property(property="email", type="string", format="string",description ="Email"),
     *              @OA\Property(property="phone", type="string", format="string",description ="Telefono"),
     *            ),
     *        ),
     *      ),
     *      @OA\Response(response=201,description="successful operation",@OA\JsonContent(type="object",@OA\Property(property="data",type="string"),@OA\Property(property="message",type="string"))),
     *      @OA\Response(response=401,description="Unauthenticated",@OA\JsonContent(type="object",@OA\Property(property="message",type="string"))),
     *      @OA\Response(response=403,description="does not have permissions",@OA\JsonContent(type="object",@OA\Property(property="message",type="string"))),
     *      @OA\Response(response=422,description="Unprocessable Entity", @OA\JsonContent(type="object",@OA\Property(property="message",type="string"),@OA\Property(property="errors",type="array",@OA\Items(type="string")))),
     * )
     */
    public function store(CreateLeadRequest $request):JsonResponse
    {
        $lead = Lead::create($request->validationData());
        return response()->json(["data" => new LeadResource($lead)], Response::HTTP_CREATED);
    }
    /**
     * @OA\Get(
     *      path="/api/leads/{id}",
     *      summary="show",
     *      tags={"Leads"},
     *      description="Get Leads",
     *      @OA\Parameter(name="id",description="uuid of Lead",@OA\Schema(type="string"),required=true,in="path"),
     *      @OA\Response(response=200,description="successful operation",@OA\JsonContent(type="object",@OA\Property(property="data",type="array",@OA\Items(type="string")),@OA\Property(property="message",type="string"))),
     *      @OA\Response(response=401,description="Unauthenticated",@OA\JsonContent(type="object",@OA\Property(property="message",type="string"))),
     *      @OA\Response(response=403,description="does not have permissions",@OA\JsonContent(type="object",@OA\Property(property="message",type="string"))),
     *      @OA\Response(response=404,description="Lead not found",@OA\JsonContent(type="object",@OA\Property(property="message",type="string"))),
     * )
     */
    public function show(string $id):JsonResponse
    {
        $lead = Lead::find($id);
        if (!$lead) return response()->json(['message' => 'Lead not found'], Response::HTTP_NOT_FOUND);
        return response()->json(["data" => new LeadResource($lead)], Response::HTTP_OK);
    }
    /**
     * @OA\Put(
     *      path="/api/leads/{id}",
     *      summary="update",
     *      tags={"Leads"},
     *      description="Update Lead ",
     *      @OA\Parameter(name="id",description="uuid of lead",@OA\Schema(type="string"),required=true,in="path"),
     *      @OA\RequestBody(
     *        required=true,
     *        description="Body Lead",
     *        @OA\MediaType(
     *            mediaType="application/x-www-form-urlencoded",
     *            @OA\Schema(
     *              type="object",
     *              required={"name","email"},
     *              @OA\Property(property="name", type="string", format="string",description ="Nombre"),
     *              @OA\Property(property="email", type="string", format="string",description ="Email"),
     *              @OA\Property(property="phone", type="string", format="string",description ="Telefono"),
     *            ),
     *         ),
     *      ),
     *      @OA\Response(response=202,description="successful operation",@OA\JsonContent(type="object",@OA\Property(property="data",type="array", @OA\Items(type="string")),@OA\Property(property="message",type="string"))),
     *      @OA\Response(response=401,description="Unauthenticated",@OA\JsonContent(type="object",@OA\Property(property="message",type="string"))),
     *      @OA\Response(response=403,description="does not have permissions",@OA\JsonContent(type="object",@OA\Property(property="message",type="string"))),
     *      @OA\Response(response=404,description="Lead not found",@OA\JsonContent(type="object",@OA\Property(property="message",type="string"))),
     *      @OA\Response(response=422,description="Unprocessable Entity", @OA\JsonContent(type="object",@OA\Property(property="message",type="string"),@OA\Property(property="errors",type="array",@OA\Items(type="string")))),
     * )
     */
    public function update(UpdateLeadRequest $request, string $id):JsonResponse
    {
        $lead = Lead::find($id);
        if (!$lead) return response()->json(['message' => 'Lead not found'], Response::HTTP_NOT_FOUND);
        $lead->fill($request->validationData());
        $lead->save();
        return response()->json(['data' => new LeadResource($lead), 'message' => 'Lead updated successfully'], Response::HTTP_ACCEPTED);
    }
    /**
     * @OA\Delete(
     *      path="/api/leads/{id}",
     *      summary="destroy",
     *      tags={"Leads"},
     *      description="Delete Lead",
     *      @OA\Parameter(name="id",description="uuid of Lead",@OA\Schema(type="string"),required=true,in="path"),
     *      @OA\Response(response=202,description="successful operation",@OA\JsonContent(type="object",@OA\Property(property="message",type="string"))),
     *      @OA\Response(response=401,description="Unauthenticated",@OA\JsonContent(type="object",@OA\Property(property="message",type="string"))),
     *      @OA\Response(response=403,description="does not have permissions",@OA\JsonContent(type="object",@OA\Property(property="message",type="string"))),
     *      @OA\Response(response=404,description="Lead not found",@OA\JsonContent(type="object",@OA\Property(property="message",type="string")))
     * )
     */
    public function destroy(string $id):JsonResponse
    {
        $lead = Lead::find($id);
        if (!$lead) return response()->json(['message' => 'Lead not found'], Response::HTTP_NOT_FOUND);
        $lead->forceDelete();
        return response()->json(['message' => 'Lead deleted successfully'], Response::HTTP_ACCEPTED);
    }
}
