<?php $session_menu = explode(',', Auth::user()->akses_submenu); ?>
<?php $id = Crypt::encryptString($model->id); ?>
@if (in_array('44', $session_menu))
    @if (Auth::user()->roles == 'Administrator')
        <a href="{{ route('primession.edit', $id) }}" class="text-info"><i class="mdi mdi-cogs font-size-18"></i></a>
    @else
        @if ($model->roles != 'Administrator')
            <a href="{{ route('primession.edit', $id) }}" class="text-info"><i class="mdi mdi-cogs font-size-18"></i></a>
        @endif
    @endif
@endif
