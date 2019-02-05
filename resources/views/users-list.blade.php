@extends('adminlte::layouts.app')

@section('htmlheader_title')
    {{ trans('adminlte_lang::message.home') }}
@endsection


@section('main-content')

<div class="panel panel-primary">
    <div class="panel-heading">Users</div>
    <div class = "row">
        <div class="col-md-12">
            <div class="box">
                <span id = "success"></span>
                <div class="box-header with-border">
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  <table class="table table-bordered">
                    <tbody>

                        @if(count($data)) 
                            @foreach($data as $users)
                            <div class="card">
                                <div class ="profile">
                                    <img class="card-img-top" src={{$users["photos"][0]}} alt="Card image cap">
                                    <a href="#" class="pull-right"> View all</a>
                                </div>
                                
                                <div class="card-body">
                                    <h4 class="card-title"><strong>{{$users['first_name']." ".$users['last_name']}}<strong></h4>
                                    <h5 class="card-title">Email: {{$users['email']}}</h5>
                                    <!-- <h5 class="card-title">Gender:   {{$users['gender']}}</h5> -->
                                    <h5 class="card-title">Age: {{$users['age']}}</h5>
                                    <h5 class="card-title">Address: {{$users['address']}}</h5>
                                    <div class ="profile">
                                    @foreach($users["photos"] as $pics)
                                        <img class="card-img-top" src={{$pics}} alt="Card image cap">
                                    @endforeach
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="7"> No record found <span class = "glyphicon glyphicon-refresh glyphicon-refresh-animate"></span></td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection