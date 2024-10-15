@php
use \App\Http\Controllers\SourceCtrl;
$source = New SourceCtrl;
$correct = '';
$format = ['a)', 'b)', 'c)', 'd)', 'e)'];
@endphp

@extends('dashboard')
@section('title', 'View Questions')
@section('content')
<style>
  ::-webkit-scrollbar{width: 5px;}
  ::-webkit-scrollbar-thumb{background-color: #ddd}
  ul.list li{padding: 10px 0; list-style: none;}
  .hide{display: none}
  .filter{padding-left: 10px;}
  .filter .item{list-style: none;font-weight: bold;padding-bottom: 25px}
  .filter li:last-child{padding:0}
  .filter .item a{display: inline-block;font-size: 15px;color: #000}
  .filter .item .drop-down{position: absolute; right: 20px}
  .filter-group{clear:top;padding-left: 10px;}
  .filter-group .item{padding-bottom: 10px}
  .filter-group .item a{border:1px solid #ddd; padding: 5px;display: block;font-weight: normal}
  .loading{position:fixed; top:0;bottom:0;left:0;right:0; background:rgba(0,0,0,0.2); text-align: center; padding-top:15%}
  .panel-heading{background:none}
  .paper_panel{padding: 15px}
  .paper_panel label{border:1px solid #ddd; display: block;padding:10px; margin-bottom:0}
  @media screen and (min-width:480px) {
    .filter-parent{max-width:400px; max-height: 600px; overflow:auto;}
    .sticky{position: fixed;top:10px;}
  }
  @media screen and (max-width:481px){
    .filter-parent{width:100%}
    .sticky{position: relative;}
  }
</style>
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>View Questions</h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i>Dashboard</a></li>
    {{-- <li><a href="#">Tables</a></li> --}}
    <li class="active">View Questions</li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Categories</h3>
          <div class="box-tools">
            <a href="{{route('question.create')}}" class="btn btn-info">
              <i class="fa fa-plus"></i> Add Question
            </a>
            {{-- <div class="input-group input-group-sm" style="float:right; width: 150px;margin-left:15px">
              <input type="text" name="table_search" class="form-control pull-right" placeholder="Search">

              <div class="input-group-btn">
                <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
              </div>
            </div> --}}
          </div>
        </div>
        <div class="box-body">
          <div class="col-md-12">
            <form action="{{route('question.view.post')}}" method="POST" id="filter_form" onsubmit="event.preventDefault(); ajaxFilter()">
              @csrf
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="">Course</label>
                    <select name="course_id" id="course_id" class="form-control select2" onchange="getDepartments(this)">
                      <option value="">Select One</option>
                      @foreach($courses as $value)
                      <option value="{{$value->id}}" {{$cat['course_id'] == $value->id ? 'selected':''}}>{{$value->name}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="">Department</label>
                    <select name="department_id" id="department_id" class="form-control select2" onchange="getSemesters(this); getSubjects(this)">
                      <option value="">Select One</option>
                      @foreach($departments as $value)
                      <option value="{{$value->id}}" {{$cat['department_id'] == $value->id ? 'selected':''}}>{{$value->name}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="col-md-3" id="semester">
                  <div class="form-group">
                    <label for="">Semester</label>
                    <select name="semester_id" id="semester_id" class="form-control select2" onchange="getSubjects(this)">
                      <option value="">Select One</option>
                      @foreach($semesters as $value)
                      <option value="{{$value->id}}" {{$cat['semester_id'] == $value->id ? 'selected':''}}>{{$value->name}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="">Subjects</label>
                    <select name="subject_id" id="subject_id" class="form-control select2" onchange="getChapters(this)">
                      <option value="">Select One</option>
                      @foreach($subjects as $value)
                      <option value="{{$value->id}}" {{$cat['subject_id'] == $value->id ? 'selected':''}}>{{$value->name}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="">Chapter</label>
                    <select name="chapter_id" id="chapter_id" class="form-control select2">
                      <option value="">Select One</option>
                      @foreach($chapters as $value)
                      <option value="{{$value->id}}" {{$cat['chapter_id'] == $value->id ? 'selected':''}}>{{$value->name}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="">Type</label>
                    <select name="type" id="" class="form-control">
                      {{-- <option value="">Select One</option> --}}
                      <option value="MCQ" {{$cat['type'] == 'MCQ' ? 'selected':''}}>MCQ</option>
                      <option value="Written" {{$cat['type'] == 'Written' ? 'selected':''}}>Written</option>
                      <option value="Video" {{$cat['type'] == 'Video' ? 'selected':''}}>Video</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <br>
                    <input class="btn btn-primary" type="submit" value="Submit">
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
      <div class="col-md-4" style="padding-left: 0">
        <div class="box filter-parent" id="filter-parent">
          @if(!is_null(Session::get('_paper')))
          @php
          $paper = Session::get('_paper');
          @endphp
          <div class="box-header">
            <div class="paper_panel">
              <div class="form-group">
                <div class="input-group">
                  <label class="label-default">{{$paper->name}}</label>
                  <span class="input-group-addon" style="font-weight: bold"><span id="qcount">{{count($paper->questions)}}</span>/<span id="maxq">{{$paper->max}}</span></span>
                </div>
              </div>
              <div class="form-group">
                <a class="btn btn-info pull-right" href="{{route('paper.view', $paper->id)}}"><i class="fa fa-check"></i> Done</a>
                {{-- <button type="button" class="btn btn-success btn-sm pull-right" onclick="addToPaper(this)" value="{{$paper->id}}"><i class="fa fa-plus"></i> Add To Paper</button> --}}
              </div>
            </div>
          </div>
          @endif
          <div class="box-body">
            <div class="panel" style="margin-bottom:0;box-shadow:none">
              <div class="panel-heading" style="border-bottom:1px solid #ddd; border-top:1px solid #ddd">
                <h4> <i class="fa fa-sliders"> </i> Filter</h4>
              </div>
              <div class="panel-body">
                <ul class="filter">
                  @foreach($filters as $filter)
                  @if(count($filter->subfilter) > 0)
                  <li class="item">
                    <p>
                      <a>{{$filter->name}}</a>
                      <span class="drop-down" onclick="showHideSubFilter(this)"><i class="fa fa-chevron-down"></i></span>
                    </p>
                    <ul class="filter-group hide">
                      @foreach($filter->subfilter as $sub)
                      <li class="item">
                        <div class="input-group">
                          <a>{{$sub->name}}</a>
                          <span class="input-group-addon">
                            <input type="checkbox" name="sub_filter" value="{{$sub->id}}" onchange="ajaxFilter()">
                          </span>
                        </div>
                      </li>
                      @endforeach
                    </ul>
                  </li>
                  @endif
                  @endforeach
                </ul>
              </div>
            </div>
          </div><!-- /.box body -->
        </div><!--/.box for fitler -->
      </div>
      <div class="col-md-8 no-padding">
        <div class="box" id="question_area">
            @include('layouts.questions.paginate')
        </div><!-- /.box -->
      </div>
      
      <div id="loading" class="loading hide">
        <img src="/img/logo_animation.png" alt="">
      </div>

      {{-- <div class="alert hi/de" style="background:#fff;right:0">///</div> --}}

<script>
  function getDepartments(e)
  {
      let ids = Array.from(e.selectedOptions).map(({value}) => value);

      $.ajax({
          type: 'GET', //THIS NEEDS TO BE GET
          url: '/get_departments/' + ids,
          success: function (data) {

              var obj = JSON.parse(JSON.stringify(data));
              var options = '<option value="">Select One</option>';

              $.each(obj['data'], function (key, val) {
                  options += '<option value="'+val.id+'">'+val.name+'</option>';
              });

              if(options != ""){
                  $("#department_id").html(options)
              }else{
                  $("#department_id").html('')
                  $("#semester_id").html('')
                  $("#subject_id").html('')
                  $("#chapter_id").html('')
              }
          },
          error: function(data) { 
                  console.log('data error');
          }
      });
  }

  function getSemesters(e)
  {
      let ids = Array.from(e.selectedOptions).map(({value}) => value);
      let department = document.getElementById('department_id');
      let preElm = department.parentNode.parentNode;

      $.ajax({
          type: 'GET', //THIS NEEDS TO BE GET
          url: '/get_semesters/' + ids,
          success: function (data) {

              var obj = JSON.parse(JSON.stringify(data));
              var options = '<option value="">Select One</option>';

              $.each(obj['data'], function (key, val) {
                  options += '<option value="'+val.id+'">'+val.name+'</option>';
              });

              if(options != "")
              {
                  if(preElm.nextElementSibling.id == 'semester')
                  {
                      $("#semester_id").html(options)
                  }
                  else
                  {
                      let elm = document.createElement('div');
                      elm.setAttribute('class', 'col-md-3');
                      elm.setAttribute('id', 'semester');
                      elm.innerHTML = '<div class="form-group">'+
                              '<label for="name">Semester Name</label>'+
                              '<select class="form-control select2" multiple name="semester_id[]" id="semester_id" onchange="getSemsSubjects(this)">'+ options +
                                  '</select>'+
                              '</div>';
                      preElm.after(elm);
                  }

                  // select2 execution
                  $(function(){ $('.select2').select2(); });
                  
              }else{
                  $("#semester_id").html('')
                  $("#subject_id").html('')
                  $("#chapter_id").html('')
                  
                  if(preElm.nextElementSibling.id == 'semester')
                  {
                      preElm.nextElementSibling.remove()
                  }
              }
          },
          error: function(data) { 
                  console.log('data error');
          }
      });

      
  }

  function getSubjects(e)
  {
      let ids = Array.from(e.selectedOptions).map(({value}) => value);

      $.ajax({
          type: 'GET', //THIS NEEDS TO BE GET
          url: '/get_subjects/' + ids,
          success: function (data) {

              var obj = JSON.parse(JSON.stringify(data));
              var options = '<option value="">Select One</option>';

              $.each(obj['data'], function (key, val) {
                  options += '<option value="'+val.id+'">'+val.name+'</option>';
              });

              if(options != ""){
                  $("#subject_id").html(options)
              }else{
                  $("#subject_id").html('')
                  $("#chapter_id").html('')
              }
          },
          error: function(data) { 
                  console.log('data error');
          }
      });
  }

  function getSemsSubjects(e)
  {
      let ids = Array.from(e.selectedOptions).map(({value}) => value);

      $.ajax({
          type: 'GET', //THIS NEEDS TO BE GET
          url: '/get_sems_subjects/' + ids,
          success: function (data) {

              var obj = JSON.parse(JSON.stringify(data));
              var options = '<option value="">Select One</option>';

              $.each(obj['data'], function (key, val) {
                  options += '<option value="'+val.id+'">'+val.name+'</option>';
              });

              if(options != ""){
                  $("#subject_id").html(options)
              }else{
                  $("#subject_id").html('')
                  $("#chapter_id").html('')
              }
          },
          error: function(data) { 
                  console.log('data error');
          }
      });
  }

  function getChapters(e)
  {
      let ids = Array.from(e.selectedOptions).map(({value}) => value);

      $.ajax({
          type: 'GET', //THIS NEEDS TO BE GET
          url: '/get_chapters/' + ids,
          success: function (data) {

              var obj = JSON.parse(JSON.stringify(data));
              var options = '<option value="">Select One</option>';

              $.each(obj['data'], function (key, val) {
                  options += '<option value="'+val.id+'">'+val.name+'</option>';
              });

              if(options != ""){
                  $("#chapter_id").html(options)
              }else{
                  $("#chapter_id").html('')
              }
          },
          error: function(data) { 
                  console.log('data error');
          }
      });
  }

  function showHideAnswer(e)
  {
    let item = e.parentNode.nextElementSibling;
    item.classList.toggle('hide');
  }

  function showHideSubFilter(e)
  {
    let sub = e.parentNode.nextElementSibling;
    sub.classList.toggle('hide');

    e.firstElementChild.classList.toggle('fa-chevron-down');
    e.firstElementChild.classList.toggle('fa-chevron-up');
  }
  //make full width the layout
  document.body.classList.add('sidebar-collapse');

  //globaly declare the question area variable
  let question_area = document.getElementById('question_area');

  //globaly declare the filter form
  const form = document.getElementById('filter_form');

  // assign loading variable for every where use
  const loading = document.getElementById('loading');

  //assign sub-filters for every where use
  let filters = document.getElementsByName('sub_filter');

  function ajaxFilter()
  {
    //loading image view
    loading.classList.remove('hide');

    let ids = [];
    filters.forEach(e => {
      if(e.checked == true){
        ids.push(e.value);  
      }  
    });

    // console.log(ids);
    const formData = new FormData(form);
    formData.append('filter_ids', ids);
    
    $.ajax({
      url: '{{route("question.view.post")}}',
      type: 'POST',
      data:formData,
      cache: false,
      contentType: false,
      processData: false,
      success:function(data)
      {
        question_area.innerHTML = data;
        loading.classList.add('hide');
        prevNext();
      },
      error:function(data)
      {
        console.log(data);
      }
    });
  }

  window.onscroll = function(){
    let filterParent = document.getElementById('filter-parent');
    if(document.body.scrollTop >= 500 || document.documentElement.scrollTop >= 500)
    {
      filterParent.classList.add('sticky');
    }
    else
    {
      filterParent.classList.remove('sticky');
    }
  }

  // delete question by ajax request
  function del(e)
  {
    let item = e.parentNode.parentNode.parentNode.parentNode;
    console.log(item);
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    $.ajax({
      url: '{{route("question.destroy", '')}}/'+e.value,
      type:'POST',
      data:{_method:'DELETE'},
      beforeSend:function(){
        return confirm('Are you sure, you want to delete this?');
      },
      success:function(data){
        //
      },
      success:function(data){}
    });

    //remove item from page
    item.remove();
  }

  function count(e)
  {
    let maxq = document.getElementById('maxq');
    if(e.checked == true)
    {
      if(Number(maxq.innerHTML) != 0 && Number(qcount.innerHTML) >= Number(maxq.innerHTML))
      {
        alert('Question Enry Max Limit Over!');
        e.checked = false;
      }
      else
      {
        qcount.innerHTML = Number(qcount.innerHTML) + 1;
        addToPaper(e, 'add');
      }
    }
    else
    {
      qcount.innerHTML = Number(qcount.innerHTML) - 1;
      addToPaper(e, 'remove');
    }
  }

  // add question to paper
  function addToPaper(e, action)
  {
    let ids = e.value;
    //loading image view
    // loading.classList.remove('hide');

    let qcount = document.getElementById('qcount');
    let questions = document.getElementsByClassName('check');

    // let ids = [];
    // for(let q = 0; q < questions.length; q++)
    // {
    //   if(questions[q].checked == true)
    //   {
    //     ids.push(questions[q].value);
    //   }
    // }

    let formData = new FormData();
    formData.append('question', ids);
    formData.append('action', action);
    // console.log(...formData);

    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

    $.ajax({
      url: '{{route("paper.addtopaper")}}',
      type: 'POST',
      data: formData,
      cache: false,
      contentType: false,
      processData: false,
      success: function(data){
        // console.log(data);
        // qcount.innerHTML = data.qcount.attached.length;
        // loading.classList.add('hide');
      },
      error: function(data){
        console.log(data);
      },
    });

  }

</script>
</section> <!-- /.content -->
@endsection
@section('scripts')
  <script>
    $(function () {
      $('#example1').DataTable()
      $('#example2').DataTable({
        'paging'      : true,
        'lengthChange': false,
        'searching'   : false,
        'ordering'    : true,
        'info'        : true,
        'autoWidth'   : false
      })
    })
  </script>

<script>
  $(function(){$('.select2').select2();});

  // change pagination symble to name
  function prevNext()
    {
      let paginate = document.getElementsByClassName('pagination');
      if(paginate.length > 0)
      {
        paginate[0].firstElementChild.firstElementChild.innerHTML = '&laquo; Previous';
        paginate[0].lastElementChild.firstElementChild.innerHTML = 'Next &raquo;';
      }
    }

  $(document).ready(function()
  {
    // click handle on pagination item
    $(document).on('click', '.pagination li a', function(event)
    {
      //prevent default get method
      event.preventDefault();
      var page = $(this).attr('href').split('page=')[1];
      fetch_data(page);
    });

    // request by pagination page
    function fetch_data(page)
    {
      let data = '';
      //loading image view
      loading.classList.remove('hide');

      let ids = [];
      filters.forEach(e => {
        if(e.checked == true){
          ids.push(e.value);  
        }  
      });

      const formData = new FormData(form);
      formData.append('filter_ids', ids);
      
      $.ajax({
        url: '{{route("question.view.post")}}?page='+page,
        type: 'POST',
        data:formData,
        cache: false,
        contentType: false,
        processData: false,
        success:function(data)
        {
          question_area.innerHTML = data;
          loading.classList.add('hide');
          prevNext();
        },
        error: function(data){
          console.log(data);
        }
      });
      question_area.scrollIntoView({ behavior: "smooth" });
      
    }
  });

    prevNext();
</script>
@endsection