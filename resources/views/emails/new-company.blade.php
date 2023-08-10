@component('mail::message')
# New Company Created

A new company has been created.

@component('mail::button', ['url' => route('companies.index')])
View Companies
@endcomponent

Thanks,
{{ config('app.name') }}
@endcomponent
