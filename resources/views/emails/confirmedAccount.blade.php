@component('mail::message')
Confirmation de la création de votre compte
# Cher(e) {{ $confirmedEmail['name'] }}
<br>
@component('mail::panel')
    Vous Intervenez dans {{ $confirmedEmail['role'] }}
    <br>
    Votre compte a été créé avec succès, Veuillez l'activer en cliquant sur le lien ci-dessous.
    <br>
    Après activation du compte, vous pouvez vous connecter avec ces identifiants.
    <br>
    <br>
    Email : {{ $confirmedEmail['email'] }}
    <br>
    Mot de passe  : {{ $confirmedEmail['password'] }}
@endcomponent


@component('mail::button', ['url' => $confirmedEmail['url']])
    Confirmer votre compte
@endcomponent

<br>

@component('mail::panel')
    Si vous n'arrivez pas a cliquer sur le bouton ci-dessus utiliser ce lien pour accéder a notre site web <a href="{{ $confirmedEmail['url'] }}">{{ $confirmedEmail['url'] }}</a>
@endcomponent

Merci,<br> {{ config('app.name') }}
@endcomponent
