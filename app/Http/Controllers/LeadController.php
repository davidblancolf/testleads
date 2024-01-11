<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use Illuminate\Http\Request;
use App\Http\Requests\CreateLeadRequest;
use App\Http\Requests\UpdateLeadRequest;

class LeadController extends Controller
{
    private $leadScoringService;

    public function __construct()
    {
        //$this->leadScoringService = new LeadScoringService();
    }

    public function index(Request $request){
        $leads = Lead::search($request->input('search'))->paginate(10);
        return view('leads.index',compact('leads'));
    }

    public function create()
    {
        return view('leads.create');
    }

    public function store(CreateLeadRequest $request)
    {
        $lead = Lead::create($request->validationData());
         //$client = new Client();
        //$client->lead_id = $lead->id;
        //$client->save();

        // Interact with external lead scoring system
        //$leadScoringService = new LeadScoringService();
        //$score = $leadScoringService->getLeadScore($lead);
        // $lead->score = $score;
        //$lead->save();
        return redirect()->route('leads.index')
        ->with('success', 'Lead created successfully.');
    }

    public function show(string $id)
    {
        $lead = Lead::find($id);
        if (!$lead) {
            abort(404,'Lead not found');
        }
        return view('leads.show', ['lead' => $lead]);
    }

    public function edit($id)
    {
        $lead = Lead::find($id);
        if (!$lead) {
            abort(404,'Lead not found');
        }
        return view('leads.edit', ['lead' => $lead]);
    }

    public function update(UpdateLeadRequest $request, string $id)
    {
        $lead = Lead::find($id);
        if (!$lead) {
            abort(404,'Lead not found');
        }
        $lead->update($request->validationData());

        // Send lead to scoring system
        //$score = $this->leadScoringService->getLeadScore($lead);
        return redirect()->route('leads.index')
        ->with('success', 'Lead updated successfully');
    }

    public function destroy($id)
    {
        $lead = Lead::find($id);
        if (!$lead) {
            abort(404,'Lead not found');
        }
        $lead->delete();
        return redirect()->route('leads.index')
        ->with('danger', 'Lead deleted successfully');
    }
}
