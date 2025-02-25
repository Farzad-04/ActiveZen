<?php
include "layout/header.php";

// Check if a session is not already active before starting one
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is authenticated
if (!isset($_SESSION["User_id"])) {
    // Redirect to login if not authenticated
    header("Location: /Data_Management_Project/login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

 <!-- All the button styling is from React Icon and they take you to different pages -->
<div class="container mt-4">
        <div class="row">
            <div class="col-md-4 text-center">
            <a href="/Data_Management_Project/workout_goals.php">
            <button class="btn" data-bs-toggle="collapse" data-bs-target="#workoutGoals" style="background-color: #CBC4B4;">
            <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 512 512" height="6em" width="6em" xmlns="http://www.w3.org/2000/svg" style="color: #7C0A02 ;"><path d="M439 32v165h18V32h-18zm-18 12.99L327.6 80l93.4 35V44.99zM165.9 103c-5 0-10.2 2.3-15.3 7-6.2 5.8-11.5 15.1-13.8 26.3-2.3 11.3-1 22 2.5 29.7 3.5 7.8 8.6 12.3 14.6 13.5 6 1.3 12.4-.9 18.7-6.6 6.1-5.8 11.5-15.1 13.8-26.4 2.2-11.3.9-22-2.5-29.7-3.5-7.8-8.6-12.2-14.6-13.5-1.1-.2-2.3-.3-3.4-.3zm-38.4 78.5c-3.4 1.2-6.9 2.5-10.7 4.1-24.85 15.7-42.2 31.2-59.84 55.7-11.19 15.5-11.74 42-12.58 61.5l20.8 9.2c.87-27.8.36-39.3 13.27-55.3 9.83-12.2 19.33-25 37.55-28.9 1.6 28.9-2.6 73.7-14 119.6 20.5 2.8 37.6-.7 57-6.3 50.7-25.3 74.1-3.8 109.3 45.7l20.5-32.1c-24.6-28.9-48.5-75.1-117.2-57.3 5-27.3 5.6-45.4 8.6-72.6.6-12 .8-23.9 1.1-35.7-8.9 6.8-19.9 10.4-31 8.1-9.5-2-17.3-7.9-22.8-15.7zm144.2 7.3c-18.2 17.8-22.2 31-50.2 38.4l-22.5-24c-.4 12.8-.8 25.9-1.9 39.2 9.5 8.7 19.2 15.7 22.7 14.6 31.3-9.4 40.3-20.3 61.4-41.9l-9.5-26.3zM409 215v96h-96v96h-96v78.1c102.3.2 167.8 1.1 270 1.8V215h-78zM140.7 363.9c-13.6 2.5-27.8 3.3-43.44.9-10.89 37.5-26.76 74.3-48.51 102.5l38.63 15.3c27.02-37.9 36.82-70.6 53.32-118.7z"></path></svg>
                    Workout Goals
                   
                </button>
                </a>
               
            </div>
            <div class="col-md-4 text-center">
            <a href="/Data_Management_Project/nutrition_goals.php">
            <button class="btn" data-bs-toggle="collapse" data-bs-target="#NutrientGoals" style="background-color: #CBC4B4;">
                    <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 512 512" height="6em" width="6em" xmlns="http://www.w3.org/2000/svg" style="color: #7C0A02"><path d="M150.902 268.233h-42.1a23.347 23.347 0 0 1 42.1 0zm67.359-13.292a114.847 114.847 0 0 1 1.203-16.31 23.335 23.335 0 0 0-18.68 29.602h18.295a113.38 113.38 0 0 1-.77-13.292zm-94.532-86.027c-15.637-15.637-36.638-32.164-55.162-32.164h-1.54l.975 19.246c8.913-.433 23.287 8.3 39.489 24.056q1.528 1.48 2.995 2.972a42.58 42.58 0 0 1 8.083-.95 42.34 42.34 0 0 1 5.208-13.172zm24.37-18.933a68.706 68.706 0 0 0 6.928-9.743 71.172 71.172 0 0 0 7.11-16.55 70.174 70.174 0 0 0 2.706-17.695 67.72 67.72 0 0 0-1.672-16.575 69.043 69.043 0 0 0-2.01-7 63.499 63.499 0 0 0-2.236-5.594 53.963 53.963 0 0 0-1.889-3.728c-.228-.433-.469-.782-.601-1.01l-.217-.35-.36.18c-.241.121-.614.302-1.035.542a52.092 52.092 0 0 0-3.609 2.177 52.07 52.07 0 0 0-4.811 3.609 69.031 69.031 0 0 0-5.377 4.907 67.72 67.72 0 0 0-10.104 13.232 70.174 70.174 0 0 0-6.964 16.49 71.16 71.16 0 0 0-2.719 17.779 68.562 68.562 0 0 0 1.672 16.575 66.337 66.337 0 0 0 4.234 12.546c.47 1.058.927 1.96 1.336 2.718a42.713 42.713 0 0 1 19.666-12.522zm342.413-43.903c-.228-.133-.59-.35-1.022-.578a43.443 43.443 0 0 0-3.777-1.804c-1.6-.674-3.5-1.42-5.641-2.105a69.031 69.031 0 0 0-7.049-1.84 67.72 67.72 0 0 0-16.611-1.263 70.174 70.174 0 0 0-17.634 3.127 71.172 71.172 0 0 0-16.31 7.41 68.562 68.562 0 0 0-13.003 10.428l-.542.578a69.633 69.633 0 0 1 12.618 22.168 68.67 68.67 0 0 0 11.307.421 71.16 71.16 0 0 0 17.646-3.091 70.174 70.174 0 0 0 16.322-7.362 67.72 67.72 0 0 0 13.003-10.428 69.02 69.02 0 0 0 4.811-5.497c1.384-1.78 2.55-3.44 3.477-4.932.926-1.492 1.635-2.718 2.093-3.609.24-.433.409-.817.517-1.058l.18-.373zm-85.642-66.06c-.433-1.697-.854-3.296-.986-4.018l-18.981 3.488c.252 1.384.685 3.043 1.275 5.329 2.814 10.898 9.298 36.013 1.48 58.23a69.97 69.97 0 0 1 16.165 11.595c12.787-28.928 4.511-61.032.999-74.625zM180.179 476h122.618a159.112 159.112 0 0 0 159.112-159.112v-29.41H21.103V316.9A159.112 159.112 0 0 0 180.179 476zm245.163-221.059a93.545 93.545 0 0 0-26.03-64.845 50.4 50.4 0 1 0-94.05-25.26 93.822 93.822 0 0 0-66.745 103.445h185.839a94.604 94.604 0 0 0 .986-13.34zm-244.718 6.748a42.412 42.412 0 0 1 10.609-28.074 23.383 23.383 0 0 0-43.555 6.014 42.81 42.81 0 0 1 23.492 28.28 23.287 23.287 0 0 0 9.622-2.407 43.845 43.845 0 0 1-.168-3.813zm-79.388-14.963a23.383 23.383 0 0 0-41.522 21.495h28.688a42.665 42.665 0 0 1 12.822-21.495zm79.845-66.686a23.371 23.371 0 0 0-43.543 5.642 42.905 42.905 0 0 1 19.51 18.427 42.292 42.292 0 0 1 11.44-2.153 42.653 42.653 0 0 1 12.58-21.916zm29 7.819a23.383 23.383 0 0 0-22.685 17.537 42.905 42.905 0 0 1 19.534 16.924 42.316 42.316 0 0 1 16.335-3.271h.854a111.36 111.36 0 0 1 7.373-17.177 23.383 23.383 0 0 0-21.41-14.013zm-69.524 26.402a23.36 23.36 0 0 0-43.483 4.174 42.905 42.905 0 0 1 20.966 18.945 42.557 42.557 0 0 1 10.826-1.648 42.593 42.593 0 0 1 11.691-21.47z"></path></svg>                 
                    </svg>
                    Nutrient Goals
                </button>
</a>
            </div>
            <div class="col-md-4 text-center">
                <a href = "/Data_Management_Project/workoutTracker.php">
            <button class="btn" data-bs-toggle="collapse" data-bs-target="#workoutTracker" style="background-color: #CBC4B4;">
                <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 640 512" height="6em" width="6em" xmlns="http://www.w3.org/2000/svg"  style="color: #7C0A02"><path d="M104 96H56c-13.3 0-24 10.7-24 24v104H8c-4.4 0-8 3.6-8 8v48c0 4.4 3.6 8 8 8h24v104c0 13.3 10.7 24 24 24h48c13.3 0 24-10.7 24-24V120c0-13.3-10.7-24-24-24zm528 128h-24V120c0-13.3-10.7-24-24-24h-48c-13.3 0-24 10.7-24 24v272c0 13.3 10.7 24 24 24h48c13.3 0 24-10.7 24-24V288h24c4.4 0 8-3.6 8-8v-48c0-4.4-3.6-8-8-8zM456 32h-48c-13.3 0-24 10.7-24 24v168H256V56c0-13.3-10.7-24-24-24h-48c-13.3 0-24 10.7-24 24v400c0 13.3 10.7 24 24 24h48c13.3 0 24-10.7 24-24V288h128v168c0 13.3 10.7 24 24 24h48c13.3 0 24-10.7 24-24V56c0-13.3-10.7-24-24-24z"></path></svg>                        
                    </svg>
                    Workout Tracker
                </button>
</a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 text-center">
                <a href = "\Data_Management_Project\body_size.php">
            <button class="btn" data-bs-toggle="collapse" data-bs-target="#bodyzie" style="background-color: #CBC4B4;">
                <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 512 512" height="6em" width="6em" xmlns="http://www.w3.org/2000/svg"  style="color: #7C0A02"><path d="M165.906 18.688C15.593 59.28-42.187 198.55 92.72 245.375h-1.095c.635.086 1.274.186 1.906.28 8.985 3.077 18.83 5.733 29.532 7.94C173.36 273.35 209.74 321.22 212.69 368c-33.514 23.096-59.47 62.844-59.47 62.844L179.5 469.53 138.28 493h81.97c-40.425-40.435-11.76-85.906 36.125-85.906 48.54 0 73.945 48.112 36.156 85.906h81.126l-40.375-23.47 26.283-38.686s-26.376-40.4-60.282-63.406c3.204-46.602 39.5-94.167 89.595-113.844 10.706-2.207 20.546-4.86 29.53-7.938.633-.095 1.273-.195 1.908-.28h-1.125c134.927-46.82 77.163-186.094-73.157-226.69-40.722 39.37 6.54 101.683 43.626 56.877 36.9 69.08 8.603 127.587-72.28 83.406-11.88 24.492-34.213 41.374-60.688 41.374-26.703 0-49.168-17.167-60.97-42-81.774 45.38-110.512-13.372-73.437-82.78 37.09 44.805 84.35-17.508 43.626-56.876zm90.79 35.92c-27.388 0-51.33 27.556-51.33 63.61 0 36.056 23.942 62.995 51.33 62.995 27.387 0 51.327-26.94 51.327-62.994 0-36.058-23.94-63.61-51.328-63.61z"></path></svg>                        
                    </svg>
                    Body Size
                </button>
</a>
            </div>

            <div class="col-md-4 text-center">
                <a href="\Data_Management_Project\nutrient_tracker.php">
            <button class="btn" data-bs-toggle="collapse" data-bs-target="#NutrientTracker" style="background-color: #CBC4B4;">
                <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 512 512" height="6em" width="6em" xmlns="http://www.w3.org/2000/svg"  style="color: #7C0A02"><path d="M196 16a30 30 0 0 0-30 30v120H46a30 30 0 0 0-30 30v120a30 30 0 0 0 30 30h120v120a30 30 0 0 0 30 30h120a30 30 0 0 0 30-30V346h120a30 30 0 0 0 30-30V196a30 30 0 0 0-30-30H346V46a30 30 0 0 0-30-30H196z"></path></svg>                    
                Nutrient Tracker
                </button>
</a>
            </div>

            <div class="col-md-4 text-center">
                <a href="\Data_Management_Project\sleep.php">
            <button class="btn" data-bs-toggle="collapse" data-bs-target="#Sleep" style="background-color: #CBC4B4;">
                <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24" height="6em" width="6em" xmlns="http://www.w3.org/2000/svg"  style="color: #7C0A02"><path d="M20,9.557V7V6V3h-2v2h-5h-2H6V3H4v3v1v2.557C2.81,10.25,2,11.525,2,13v4c0,0.553,0.448,1,1,1h1v4h2v-4h12v4h2v-4h1 c0.553,0,1-0.447,1-1v-4C22,11.525,21.189,10.25,20,9.557z M18,7v2h-5V7H18z M6,7h5v2H6V7z M20,16h-2H4v-3c0-1.103,0.897-2,2-2h12 c1.103,0,2,0.897,2,2V16z"></path></svg>                
            Sleep
            </button>
</a>
            </div>
            
        </div>
        <div class="row">

            <div class="col-md-4 text-center">
                <a href="\Data_Management_Project\index.php">
            <button class="btn" data-bs-toggle="collapse" data-bs-target="#Weather" style="background-color: #CBC4B4;">
                <svg stroke="currentColor" fill="currentColor" stroke-width="0" version="1.2" baseProfile="tiny" viewBox="0 0 24 24" height="6em" width="6em" xmlns="http://www.w3.org/2000/svg"  style="color: #7C0A02"><path d="M17 19h-11c-2.206 0-4-1.794-4-4 0-1.861 1.277-3.429 3.001-3.874l-.001-.126c0-3.309 2.691-6 6-6 2.587 0 4.824 1.638 5.65 4.015 2.942-.246 5.35 2.113 5.35 4.985 0 2.757-2.243 5-5 5zm-11.095-6.006c-1.008.006-1.905.903-1.905 2.006s.897 2 2 2h11c1.654 0 3-1.346 3-3s-1.346-3-3-3c-.243 0-.5.041-.81.13l-1.075.307-.186-1.103c-.325-1.932-1.977-3.334-3.929-3.334-2.206 0-4 1.794-4 4 0 .272.027.545.082.811l.244 1.199-1.421-.016z"></path></svg>            
                Weather
            </button>
</a>
            </div>

            <div class="col-md-4 text-center">
                <a href= "/Data_Management_Project/Home.php">
            <button class="btn" data-bs-toggle="collapse" data-bs-target="#Home" style="background-color: #CBC4B4;">
                <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 1024 1024" height="6em" width="6em" xmlns="http://www.w3.org/2000/svg" style="color: #7C0A02"><path d="M946.5 505L534.6 93.4a31.93 31.93 0 0 0-45.2 0L77.5 505c-12 12-18.8 28.3-18.8 45.3 0 35.3 28.7 64 64 64h43.4V908c0 17.7 14.3 32 32 32H448V716h112v224h265.9c17.7 0 32-14.3 32-32V614.3h43.4c17 0 33.3-6.7 45.3-18.8 24.9-25 24.9-65.5-.1-90.5z"></path></svg>
                Home
            </button>
</a>
            </div>

            

            <div class="col-md-4 text-center">
                <a href="\Data_Management_Project\Tutorial.php">
            <button class="btn" data-bs-toggle="collapse" data-bs-target="#MapYourRun" style="background-color: #CBC4B4;">
                <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24" height="6em" width="6em" xmlns="http://www.w3.org/2000/svg"  style="color: #7C0A02"><circle cx="17" cy="4" r="2"></circle><path d="M15.777,10.969c0.376,0.563,1.008,0.89,1.666,0.89c0.16,0,0.322-0.02,0.482-0.06l3.316-0.829L20.758,9.03l-3.316,0.829 l-1.379-2.067c-0.291-0.439-0.756-0.751-1.272-0.854l-3.846-0.77c-0.888-0.181-1.778,0.265-2.181,1.067l-1.658,3.316l1.789,0.895 l1.658-3.317l1.967,0.394L7.434,17H3v2h4.434c0.698,0,1.355-0.372,1.715-0.971l1.918-3.196l5.169,1.034l1.816,5.449l1.896-0.633 l-1.815-5.448c-0.226-0.679-0.802-1.188-1.506-1.33l-3.039-0.607l1.772-2.954L15.777,10.969z"></path></svg>            
            Tutorials   
            </button>
</a>
            </div>

        </div>


        <div class="row"> 

            <div class="col-md-4 text-center">
                <a href="\Data_Management_Project\mentalwellbeing.php">
            <button class="btn" data-bs-toggle="collapse" data-bs-target="#Mentalwellbeing" style="background-color: #CBC4B4;">
                <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24" height="6em" width="6em" xmlns="http://www.w3.org/2000/svg"  style="color: #7C0A02"><g><path fill="none" d="M0 0H24V24H0z"></path><path d="M11 2c4.068 0 7.426 3.036 7.934 6.965l2.25 3.539c.148.233.118.58-.225.728L19 14.07V17c0 1.105-.895 2-2 2h-1.999L15 22H6v-3.694c0-1.18-.436-2.297-1.244-3.305C3.657 13.631 3 11.892 3 10c0-4.418 3.582-8 8-8zm-.53 5.763c-.684-.684-1.792-.684-2.475 0-.684.683-.684 1.791 0 2.474L11 13.243l3.005-3.006c.684-.683.684-1.791 0-2.474-.683-.684-1.791-.684-2.475 0l-.53.53-.53-.53z"></path></g></svg>
                Mental Wellbeing
            </button>
</a>
            </div>
            <div class="col-md-4 text-center">
                <a href="Views.php">
            <button class="btn" data-bs-toggle="collapse" data-bs-target="#Views" style="background-color: #CBC4B4;">
                <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 16 16" height="6em" width="6em" xmlns="http://www.w3.org/2000/svg"  style="color: #7C0A02"><path fill-rule="evenodd" d="M16 8.5l-6 6-3-3L8.5 10l1.5 1.5L14.5 7 16 8.5zM5.7 12.2l.8.8H2c-.55 0-1-.45-1-1V3c0-.55.45-1 1-1h7c.55 0 1 .45 1 1v6.5l-.8-.8c-.39-.39-1.03-.39-1.42 0L5.7 10.8a.996.996 0 0 0 0 1.41v-.01zM4 4h5V3H4v1zm0 2h5V5H4v1zm0 2h3V7H4v1zM3 9H2v1h1V9zm0-2H2v1h1V7zm0-2H2v1h1V5zm0-2H2v1h1V3z"></path></svg>
                Views
            </button>
            
</a>

            </div>
            <div class="col-md-4 text-center">
                <a href="stress_vs_sleep.php">
            <button class="btn" data-bs-toggle="collapse" data-bs-target="#Views" style="background-color: #CBC4B4;">
            <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 16 16" height="6em" width="6em" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M16 14v1H0V0h1v14h15zM5 13H3V8h2v5zm4 0H7V3h2v10zm4 0h-2V6h2v7z" style="color: #7C0A02"></path></svg>

            Graph
            </button>
</a>
            


            

        </div>

    







    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>


<?php 
include "layout/footer.php";
?>