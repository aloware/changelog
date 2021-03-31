@component('mail::message')

    Hello {{ $user->first_name }},

    Welcome to {{ env('APP_NAME') }}.

    Your account admin has invited you to join your company in {{ env('APP_NAME') }}.

    To proceed, click the button below,

@component('mail::button', ['url' => $url, 'color' => 'primary'])
    Open my {{ env('APP_NAME') }} account
@endcomponent

    Thanks,
    {{ config('app.name') }}

    {{-- Subcopy --}}
    @isset($actionText)
        @slot('subcopy')
            @lang(
                "If you’re having trouble clicking the \":actionText\" button, copy and paste the URL below\n".
                'into your web browser:',
                [
                    'actionText' => $actionText,
                ]
            ) <span class="break-all">[{{ $url }}]({{ $url }})</span>
        @endslot
    @endisset
@endcomponent
