<div class="alert alert-{{$style or 'default'}} {{(isset($dimissible) && $dimissible)?'alert-dimissible':''}}">
    @if(isset($dimissible) && $dimissible)
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    @endif
    <h4>
        <i class="icon fa fa-{{$icon or ''}}"></i> {{$title}}
    </h4>
    {{$slot}}
</div>