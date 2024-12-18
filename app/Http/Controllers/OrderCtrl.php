<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Filter;
use App\Models\SubFilter;
use App\Models\Role;
use App\Models\Order;
use Auth;
use Image;
use File;
use Session;
use Validator;

class OrderCtrl extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */

  public function index()
  {
    $orders = Order::orderBy('id','desc')->paginate(25);
    return view('layouts.orders.index',compact('orders'));
  }

  public function destroy($id)
  {
      $file = AnswerFile::find($id);
      $xfile = public_path($file->file);
         
      if (File::exists($xfile)) {
          File::delete($xfile);
      }
      $file->delete();

      return response()->json([
          'success' => true,
          'message' => 'File successfully deleted!',
          'file' => $file
      ]);
  }
}