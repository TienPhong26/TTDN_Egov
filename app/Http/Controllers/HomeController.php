<?php

namespace App\Http\Controllers;

use App\VanBanDen;
use App\VanBanDi;
use App\VanBanNoiBo;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    //
    public function index(){
        return view('admin.home');

    }

    public function getThongso() {
		//$coquanbanhanh = CoQuanBanHanh::all();
        $dangxuly = VanBanDen::where('action', 'pending')->count();
        $vanbanden = VanBanDen::all()->count();
        $vanbandi = VanBanDi::all()->count();
        $vanbannoibo = VanBanNoiBo::all()->count();
		return view('admin.home', ['dangxuly' => $dangxuly, 'vanbanden' => $vanbanden, 'vanbandi' => $vanbandi, 'vanbannoibo' => $vanbannoibo]);
	}
}
