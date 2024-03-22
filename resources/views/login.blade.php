@extends('layout.landing_master')
@section('content')
@section('title', 'Home')

<div class="site-section bg-image2 overlay"  id="contact-section" style="background-image: url({{asset('front/images/about_us.jpg')}});">
    <div class="container" style="margin-top: 60px">
    
    <div class="row justify-content-center">
    <div class="col-lg-7 mb-5">
    
    <form method="POST"  id="login" class="p-5 bg-white">
        @csrf
        @method('POST')
    <h2 class="h4 text-black mb-5" style="font-weight:bolder">Login</h2>
    
    <div class="row form-group">
    <div class="col-md-12">
    <label class="text-black" for="email">Email</label>
    <input type="email" id="email" name="email" class="form-control rounded-0">
    <span class="text-danger error-text email_error"></span>
    </div>
    </div>
    <div class="row form-group">
    <div class="col-md-12">
    <label class="text-black" for="password">Password</label>
    <input type="password" name="password" id="password" class="form-control rounded-0">
    <span class="text-danger error-text password_error"></span>
    </div>
    
    </div>
    <div class="row form-group">
        <div class="col-md-12">
        <input type="submit" id="loginBtn" value="Login" class="btn btn-primary mr-2 mb-2">
    </div>
    </form>
    </div>
    </div>
    </div>
    </div>

    
<script type="text/javascript" src="{{asset('js/jquery.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>

      $("#login").submit(function(e){
        e.preventDefault();

        var all = $(this).serialize();
        //console.log(all);
        $.ajax({
            url:  "",
            type: "POST",
            data: all,


            beforeSend:function(){
               // $(document).find('span.error-text').text('');
                $('#loginBtn').prop('disabled',true);
                $('#loginBtn').css('cursor', 'not-allowed');
                $('#loginBtn').html('<span class="flex justify-center items-center">Authenticating... </span>');
            },

            success: function(data){

                if (data.status==0) {
                    $.each(data.error, function(prefix, val){
                        $('span.'+prefix+'_error').text(val[0]);
                    });
                   // $('#save').prop('disabled', false);
                    $("#loginBtn").attr('disabled',false);
                    $('#loginBtn').css('cursor', 'pointer');
                    $('#loginBtn').html('<span class="flex justify-center items-center">Sign Up </span>');
                }
                if(data == 1){
                    toastr.success("Login Successful");
                    setInterval(function(){
                        window.location.replace('{{route("dashboard.admin.index")}}');
                    },2000)

                }else if(data == 3){
                    toastr.success("Login Successful");
                    setInterval(function(){
                      
                    },2000)

                }else if(data == 9){
                    toastr.error("Error occured: Account Inactive");
                    $("#loginBtn").attr('disabled',false);
                    $('#loginBtn').css('cursor', 'pointer');
                    $('#loginBtn').html('<span class="flex justify-center items-center">Sign Up </span>');

                }else if(data == 10){
                    toastr.error("Error occured: Subscription Expired");
                    $("#loginBtn").attr('disabled',false);
                    $('#loginBtn').css('cursor', 'pointer');
                    $('#loginBtn').html('<span class="flex justify-center items-center">Sign Up </span>');

                }else if (data == 12){
                    toastr.success("Login Successful");
                    setInterval(function(){ //customer dashboard login
                        window.location.href = document.referrer;
                    },2000)

                }else if(data == 7){
                    toastr.error("Error occured: Incorrect Email/Password");
                    $("#loginBtn").attr('disabled',false);
                    $('#loginBtn').css('cursor', 'pointer');
                    $('#loginBtn').html('<span class="flex justify-center items-center">Sign Up </span>');

                }else{
                   //alert();

                }
            }
        })
    });
</script>
    @endsection
