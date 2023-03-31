@component('mail::message')

Selamat Kuesioner "{{$form->title}}" sudah dibuat.

Jika ingin menshare Kuesioner ini, berikut link:

@component('mail::panel')
{{$form->share_url}}
@endcomponent

Jika ingin mengembed ke website yang lain, Salin dan tempelkan kode berikut:
@component('mail::panel')
 {{ '<iframe style="border:none;width:100%;" height="620px" src="'.$form->share_url.'"></iframe>' }}
@endcomponent

{{-- Finally, we created a **Facebook group** with all the other users to share all the exciting news and tutorials about NotionForms.
I would love to see you there, here is the link:

@component('mail::button', ['url' => config('links.facebook_group')])
Join Facebook Group
@endcomponent --}}

@endcomponent
