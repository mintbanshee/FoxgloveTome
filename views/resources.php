<!-- views/resources.php -->

<?php

include __DIR__ . '/header.php';

$resources = require __DIR__ . '/../config/resources.php';

?> 

<div class="container py-5">

  <div class="mb-4 text-center">
    <h1 class="montecarlo-regular mb-4 fw-bold">Support Resources</h1>
    <p class="lead mb-4">Our mission is to provide a safe and supportive environment for everyone but we, ourselves, are not able to provide all the support you may need.</p>
    <p class="mb-4">If you are in crisis or need immediate help, please reach out to one of the following resources:</p>
  </div>

    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body d-flex flex-column">
                  <h2 class="card-title text-center mb-4 montecarlo-regular">Find Your Resources</h2>
                        <div class="mb-5">
                          <p class="fw-semibold mb-3">Select your country:</p>
                          <select id="country" class="form-select">
                            <option value="">-- Choose a country --</option>
                            <option value="Canada">Canada</option>
                            <option value="USA">USA</option>
                          </select>
                        </div>

                        <div class="mb-4 text-center">
                          <h3 class="montecarlo-regular mb-4 fw-bold">Couldn't Find Your Country?</h3>
                          <p class="lead mb-4">We are sorry we haven't added your country yet.</p>
                          <p class="mb-4">Here is a trusted resource to help you find support in your area</p>
                          <a href="https://findahelpline.com" 
                            target="_blank" 
                            class="btn btn-outline-success rounded-pill px-4">
                            Find a Helpline
                          </a>
                        </div>