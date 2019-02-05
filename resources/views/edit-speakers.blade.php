@extends('adminlte::layouts.app')

@section('htmlheader_title')
    {{ trans('adminlte_lang::message.home') }}
@endsection


@section('main-content')
    <div class="container">
        <div class="panel panel-primary">
        <div class="panel-heading"> Update Speaker</div>
            <!-- @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <strong>Whoops!</strong> There were some problems with your input.<br><br>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif -->
            <?php $id = $result->id ?>
            <!-- action="{{url('speakers/edit').'/'.$id}}" -->
            <form id = "edit-form" method="post" class="form-horizontal" enctype="multipart/form-data">
            {{csrf_field()}} 
            <input type ="hidden" id="id" value = {{$id}} />
                <div class="panel-body">   
                    <div class="form-group">
                        <div class="col-sm-10">
                            <label for="name">Name:</label>
                            <input type="text" class="form-control" id="name" placeholder="Enter Name" name="name" value = "{{$result->name}}" />
                            <span class = "error" id = "name-error"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-10">
                            <label for="email">Email:</label>
                            <input type="email" class="form-control" id="email" placeholder="Enter email" name="email" value = "{{$result->email}}" />
                            <span class = "error" id = "email-error"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-10">
                            <label for="designation">Designation:</label>
                            <input type="text" class="form-control" id="designation" placeholder="Enter Designation" name="designation" value = "{{$result->designation}}" />
                            <span class = "error" id = "designation-error"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-10">
                            <label for="images">Change Images:</label>
                            <span class="text-danger" id = "maximum-limit"></span> 
                            <!-- <div class="input-group-btn add">
                                <button class="btn btn-success" type="button"><i class="glyphicon glyphicon-plus"></i>add</button>
                            </div> -->
                            <div class="show">
                                <div class="input-group-btn add"> 
                                    <button  class="btn btn-success" type="button"><i class="glyphicon glyphicon-plus"></i>Upload Multiple</button>
                                </div><br>
                                <a href="#crop" id="crop-popup">
                                    <label for="imgInp" id="single-photo-add" class="btn btn-default btn-file fancybox">
                                    Add Singal Image
                                    </label>
                                    <input class = "hidden" type='file' name="images[]" id="imgInp" />
                                </a>

                                <div id = "crop">
                                    <img id="my-image" src="#" /><br>
                                    <img id="result" src="">
                                    <button type="button" id="use">Crope</button>
                                </div>
                            </div>
                            <div class="clone hide">
                                <div class = "row">
                                    <div class = "col-md-4">
                                        <div class="control-group input-group increment">
                                            <div id="test">
                                                <label for="file" id="gallery-photo-add" class="btn btn-default btn-file">
                                                Add Multiple Image(s)
                                                </label>
                                            </div>
                                            <input class="hide" type="file" name="images[]" id = "file" multiple />

                                            <span class="gallery"></span>
                                            <div id="upload-demo"></div>
                                            <!-- <label class="data-url"></label> -->
                                            <div id="status"></div>

                                            <div class="input-group-btn"> 
                                                <button class="btn btn-danger" type="button"><i class="glyphicon glyphicon-remove"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>  
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-10">
                            <label for="previous images">Previous Image(s):</label>
                            <div>
                                <?php
                                    $x = $result->images;
                                    $img_name = explode( ',', $x);
                                ?>
                                @if($result->images)
                                    @foreach($img_name as $images)
                                    <img src="{{url(urlencode('thumbnail').'/'.$images)}}" height="100px" width="100px"/>     
                                    @endforeach
                                @else
                                --
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-10">
                            <label for="description">Description:</label>
                            <textarea class="form-control" rows="5" id="description" name ="description" >{{$result->description}}</textarea>
                            <span class = "error" id = "description-error"></span>
                        </div>
                    </div>    
                    <div class="form-group">
                        <div class="progress">
                            <div class="progress-bar progress-bar-success myprogress" role="progressbar" style="width:0%">0%</div>
                        </div>
                        <span id = "errors"></span> 
                        <span id = "success"></span>        
                        <div class="col-sm-10">
                    
                            <button type="submit" id = "submitbtn" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
