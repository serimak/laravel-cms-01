<?php

namespace App\Http\Controllers;

use App\Models\ResRegistration;
use App\Models\ResResponsiblePerson;
use App\Models\ResResearcher;
use App\Models\ResFiscalYear;
use App\Models\ResBudgetType;
use App\Models\ResAgencyResponsible;
use App\Models\ResJobStatus;
use App\Models\ResAbstract;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;

class ResRegistrationController extends Controller
{
  private $_data = [];

  private function getPermissions( $request, $r=nulll, $w=null, $d=null, $s=null )
  {
      $permissions = \Request::get('permissions');

      if(@$permissions[$request->segment(1)]['sub']) {

          $ps['menu_read']   = $r;
          $ps['menu_write']  = $w;
          $ps['menu_delete'] = $d;
          $ps['menu_super']  = $s;

          $mainmenu = $permissions[$request->segment(1)]['main'];

          if(array_intersect_assoc($mainmenu, $ps)) {

              $pss['submenu_read']   = $r;
              $pss['submenu_write']  = $w;
              $pss['submenu_delete'] = $d;
              $pss['submenu_super']  = $s;

              $submenu = $permissions[$request->segment(1)]['sub'][$request->segment(2)];

              return array_intersect_assoc($submenu, $pss);
          } else {

              return null;
          }

      } else {

          $ps['menu_read']   = $r;
          $ps['menu_write']  = $w;
          $ps['menu_delete'] = $d;
          $ps['menu_super']  = $s;

          $mainmenu = $permissions[$request->segment(1)]['main'];

          return array_intersect_assoc($mainmenu, $ps);
      }
  }

  private function flash_messages($request, $status, $messages)
  {
      $request->session()->flash('flash_messages', ['status' => $status, 'messages' => $messages]);
  }

  private function _validator(array $data)
  {
    // dd($data);
    return Validator::make($data,
        [
          'project_name_th' => 'required|string|max:1024',
        //'project_name_en' => 'nullable|string|max:1024|regex:/(^[A-Za-z0-9 _~\-+!@#<=>:;.,\?\/\$%\^&\*\(\)\[\]\"\'\{\}\`]+$)+/',
          'fiscal_year_id' => 'required|integer',
          'budget_type_id' => 'required|integer',
          'research_advisor' => 'nullable',
          'research_leader' => 'nullable',
          'research_researcher' => 'nullable',
          'agency_responsible_id' => 'required|integer',
          'budget_allocated' => 'required|numeric',
          'job_status_id' => 'required|integer',
          'start_date' => 'nullable',
          'end_date' => 'nullable',
          'date_of_submission' => 'nullable'
        ],
        [
        //'project_name_en.regex'    => 'Field "Project name english" allow user type only English characters, numbers and special characters',
        //'start_date.regex'         => 'รูปแบบ วัน/เดือน/ปี พ.ศ. ไม่ถูกต้อง กรุณากรอกในรูปแบบ DD/MM/YYYY ตัวอย่างเช่น 01/06/2561',
        //'end_date.regex'           => 'รูปแบบ วัน/เดือน/ปี พ.ศ. ไม่ถูกต้อง กรุณากรอกในรูปแบบ DD/MM/YYYY ตัวอย่างเช่น 01/06/2561',
        //'date_of_submission.regex' => 'รูปแบบ วัน/เดือน/ปี พ.ศ. ไม่ถูกต้อง กรุณากรอกในรูปแบบ DD/MM/YYYY ตัวอย่างเช่น 01/06/2561'
        ]
    );
  }

  public function index(Request $request)
  {
        // if(count($this->getPermissions($request, 1))==1) { // R, W, D, S

        //     $resRegLists = ResRegistration::orderBy('id', 'asc')->get();

        //     foreach ($resRegLists as $key => $value) {

        //         $this->_data['result'][$key] = $value;

        //         $this->_data['result'][$key]['fiscal_year_id']        = @ResFiscalYear::find($value['fiscal_year_id'])->name_th;
        //         $this->_data['result'][$key]['budget_type_id']        = @ResBudgetType::find($value['budget_type_id'])->name_th;
        //         $this->_data['result'][$key]['agency_responsible_id'] = @ResAgencyResponsible::find($value['agency_responsible_id'])->name_th;
        //         $this->_data['result'][$key]['job_status_id']         = @ResJobStatus::find($value['job_status_id'])->name_th;
        //         $this->_data['result'][$key]['start_date']            = $value['start_date'] ? Carbon::parse($value['start_date'])->addYear(543)->format('d/m/Y') : ""; //$value['start_date'] ? date('d/m/Y', strtotime($value['start_date'])) : "";
        //         $this->_data['result'][$key]['end_date']              = $value['end_date'] ? Carbon::parse($value['end_date'])->addYear(543)->format('d/m/Y') : "";
        //         $this->_data['result'][$key]['date_of_submission']    = $value['date_of_submission'] ? Carbon::parse($value['date_of_submission'])->addYear(543)->format('d/m/Y') : "";
        //     }

        //     return view('ResRegistration.list')->with($this->_data);

        // } else {

        //     return response()->json([]);

        // }

      $resRegLists = DB::table('res_registration')
                      ->leftJoin('res_fiscal_year', 'res_fiscal_year.id', '=', 'res_registration.fiscal_year_id')
                      ->leftJoin('res_budget_type', 'res_budget_type.id', '=', 'res_registration.budget_type_id')
                      ->leftJoin('res_agency_responsible', 'res_agency_responsible.id', '=', 'res_registration.agency_responsible_id')
                      ->leftJoin('res_job_status', 'res_job_status.id', '=', 'res_registration.job_status_id')
                      ->select(DB::raw('res_registration.id, res_registration.project_name_th, res_registration.project_name_en, res_registration.research_advisor, res_registration.research_leader, res_registration.research_researcher, res_fiscal_year.name_th AS fiscal_year_id, res_budget_type.name_th AS budget_type_id, res_agency_responsible.name_th AS agency_responsible_id, res_registration.budget_allocated, res_registration.start_date, res_registration.end_date, res_job_status.name_th AS job_status_id, res_registration.date_of_submission, res_registration.created_by, res_registration.updated_by, res_registration.created_at, res_registration.updated_at'))
                      ->get();

      foreach ($resRegLists as $key => $value) {
          //dd($value->start_date);
          $this->_data['result'][$key] = $value;

          $this->_data['result'][$key]->start_date         = $value->start_date ? Carbon::parse($value->start_date)->addYear(543)->format('d/m/Y') : "";
          $this->_data['result'][$key]->end_date           = $value->end_date ? Carbon::parse($value->end_date)->addYear(543)->format('d/m/Y') : "";
          $this->_data['result'][$key]->date_of_submission = $value->date_of_submission ? Carbon::parse($value->date_of_submission)->addYear(543)->format('d/m/Y') : "";
      }
      //dd($this->_data['result']);
      return view('ResRegistration.list')->with($this->_data);
  }

  public function view(Request $request, $id)
  {
    if(count($this->getPermissions($request, 1))==1) { // R, W, D, S

      $value = ResRegistration::find($id);

      $this->_data['result'] = $value;
      $this->_data['result']['fiscal_year_id']        = @ResFiscalYear::find($value['fiscal_year_id'])->name_th;
      $this->_data['result']['budget_type_id']        = @ResBudgetType::find($value['budget_type_id'])->name_th;
      $this->_data['result']['agency_responsible_id'] = @ResAgencyResponsible::find($value['agency_responsible_id'])->name_th;
      $this->_data['result']['job_status_id']         = @ResJobStatus::find($value['job_status_id'])->name_th;
      $this->_data['result']['start_date']            = $value['start_date'] ? Carbon::parse($value['start_date'])->addYear(543)->format('d/m/Y') : ""; //$value['start_date'] ? date('d/m/Y', strtotime($value['start_date'])) : "";
      $this->_data['result']['end_date']              = $value['end_date'] ? Carbon::parse($value['end_date'])->addYear(543)->format('d/m/Y') : "";
      $this->_data['result']['date_of_submission']    = $value['date_of_submission'] ? Carbon::parse($value['date_of_submission'])->addYear(543)->format('d/m/Y') : "";

      $resAbstract = @ResAbstract::where('res_registration_id', $value['id'])->first();
      $this->_data['result']['abstract_th'] = $resAbstract ? $resAbstract->abstract_th : "";
      //dd($this->_data);
      return view('ResRegistration.view')->with($this->_data);

    } else {

        return response()->json([]);

    }
  }

  public function create(Request $request)
  {
    if(count($this->getPermissions($request, 1, 1))==2) { // R, W, D, S

      if($request->isMethod('post')) {
        //dd($request);
        $validator = $this->_validator($request->all());
        if ($validator->fails()) {
            return redirect()->route('resRegis.add')
                             ->withErrors($validator)
                             ->withInput();
        }

        $advisorWithComma = "";
        $advisors = $request->advisors ? count($request->advisors) : 0;
        if ($advisors > 0) {
          $posi = 0;
          for ($i = 0; $i < $advisors; $i++ ) {
            if(trim($request->advisors[$i]) != ''){
              if($posi == 0){
                $posi = 1;
                $advisorWithComma = $advisorWithComma . $request->advisors[$i];
              }else{
                $advisorWithComma = $advisorWithComma . ', ' . $request->advisors[$i];
              }
            }
          }
        }

        $leaderWithComma = "";
        $leaders = $request->leaders ? count($request->leaders) : 0;
        if ($leaders > 0) {
          $posj = 0;
          for ($i = 0; $i < $leaders; $i++ ) {
            if(trim($request->leaders[$i]) != ''){
              if($posj == 0){
                $posj = 1;
                if(trim($request->leader_percents[$i]) != ''){
                  $leaderWithComma = $leaderWithComma . $request->leaders[$i] . '(' . $request->leader_percents[$i] . '%)';
                }else{
                  $leaderWithComma = $leaderWithComma . $request->leaders[$i] . '(0%)';
                }
              }else{
                if(trim($request->leader_percents[$i]) != ''){
                  $leaderWithComma = $leaderWithComma . ', ' . $request->leaders[$i] . '(' . $request->leader_percents[$i] . '%)';
                }else{
                  $leaderWithComma = $leaderWithComma . ', ' . $request->leaders[$i] . '(0%)';
                }
              }
            }
          }
        }

        $researcherWithComma = "";
        $researchers = $request->researchers ? count($request->researchers) : 0;
        if ($researchers > 0) {
          $posk = 0;
          for ($i = 0; $i < $researchers; $i++ ) {
            if(trim($request->researchers[$i]) != ''){
              if($posk == 0){
                $posk = 1;
                if(trim($request->researcher_percents[$i]) != ''){
                  $researcherWithComma = $researcherWithComma . $request->researchers[$i] . '(' . $request->researcher_percents[$i] . '%)';
                }else{
                  $researcherWithComma = $researcherWithComma . $request->researchers[$i] . '(0%)';
                }
              }else{
                if(trim($request->researcher_percents[$i]) != ''){
                  $researcherWithComma = $researcherWithComma . ', ' . $request->researchers[$i] . '(' . $request->researcher_percents[$i] . '%)';
                }else{
                  $researcherWithComma = $researcherWithComma . ', ' . $request->researchers[$i] . '(0%)';
                }
              }
            }
          }
        }

        $resReg = new ResRegistration;
        $resReg->project_name_th = $request->project_name_th;
      //$resReg->project_name_en = $request->project_name_en;
        $resReg->fiscal_year_id = $request->fiscal_year_id;
        $resReg->budget_type_id = $request->budget_type_id;
        $resReg->research_advisor = $advisorWithComma;
        $resReg->research_leader = $leaderWithComma;
        $resReg->research_researcher = $researcherWithComma;
        $resReg->agency_responsible_id = $request->agency_responsible_id;
        $resReg->budget_allocated = $request->budget_allocated;
        $resReg->start_date = $request->start_date ? Carbon::createFromFormat('d/m/Y', $request->start_date, 'Asia/Bangkok')->subYear(543) : null;
        $resReg->end_date = $request->end_date ? Carbon::createFromFormat('d/m/Y', $request->end_date, 'Asia/Bangkok')->subYear(543) : null;
        $resReg->job_status_id = $request->job_status_id;
        $resReg->date_of_submission = $request->date_of_submission ? Carbon::createFromFormat('d/m/Y', $request->date_of_submission, 'Asia/Bangkok')->subYear(543) : null;
        $resReg->created_by = Auth::user()->id;
        $resReg->updated_by = Auth::user()->id;
        $resReg->save();

        $advisors = $request->advisors ? count($request->advisors) : 0;
        if ($advisors > 0) {
          for ($i = 0; $i < $advisors; $i++ ) {
            if(trim($request->advisors[$i]) != ''){
              $resResearcher = new ResResearcher;
              $resResearcher->res_registration_id = $resReg->id;
              $resResearcher->res_responsible_person_id = $request->research_advisor;
              $resResearcher->name_th = $request->advisors[$i];
              $resResearcher->name_en = "";
              $resResearcher->percent = $request->advisor_percents[$i];
              $resResearcher->created_by = Auth::user()->id;
              $resResearcher->updated_by = Auth::user()->id;
              $resResearcher->save();
            }
          }
        }

        $leaders = $request->leaders ? count($request->leaders) :0;
        if ($leaders > 0) {
          for ($i = 0; $i < $leaders; $i++ ) {
            if(trim($request->leaders[$i]) != ''){
              $resResearcher = new ResResearcher;
              $resResearcher->res_registration_id = $resReg->id;
              $resResearcher->res_responsible_person_id = $request->research_leader;
              $resResearcher->name_th = $request->leaders[$i];
              $resResearcher->name_en = "";
              $resResearcher->percent = $request->leader_percents[$i];
              $resResearcher->created_by = Auth::user()->id;
              $resResearcher->updated_by = Auth::user()->id;
              $resResearcher->save();
            }
          }
        }

        $researchers = $request->researchers ? count($request->researchers) : 0;
        if ($researchers > 0) {
          for ($i = 0; $i < $researchers; $i++ ) {
            if(trim($request->researchers[$i]) != ''){
              $resResearcher = new ResResearcher;
              $resResearcher->res_registration_id = $resReg->id;
              $resResearcher->res_responsible_person_id = $request->research_researcher;
              $resResearcher->name_th = $request->researchers[$i];
              $resResearcher->name_en = "";
              $resResearcher->percent = $request->researcher_percents[$i];
              $resResearcher->created_by = Auth::user()->id;
              $resResearcher->updated_by = Auth::user()->id;
              $resResearcher->save();
            }
          }
        }

        $resAbstract = new ResAbstract;
        $resAbstract->res_registration_id = $resReg->id;
        $resAbstract->abstract_th = $request->abstract_th;
        $resAbstract->abstract_en = "";
        $resAbstract->created_by = Auth::user()->id;
        $resAbstract->updated_by = Auth::user()->id;
        $resAbstract->save();

        return redirect()->route('resRegis');

      } else {

      //$this->_data['resResponsiblePersonList'] = ResResponsiblePerson::orderBy('id', 'asc')->get();
        $this->_data['resFiscalYearList']        = ResFiscalYear::orderBy('id', 'desc')->get();
        $this->_data['resBudgetTypeList']        = ResBudgetType::orderBy('id', 'asc')->get();
        $this->_data['resAgencyResponsibleList'] = ResAgencyResponsible::orderBy('id', 'asc')->get();
        $this->_data['resJobStatusList']         = ResJobStatus::orderBy('id', 'asc')->get();

        return view('ResRegistration.add')->with($this->_data);

      }

    } else {

        return response()->json([]);

    }
  }

  public function edit(Request $request, $id)
  {
    if(count($this->getPermissions($request, 1, 1, 1))==3) { // R, W, D, S

      $resReg = ResRegistration::find($id);

      if($resReg) {

        if($request->isMethod('post')) {

          $validator = $this->_validator($request->all());
          if ($validator->fails()) {
              return redirect()->route('resRegis.edit', [$id])
                               ->withErrors($validator)
                               ->withInput();
          }

          // ResRegistration
          $advisorWithComma = "";
          $advisors = $request->advisors ? count($request->advisors) : 0;
          if ($advisors > 0) {
            $posi = 0;
            for ($i = 0; $i < $advisors; $i++ ) {
              if(trim($request->advisors[$i]) != ''){
                if($posi == 0){
                  $posi = 1;
                  $advisorWithComma = $advisorWithComma . $request->advisors[$i];
                }else{
                  $advisorWithComma = $advisorWithComma . ', ' . $request->advisors[$i];
                }
              }
            }
          }
  
          $leaderWithComma = "";
          $leaders = $request->leaders ? count($request->leaders) : 0;
          if ($leaders > 0) {
            $posj = 0;
            for ($i = 0; $i < $leaders; $i++ ) {
              if(trim($request->leaders[$i]) != ''){
                if($posj == 0){
                  $posj = 1;
                  if(trim($request->leader_percents[$i]) != ''){
                    $leaderWithComma = $leaderWithComma . $request->leaders[$i] . '(' . $request->leader_percents[$i] . '%)';
                  }else{
                    $leaderWithComma = $leaderWithComma . $request->leaders[$i] . '(0%)';
                  }
                }else{
                  if(trim($request->leader_percents[$i]) != ''){
                    $leaderWithComma = $leaderWithComma . ', ' . $request->leaders[$i] . '(' . $request->leader_percents[$i] . '%)';
                  }else{
                    $leaderWithComma = $leaderWithComma . ', ' . $request->leaders[$i] . '(0%)';
                  }
                }
              }
            }
          }
  
          $researcherWithComma = "";
          $researchers = $request->researchers ? count($request->researchers) : 0;
          if ($researchers > 0) {
            $posk = 0;
            for ($i = 0; $i < $researchers; $i++ ) {
              if(trim($request->researchers[$i]) != ''){
                if($posk == 0){
                  $posk = 1;
                  if(trim($request->researcher_percents[$i]) != ''){
                    $researcherWithComma = $researcherWithComma . $request->researchers[$i] . '(' . $request->researcher_percents[$i] . '%)';
                  }else{
                    $researcherWithComma = $researcherWithComma . $request->researchers[$i] . '(0%)';
                  }
                }else{
                  if(trim($request->researcher_percents[$i]) != ''){
                    $researcherWithComma = $researcherWithComma . ', ' . $request->researchers[$i] . '(' . $request->researcher_percents[$i] . '%)';
                  }else{
                    $researcherWithComma = $researcherWithComma . ', ' . $request->researchers[$i] . '(0%)';
                  }
                }
              }
            }
          }
  
          $resReg->project_name_th = $request->project_name_th;
        //$resReg->project_name_en = $request->project_name_en;
          $resReg->fiscal_year_id = $request->fiscal_year_id;
          $resReg->budget_type_id = $request->budget_type_id;
          $resReg->research_advisor = $advisorWithComma;
          $resReg->research_leader = $leaderWithComma;
          $resReg->research_researcher = $researcherWithComma;
          $resReg->agency_responsible_id = $request->agency_responsible_id;
          $resReg->budget_allocated = $request->budget_allocated;
          $resReg->start_date = $request->start_date ? Carbon::createFromFormat('d/m/Y', $request->start_date, 'Asia/Bangkok')->subYear(543) : null;
          $resReg->end_date = $request->end_date ? Carbon::createFromFormat('d/m/Y', $request->end_date, 'Asia/Bangkok')->subYear(543) : null;
          $resReg->job_status_id = $request->job_status_id;
          $resReg->date_of_submission = $request->date_of_submission ? Carbon::createFromFormat('d/m/Y', $request->date_of_submission, 'Asia/Bangkok')->subYear(543) : null;
          $resReg->updated_by = Auth::user()->id;
          $resReg->save();

          // ResResearcher
          ResResearcher::where('res_registration_id', $resReg->id)->delete();

          $advisors = $request->advisors ? count($request->advisors) : 0;
          if ($advisors > 0) {
            for ($i = 0; $i < $advisors; $i++ ) {
              if(trim($request->advisors[$i]) != ''){
                $resResearcher = new ResResearcher;
                $resResearcher->res_registration_id = $resReg->id;
                $resResearcher->res_responsible_person_id = $request->research_advisor;
                $resResearcher->name_th = $request->advisors[$i];
                $resResearcher->name_en = "";
                $resResearcher->percent = $request->advisor_percents[$i];
                $resResearcher->created_by = Auth::user()->id;
                $resResearcher->updated_by = Auth::user()->id;
                $resResearcher->save();
              }
            }
          }
  
          $leaders = $request->leaders ? count($request->leaders) :0;
          if ($leaders > 0) {
            for ($i = 0; $i < $leaders; $i++ ) {
              if(trim($request->leaders[$i]) != ''){
                $resResearcher = new ResResearcher;
                $resResearcher->res_registration_id = $resReg->id;
                $resResearcher->res_responsible_person_id = $request->research_leader;
                $resResearcher->name_th = $request->leaders[$i];
                $resResearcher->name_en = "";
                $resResearcher->percent = $request->leader_percents[$i];
                $resResearcher->created_by = Auth::user()->id;
                $resResearcher->updated_by = Auth::user()->id;
                $resResearcher->save();
              }
            }
          }
  
          $researchers = $request->researchers ? count($request->researchers) : 0;
          if ($researchers > 0) {
            for ($i = 0; $i < $researchers; $i++ ) {
              if(trim($request->researchers[$i]) != ''){
                $resResearcher = new ResResearcher;
                $resResearcher->res_registration_id = $resReg->id;
                $resResearcher->res_responsible_person_id = $request->research_researcher;
                $resResearcher->name_th = $request->researchers[$i];
                $resResearcher->name_en = "";
                $resResearcher->percent = $request->researcher_percents[$i];
                $resResearcher->created_by = Auth::user()->id;
                $resResearcher->updated_by = Auth::user()->id;
                $resResearcher->save();
              }
            }
          }

          // ResAbstract
          ResAbstract::where('res_registration_id', $resReg->id)->delete();
          if($request->abstract_th){
            $resAbstract = new ResAbstract;
            $resAbstract->res_registration_id = $resReg->id;
            $resAbstract->abstract_th = $request->abstract_th;
            $resAbstract->abstract_en = "";
            $resAbstract->created_by = Auth::user()->id;
            $resAbstract->updated_by = Auth::user()->id;
            $resAbstract->save();
          }
   
          return redirect()->route('resRegis');

        } else {

          $this->_data['result'] = $resReg;

          $this->_data['result']['start_date']         = $resReg->start_date ? Carbon::parse($resReg->start_date)->addYear(543)->format('d/m/Y') : "";
          $this->_data['result']['end_date']           = $resReg->end_date ? Carbon::parse($resReg->end_date)->addYear(543)->format('d/m/Y') : "";
          $this->_data['result']['date_of_submission'] = $resReg->date_of_submission ? Carbon::parse($resReg->date_of_submission)->addYear(543)->format('d/m/Y') : "";

          $resAdvisor    = ResResearcher::where('res_registration_id', $resReg->id)->where('res_responsible_person_id', 1)->select('id')->orderBy('id', 'desc')->first();
          $resLeader     = ResResearcher::where('res_registration_id', $resReg->id)->where('res_responsible_person_id', 2)->select('id')->orderBy('id', 'desc')->first();
          $resResearcher = ResResearcher::where('res_registration_id', $resReg->id)->where('res_responsible_person_id', 3)->select('id')->orderBy('id', 'desc')->first();

          $advisorMaximum    = 0;
          $leaderMaximum     = 0;
          $researcherMaximum = 0;

          if($resAdvisor){
            $advisorMaximum = $resAdvisor->id;
          }
          if($resLeader){
            $leaderMaximum = $resLeader->id;
          }
          if($resResearcher){
            $researcherMaximum = $resResearcher->id;
          }

          $this->_data['advisorMaximum'] = $advisorMaximum;
          $this->_data['leaderMaximum'] = $leaderMaximum;
          $this->_data['researcherMaximum'] = $researcherMaximum;

          $this->_data['advisorList']    = ResResearcher::where('res_registration_id', $resReg->id)->where('res_responsible_person_id', 1)->orderBy('id', 'asc')->get();
          $this->_data['leaderList']     = ResResearcher::where('res_registration_id', $resReg->id)->where('res_responsible_person_id', 2)->orderBy('id', 'asc')->get();
          $this->_data['researcherList'] = ResResearcher::where('res_registration_id', $resReg->id)->where('res_responsible_person_id', 3)->orderBy('id', 'asc')->get();

          $this->_data['resResponsiblePersonList'] = ResResponsiblePerson::orderBy('id', 'asc')->get();
          $this->_data['resFiscalYearList']        = ResFiscalYear::orderBy('id', 'desc')->get();
          $this->_data['resBudgetTypeList']        = ResBudgetType::orderBy('id', 'asc')->get();
          $this->_data['resAgencyResponsibleList'] = ResAgencyResponsible::orderBy('id', 'asc')->get();
          $this->_data['resJobStatusList']         = ResJobStatus::orderBy('id', 'asc')->get();

          $resAbstract = ResAbstract::where('res_registration_id', $resReg->id)->first();
          $this->_data['result']['abstract_th'] = $resAbstract ? $resAbstract->abstract_th : "";

          //dd($this->_data);

          return view('ResRegistration.edit')->with($this->_data);
        }
      } else {
        return redirect()->route('resRegis');
      }
    } else {
        return response()->json([]);
    }
  }

  public function update(Request $request)
  {
    if(count($this->getPermissions($request, 1, 1, 1))==3) { // R, W, D, S

      $validator = Validator::make($request->all(), [
        'id' => 'required',
        'action' => 'required|string'
      ]);

      if ($validator->fails()) {
          return redirect()->route('resRegis')
                           ->withErrors($validator)
                           ->withInput();
      }

      switch ($request->action) {
        case 'delete':

          ResResearcher::where('res_registration_id', $request->id)->delete();

          ResRegistration::where('id', $request->id)->delete();

          ResAbstract::where('res_registration_id', $request->id)->delete();

          $this->flash_messages($request, 'success', 'ทำการลบข้อมูลสำเร็จ !');
          break;

        default:
          $this->flash_messages($request, 'danger', 'ทำการลบข้อมูลไม่สำเร็จ !');
          break;
      }

      return redirect()->route('resRegis');

    } else {

        return response()->json([]);

    }
  }
}
