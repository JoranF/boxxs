<?php

require_once "../src/db.php";
require_once "../src/user.php";

$users = new User();
$cancelPie = false;
?>
<?php if ($_SESSION['user']['email'] !== 'jor@gmail.com') : ?>
    <?php header("Location: ./index.php"); ?>
<?php endif ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/1.1.2/tailwind.min.css">
    <link rel="stylesheet" href="https://unpkg.com/flowbite@1.4.1/dist/flowbite.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3/dist/chart.min.js"></script>
    <title>Admin</title>
</head>

<nav class="bg-white border-gray-200 px-2 sm:px-4 py-2.5 rounded dark:bg-gray-800">
    <div class="container flex ">
        <a href="../public/" class="">
            <img src="https://upload.wikimedia.org/wikipedia/commons/7/73/Lays_brand_logo.png" class="mr-3 h-6 sm:h-9" alt="Bloxxs Logo">
            <span class="self-center text-xl font-semibold whitespace-nowrap dark:text-white">Bloxxs</span>
        </a>
        <?php if (isset($_SESSION['user']['id'])) : ?>
            <div class="flex items-center absolute right-5 top-0 m-5">
                <button type="button" class="flex mr-3 text-sm bg-gray-800 rounded-full md:mr-0 focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600" id="user-menu-button" aria-expanded="false" data-dropdown-toggle="dropdown">
                    <span class="sr-only">Open user menu</span>
                    <img class="w-8 h-8 rounded-full" src="https://picsum.photos/100/100" alt="user photo">
                </button>
                <div class="hidden z-50 my-4 text-base list-none bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600" id="dropdown" style="position: absolute; inset: auto auto 0px 0px; margin: 0px; transform: translate(1246px, 783px);" data-popper-reference-hidden="" data-popper-escaped="" data-popper-placement="top">
                    <div class="py-3 px-4">
                        <span class="block text-sm text-gray-900 dark:text-white"><?= $_SESSION['user']['username']; ?></span>
                        <span class="block text-sm font-medium text-gray-500 truncate dark:text-gray-400"><?= $_SESSION['user']['email']; ?></span>
                    </div>
                    <ul class="py-1" aria-labelledby="dropdown">
                        <?php if ($_SESSION['user']['email'] == 'jor@gmail.com') : ?>
                            <li>
                                <a href="./index.php" class="block py-2 px-4 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Home</a>
                            </li>
                        <?php endif ?>
                        <!-- <li>
                            <a href="#" class="block py-2 px-4 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Settings</a>
                        </li> -->
                        <li>
                            <a href="../src/signout.php" class="block py-2 px-4 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Sign out</a>
                        </li>
                    </ul>
                </div>
            <?php endif ?>
            <button data-collapse-toggle="mobile-menu-2" type="button" class="inline-flex items-center p-2 ml-1 text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600" aria-controls="mobile-menu-2" aria-expanded="false">
                <span class="sr-only">Open main menu</span>
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                </svg>
                <svg class="hidden w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                </svg>
            </button>
            </div>
    </div>
</nav>

<div class="flex justify-around">
    <div class="w-1/3">
        <canvas id="userchart"></canvas>
    </div>
    <div class="w-1/3 ">
        <canvas id="sharechart"></canvas>
    </div>
</div>
<div>
    <!-- drop down list of all users -->
    <div class="flex justify-around">
        <div class="w-1/3">
            <div class="flex flex-col">
                <div class="flex justify-center">
                    <div>
                        <form name="mainForm" action="" method="get">
                            <label for="user">Choose a user:</label>

                            <input type="text" placeholder="Search.." id="userInput" onkeyup="filterUser()">
                            <select name="user" id="users">
                                <option hidden value="0">Select name</option>
                                <?php
                                $allUsers = $users->getAllUsers();
                                foreach ($allUsers as $user) : ?>
                                    <option id="<?= $user['id']; ?>" class="userOptions" value="<?= $user['id']; ?>"><?= $user['username']; ?></option>
                                <?php endforeach ?>
                            </select>
                            <button class="buttonbg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded" type="submit">Search</button>
                        </form>
                    </div>
                </div>
                <div>
                    <canvas id="fileschart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
// get id of user from dropdown list
if (isset($_GET['user'])) {
    $userId = $_GET['user'];
} else {
    $userId = $_SESSION['user']['id'];
}
// check if folder exists
if (file_exists('../uploads/' . $userId)) {
    $filesize = array_map('filesize', glob('../uploads/' . $userId . '/*'));
    foreach ($filesize as $bytes) {
        if ($bytes >= 1073741824) {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        } elseif ($bytes > 1) {
            $bytes = $bytes . ' bytes';
        } elseif ($bytes == 1) {
            $bytes = $bytes . ' byte';
        } else {
            $bytes = '0 bytes';
        }
        $convertedfilesize[] = $bytes;
    }
    $filenames = array_diff(scandir('../uploads/' . $userId . ''), array('.', '..'));
    $files = array_combine($filenames, $convertedfilesize);
    $convertedfilesize = json_encode($convertedfilesize);
    $filenames = json_encode($filenames);
    $files = json_encode($files);
} else {


    echo '<div class="flex justify-center">
    <div class="w-1/3">
        <div class="flex flex-col">
            <div class="flex justify-center">
                <div>
                    <h1 id="cancelPie" >this user has no files uploaded yet</h1>
                </div>
            </div>
        </div>
    </div>
</div>
';
$cancelPie = true;

}
$userDates = $users->getUserDates();

$sharechart = $users->getsharechart();

foreach ($userDates as $userDate) {
    $userDatesArray[] = $userDate['reg_date'];
}

foreach ($sharechart as $userDate) {
    $sharechartArray[] = $userDate['time'];
}
// get number after first - in each date
$userDatesArray = array_map(function ($item) {
    $item = explode("-", $item);
    return $item[1];
}, $userDatesArray);

$sharechartArray = array_map(function ($item) {
    $item = explode("-", $item);
    return $item[1];
}, $sharechartArray);

// get amount of users per month
// replace number with month
$userDatesArray = str_replace("01", "January", $userDatesArray);
$userDatesArray = str_replace("02", "February", $userDatesArray);
$userDatesArray = str_replace("03", "March", $userDatesArray);
$userDatesArray = str_replace("04", "April", $userDatesArray);
$userDatesArray = str_replace("05", "May", $userDatesArray);
$userDatesArray = str_replace("06", "June", $userDatesArray);
$userDatesArray = str_replace("07", "July", $userDatesArray);
$userDatesArray = str_replace("08", "August", $userDatesArray);
$userDatesArray = str_replace("09", "September", $userDatesArray);
$userDatesArray = str_replace("10", "October", $userDatesArray);
$userDatesArray = str_replace("11", "November", $userDatesArray);
$userDatesArray = str_replace("12", "December", $userDatesArray);

$userDatesArray = array_count_values($userDatesArray);
$userDatesArray = json_encode($userDatesArray);

$sharechartArray = str_replace("01", "January", $sharechartArray);
$sharechartArray = str_replace("02", "February", $sharechartArray);
$sharechartArray = str_replace("03", "March", $sharechartArray);
$sharechartArray = str_replace("04", "April", $sharechartArray);
$sharechartArray = str_replace("05", "May", $sharechartArray);
$sharechartArray = str_replace("06", "June", $sharechartArray);
$sharechartArray = str_replace("07", "July", $sharechartArray);
$sharechartArray = str_replace("08", "August", $sharechartArray);
$sharechartArray = str_replace("09", "September", $sharechartArray);
$sharechartArray = str_replace("10", "October", $sharechartArray);
$sharechartArray = str_replace("11", "November", $sharechartArray);
$sharechartArray = str_replace("12", "December", $sharechartArray);

$sharechartArray = array_count_values($sharechartArray);
$sharechartArray = json_encode($sharechartArray);

?>

<script script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src="https://unpkg.com/flowbite@1.4.1/dist/flowbite.js"></script>
<script>
    var userDatesArray = <?php echo $userDatesArray ?>;

    const ctx = document.getElementById('userchart');
    const userDates = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: Object.keys(userDatesArray),
            datasets: [{
                label: '# of Users per Month',
                data: Object.values(userDatesArray),
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {}


    });

    var sharechartArray = <?php echo $sharechartArray ?>;

    const ctx2 = document.getElementById('sharechart');
    const sharechart = new Chart(ctx2, {
        type: 'bar',
        data: {
            labels: Object.keys(sharechartArray),
            datasets: [{
                label: '# amount of shared per month',
                data: Object.values(sharechartArray),
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {}
    });


    <?php if(!$cancelPie):  ?>
        var convertedfilesize = <?php echo $convertedfilesize ?>;
        var filenames = <?php echo $filenames ?>;
        var files = <?php echo $files ?>;

        values = Object.keys(convertedfilesize);
        // add 1 to each value to make it start at 1
        values = values.map(function(item) {
            return parseInt(item) + 1;
        });

        const ctx3 = document.getElementById('fileschart');
        const fileschart = new Chart(ctx3, { 
            type: 'pie',
            data: {
                labels: Object.keys(files),
                datasets: [{
                    label: 'My First Dataset',
                    data: values,
                    backgroundColor: [
                        'rgb(255, 99, 132)',
                        'rgb(54, 162, 235)',
                        'rgb(255, 205, 86)'
                    ],
                    hoverOffset: 4
                }]
            },
        });
    <?php endif; ?>



    function filterUser() {
        let input = document.getElementById('userInput').value;
        let options = document.getElementsByClassName('userOptions');
        for (let i = 0; i < options.length; i++) {
            if (options[i].innerHTML.toLowerCase().indexOf(input.toLowerCase()) > -1) {
                options[i].style.display = "";
            } else {
                options[i].style.display = "none";
            }
        }
    }
</script>