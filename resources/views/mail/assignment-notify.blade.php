<x-mail::message>
# The {{ $data['title'] }} has been updated

Hello {{ $user->name }},

You have an update for your assignment - {{ $data['title'] }}!
 
<x-mail::button :url="$url">
View Assignment
</x-mail::button>
 
Thanks,<br>
{{ config('app.name') }}
</x-mail::message>