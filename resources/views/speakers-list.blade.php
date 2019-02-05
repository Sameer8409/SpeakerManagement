@extends('adminlte::layouts.app')

@section('htmlheader_title')
    {{ trans('adminlte_lang::message.home') }}
@endsection


@section('main-content')

<div class="panel panel-primary">
    <div class="panel-heading">Speakers</div>
    <div class = "row">
        <div class="col-md-12">
            <div class="box">
                <span id = "success"></span>
                <div class="box-header with-border">
                    <!-- <h3 class="box-title">Speakers</h3> -->
                    <!-- @if ($message = Session::get('success'))
                    <div class="alert alert-success alert-block">
                        <button type="button" class="close" data-dismiss="alert">×</button> 
                        <strong>{{ $message }}</strong>
                    </div>
                    @endif -->
                    <div class ="pull-right">
                        <a title="Add new speaker" href = "{{url('show/users')}}"> Show Users </a>
                    </div> 
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th style="width: 10px">S.No</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Designation</th>
                            <th>Image</th>
                            <th>Description</th>
                            <th colspan="2">Action</th>
                        </tr>
                        <?php $current_record = $paginate['from']; ?>

                        @if(!$result->isEmpty()) 
                            <?php 
                                $i = $current_record; 
                            ?>
                            @foreach($result as $speakers)
                                
                            <?php
                                $x = $speakers->images;
                                $img_name = explode( ',', $x);
                            ?>
                           
                            <tr>
                                <td>{{ $i++ }}.</td>
                                <td>{{$speakers->name}}</td>
                                <td>{{$speakers->email}}</td>
                                <td>{{$speakers->designation}}</td>
                                <td>
                                @if($speakers->images)
                                    @foreach($img_name as $images)
                                    <a class="fancybox" rel="gallery1" href="{{ url(urlencode('images').'/'.$images)}}">
                                    <img src ="{{url(urlencode('thumbnail').'/'.$images)}}" alt="{{$images}}" style = "height:70px;width:70px;"/>
                                    </a>

                                    
                                    <!-- <a title="View Image" href = "{{ url(urlencode('images').'/'.$images)}}" >
                                    <img src ="{{url(urlencode('thumbnail').'/'.$images)}}" alt="{{$images}}" style = "height:70px;width:70px;"/>
                                    </a> -->
                                    &nbsp;
                                    @endforeach
                                @else
                                ---
                                @endif
                                </td>
                                <td>{{$speakers->description}}</td>
                                   <?php $x = $speakers->id ?>
                                <td>
                                    <a title="Update this record" class="glyphicon glyphicon-pencil" href="{{url('speakers/edit').'/'.$x}}" ></a>
                                   </td>
                                   <td> 
                                   <button class="deleteProduct" id = "submitbtn" data-id="{{ $x }}" data-token="{{ csrf_token() }}" ><i class="glyphicon glyphicon-trash" id = {{$x}} aria-hidden="true"></i></button>
                                    <!-- <form action="{{ route('speakers.destroy', $x) }}" method="post" style="display: inline-block;">
                                     {{ csrf_field() }}
                                      <input name="_method" type="hidden" value="DELETE">
                                  
                                      <button type="submit" class = "btn btn-danger"><i class="glyphicon glyphicon-trash" aria-hidden="true"></i></button>
                                    </form> -->
                                </td>
                            </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="7"> No record found <span class = "glyphicon glyphicon-refresh glyphicon-refresh-animate"></span></td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
            <div class="box-footer clearfix">
                <ul class="pagination pagination-sm no-margin pull-right">
                    {{$result->links()}}
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection