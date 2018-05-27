<?php

namespace App\Http\Controllers;

use App\Models\ResRegistration;
use App\Models\ResResponsiblePerson;
use App\Models\ResAdvisor;
use App\Models\ResFiscalYear;
use App\Models\ResBudgetType;
use App\Models\ResAgencyResponsible;
use App\Models\ResJobStatus;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

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
          'project_name_en' => 'nullable|string|max:1024',
          'responsible_person_id' => 'required|integer',
          'fiscal_year_id' => 'required|integer',
          'budget_type_id' => 'required|integer',
          'advisors' => 'nullable',
          'agency_responsible_id' => 'required|integer',
          'budget_allocated' => 'required|numeric',
          'start_date' => 'required',
          'end_date' => 'required',
          'job_status_id' => 'required|integer',
          'date_of_submission' => 'nullable'
        ],
        [
        //'project_name_en.regex' => 'Field "Project name english" allow user type only English characters, numbers and special characters'
        ]
    );
  }

  public function index(Request $request)
  {
        if(count($this->getPermissions($request, 1))==1) { // R, W, D, S

            $resRegLists = ResRegistration::orderBy('id', 'asc')->get();

            foreach ($resRegLists as $key => $value) {

                $this->_data['result'][$key] = $value;

                $this->_data['result'][$key]['responsible_person_id'] = @ResResponsiblePerson::find($value['responsible_person_id'])->name_th;
                $this->_data['result'][$key]['fiscal_year_id']        = @ResFiscalYear::find($value['fiscal_year_id'])->name_th;
                $this->_data['result'][$key]['budget_type_id']        = @ResBudgetType::find($value['budget_type_id'])->name_th;
                $this->_data['result'][$key]['agency_responsible_id'] = @ResAgencyResponsible::find($value['agency_responsible_id'])->name_th;
                $this->_data['result'][$key]['job_status_id']         = @ResJobStatus::find($value['job_status_id'])->name_th;
                $this->_data['result'][$key]['start_date']            = date('d/m/Y', strtotime($value['start_date']));
                $this->_data['result'][$key]['end_date']              = date('d/m/Y', strtotime($value['end_date']));
                $this->_data['result'][$key]['date_of_submission']    = $value['date_of_submission'] ? date('d/m/Y', strtotime($value['date_of_submission'])) : "";
            }

            return view('ResRegistration.list')->with($this->_data);

        } else {

            return response()->json([]);

        }
  }

  public function view(Request $request, $id)
  {
    if(count($this->getPermissions($request, 1))==1) { // R, W, D, S

      $value = ResRegistration::find($id);
      $this->_data['result'] = $value;

      $this->_data['result']['responsible_person_id'] = @ResResponsiblePerson::find($value['responsible_person_id'])->name_th;
      $this->_data['result']['fiscal_year_id']        = @ResFiscalYear::find($value['fiscal_year_id'])->name_th;
      $this->_data['result']['budget_type_id']        = @ResBudgetType::find($value['budget_type_id'])->name_th;
      $this->_data['result']['agency_responsible_id'] = @ResAgencyResponsible::find($value['agency_responsible_id'])->name_th;
      $this->_data['result']['job_status_id']         = @ResJobStatus::find($value['job_status_id'])->name_th;
      $this->_data['result']['start_date']            = date('d/m/Y', strtotime($value['start_date']));
      $this->_data['result']['end_date']              = date('d/m/Y', strtotime($value['end_date']));
      $this->_data['result']['date_of_submission']    = $value['date_of_submission'] ? date('d/m/Y', strtotime($value['date_of_submission'])) : "";

      return view('ResRegistration.view')->with($this->_data);

    } else {

        return response()->json([]);

    }
  }

  public function create(Request $request)
  {
    if(count($this->getPermissions($request, 1, 1))==2) { // R, W, D, S

      if($request->isMethod('post')) {

        $validator = $this->_validator($request->all());
        if ($validator->fails()) {
            return redirect()->route('resRegis.add')
                             ->withErrors($validator)
                             ->withInput();
        }

        $advisorWithComma = "";
        $advisors = count($request->advisors);
        if ($advisors > 0) {
          $position = 0;
          for ($i = 0; $i < $advisors; $i++ ) {
            if(trim($request->advisors[$i]) != ''){
              if($position == 0){
                $position = 1;
                $advisorWithComma = $advisorWithComma . $request->advisors[$i];
              }else{
                $advisorWithComma = $advisorWithComma . ', ' . $request->advisors[$i];
              }
            }
          }
        }

        $resReg = new ResRegistration;
        $resReg->project_name_th = $request->project_name_th;
        $resReg->project_name_en = $request->project_name_en;
        $resReg->responsible_person_id = $request->responsible_person_id;
        $resReg->fiscal_year_id = $request->fiscal_year_id;
        $resReg->budget_type_id = $request->budget_type_id;
        $resReg->advisors = $advisorWithComma;
        $resReg->agency_responsible_id = $request->agency_responsible_id;
        $resReg->budget_allocated = $request->budget_allocated;
        $resReg->start_date = $request->start_date;
        $resReg->end_date = $request->end_date;
        $resReg->job_status_id = $request->job_status_id;
        $resReg->date_of_submission = $request->date_of_submission;
        $resReg->created_by = Auth::user()->id;
        $resReg->updated_by = Auth::user()->id;
        $resReg->save();

        $advisors = count($request->advisors);
        if ($advisors > 0) {
          for ($i = 0; $i < $advisors; $i++ ) {
            if(trim($request->advisors[$i]) != ''){
              $resAdvisor = new ResAdvisor;
              $resAdvisor->res_registration_id = $resReg->id;
              $resAdvisor->advisor_name_th = $request->advisors[$i];
              $resAdvisor->advisor_name_en = "";
              $resAdvisor->created_by = Auth::user()->id;
              $resAdvisor->updated_by = Auth::user()->id;
              $resAdvisor->save();
            }
          }
        }

        return redirect()->route('resRegis');

      } else {

        $this->_data['resResponsiblePersonList'] = ResResponsiblePerson::orderBy('id', 'asc')->get();
        $this->_data['resFiscalYearList']        = ResFiscalYear::orderBy('id', 'asc')->get();
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
          $advisors = count($request->advisors);
          if ($advisors > 0) {
            $position = 0;
            for ($i = 0; $i < $advisors; $i++ ) {
              if(trim($request->advisors[$i]) != ''){
                if($position == 0){
                  $position = 1;
                  $advisorWithComma = $advisorWithComma . $request->advisors[$i];
                }else{
                  $advisorWithComma = $advisorWithComma . ', ' . $request->advisors[$i];
                }
              }
            }
          }
  
          $resReg->project_name_th = $request->project_name_th;
          $resReg->project_name_en = $request->project_name_en;
          $resReg->responsible_person_id = $request->responsible_person_id;
          $resReg->fiscal_year_id = $request->fiscal_year_id;
          $resReg->budget_type_id = $request->budget_type_id;
          $resReg->advisors = $advisorWithComma;
          $resReg->agency_responsible_id = $request->agency_responsible_id;
          $resReg->budget_allocated = $request->budget_allocated;
          $resReg->start_date = $request->start_date;
          $resReg->end_date = $request->end_date;
          $resReg->job_status_id = $request->job_status_id;
          $resReg->date_of_submission = $request->date_of_submission;
          $resReg->updated_by = Auth::user()->id;
          $resReg->save();

          // ResAdvisor
          ResAdvisor::where('res_registration_id', $resReg->id)->delete();

          $advisors = count($request->advisors);
          if ($advisors > 0) {
            for ($i = 0; $i < $advisors; $i++ ) {
              if(trim($request->advisors[$i]) != ''){
                $resAdvisor = new ResAdvisor;
                $resAdvisor->res_registration_id = $resReg->id;
                $resAdvisor->advisor_name_th = $request->advisors[$i];
                $resAdvisor->advisor_name_en = "";
                $resAdvisor->created_by = Auth::user()->id;
                $resAdvisor->updated_by = Auth::user()->id;
                $resAdvisor->save();
              }
            }
          }

          return redirect()->route('resRegis');

        } else {

          $this->_data['result'] = $resReg;

          $resAdv = ResAdvisor::where('res_registration_id', $resReg->id)->select('id')->orderBy('id', 'desc')->first();
          $advisorMaximum = 0;
          if($resAdv){
            $advisorMaximum = $resAdv->id;
          }
          $this->_data['advisorMaximum'] = $advisorMaximum;
          $this->_data['advisorList'] = ResAdvisor::where('res_registration_id', $resReg->id)->orderBy('id', 'asc')->get();

          $this->_data['resResponsiblePersonList'] = ResResponsiblePerson::orderBy('id', 'asc')->get();
          $this->_data['resFiscalYearList']        = ResFiscalYear::orderBy('id', 'asc')->get();
          $this->_data['resBudgetTypeList']        = ResBudgetType::orderBy('id', 'asc')->get();
          $this->_data['resAgencyResponsibleList'] = ResAgencyResponsible::orderBy('id', 'asc')->get();
          $this->_data['resJobStatusList']         = ResJobStatus::orderBy('id', 'asc')->get();

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

          ResAdvisor::where('res_registration_id', $request->id)->delete();

          ResRegistration::where('id', $request->id)->delete();

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
