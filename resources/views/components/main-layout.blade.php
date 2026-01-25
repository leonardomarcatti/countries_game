<!DOCTYPE html>
<html lang="pt">

    <x-top :pageTitle="$pageTitle" />

    <body>
        <x-header />
        {{$slot}}
        <x-footer />
    </body>

</html>
