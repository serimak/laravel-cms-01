<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;

class ChartController extends Controller
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

        $researchResultLists = DB::select( DB::raw("SELECT a.id, a.name_th AS label, a.color, (SELECT count(*) FROM res_registration b WHERE b.agency_responsible_id = a.id) AS number_of_research FROM res_agency_responsible a") );

        foreach ($researchResultLists as $key => $value) {
            $this->_data['chart'][$key]['value']     = $value->number_of_research;
            $this->_data['chart'][$key]['color']     = $value->color ? $value->color : ('#'.str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT));
            $this->_data['chart'][$key]['highlight'] = $value->color ? $value->color : ('#'.str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT));
            $this->_data['chart'][$key]['label']     = $value->label;

            $this->_data['chartbar']['labels'][] = $value->label;
            $this->_data['chartbar']['datasets'][0]['data'][$key] = $value->number_of_research;
        }

        return view('Chart.list')->with($this->_data);

  }

}
