<?php include __DIR__ ."/../includes/header_home.php"; ?>

<div class="container-fluid flex-grow-1">
  <div class="row">

    <!-- Main -->
    <main class="col-12 px-4 py-4">

      <div class="mb-3 border-bottom pb-2">
        <h1 class="h2">Dashboard</h1>
      </div>

      <!-- Stat Cards -->
      <div class="row g-3 mb-4">

        <div class="col-md-4">
          <div class="card border-0 shadow-sm p-3">
            <div class="d-flex align-items-center gap-3">
              <div class="bg-info text-white rounded p-3">
                <i class="bi bi-people-fill fs-4"></i>
              </div>
              <div>
                <h3 class="mb-0">70</h3>
                <small class="text-muted">Total Members</small>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-4">
          <div class="card border-0 shadow-sm p-3">
            <div class="d-flex align-items-center gap-3">
              <div class="bg-primary text-white rounded p-3">
                <i class="bi bi-person-check-fill fs-4"></i>
              </div>
              <div>
                <h3 class="mb-0">50 / 20</h3>
                <small class="text-muted">Active / Inactive</small>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-4">
          <div class="card border-0 shadow-sm p-3">
            <div class="d-flex align-items-center gap-3">
              <div class="bg-warning text-white rounded p-3">
                <i class="bi bi-calendar3 fs-4"></i>
              </div>
              <div>
                <h3 class="mb-0">5</h3>
                <small class="text-muted">Events (Year)</small>
              </div>
            </div>
          </div>
        </div>


      </div>

      <!-- Next Event + Recent Activities -->
      <div class="row mt-4 g-3">

        <div class="col-md-6">
          <h5>Next Event</h5>
          <div class="card border-2 border-dashed text-center p-4 bg-light">
            <i class="bi bi-calendar-event fs-1 text-primary mb-2"></i>
            <h6 class="mb-1">Special Service</h6>
            <p class="mb-0">Date: 02/25/2026</p>
            <p class="mb-0">Time: 7:00 PM</p>
            <p>Location: Central Church</p>
          </div>
        </div>

        <div class="col-md-6">
          <h5>Recent Activities</h5>
          <div class="card border p-3">
            <ul class="list-unstyled mb-0">
              <li class="mb-2">
                <i class="bi bi-check-circle-fill text-success me-2"></i>
                Leaders meeting held on 02/10
              </li>
              <li class="mb-2">
                <i class="bi bi-check-circle-fill text-success me-2"></i>
                $500 donation received on 02/12
              </li>
              <li>
                <i class="bi bi-check-circle-fill text-success me-2"></i>
                Prayer event completed on 02/15
              </li>
            </ul>
          </div>
        </div>

      </div>


    </main>
  </div>
</div>

<?php include __DIR__ ."/../includes/footer_home.php"; ?>