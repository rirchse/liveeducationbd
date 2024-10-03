<?php
namespace App\Http\Controllers;

use Image;
use File;

class SourceCtrl extends Controller
{
  public function uploadImage($file, $path)
  {
    $file_name = uniqid().'.'.$file->getClientOriginalExtension();
    $base_path = base_path('public/uploads/'.$path);
    $file->move($base_path, $file_name);
    return '/uploads/'.$path.$file_name;
  }

  public function dformat($date)
  {
    if($date)
    {
      return date('d M Y', strtotime($date));
    }
    return '';
  }

  public function dtformat($date)
  {
    if($date)
    {
      return date('d M Y h:i:s A', strtotime($date));
    }
    return '';
  }

  public function balance($data)
  {
    if($data)
    {
      if($data > 0)
      {
        return '<span style="color:green">Adv: '.$data.'</span>';
      }
      elseif($data < 0)
      {
        return '<span style="color:red">Due: '.$data.'</span>';
      }
    }
    return 0;
  }

  public function mcqlist()
  {
    return [
      ['ক.', 'খ.', 'গ.', 'ঘ.', 'ঙ.'],
      ['ক)', 'খ)', 'গ)', 'ঘ)', 'ঙ)'],
      ['(ক)', '(খ)', '(গ)', '(ঘ)', '(ঙ)'],
      ['1.', '2.', '3.', '4.', '5.'],
      ['1)', '2)', '3)', '4)', '5)'],
      ['(1)', '(2)', '(3)', '(4)', '(5)'],
      ['a.', 'b.', 'c.', 'd.', 'e.'],
      ['a)', 'b)', 'c)', 'd)', 'e)'],
      ['(a)', '(b)', '(c)', '(d)', '(e)'],
      ['A.', 'B.', 'C.', 'D.', 'E.'],
      ['A)', 'B)', 'C)', 'D)', 'E)'],
      ['(A)', '(B)', '(C)', '(D)', '(E)'],
      ['i)', 'ii)', 'iii)', 'iv)', 'v)'],
      ['i.', 'ii.', 'iii.', 'iv.', 'v.'],
      ['(i)', '(ii)', '(iii)', '(iv)', '(v)'],
    ];
  }
}