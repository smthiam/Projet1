@extends ('layouts')


@section('container')
<h1>Contactez-nous</h1>
<br>
<form action="" method="POST">
<input type="hidden" name="_token" value="{{ csfr_token() }}">
<p><input name="email"  type="text" placeholder="Email"></p>
<p><input name="object" type="text" placeholder="object"></p>
<p><textarea name="message" id="" cols="30" rows="10" placeholder="Votre message..."> </textarea></p>
<button type="submit">Envoyer</button>
</form>
@endsection