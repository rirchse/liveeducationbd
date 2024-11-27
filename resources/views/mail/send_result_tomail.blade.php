@php
use \App\Http\Controllers\SourceCtrl;
$source = New SourceCtrl;
$user = Auth::guard('student')->user();
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Email Default Template</title>
</head>
<body style="background:#eee;padding:25px">
  <div style="background:#fff;max-width:500px;margin: 0 auto;padding:25px">
    <table style="width: 100%">
      <tr>
        <th colspan="2" style="text-align: center;font-size:18px">Result Summary</th>
      </tr>
      <tr>
        <td>Candidate Name</td>
        <th>{{$candidate}}</th>
      </tr>
      <tr>
        <td>Course Name</td>
        <th>{{$course_name}}</th>
      </tr>
      <tr>
        <td>Exam No.</td>
        <th>{{$exam_no}}</th>
      </tr>
      <tr>
        <td>Start Time</td>
        <th>{{$start_at}}</th>
      </tr>
      <tr>
        <td>End Time</td>
        <th>{{$end_at}}</th>
      </tr>
      <tr>
        <td>Answered</td>
        <th>{{$answered}}</th>
      </tr>
      <tr>
        <td>Correct</td>
        <th>{{$correct}}</th>
      </tr>
      <tr>
        <td>Wrong</td>
        <th>{{$wrong}}</th>
      </tr>
      <tr>
        <td>No Answered</td>
        <th>{{$no_answer}}</th>
      </tr>
      <tr>
        <td>Mark for per right answer</td>
        <th>{{$mark}}</th>
      </tr>
      <tr>
        <td>Negative Mark for per wrong answer</td>
        <th>{{$minus}}</th>
      </tr>
      <tr style="font-size:18px;border:1px solid #999; background: #ddd">
        <td>Score</td>
        <th>{{$mark}}</th>
      </tr>
      <tr>
        <td>Result Percentage</td>
        <th>{{number_format($percentage, 2)}}%</th>
      </tr>
      <tr>
        <td>Final Result</td>
        <th style="font-size: 16px">
          @if($percentage > 80)
          <label style="background:aqua">Extra Ordinary</label>
          @elseif($percentage > 60)
          <label style="background:green">Very Good</label>
          @elseif($percentage > 40)
          <label style="background:orange">Good</label>
          @elseif($percentage < 40)
          <label style="background:red">Learner</label>
          @endif
        </th>
      </tr>
    </table>
    <p>{!!$comments!!}</p>
  </div>  
</body>
</html>