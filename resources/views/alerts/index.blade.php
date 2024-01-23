<div>
    @if(Session::has($alert))
         @if($alert)
             <div class="alert {{ $alert }} alert-dismissible fade show" role="alert">
                 <strong>{{ $alertName }}!</strong> {{ $sessionMessage}}.
                 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                 </button>
             </div>
         @endif
    @endif

 </div>
