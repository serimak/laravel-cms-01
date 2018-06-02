<?php

namespace App\Http\Controllers;

use App\Models\ResRegistration;
use App\Models\ResResponsiblePerson;
use App\Models\ResResearcher;
use App\Models\ResFiscalYear;
use App\Models\ResBudgetType;
use App\Models\ResAgencyResponsible;
use App\Models\ResJobStatus;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class SerRegistrationController extends Controller
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

  public function index(Request $request)
  {
        if(count($this->getPermissions($request, 1))==1) { // R, W, D, S

            $resRegLists = ResRegistration::orderBy('id', 'asc')->get();

            foreach ($resRegLists as $key => $value) {

                $this->_data['result'][$key] = $value;

                $this->_data['result'][$key]['fiscal_year_id']        = @ResFiscalYear::find($value['fiscal_year_id'])->name_th;
                $this->_data['result'][$key]['budget_type_id']        = @ResBudgetType::find($value['budget_type_id'])->name_th;
                $this->_data['result'][$key]['agency_responsible_id'] = @ResAgencyResponsible::find($value['agency_responsible_id'])->name_th;
                $this->_data['result'][$key]['job_status_id']         = @ResJobStatus::find($value['job_status_id'])->name_th;
                $this->_data['result'][$key]['start_date']            = $value['start_date'] ? Carbon::parse($value['start_date'])->addYear(543)->format('d/m/Y') : ""; //$value['start_date'] ? date('d/m/Y', strtotime($value['start_date'])) : "";
                $this->_data['result'][$key]['end_date']              = $value['end_date'] ? Carbon::parse($value['end_date'])->addYear(543)->format('d/m/Y') : "";
                $this->_data['result'][$key]['date_of_submission']    = $value['date_of_submission'] ? Carbon::parse($value['date_of_submission'])->addYear(543)->format('d/m/Y') : "";
            }

            return view('SerRegistration.list')->with($this->_data);

        } else {

            return response()->json([]);

        }
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

      return view('SerRegistration.view')->with($this->_data);

    } else {

        return response()->json([]);

    }
  }

}
