<?php
include('../dbconnect.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-yellow-100">
    <div class="max-w-screen-lg px-4 sm:px-6 text-gray-800 sm:grid md:grid-cols-4 sm:grid-cols-2 mx-auto">
        <div class="p-5">
            <h3 class="font-bold text-xl text-slate-700">Company Name</h3>
            <p class="mt-2 text-gray-700">
                Lorem, ipsum dolor sit amet consectetur adipisicing elit. Facilis ipsa doloremque totam in! Iure officia labore, explicabo officiis cum provident tempore commodi quas perspiciatis! Ab qui explicabo molestiae ut incidunt.
            </p>
        </div>
        <div class="p-5">
            <div class="text-sm uppercase text-slate-700 font-bold">About us</div>
            <a class="my-3 block hover:text-yellow-700" href="#">Location <span class="text-teal-600 text-xs p-1"></span></a>
            <a class="my-3 block hover:text-yellow-700" href="#">Support <span class="text-teal-600 text-xs p-1">New</span></a>
        </div>
        <div class="p-5">
            <div class="text-sm uppercase text-slate-700 font-bold">Support</div>
            <a class="my-3 block hover:text-yellow-700" href="#">Help Center <span class="text-teal-600 text-xs p-1"></span></a>
            <a class="my-3 block hover:text-yellow-700" href="#">Privacy Policy <span class="text-teal-600 text-xs p-1"></span></a>
            <a class="my-3 block hover:text-yellow-700" href="#">FAQ <span class="text-teal-600 text-xs p-1"></span></a>
        </div>
        <div class="p-5">
            <div class="text-sm uppercase text-slate-700 font-bold">Contact us</div>
            <a class="my-3 block hover:text-yellow-700" href="#">24A Sule Road, Yangon Myanmar. <span class="text-teal-600 text-xs p-1"></span></a>
            <a class="my-3 block hover:text-yellow-700" href="#">thihannaing123@gmail.com <span class="text-teal-600 text-xs p-1"></span></a>
        </div>
    </div>
    
    <div class="bg-yellow-200 pt-2">
        <div class="flex pb-5 px-3 m-auto pt-5 border-t border-yellow-300 text-gray-800 text-sm flex-col max-w-screen-lg items-center">
            <div class="md:flex-auto md:flex-row-reverse mt-2 flex-row flex justify-center">
                <a href="reddit.com" class="w-6 mx-2">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M0 256C0 114.6 114.6 0 256 0S512 114.6 512 256s-114.6 256-256 256L37.1 512c-13.7 0-20.5-16.5-10.9-26.2L75 437C28.7 390.7 0 326.7 0 256zM349.6 153.6c23.6 0 42.7-19.1 42.7-42.7s-19.1-42.7-42.7-42.7c-20.6 0-37.8 14.6-41.8 34c-34.5 3.7-61.4 33-61.4 68.4l0 .2c-37.5 1.6-71.8 12.3-99 29.1c-10.1-7.8-22.8-12.5-36.5-12.5c-33 0-59.8 26.8-59.8 59.8c0 24 14.1 44.6 34.4 54.1c2 69.4 77.6 125.2 170.6 125.2s168.7-55.9 170.6-125.3c20.2-9.6 34.1-30.2 34.1-54c0-33-26.8-59.8-59.8-59.8c-13.7 0-26.3 4.6-36.4 12.4c-27.4-17-62.1-27.7-100-29.1l0-.2c0-25.4 18.9-46.5 43.4-49.9l0 0c4.4 18.8 21.3 32.8 41.5 32.8zM177.1 246.9c16.7 0 29.5 17.6 28.5 39.3s-13.5 29.6-30.3 29.6s-31.4-8.8-30.4-30.5s15.4-38.3 32.1-38.3zm190.1 38.3c1 21.7-13.7 30.5-30.4 30.5s-29.3-7.9-30.3-29.6c-1-21.7 11.8-39.3 28.5-39.3s31.2 16.6 32.1 38.3zm-48.1 56.7c-10.3 24.6-34.6 41.9-63 41.9s-52.7-17.3-63-41.9c-1.2-2.9 .8-6.2 3.9-6.5c18.4-1.9 38.3-2.9 59.1-2.9s40.7 1 59.1 2.9c3.1 .3 5.1 3.6 3.9 6.5z"/></svg>
                </a>
                <a href="x.com" class="w-6 mx-2">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M389.2 48h70.6L305.6 224.2 487 464H345L233.7 318.6 106.5 464H35.8L200.7 275.5 26.8 48H172.4L272.9 180.9 389.2 48zM364.4 421.8h39.1L151.1 88h-42L364.4 421.8z"/></svg>
                </a>
                <a href="facebook.com" class="w-6 mx-2">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M512 256C512 114.6 397.4 0 256 0S0 114.6 0 256C0 376 82.7 476.8 194.2 504.5V334.2H141.4V256h52.8V222.3c0-87.1 39.4-127.5 125-127.5c16.2 0 44.2 3.2 55.7 6.4V172c-6-.6-16.5-1-29.6-1c-42 0-58.2 15.9-58.2 57.2V256h83.6l-14.4 78.2H287V510.1C413.8 494.8 512 386.9 512 256h0z"/></svg>
                </a>
            </div>
            <div class="my-5 text-gray-700">© Copyright 2024. All Rights Reserved.</div>
        </div>
    </div>
</body>
</html>
