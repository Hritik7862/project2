     <!--notifasion app.blade.php-->


     <!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Scripts -->
    
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])




    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.1/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.css">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.all.min.js"></script>


    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="{{ asset('css/app.css') }}?v=1">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>

</head>


<body id="bgimage">
    <div id="main">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm"> 
            <div class="container">
           
                <!-- <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button> -->
  

                <div id="mySidenav" class="sidenav">
                         <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
                         @auth
                         @if (auth()->user()->isAdmin() || auth()->user()->isSuperAdmin())
                             <li class="nav-item">
                                 <a class="nav-link" href="/user">
                                     <i class='fas fa-user-alt'></i> Users
                                 </a>
                             </li>
                         @endif
   
                    
                 <li class="panel panel-default" id="dropdown">
             						<a data-toggle="collapse" href="#dropdown-lvl1">
                                     <i class="fas fa-project-diagram"></i> Projects <i class="fa fa-caret-down"></i>
             						  <span class="caret"></span>
                         </a>
             						<!-- Dropdown level 1 -->
             						<div id="dropdown-lvl1" class="panel-collapse collapse">
             							<div class="panel-body">
             								<ul class="nav navbar-nav">
             									<li><a href="{{ route('project-users') }}">ProjectNames</a></li>
             									<li><a  href="/project">Project Listing</a></li>
             								</ul>
             							</div>
             						</div>
             					</li>
                 <li class="nav-item">
                     <a class="nav-link" href='/task'><i class="fas fa-tasks"></i> Tasks</a>
                 </li>
                 <li class="nav-item">
                     <a class="nav-link" href='/members'><i class="fa fa-refresh"></i> Members</a>
                 </li>
                 @endauth
             </div>
           <span style="font-size:20px;cursor:pointer" onclick="openNav()">&#9776;</span>
           
           <div id="navbarSupportedContent">
   
                 
                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                     
                        @guest

                            @if (Route::has('login'))

                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif
                           
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" hidden href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                                       
                        <li class="nav-item dropdown" >
                        <li class="nav-item">
                             <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="notificationsDropdown" id="notificationDropdown">
                           <li class="dropdown-header text-white" style="background-color: rgb(0, 0, 139);"><h4>Notifications</h4></li>
                           <li class="dropdown-divider"></li>
                           <li id="notificationList"></li>
                            </ul>
                                          
                         </li>
                         <button class="btn btn-dropdown-toggle" type="button" id="notificationLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              <i class="fa fa-bell fa-lg" style="color: #111"></i>
                              <span id="notificationCount" class="badge badge-danger">0</span>
                              </button>
                                  <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                  <img src="{{ asset('storage/' . Auth::user()->profile_picture) }}" alt="{{ Auth::user()->name }}'s Profile Picture" class="profile-picture-small">
                                
                                  @if(Auth::user()->is_active)
                                      <i class="fa fa-circle text-success"></i>
                                  @endif
                              </a>
                                                                                                                           
                                   <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                  <a class="dropdown-item" href="{{ route('profile') }}">
                                      <i class='fas fa-user-alt'></i> My Profile
                                  </a>
                                  
                                  <a class="dropdown-item" href="{{ route('logout') }}"
                                     onclick="event.preventDefault();
                                     document.getElementById('logout-form').submit();">
                                     <i class='fas fa-sign-out-alt'></i> {{ __('Logout') }}
                                  </a>
                              
                                  <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                      @csrf
                                  </form>
                              </div>

                            </li>
                        @endguest
                    </ul>
                     
                </div>
            </div>
        </nav>
        
  
        <main class="py-4">
            @yield('content')
            @yield('project')
        </main>

</body>
</html>
<script>

function openNav() {
  document.getElementById("mySidenav").style.width = "200px";
  document.getElementById("main").style.marginLeft = "200px";
  document.body.style.backgroundColor = "rgba(0,0,0,0.4)";
  document.querySelector("span[onclick='openNav()']").style.display = "none";
  document.querySelector("span[onclick='closeNav()']").style.display = "flex";
}

function closeNav() {
  document.getElementById("mySidenav").style.width = "0";
  document.getElementById("main").style.marginLeft= "0";
  document.body.style.backgroundColor = "white";
  document.querySelector("span[onclick='openNav()']").style.display = "flex";
  document.querySelector("span[onclick='closeNav()']").style.display = "none";
}

function getTimeAgo(date) {
 let currentTime = new Date();
    let timeDifference = currentTime - date;
    let seconds = Math.floor(timeDifference / 1000);
    let minutes = Math.floor(seconds / 60);
    let hours = Math.floor(minutes / 60);
    let days = Math.floor(hours / 24);
    let months = Math.floor(days / 30);

    if (months > 0) {
        return `${months} month${months > 1 ? 's' : ''} ago`;
    } else if (days > 0) {
        return `${days} day${days > 1 ? 's' : ''} ago`;
    } else if (hours > 0) {
        return `${hours} hour${hours > 1 ? 's' : ''} ago`;
    } else if (minutes > 0) {
        return `${minutes} minute${minutes > 1 ? 's' : ''} ago`;
    } else {
        return `${seconds} second${seconds > 1 ? 's' : ''} ago`;
    }
}


$(document).ready(function () {
    $('#notificationLink').on('click', function () {
        var dropdownMenu = $('#notificationDropdown');
        if (dropdownMenu.is(':hidden')) {
            updateNotificationCount();
            dropdownMenu.show();
        } else {
            dropdownMenu.hide();
        }
    });

    function updateNotificationCount() {
    $.ajax({
        url: '/notifications/{taskId}',
        method: 'GET',
        success: function (data) {
        // console.log(data)
            var notificationList = $('#notificationList');
            var notificationCount = $('#notificationCount');

            notificationList.empty();

            if (data.length > 0) {
                var unreadCount = 0;
                data.forEach(function (notification) {
                    if (notification.read != 1) {
                        unreadCount++;
                        var creationDate = new Date(notification.created_at);
                        var formattedDate = getTimeAgo(creationDate);

                        var item = `
                            <div class="notification-item">
                                <div class="notification-content">
                                    <img src="http://127.0.0.1:8000/storage/${notification.task.assigned_to.profile_picture}" class="profile-picture-small" alt="Profile Picture">
                                    ${notification.task.assigned_to.name}
                                    ${notification.task.task_name} ${notification.remark}
                                  
                                                      <br>
                                                      <span class="timestamp">${formattedDate}</span>
                                                      </div>
                                <p><input class="form-check-input buttonhide" type="checkbox" value="" id="${notification.id}"><i class="fa-duotone fa-badge-check"></i></p>
                            </div>`;
                        notificationList.append(item);
                    }
                });

                notificationCount.text(unreadCount);

                if (unreadCount === 1) {
                    dropdownMenu.hide();
                }
            } else {
                notificationCount.text('0');
                notificationList.html('<p class="dropdown-item">No notifications available</p>');
                dropdownMenu.hide();
            }
        },
        error: function (error) {
            console.error('Error fetching notifications:', error);
        }
    });
}






    $(document).on('click', '.buttonhide', function (evt) {
        var id = this.id;
        $.ajax({
            url: "messageread/" + id,
            method: 'get',
            success: function (res) {
                console.log(res);
            }
        });
    });

    updateNotificationCount();
});



</script>

<style>
   .popup {
    display: none;
    position: fixed;
    top: 45%;
    left: 50rem !important;
    transform: translate(-50%, -50%);
    background-color: white;
    border: 1px solid #ccc;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
    z-index: 9999;
    border-radius: 10px;
    max-width: 85%;
    max-height: 80%;
    overflow: scroll;
}

.popup-content {
    text-align: center;
}

.popup-close {
    position: absolute;
    top: 0px;
    right: 5px;
    cursor: pointer;
    font-size: 20px;
}


    .profile-picture-small {
    width: 50px; 
    height: 50px; 
    border-radius: 50%; 
}
</style>

<style>
    .timestamp {
    color: #888;
}
body {
  font-family: "Lato", sans-serif;
  transition: background-color .5s;
}

.sidenav {
  height: 100%;
  width: 0;
  position: fixed;
  z-index: 1;
  top: 0;
  left: 0;
  background-color: #111;
  overflow-x: hidden;
  transition: 0.5s;
  padding-top: 60px;
}


.sidenav a {
  padding: 8px 8px 8px 32px;
  text-decoration: none;
  font-size: 20px;
  color: #818181;
  display: block;
  transition: 0.3s;
}

.sidenav a:hover {
  color: #f1f1f1;
}

.sidenav .closebtn {
  position: absolute;
  top: 0;
  right: 25px;
  font-size: 36px;
  margin-left: 0px;
}

#main {
  transition: margin-left .5s;
  padding: 0px;
}

@media screen and (max-height: 450px) {
  .sidenav {padding-top: 15px;}
  .sidenav a {font-size: 18px;}
}
#notificationDropdown {
    display: none;
    position: absolute;
    top: 100%; 
    right: 0;
    min-width: 350px;
    background-color: white;
    border: 1px solid #ccc;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
    z-index: 9999;
    border-radius: 10px;
}

#notificationList {
    padding: 5px;
}

.notification-item {
        display: flex;
        align-items: center;
        justify-content: space-between; 
        margin-bottom: 10px;
    }

    .notification-content {
        flex-grow: 1;
    }

    .form-check-input.buttonhide {
        margin-left: 10px; 
        position: relative;
        top: 1px;
    }
    
</style>
