@extends('layouts.app')

@section('title', 'Contacts')

@section('content')
    <div id="footer-page-header">
        <div>
            <h1>Get in touch</h1>
            <p>Have questions or feedback? We'd be happy to hear from you. Here's how you can get in touch...</p>
        </div>
    </div>
    <div id="footer-page-content">
        <div id="footer-page-phone">
            <i class='bx bx-phone'></i>
            <h2>Phone</h2>
            <p>Call us at +351 891 639 240</p>
        </div>
        <div id="footer-page-mail">
            <i class='bx bx-envelope'></i>
            <h2>Email</h2>
            <p>Send us an email at newflowfooter-page@up.pt</p>
        </div>
        <div id="footer-page-pin">
            <i class='bx bx-map'></i>
            <h2>Address</h2>
            <p>Rua Dr Roberto Frias, 4200-465, Porto, Portugal</p>
        </div>
    </div>

@endsection