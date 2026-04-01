Hei {{ $guest_name }},

Du er invitert til {{ $event_title }}.

@isset($event_date)
Dato og tid: {{ date('d.m.Y H:i', strtotime($event_date)) }}
@endisset

@isset($event_location)
Sted: {{ $event_location }}
@endisset

Melding fra vert:
{{ $message_text }}

Vennlig hilsen,
{{ $sender_name }}
via Samling.no
