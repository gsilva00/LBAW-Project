@extends('layouts.app')

@section('title', 'About Us')

@section('content')
    <div id="contacts-header">
        <div>
            <h1>About Us</h1>
            <p>NewFlow is a news website created by a small team of developers at FEUP. Its goal is to make important
                information easy to access for both students and professionals, all in a simple web format. In short,
                NewFlow aims to give up-and-coming and experienced journalists a platform to share their stories with
                the wider community.</p>
            <p>"We give you all the knowledge. What do you do with it is in your hands..."</p>
            <h1>What Are The Perks Of Being With Us?</h1>
            <p>Well, you can say...</p>
        </div>
    </div>
    <div id="contacts-content">
        <div id="contacts-phone">
            <i class='bx bx-ghost'></i>
            <h2>Don't become a ghost</h2>
            <p>Are you behind the times like an old newspaper? Here, you can stay updated with the current world in less than few seconds!</p>
        </div>
        <div id="contacts-mail">
            <i class='bx bx-wink-smile'></i>
            <h2>A factual space</h2>
            <p>Tired of fake news spreading in social media? Don't worry! The news we share to you are examined carefully by our community!</p>
        </div>
        <div id="contacts-pin">
            <i class='bx bxs-invader'></i>
            <h2>Everything anytime</h2>
            <p>Your experience will be tailored to your preferences. Of course, you can always search for a niche article buried in the depths!</p>
        </div>
    </div>

@endsection