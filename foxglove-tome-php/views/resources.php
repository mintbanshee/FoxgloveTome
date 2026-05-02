<?php

// *~*~*~*~*~*~* SUPPORT RESOURCES *~*~*~*~*~*~*

include __DIR__ . '/header.php';

$resources = require __DIR__ . '/../config/resources.php';

?> 

<div class="container py-3">

<!--*~*~*~*   Header/Welcome    *~*~*~*-->
  <div class="mb-2 text-center">
    <h1 class="montecarlo-regular mb-4 fw-bold">Support Resources</h1>
    <p class="lead mb-4">Our mission is to provide a safe and supportive environment for everyone but we, ourselves, are not able to provide all the support you may need.</p>
    <p class="mb-4">If you are in crisis or need immediate help, please reach out to one of the following resources:</p>
  </div>


    <div class="row justify-content-center">
        <div class="col-md-6 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body d-flex flex-column">
                  <h2 class="card-title text-center mb-4 montecarlo-regular">Find Local Support</h2>

                      <!--*~*~*~*   Select Country to Populate Resources   *~*~*~*-->
                        <div class="mb-5">
                          <p class="fw-semibold mb-3">Please select a country to view a list of resources:</p>
                          <select id="country" class="form-select">
                            <option value="">-- Choose a country first --</option>

                            <?php foreach ($resources as $country => $countryResources): ?>
                              <option value="<?= htmlspecialchars($country) ?>">
                                <?= htmlspecialchars($country) ?>
                              </option>
                            <?php endforeach; ?>
                          </select>
                        </div>

                        <!-- display the selected country's resources from the config file -->

                        <div id="resourceGroups">
                          <?php foreach ($resources as $country => $countryResources): ?>
                            <div class="resource-group d-none" data-country="<?= htmlspecialchars($country) ?>">

                              <?php foreach ($countryResources as $resource): ?>
                                <div class="card mb-3 shadow-sm">
                                  <div class="card-body">
                                    <h3 class="h5 mb-2"><?= htmlspecialchars($resource['name']) ?></h3>

                                    <p><?= htmlspecialchars($resource['description']) ?></p>

                                    <p class="mb-1">
                                      <strong>Call:</strong> <?= htmlspecialchars($resource['contact']) ?>
                                    </p>

                                    <?php if (!empty($resource['text'])): ?>
                                      <p class="mb-1">
                                        <strong>Text:</strong> <?= htmlspecialchars($resource['text']) ?>
                                      </p>
                                    <?php endif; ?>

                                    <a href="<?= htmlspecialchars($resource['link']) ?>"
                                      target="_blank"
                                      class="btn btn-outline-success rounded-pill mt-3">
                                      Visit Resource
                                    </a>
                                  </div>
                               </div>
                              <?php endforeach; ?>

                            </div>
                          <?php endforeach; ?>
                        </div>


                        <!-- Find more help and contact us -->

                        <div class="mb-4 text-center">
                          <h3 class="montecarlo-regular mb-4 mt-3 fw-bold">Couldn't find your country or need more options?</h3>
                          <p class="lead mb-4">We are sorry we haven't added what you're looking for.</p>
                          <p class="mb-4">Here is a trusted resource to help you find support in your area</p>
                          <a href="https://findahelpline.com" 
                            target="_blank" 
                            class="btn btn-success rounded-pill px-4 mb-2">
                            Find a Helpline
                          </a>
                          <p class="mt-5">Please feel free to email us to suggest resources to add to our directory.</p>
                          <a href="mailto:mintbanshee@gmail.com?subject=Foxglove%20Resource%20Suggestion"
                              class="btn btn-outline-success rounded-pill px-4 mt-2 mb-2">
                              Suggest a Resource via Email Here
                          </a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>    
</div>  

<!-- Bottom Nav -->
<nav class="navbar fixed-bottom navbar-sanctuary navbar-dark border-top d-flex align-items-center" style="height:70px;">
  <div class="container-fluid justify-content-around align-items-center">

    <a href="javascript:history.back()" class="btn btn-light btn-outline-primary rounded-pill px-4">
      Back
    </a>

    <a class="btn btn-light btn-outline-success rounded-pill px-3" 
        href="<?= BASE_URL ?>views/users/user_dashboard.php">
        Login/Dashboard
    </a>

  </div>
</nav>

<!-- script for dropdown menu -->

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const countrySelect = document.getElementById('country');
    const resourceGroups = document.querySelectorAll('.resource-group');

    countrySelect.addEventListener('change', function () {
      resourceGroups.forEach(group => {
        group.classList.add('d-none');

        if (group.dataset.country === this.value) {
          group.classList.remove('d-none');
        }
      });
    });
  });
</script>

<?php include __DIR__ . '/footer.php'; ?>