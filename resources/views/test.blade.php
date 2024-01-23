@foreach ($users as $key=> $user)
   @if($key == 1)
    {{ $user }}
   @endif
@endforeach
