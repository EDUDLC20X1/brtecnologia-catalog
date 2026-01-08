@component('mail::message')

# Exportación Lista

Tu exportación de productos en PDF está lista. Puedes descargarla desde el siguiente enlace:

@component('mail::button', ['url' => $url])
Descargar PDF
@endcomponent

Gracias,

El equipo de B&R Tecnología

@endcomponent
