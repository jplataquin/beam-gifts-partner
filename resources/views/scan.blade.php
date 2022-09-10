@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Scan</h1>
    <video id="vidEl"></video>
    <script type="module">
        import QrScanner from '/qr-scanner.min.js';

        const vidEl = document.querySelector('#vidEl');

        const qrScanner = new QrScanner(
            vidEl,
            result => console.log('decoded qr code:', result),
            { /* your options or returnDetailedScanResult: true if you're not specifying any other options */ },
        );

        console.log(qrScanner);
    </script>
</div>
@endsection
