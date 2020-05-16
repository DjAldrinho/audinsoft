<div class="small-box {{$bg or ''}}">
    <div class="inner">
        <h3>{{$number}}</h3>

        <p>{{$title}}</p>
    </div>
    <div class="icon">
        <i class="fa fa-{{$icon or ''}}"></i>
    </div>
    <a href="{{route('listar-reservas')}}" class="small-box-footer">
        Mas info <i class="fa fa-arrow-circle-right"></i>
    </a>
</div>