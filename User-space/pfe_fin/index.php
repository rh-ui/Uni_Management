<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard</title>
  <link rel="stylesheet" href="css/all.min.css" />
  <link rel="stylesheet" href="css/framework.css" />
  <link rel="stylesheet" href="css/master.css" />
  <link rel="stylesheet" href="css/boxicons.min.css">
  <link rel="stylesheet" href="https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css">
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;500&display=swap" rel="stylesheet" />
</head>

<body>
  <!-------------------------------------------------Side Bar-------------------------------------------------->
  <?php include('sidebar.php'); ?>
  <!------------------------------------------------------------------------------------------------------->
  <div class="page d-flex">
    <div class="content w-full">
      <!-- Start Head -->
      <div class="head bg-white p-15 between-flex">
        <div class="search p-relative">

        </div>
        <div class="icons d-flex align-center">
          <span class="notification p-relative">
            <i class="fa-regular fa-bell fa-lg"></i>
          </span>
          <img src="imgs/face-1.png" alt="" />
        </div>
      </div>
      <!-- End Head -->
      <h1 class="p-relative">Dashboard</h1>
      <div class="wrapper d-grid gap-20">
        <!-- Start Welcome Widget -->
        <div class="welcome bg-white rad-10 txt-c-mobile block-mobile">
          <div class="intro p-20 d-flex space-between bg-white">
            <div>
              <h2 class="m-0">Welcome</h2>
              <p class="c-grey mt-5">Elzero</p>
            </div>
            <img class="hide-mobile" src="imgs/welcome2.png" alt="" />
          </div>
          <img src="imgs/face-1.png" alt="" class="avatar" />
          <div class="body txt-c d-flex p-20 mt-20 mb-20 block-mobile bg-eee">
            <div>Osama Elzero <span class="d-block c-grey fs-14 mt-10">Developer</span></div>
            <div>80 <span class="d-block c-grey fs-14 mt-10">Projects</span></div>
            <div>$8500 <span class="d-block c-grey fs-14 mt-10">Earned</span></div>
          </div>
          <a href="profile.html" class="visit d-block fs-14 bg-blue c-white w-fit btn-shape">Profile</a>
        </div>
        <!-- End Welcome Widget -->
        <!-- Start Quick Draft Widget -->
        <div class="quick-draft p-20 bg-white rad-10">
          <h2 class="mt-0 mb-10">Quick Draft</h2>
          <p class="mt-0 mb-20 c-grey fs-15">Write A Draft For Your Ideas</p>
          <form>
            <input class="d-block mb-20 w-full p-10 b-none bg-eee rad-6" type="text" placeholder="Title" />
            <textarea class="d-block mb-20 w-full p-10 b-none bg-eee rad-6" placeholder="Your Thought"></textarea>
            <input class="save d-block fs-14 bg-blue c-white b-none w-fit btn-shape" type="submit" value="Save" />
          </form>
        </div>
        <!-- End Quick Draft Widget -->
        <!-- Start Statistics Widget -->
        <div class="targets p-20 bg-white rad-10">
          <h2 class="mt-0 mb-10">Statistics</h2>

        </div>
        <!-- End Statistics Widget -->
        <!-- Start Ticket Widget   -->
        <div class="tickets p-20 bg-white rad-10">
          <h2 class="mt-0 mb-10">Tickets Statistics</h2>
          <p class="mt-0 mb-20 c-grey fs-15">Everything About Support Tickets</p>
          <div class="d-flex txt-c gap-20 f-wrap">
            <div class="box p-20 rad-10 fs-13 c-grey">
              <i class="fa-regular fa-rectangle-list fa-2x mb-10 c-orange"></i>
              <span class="d-block c-black fw-bold fs-25 mb-5">2500</span>
              Total
            </div>
            <div class="box p-20 rad-10 fs-13 c-grey">
              <i class="fa-solid fa-spinner fa-2x mb-10 c-blue"></i>
              <span class="d-block c-black fw-bold fs-25 mb-5">500</span>
              Pending
            </div>
            <div class="box p-20 rad-10 fs-13 c-grey">
              <i class="fa-regular fa-circle-check fa-2x mb-10 c-green"></i>
              <span class="d-block c-black fw-bold fs-25 mb-5">1900</span>
              Closed
            </div>
            <div class="box p-20 rad-10 fs-13 c-grey">
              <i class="fa-regular fa-rectangle-xmark fa-2x mb-10 c-red"></i>
              <span class="d-block c-black fw-bold fs-25 mb-5">100</span>
              Deleted
            </div>
          </div>
        </div>
        <!-- End Ticket Widget -->
        <!-- Start Latest News Widget -->
        <div class="latest-news p-20 bg-white rad-10 txt-c-mobile">
          <h2 class="mt-0 mb-20">Calendrier</h2>

        </div>
        <!-- End Latest News Widget -->
        <!-- Start Latest Uploads Widget -->
        <div class="latest-uploads p-20 bg-white rad-10">
          <h2 class="mt-0 mb-20">Latest Uploads</h2>
          <ul class="m-0">
            <li class="between-flex pb-10 mb-10">
              <div class="d-flex align-center">
                <img class="mr-10" src="imgs/pdf.svg" alt="" />
                <div>
                  <span class="d-block">my-file.pdf</span>
                  <span class="fs-15 c-grey">Elzero</span>
                </div>
              </div>
              <div class="bg-eee btn-shape fs-13">2.9mb</div>
            </li>
            <li class="between-flex pb-10 mb-10">
              <div class="d-flex align-center">
                <img class="mr-10" src="imgs/avi.svg" alt="" />
                <div>
                  <span class="d-block">My-Video-File.avi</span>
                  <span class="fs-15 c-grey">Admin</span>
                </div>
              </div>
              <div class="bg-eee btn-shape fs-13">4.9mb</div>
            </li>
            <li class="between-flex pb-10 mb-10">
              <div class="d-flex align-center">
                <img class="mr-10" src="imgs/psd.svg" alt="" />
                <div>
                  <span class="d-block">My-Psd-File.pdf</span>
                  <span class="fs-15 c-grey">Osama</span>
                </div>
              </div>
              <div class="bg-eee btn-shape fs-13">4.5mb</div>
            </li>
            <li class="between-flex pb-10 mb-10">
              <div class="d-flex align-center">
                <img class="mr-10" src="imgs/zip.svg" alt="" />
                <div>
                  <span class="d-block">My-Zip-File.pdf</span>
                  <span class="fs-15 c-grey">User</span>
                </div>
              </div>
              <div class="bg-eee btn-shape fs-13">8.9mb</div>
            </li>
            <li class="between-flex pb-10 mb-10">
              <div class="d-flex align-center">
                <img class="mr-10" src="imgs/dll.svg" alt="" />
                <div>
                  <span class="d-block">My-DLL-File.pdf</span>
                  <span class="fs-15 c-grey">Admin</span>
                </div>
              </div>
              <div class="bg-eee btn-shape fs-13">4.9mb</div>
            </li>
            <li class="between-flex">
              <div class="d-flex align-center">
                <img class="mr-10" src="imgs/eps.svg" alt="" />
                <div>
                  <span class="d-block">My-Eps-File.pdf</span>
                  <span class="fs-15 c-grey">Designer</span>
                </div>
              </div>
              <div class="bg-eee btn-shape fs-13">8.9mb</div>
            </li>
          </ul>
        </div>
        <!-- End Latest Uploads Widget -->
        <!-- Start Last Project Progress Widget -->
        <div class="last-project p-20 bg-white rad-10 ">
          <h2 class="mt-0 mb-20">Last Project Progress</h2>
          <ul class="m-0">
            <li class="mt-25 d-flex align-center done">Got The Project</li>
            <li class="mt-25 d-flex align-center done">Started The Project</li>
            <li class="mt-25 d-flex align-center done">The Project About To Finish</li>
            <li class="mt-25 d-flex align-center current">Test The Project</li>
            <li class="mt-25 d-flex align-center">Finish The Project & Get Money</li>
          </ul>
          <img class="launch-icon hide-mobile" src="imgs/project.png" alt="" />
        </div>
        <!-- End Last Project Progress Widget -->
        <!-- Start Reminders Widget -->
        <div class="reminders p-20 bg-white rad-10">
          <h2 class="mt-0 mb-25">Reminders</h2>
          <ul class="m-0">
            <li class="d-flex align-center mt-15">
              <span class="key bg-blue mr-15 d-block rad-half"></span>
              <div class="pl-15 blue">
                <p class="fs-14 fw-bold mt-0 mb-5">Check My Tasks List</p>
                <span class="fs-13 c-grey">28/09/2022 - 12:00am</span>
              </div>
            </li>
            <li class="d-flex align-center mt-15">
              <span class="key bg-green mr-15 d-block rad-half"></span>
              <div class="pl-15 green">
                <p class="fs-14 fw-bold mt-0 mb-5">Check My Projects</p>
                <span class="fs-13 c-grey">26/10/2022 - 12:00am</span>
              </div>
            </li>
            <li class="d-flex align-center mt-15">
              <span class="key bg-orange mr-15 d-block rad-half"></span>
              <div class="pl-15 orange">
                <p class="fs-14 fw-bold mt-0 mb-5">Call All My Clients</p>
                <span class="fs-13 c-grey">05/11/2022 - 12:00am</span>
              </div>
            </li>
            <li class="d-flex align-center mt-15">
              <span class="key bg-red mr-15 d-block rad-half"></span>
              <div class="pl-15 red">
                <p class="fs-14 fw-bold mt-0 mb-5">Finish The Development Workshop</p>
                <span class="fs-13 c-grey">20/12/2022 - 12:00am</span>
              </div>
            </li>
          </ul>
        </div>
        <!-- End Reminders Widget -->
      </div>
    </div>
  </div>

  <!--Sidebar Script-->
  <script src="js/app.js"></script>
</body>

</html>