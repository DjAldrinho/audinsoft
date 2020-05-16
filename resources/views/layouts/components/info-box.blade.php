<div class="info-box {{$bg or ''}}">
    <span class="info-box-icon">
        <i class="fa {{$icon or ''}}"></i>
    </span>

    <div class="info-box-content">
        <span class="info-box-text">{{$title}}</span>
        <span class="info-box-number">{{$number}}</span>

        @if($progress)
            <div class="progress">
                <div class="progress-bar" style="width: {{$progress_number}}%"></div>
            </div>
            <span class="progress-description">
          {{$progress_number}} {{$description}}
        </span>
        @endif
    </div>
</div>