<?php
namespace App\Http\Controllers;

use Image;
use File;
use Mail;
use DateTime;

class SourceCtrl extends Controller
{
  public function uploadImage($file, $path, $size = null)
  {
    $file_name = uniqid().'.'.$file->getClientOriginalExtension();
    // if($size)
    // {
    //   $file = Image::make($file->getRealPath());
    //   $file->resize($size['w'], $size['h']);
    // }
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

  public function tformat($date)
  {
    if($date)
    {
      return date('h:i:s A', strtotime($date));
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
      'email_from' => 'liveeducationbd24@gmail.com',
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
  
  public function point0($data)
  {
    return number_format($data, 0);
  }

  public function reminder($date)
  {
    $y = $m = $d = $h = $i = $s = '';
    $returnable = '';
    $datetime1 = new DateTime($date);
    $datetime2 = new DateTime(date('Y-m-d H:i:s'));
    $interval  = $datetime1->diff($datetime2);
    // return $interval->format('%y years %m months and %d days');

    if($interval->format('%y'))
    {
      $y = $interval->format('%y Year ');
      $returnable = $returnable.$y;
    }

    if($interval->format('%m'))
    {
      $m = $interval->format('%m Month ');
      $returnable = $returnable.$m;
    }

    if($interval->format('%d'))
    {
      $d = $interval->format('%d Day ');
      $returnable = $returnable.$d;
    }

    if($interval->format('%h'))
    {
      $h = $interval->format('%h Hour ');
      $returnable = $returnable.$h;
    }

    if($interval->format('%i'))
    {
      $i = $interval->format('%i Minute ');
      $returnable = $returnable.$i;
    }

    return $returnable;
  }

  public function numset($num, $count = null)
  {
    return str_pad($num, $count, '0', STR_PAD_LEFT);
  }
}