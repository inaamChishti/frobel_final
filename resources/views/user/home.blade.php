@extends("layouts.auth")

@section("styles")
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<style>
    #foo {
    position: fixed;
    bottom: 12px;
    right: 5px;
  }
  .card{
    min-height: 150px !important;
    padding: 25px 50px 50px 50px !important;
    width: 294px !important;
    height: 150px !important;
    background-color: #337ab7;
    text-align: center;
    color: #fff !important;
    font-size: 17px !important;
    font-style: italic !important;
    line-height: 21px !important;
    font-weight: 700 !important;
    -webkit-transition-delay: 1500ms !important;
}
</style>
@endsection

@section("content")
{{-- style="background-image: url({{asset('img/wallpaper/bg.jpeg')}})" --}}
<div class="container-fluid flex-grow-1 container-p-y" >

    <h4 class="font-weight-bold py-3 mb-4">
      {{-- @if (auth()->user()) --}}
      {{-- @foreach (auth()->user()->roles as $role)
          @if ($role->name == 'Super Admin')
            Super Admin
          @elseif ($role->name == 'Admin')
            Admin
          @elseif ($role->name == 'Supervisor')
            Supervisor
          @else
            User
          @endif
      @endforeach
    @endif --}}
    Dashboard
    </h4>

    <div id="foo" class="toast" data-autohide="false" style="background-color:white;border-radius: 20px 20px 20px 20px">
        <div class="toast-header" style="padding: 10px" >
          <img src="{{ asset('img/frobel-logo3.png') }}" width="40px">
          <strong class="mr-auto" style="color: #337ab7">
            {{-- @if (auth()->user())
            @foreach (auth()->user()->roles as $role)
                @if ($role->name == 'Super Admin')
                  Super Admin
                @elseif ($role->name == 'Admin')
                  Admin
                @elseif ($role->name == 'Supervisor')
                  Supervisor
                @else
                  User
                @endif
            @endforeach
          @endif --}}
            Dashboard!</strong>
            <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="toast-body mr-auto card" style=" color:white">
          Welcome to Frobel School Management System.
        </div>
      </div>




  </div>
@endsection

@section("scripts")
<script>
    $('.toast').toast('show')
</script>
@endsection
