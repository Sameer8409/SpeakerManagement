<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
    <style>
    .glyphicon-refresh-animate {
        -animation: spin .7s infinite linear;
        -webkit-animation: spin2 .7s infinite linear;
    }

    @-webkit-keyframes spin2 {
        from { -webkit-transform: rotate(0deg);}
        to { -webkit-transform: rotate(360deg);}
    }

    @keyframes spin {
        from { transform: scale(1) rotate(0deg);}
        to { transform: scale(1) rotate(360deg);}
    }
    </style>
    <div class = "container">
        <div class="panel panel-primary">
            <div class="panel-heading">Speakers</div>
            <div class = "row">
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <!-- <h3 class="box-title">Speakers</h3> -->
                            @if ($message = Session::get('success'))
                            <div class="alert alert-success alert-block">
                                <button type="button" class="close" data-dismiss="alert">×</button> 
                                <strong>{{ $message }}</strong>
                            </div>
                            @endif
                            <div class ="pull-right">
                                <a title="Add new speaker" href = "{{url('speakers/add')}}"><button class = "btn btn-success"> Add Speaker </button></a>
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
                                    <th>Action</th>
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
                                            <a title="View Image" href = "{{ url(urlencode('images').'/'.$images)}}" style="{color:red;} :hover{color:green;font-weight:bold;}">
                                            <img src ="{{url(urlencode('thumbnail').'/'.$images)}}" alt="{{$images}}"/>
                                            </a><br><br>
                                            @endforeach
                                        @else
                                        ---
                                        @endif
                                        </td>
                                        <td>{{$speakers->description}}</td>
                                           <?php $x = $speakers->id ?>
                                        <td>
                                            <a title="Update this record" class="glyphicon glyphicon-pencil" href="{{url('speakers/edit').'/'.$x}}" ></a>
                                           &nbsp; 
                                            <form action="{{ route('speakers.destroy', $x) }}" method="post" style="display: inline-block;">
                                             {{ csrf_field() }}
                                              <input name="_method" type="hidden" value="DELETE">
                                          
                                              <button type="submit" class = "btn btn-danger"><i class="glyphicon glyphicon-trash" aria-hidden="true"></i></button>
                                            </form>
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
    </div>
    <script type ="text/javascript">
        window.setTimeout(function() {
        $(".alert").fadeTo(500, 0).slideUp(500, function(){
            $(this).remove(); 
        });
    }, 4000);
    </script>
</body>
</html>