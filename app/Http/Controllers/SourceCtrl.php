<?php
namespace App\Http\Controllers;

use Image;
use File;
use Mail;

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

  public function dtcformat($date)
  {
    if($date)
    {
      return date('M d, Y H:i:s', strtotime($date));
    }
    return '';
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

  public function sendMail(array $data)
  {
    $data1 = [
      'email_from' => 'noreply@liveeducationbd.com',
      'from_name' => 'Live Education BD'
    ];

    $data = array_merge($data, $data1);

    Mail::send('mail.default', $data, function($message) use ($data)
    {
      $message->to($data['email_to'])->subject($data['subject']);
      $message->from($data['email_from'], $data['from_name']);
    });
  }

  public function host()
  {    
    $protocol = isset($_SERVER['HTTPS'])?'https://':'http://';
    $host = $protocol.$_SERVER['HTTP_HOST'];
    if(empty($_SERVER['HTTP_HOST']))
    {
        $host = 'http://liveeducationbd.com';
    }
    return $host;
  }
}