<!-- REQUIRED JS SCRIPTS -->

<!-- JQuery and bootstrap are required by Laravel 5.3 in resources/assets/js/bootstrap.js-->
<!-- Laravel App -->
<script src="{{ asset('/js/app.js') }}" type="text/javascript"></script>
<!-- <script src="{{ asset('/js/fetchRequest.js') }}" type="text/javascript"></script> -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<!-- <script src="http://malsup.github.com/jquery.form.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.6/jquery.fancybox.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.2/croppie.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
<!-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> -->
<!-- Optionally, you can add Slimscroll and FastClick plugins.
      Both of these plugins are recommended to enhance the
      user experience. Slimscroll is required when using the
      fixed layout. -->
 <script type="text/javascript">

    
    var croped_image;
    
    window.Laravel = {!! json_encode([
        'csrfToken' => csrf_token(),
    ]) !!};
    
    // window.setTimeout(function() {
    //     $(".alert").fadeTo(500, 0).slideUp(500, function(){
    //         $(this).remove(); 
    //     });
    // }, 4000);

    $(document).ready(function() {

    $result = axios.get('http://localhost:8010/api/show').then(res=>{
            console.log(res.data);
        });
        console.log($result);
        /* Fancy Box */
        $("a.fancybox").fancybox({
            'hideOnContentClick': true,
            'transitionIn'  :   'elastic',
            'transitionOut' :   'elastic',
            'speedIn'       :   600, 
            'speedOut'      :   200, 
            'overlayShow'   :   true,
            'type'          :   'image'
        });
        
        /* Image Upload Button */
        var htmlSuc = $(".show").html();
        $('.progress').hide();
        $(".btn-success").click(function(){ 
            var html = $(".clone").html();
            $(".add").before(html);
            $(".add").hide();
            $("#crop").hide();
            $("#crop-popup").hide();
        });
        
        /* Multiple Image Upload Close Button */
        $("body").on("click",".btn-danger",function(){ 

            $(this).parents(".control-group").remove();
            $('span.gallery').empty();
            $(".add").show();
            $(".img-error").empty();
            $("#crop-popup").show();
        });
    });

    /* Add Speaker */
    var frm = $('#add-form');
    frm.submit(function (e) {
        e.preventDefault();
        $('.error').empty();
        var form = $('#add-form')[0];
        var data = new FormData(form);
        data.append("croped_image", croped_image);
        $("#submitbtn").prop("disabled", true);
        
        $.ajax({
            type: "POST",
            enctype: 'multipart/form-data',
            url: "{{url('speakers/add')}}",
            data: data,
            processData: false,
            contentType: false,
            cache: false,
            timeout: 600000,
            // Progress bar
            xhr: function () {
                var xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener("progress", function (evt) {
                    if (evt.lengthComputable) {
                        var percentComplete = evt.loaded / evt.total;
                        percentComplete = parseInt(percentComplete * 100);
                        $('.myprogress').text(percentComplete + '%');
                        $('.myprogress').css('width', percentComplete + '%');
                    }
                }, false);
                return xhr;
            },
            success: function (data) {
                $('.error').hide();
                $("#submitbtn").prop("disabled", false);
                $('#add-form').trigger("reset");
                $(".btn-danger").remove();
                $(".add").show();
                $("#crop-popup").show();
                $("#crop").hide();
                $('span.gallery').empty(); 
                $("#success").html("<h3>Speaker added Successfully</h3>");
                $("#success").fadeOut(2000);  
                $('.progress').show();
                $('.progress').fadeOut(2000);
                Swal.fire({
                    type: 'success',
                    title: 'Speaker has been added successfully',
                    showConfirmButton: false,
                    timer: 2000
                })
                .then((value) => {
                    window.location.href = "{{url('speakers')}}";
                });
                
                // setTimeout(function () {
                // window.location.href = "{{url('speakers')}}";
                // }, 2020);
            },
            error: function (e) {
                $('.error').show();
                $('.myprogress').hide();
                var errors =    JSON.parse(e.responseText)

                 $.each(errors, function (index, value) {
                     var i = index.substring(index.indexOf(".") + 1);
                     var j=i;
                     j++;
                $("#images\\."+i+"-error").text("File no. "+j+" is "+value[0]);
                    
                     console.log("hgh",i);
                $("#"+index+"-error").text(value[0]);
                    
                    console.log("#"+index+"-error", value[0]);
                });

                $("#submitbtn").prop("disabled", false);

            },

        });
    });

    /* Update Speaker */ 
    var edit_form = $('#edit-form');
    edit_form.submit(function (e) {
        e.preventDefault();
        var x = $('#id').val();
        var URL = "{{url('speakers/edit').'/'}}"+x;
        $('.error').empty();
        var form = $('#edit-form')[0];
        var data = new FormData(form);
        data.append("croped_image", croped_image);
        $("#submitbtn").prop("disabled", true);
        
        $.ajax({
            type: "POST",
            enctype: 'multipart/form-data',
            url: URL,
            data: data,
            processData: false,
            contentType: false,
            cache: false,
            timeout: 600000,
            // this part is progress bar
            xhr: function () {
                var xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener("progress", function (evt) {
                    if (evt.lengthComputable) {
                        var percentComplete = evt.loaded / evt.total;
                        percentComplete = parseInt(percentComplete * 100);
                        $('.myprogress').text(percentComplete + '%');
                        $('.myprogress').css('width', percentComplete + '%');
                    }
                }, false);
                return xhr;
            },
            success: function (data) {
                $('.error').hide();
                // $("#result").text(data);
                console.log("SUCCESS : ", data);
                $("#submitbtn").prop("disabled", false);
                $('#edit-form').trigger("reset");
                

                // $('#edit-form')[0].reset();
                $(".btn-danger").remove();
                $(".add").show();
                $("#crop-popup").show();
                $("#crop").hide();
                $('span.gallery').empty(); 
                $("#success").html("<h3>Speaker Updated Successfully</h3>");
                $("#success").fadeOut(2000);  
                $('.progress').show();
                $('.progress').fadeOut(2000);
                Swal.fire({
                    type: 'success',
                    title: 'Speaker has been added successfully',
                    showConfirmButton: false,
                    timer: 2000
                })
                .then((value) => {
                    window.location.href = "{{url('speakers')}}";
                });
                // setTimeout(function () {
                //     window.location.href = "{{url('speakers')}}";
                // }, 2020);
            },
            error: function (e) {
                $('.error').show();
                $('.myprogress').hide();
                var errors =    JSON.parse(e.responseText)

                 $.each(errors, function (index, value) {
                $("#"+index+"-error").text(value[0]);
                    
                    console.log("#"+index+"-error", value[0]);
                });

                $("#submitbtn").prop("disabled", false);

            },

        });
    });

    /*Delete Speaker */

    $(".deleteProduct").click(function(){
        const swalButton = Swal.mixin({
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn btn-danger',
            animation: false,
            customClass: 'animated tada',
            buttonsStyling: false,
        })
        swalButton.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            type: "warning",
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel!',
            reverseButtons: true
        })
        .then((result)=>{
            if(result.value)
            {
                var id = $(this).data("id");
                var token = $(this).data("token");
                $("#submitbtn").prop("disabled", true);
                $.ajax(
                {
                    url: "{{url('speakers/delete').'/'}}"+id,
                    type: 'get',
                    dataType: "JSON",
                    data: {
                        "id": id,
                        "_method": 'DELETE',
                        "_token": token,
                    },
                    success: function (data)
                    {
                        Swal.fire({
                        type: 'success',
                        title: 'Speaker has been deleted successfully',
                        showConfirmButton: false,
                        timer: 1500
                        })
                        .then((value) => {
                            window.location.href = "{{url('speakers')}}";
                        });

                        $("#submitbtn").prop("disabled", false);
                    },
                    error: function ()
                    {
                        $("#submitbtn").prop("disabled", false);
                        console.log("It failed");
                    }
                });
            }else if(result.dismiss === Swal.DismissReason.cancel) 
            {
                swalButton.fire(
                'Cancelled',
                'Speaker record  is safe!',
                'error'
                )
            }
        });
    });
    
    //Croppie

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('.cr-boundary').remove();
                $('#my-image').attr('src', e.target.result);
                var resize = new Croppie($('#my-image')[0], {
                    viewport: { width: 100, height: 100 },
                    boundary: { width: 150, height: 150 },
                    showZoomer: false,
                    enableResize: true,
                    enableOrientation: true
                });

                $('#use').fadeIn();
                $('#use').on('click', function() {
                    resize.result('base64').then(function(dataImg) {
                    var data = [{ image: dataImg }, { name: 'myimgage.jpg' }];
                    croped_image = dataImg;
                    $('#result').attr('src', dataImg);
                    $('.cr-boundary').hide();
                    $('#use').hide();
                    // $('#single-photo-add').hide();
                    })
                })
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#imgInp").change(function() {
        $("#crop").show();
        $(".img-error").empty();
        readURL(this);
    });
    

    /*Image Preview code*/
    $(function() {
        var imagesPreview = function(input, placeToInsertImagePreview) {
            if (input.files) {
                var filesAmount = input.files.length;
            
                for (i = 0; i < filesAmount; i++) {

                    var fileName = input.files[i].name;
                    var fileExtension = fileName.substr((fileName.lastIndexOf('.') + 1));
                    console.log(fileExtension);
                    
                    var reader = new FileReader();
                    if(fileExtension == 'png'  || fileExtension == 'jpg' || fileExtension == 'jpeg'|| fileExtension == 'svg' || fileExtension == 'gif')
                    {
                        reader.onload = function(event) {
                            $($.parseHTML('<img>' )).attr('src', event.target.result).appendTo(placeToInsertImagePreview);
                        }
                    }else{
                        reader.onload = function(event) {
                            $($.parseHTML('<img>' )).appendTo(placeToInsertImagePreview);
                        }
                    }
                    reader.readAsDataURL(input.files[i]);
                }
            }
        };

        /* Multiple image validation */
        $('body').on('change', '#file', function () {
            $('.btn-danger').show();
            $('#gallery-photo-add').hide();
            $('#error-pera').hide();

            if(this.files.length<4){
                imagesPreview(this, 'span.gallery');
            }else{
                $('#gallery-photo-add').show();
                $('#gallery-photo-add').after("<p class = 'error' id = 'error-pera'>Only three images are allowed</p>");
                $('.btn-danger').hide();
            }
        });
    });

        /* Multi image one by one*/

    // $('body').on('change', '#file', function ()
    //     {
    //         $('#hide-btn').hide()
    //         if (this.files && this.files[0])
    //         {
    //             $.each(this.files, function( index, value ) {
    //                 if (!/\.(jpe?g|png|gif)$/i.test(value.name)) {
    //                 return alert(this.value.name + " is not an image");
    //                 }else{
    //                     console.log(value);
    //                 abc += index; //increementing global variable by 1
    //                 var z = abc - 1;
    //                 console.log(abc);
    //                     // var x = $(this)
    //                     //     .parent()
    //                     //     .find('#previewimg' + z).remove();
    //                     // $(this).before("<div id='abcd" + abc + "' class='abcd'><img id='previewimg" + abc + "' src='' style='height: 100px; width: 100px;  border: 2px dashed #f69c55;'/></div>");
    //                 var reader = new FileReader();
    //                 reader.onload = function(event) {
    //                     $($.parseHTML('<img>')).attr('src', event.target.result).appendTo("#filesInfo");
    //                 }

    //                 reader.onload = imageIsLoaded;
    //                 reader.readAsDataURL(this.value);
    //                 $(this).hide();
    //                 }
    //             });
    //         }
    //     });


    /* image preview */
    
    // function imageIsLoaded(e)
    // {
    //     $('#previewimg' + abc)
    //         .attr('src', e.target.result);
    // };

    /*  Progress bar using malsup */
    // $(function() {
    //     var bar = $('.bar');
    //     var percent = $('.percent');
    //     var status = $('#status');
    //     $('form').ajaxForm({
    //         beforeSend: function() {
    //             status.empty();
    //             var percentVal = '0%';
    //             bar.width(percentVal);
    //             percent.html(percentVal);
               
    //         },
    //         uploadProgress: function(event, position, total, percentComplete) {
    //             var percentVal = percentComplete + '%';
    //             bar.width(percentVal);
    //             percent.html(percentVal);
    //         },
    //         success: function() {
    //             var percentVal = 'Wait, Saving';
    //             bar.width(percentVal);
    //             percent.html(percentVal);
    //         },
    //         complete: function(xhr, response) {
    //             status.html(xhr.responseText);
    //             console.log(response);
    //             // for (var i = 0; i < data.status.length; i++) {            
    //                 var div = document.getElementById('images');
    //                 var img = document.createElement('img');
    //                 img.setAttribute('src',"");
    //                 img.setAttribute('width','150px');
    //                 img.setAttribute('height','150px');
    //             // }
    //         // if(data.status === 200)
    //         // {
    //         //     window.location = "{{url('speakers')}}";
    //         // }
    //         }         
    //     });
    // });

</script>