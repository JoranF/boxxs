<?php

session_start();
require_once "../src/db.php";
require_once "../src/files.php";

$files = new Files();

if (isset($_POST['upload'])) {
    // print_r($_FILES['fileToUpload']['name']);
    $files->upload($_FILES, $_SESSION['user']['id']);
}
$_SESSION['file_id'] = 0;
?>

<!-- cloud storage page -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/1.1.2/tailwind.min.css">
    <link rel="stylesheet" href="https://unpkg.com/flowbite@1.4.1/dist/flowbite.min.css" />
    <title>bloxxs</title>
</head>

<body>
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
                                <a href="./admin.php" class="block py-2 px-4 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Dashboard</a>
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

    <?php if (Files::$info == !'') :; ?>
        <div class="flex p-4 mb-4 text-sm text-blue-700 bg-blue-100 rounded-lg dark:bg-blue-200 dark:text-blue-800" role="alert">
            <svg class="inline flex-shrink-0 mr-3 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
            </svg>
            <div>
                <span class="font-medium">Info</span> <?= Files::$info ?>
            </div>
        </div>
    <?php endif ?>

    <div class="flex">
<?php if (isset($_SESSION['user']['id'])) : ?>
        <?php if (!isset($_GET['shared'])) : ?>
            <aside class="w-64" aria-label="Sidebar">
                <div class="overflow-y-auto py-4 px-3 rounded dark:bg-gray-800">
                    <ul class="space-y-2">
                        <li>
                            <a href="#" class="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                                <svg class="flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M8.707 7.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l2-2a1 1 0 00-1.414-1.414L11 7.586V3a1 1 0 10-2 0v4.586l-.293-.293z"></path>
                                    <path d="M3 5a2 2 0 012-2h1a1 1 0 010 2H5v7h2l1 2h4l1-2h2V5h-1a1 1 0 110-2h1a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V5z"></path>
                                </svg>
                                <span class="flex-1 ml-3 whitespace-nowrap" type="button" data-modal-toggle="upload-modal">Upload files</span>
                            </a>
                        </li>
                        <li>
                            <a href="../public/sharing.php" class="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                                <svg class="flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z"></path>
                                </svg>
                                <span class="flex-1 ml-3 whitespace-nowrap" type="button" data-modal-toggle="">Shared Files</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </aside>
        <?php endif ?>
<?php endif ?>

        <!-- show files here -->
        <div class="justify-center w-screen m-10">
            <!-- delete and share bar -->
            <div class="flex py-2 w-64 opacity-50" id="fileOptions">
                <?php if (!isset($_GET['shared'])) :; ?>
                    <button disabled class="mr-5 inline-flex items-center px-3 py-2 border border-gray-300 rounded-md text-sm leading-5 font-medium text-gray-700 hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-50 active:text-gray-800 transition ease-in-out duration-150" id="delete-button">
                        <svg class="-ml-1 mr-2 h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                        <p class="text-red-500">
                            Delete
                        </p>
                    </button>
                <?php else : ?>
                    <button disabled class="mr-5 inline-flex items-center px-3 py-2 border border-gray-300 rounded-md text-sm leading-5 font-medium text-gray-700 hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-50 active:text-gray-800 transition ease-in-out duration-150" id="archive-button">
                        <svg class="-ml-1 mr-2 h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                        <p class="text-red-500">
                            Delete
                        </p>
                    </button>
                <?php endif ?>

                <button disabled class="mx-5 inline-flex items-center px-3 py-2 border border-gray-300 rounded-md text-sm leading-5 font-medium text-gray-700 hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-50 active:text-gray-800 transition ease-in-out duration-150" type="button" id="share-button" data-modal-toggle="share-button">
                    <svg class="-ml-1 mr-2 h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M4 3a2 2 0 012-2h3.586a2 2 0 011.414.586l7 7a2 2 0 010 2.828l-7 7A2 2 0 016.414 19H4a2 2 0 01-2-2V3zm3.293 9.293a1 1 0 010 1.414l-1.414 1.414a1 1 0 01-1.414 0l-3-3a1 1 0 111.414-1.414L9.586 10l-2.293-2.293a1 1 0 010-1.414l3-3a1 1 0 011.414 0l1.414 1.414z" clip-rule="evenodd"></path>
                    </svg>
                    <p class="text-green-500">
                        Share
                    </p>
                </button>
            </div>
            <?php if (isset($_SESSION['user']['id'])) : ?>
                <div class="border w-full flex flex-wrap ">
                    <?php if (!isset($_GET['shared'])) : ?>
                        <?php
                        $userFiles = $files->getFilesFromUser($_SESSION['user']['id']);
                        foreach ($userFiles as $file) :
                            $directory = $files->getFile($_SESSION['user']['id'], $file);
                        ?>
                            <div class="w-56 m-2 mb-5 bg-white rounded-lg border border-gray-200 h-full shadow-md dark:bg-gray-800 dark:border-gray-700">
                                <img class="rounded-t-lg hidden" src="<?= $directory; ?>" alt="">
                                <div class="p-5">
                                    <h5 class="mb-2 text-sm font-bold text-gray-900 dark:text-white"><?= $file ?></h5>
                                </div>
                                <div class="flex">
                                    <!-- checkbox -->
                                    <div class="flex p-2 text-base font-normal text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                                        <input onClick="validate(this);" type="checkbox" id="checkbox" name="checkbox-<?= $file ?>" value="<?= $file ?>">
                                        <label class="form-checkbox-label" for="checkbox-<?= $file ?>">
                                    </div>
                                    <!-- delete download share -->
                                    <div class="flex ml-12 items-center">
                                        <a href="<?= $directory; ?>" download class="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                                            <svg class="flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                            </svg>
                                            <span class="flex-1 ml-3 whitespace-nowrap">Download</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach ?>
                    <?php endif ?>
                    <!-- check if shared param is set -->
                    <?php if (isset($_GET['shared'])) : ?>
                        <?php
                        // get all files to show from shared_files table
                        $sharedFiles = $files->getSharedFiles($_GET['shared']);
                        if ($sharedFiles == null) {
                            echo '<p class="text-center text-xl text-gray-500">No files shared</p>';
                        }
                        foreach ($sharedFiles as $file) :
                            $email = str_replace('%40', '@', $file['shared_user_mail']);
                            if ($_SESSION['user']['email'] == $email) :
                                // get files from file_box table
                                $shared_files = $files->getFiles($file['id']);
                                foreach ($shared_files as $shared_file) :
                                    if (!$shared_file['archived']) :
                                        $_SESSION['file_id'] = $file['id'];
                                        // get directory
                                        $directory = $files->getDirectory($shared_file['file_name'], $file['owner_user_id']);
                                        // check if file exists
                                        if (!file_exists($directory)) {
                                            continue;
                                        }
                        ?>
                                        <div class="w-56 m-2 mb-5 bg-white rounded-lg border border-gray-200 h-full shadow-md dark:bg-gray-800 dark:border-gray-700">
                                            <img class="rounded-t-lg hidden" src="<?= $directory; ?>" alt="">
                                            <div class="p-5">
                                                <h5 class="mb-2 text-sm font-bold text-gray-900 dark:text-white"><?= $shared_file['file_name'] ?></h5>
                                            </div>
                                            <div class="flex">
                                                <!-- checkbox -->
                                                <div class="flex p-2 text-base font-normal text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                                                    <input onClick="validate(this);" type="checkbox" id="checkbox" name="checkbox-<?= $file ?>" value="<?= $shared_file['file_name'] ?>">
                                                    <label class="form-checkbox-label" for="checkbox-<?= $shared_file['file_name'] ?>">
                                                </div>
                                                <!-- delete download share -->
                                                <div class="flex ml-12 items-center">
                                                    <a href="<?= $directory; ?>" download class="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                                                        <svg class="flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                                        </svg>
                                                        <span class="flex-1 ml-3 whitespace-nowrap">Download</span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    <?php else :
                                        // delete all rows with shared_file_id from shared_files table
                                        $files->deleteSharedFile($_SESSION['file_id']);
                                    endif ?>
                                <?php endforeach ?>
                            <?php else : ?>
                                <p class="text-center text-xl text-gray-500">You are not allowed to see these file</p>
                            <?php endif ?>
                        <?php endforeach ?>
                    <?php endif ?>
                <?php else : ?>
                    <a class="absolute left-1/2 underline  text-xl text-gray-500" href="login.php">Login Here to Upload your files to the cloud</a>
                <?php endif ?>

                </div>
                <!-- folder card -->
                <!-- <div class="flex">
                <div class="rounded-xl bg-gray-300 h-fit w-32 text-center pt-2 py-2 mt-4 mr-4 hover:bg-gray-300 cursor-pointer">
                    <div>
                        <p>Folder name</p>
                    </div>
                </div>
                <div class="rounded-xl bg-gray-300 h-fit w-32 text-center pt-2 py-2 mt-4 mr-4 hover:bg-gray-300 cursor-pointer">
                    <div>
                        <p>Folder name</p>
                    </div>
                </div>
            </div> -->
        </div>

    </div>


    <div id="upload-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 h-modal md:h-full justify-center items-center">
        <div class="relative p-4 w-full max-w-md h-full md:h-auto">
            <div class="relative bg-white rounded-lg shadow ">
                <div class="flex justify-end p-2">
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white" id="upload-modal-close">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
                <form class="px-6 pb-4 space-y-6 lg:px-8 sm:pb-6 xl:pb-8" enctype="multipart/form-data" method="post" action="<?= $_SERVER['PHP_SELF']; ?>">
                    <h3 class="text-xl font-medium text-gray-900 ">Upload file</h3>
                    <div class="flex justify-center">
                        <div class="mb-3 w-96">
                            <label for="fileToUpload" class="form-label inline-block mb-2 text-gray-700">Upload one or multiple files</label>
                            <input type="file" name="fileToUpload[]" class="form-input rounded-md border" id="fileToUpload" multiple>
                        </div>
                    </div>

                    <div class="flex items-center justify-end">
                        <button type="submit" name="upload" class="bg-gray-800 text-white hover:bg-gray-700  rounded-lg px-6 py-3">
                            Upload
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="folder-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 h-modal md:h-full justify-center items-center">
        <div class="relative p-4 w-full max-w-md h-full md:h-auto">
            <div class="relative bg-white rounded-lg shadow ">
                <div class="flex justify-end p-2">
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white" data-modal-toggle="folder-modal">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
                <form class="px-6 pb-4 space-y-6 lg:px-8 sm:pb-6 xl:pb-8" enctype="multipart/form-data" method="post" action="<?= $_SERVER['PHP_SELF']; ?>">
                    <h3 class="text-xl font-medium text-gray-900 ">Create folder</h3>
                    <div class="flex justify-center">
                        <div class="mb-3 w-96">
                            <label for="nameFolder" class="form-label inline-block mb-2 text-gray-700">Name</label>
                            <input type="text" name="nameFolder" class="form-input rounded-md border" id="nameFolder">
                        </div>
                    </div>

                    <div class="flex items-center justify-end">
                        <button type="submit" name="create_folder" class="bg-gray-800 text-white hover:bg-gray-700  rounded-lg px-6 py-3">
                            Create
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="share-modal" tabindex="-1" aria-hidden="true" class="hidden flex justify-center ">
        <div class="relative p-4 w-full max-w-md h-full md:h-auto ">
            <div class="relative bg-white rounded-lg shadow-xl ">
                <div class="flex justify-end p-2">
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white" id="share-modal-close" data-modal-toggle="share-modal">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
                <form class="px-6 pb-4 space-y-6 lg:px-8 sm:pb-6 xl:pb-8" id="share_form" method="post" action="<?= $_SERVER['PHP_SELF']; ?>">
                    <h3 class="text-xl font-medium text-gray-900 ">Share selected files</h3>
                    <div class="flex justify-center">
                        <div class="mb-3 w-96">
                            <label for="shareMail" class="form-label inline-block mb-2 text-gray-700">Email</label>
                            <input type="email" name="shareMail" class="form-input rounded-md border" id="shareMail">
                        </div>
                    </div>

                    <div class="flex items-center justify-end">
                        <button id="share_files" type="submit" class="bg-gray-800 text-white hover:bg-gray-700  rounded-lg px-6 py-3">
                            Share
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <footer class="p-4 bg-white rounded-lg shadow md:flex md:items-center md:justify-between md:p-6 dark:bg-gray-800 fixed bottom-0">
        <span class="text-sm text-gray-500 sm:text-center dark:text-gray-400">© 2022 <a href="" class="hover:underline">Boxxs</a>. All Rights Reserved.
        </span>
        <ul class="flex flex-wrap items-center mt-3 text-sm text-gray-500 dark:text-gray-400 sm:mt-0">
            <li>
                <a href="#" class="mr-4 hover:underline md:mr-6 ">About</a>
            </li>
            <li>
                <a href="#" class="mr-4 hover:underline md:mr-6">Privacy Policy</a>
            </li>
            <li>
                <a href="#" class="mr-4 hover:underline md:mr-6">Licensing</a>
            </li>
            <li>
                <a href="#" class="hover:underline">Contact</a>
            </li>
        </ul>
    </footer>
</body>
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src="https://unpkg.com/flowbite@1.4.1/dist/flowbite.js"></script>

<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }

    let checkedFiles = [];

    function validate(target) {
        if (target.checked) {
            checkedFiles.push(target.value);
            document.getElementById('fileOptions').classList.remove('opacity-50');
            // check if element exists
            if (document.getElementById('delete-button')) {
                document.getElementById('delete-button').removeAttribute('disabled');
            }
            if (document.getElementById('archive-button')) {
                document.getElementById('archive-button').removeAttribute('disabled');
            }
            document.getElementById('share-button').removeAttribute('disabled');
        } else {
            checkedFiles.splice(checkedFiles.indexOf(target.value), 1);
        }
        if (checkedFiles.length == 0) {
            document.getElementById('fileOptions').classList.add('opacity-50');
            if (document.getElementById('delete-button')) {
                document.getElementById('delete-button').setAttribute('disabled', 'disabled');
            }
            if (document.getElementById('archive-button')) {
                document.getElementById('archive-button').setAttribute('disabled', 'disabled');
            }
            document.getElementById('share-button').setAttribute('disabled', 'disabled');
        }
        console.log(checkedFiles);
    };

    $("#share-button").click(function() {
        $("#share-modal").toggleClass("hidden");
    });
    $("#share-modal-close").click(function() {
        $("#share-modal").toggleClass("hidden");
    });

    $(document).ready(function() {
        $("#delete-button").click(function() {
            $.ajax({
                type: "POST",
                data: {
                    deleteFiles: checkedFiles,
                    id: '<?= $_SESSION['user']['id']; ?>'
                },
                url: "../src/dataHandler.php",
                dataType: "html",
                async: false,
                success: function(data) {
                    location.reload();
                }
            });
        });

        $("#archive-button").click(function() {
            $.ajax({
                type: "POST",
                data: {
                    archiveFiles: checkedFiles,
                    shared_files_id: '<?= $_SESSION['file_id']; ?>'
                },
                url: "../src/dataHandler.php",
                dataType: "html",
                async: false,
                success: function(data) {
                    location.reload();
                    // console.log(data);
                }
            });
        });

        $("#share_form").submit(function(e) {
            e.preventDefault();
            var form = $(this);
            var formData = form.serialize();

            $.ajax({
                type: "POST",
                data: {
                    formData: formData,
                    shareFiles: checkedFiles,
                    id: '<?= $_SESSION['user']['id']; ?>'
                },
                url: "../src/dataHandler.php",
                dataType: "html",
                async: false,
                success: function() {
                    window.location.href = '../public/sharing.php';
                }
            });
        });
    });
</script>
</html>