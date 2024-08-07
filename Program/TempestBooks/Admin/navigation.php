<?php

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Hamburger Menu with Tailwind CSS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body class="bg-gray-100">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div id="sidebar" class="sidebar fixed inset-y-0 left-0 transform bg-gray-100 w-64 text-white h-full lg:translate-x-0 -translate-x-full transition-transform duration-300 ease-in-out">
            <div class="p-4 flex justify-between items-center lg:hidden">
                <h1 class="text-xl text-slate-700 font-bold">Admin Dashboard</h1>
                <button id="close-button" class="text-2xl">
                    <i class="fas fa-times text-slate-700"></i>
                </button>
            </div>
            <ul class=" space-y-2 flex flex-col py-6">
                <div class="flex items-center pl-6 h-20 border-b border-gray-800">
                    <img src="../Images/LOGO.jpg" alt="Profile Picture" class="rounded-full h-10 w-10 flex items-center justify-center mr-3 border-2 border-yellow-500">
                    <div class="ml-1">
                        <p class="ml-1 text-md font-medium font-bold tracking-wide truncate text-slate-700 font-sans"> Tempest Books</p>
                        <div class="badge">
                            <span class="px-2 py-0.5 ml-auto text-xs font-medium tracking-wide text-blue-800 bg-blue-100 rounded-full">Admin</span>
                        </div>
                    </div>
                </div>
                <li>
                    <a href="AdminDashboard.php" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-yellow-400 transition-all text-gray-500 hover:text-gray-200 border-l-4 border-transparent hover:border-blue-500 pr-6">
                        <span class="inline-flex justify-center items-center ml-4">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                        </span>
                        <span class="ml-2 font-semibold text-sm tracking-wide truncate font-sans">Home</span>
                    </a>
                </li>
                <li>
                    <a href="books.php" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-yellow-400 transition-all text-gray-500 hover:text-gray-200 border-l-4 border-transparent hover:border-blue-500 pr-6">
                        <span class="inline-flex justify-center items-center ml-4">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                            </svg>

                            <span class="ml-2 font-semibold text-sm tracking-wide truncate font-sans">Book</span>
                    </a>
                </li>
                <li>
                    <a href="author.php" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-yellow-400 transition-all text-gray-500 hover:text-gray-200 border-l-4 border-transparent hover:border-blue-500 pr-6">
                        <span class="inline-flex justify-center items-center ml-4">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                            </svg>
                            <span class="ml-2 font-semibold text-sm tracking-wide truncate font-sans">Author</span>
                    </a>
                </li>
                <li>
                    <a href="isbn.php" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-yellow-400 transition-all text-gray-500 hover:text-gray-200 border-l-4 border-transparent hover:border-blue-500 pr-6">
                        <span class="inline-flex justify-center items-center ml-4">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0 1 3.75 9.375v-4.5ZM3.75 14.625c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5a1.125 1.125 0 0 1-1.125-1.125v-4.5ZM13.5 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0 1 13.5 9.375v-4.5Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 6.75h.75v.75h-.75v-.75ZM6.75 16.5h.75v.75h-.75v-.75ZM16.5 6.75h.75v.75h-.75v-.75ZM13.5 13.5h.75v.75h-.75v-.75ZM13.5 19.5h.75v.75h-.75v-.75ZM19.5 13.5h.75v.75h-.75v-.75ZM19.5 19.5h.75v.75h-.75v-.75ZM16.5 16.5h.75v.75h-.75v-.75Z" />
                            </svg>
                        </span>
                        <span class="ml-2 font-semibold text-sm tracking-wide truncate font-sans">ISBN</span>
                    </a>
                </li>
                <li>
                    <a href="category.php" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-yellow-400 transition-all text-gray-500 hover:text-gray-200 border-l-4 border-transparent hover:border-blue-500 pr-6">
                        <span class="inline-flex justify-center items-center ml-4">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 0 0 5.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 0 0 9.568 3Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6Z" />
                            </svg>
                        </span>
                        <span class="ml-2 font-semibold text-sm tracking-wide truncate font-sans">Category</span>
                    </a>
                </li>
                <li>
                    <a href="publisher.php" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-yellow-400 transition-all text-gray-500 hover:text-gray-200 border-l-4 border-transparent hover:border-blue-500 pr-6">
                        <span class="inline-flex justify-center items-center ml-4">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 0 0 .75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 0 0-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0 1 12 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 0 1-.673-.38m0 0A2.18 2.18 0 0 1 3 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 0 1 3.413-.387m7.5 0V5.25A2.25 2.25 0 0 0 13.5 3h-3a2.25 2.25 0 0 0-2.25 2.25v.894m7.5 0a48.667 48.667 0 0 0-7.5 0M12 12.75h.008v.008H12v-.008Z" />
                            </svg>
                        </span>
                        <span class="ml-2 font-semibold text-sm tracking-wide truncate font-sans">Publisher</span>
                    </a>
                </li>
                <li class="px-5">
                    <div class="flex flex-row items-center h-8">
                        <div class="flex font-bold text-sm text-slate-600 my-4 font-sans uppercase">Confirmations</div>
                    </div>
                </li>
                <li>
                    <a href="orderlist.php" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-yellow-400 transition-all text-gray-500 hover:text-gray-200 border-l-4 border-transparent hover:border-blue-500 pr-6">
                        <span class="inline-flex justify-center items-center ml-4">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                            </svg>
                        </span>
                        <span class="ml-2 font-semibold text-sm tracking-wide truncate font-sans">Order List</span>
                    </a>
                </li>
                <li>
                    <a href="purchase.php" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-yellow-400 transition-all text-gray-500 hover:text-gray-200 border-l-4 border-transparent hover:border-blue-500 pr-6">
                        <span class="inline-flex justify-center items-center ml-4">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5m8.25 3v6.75m0 0-3-3m3 3 3-3M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
                            </svg>
                        </span>
                        <span class="ml-2 font-semibold text-sm tracking-wide truncate font-sans">Purchasing </span>
                    </a>
                </li>
                <li>
                    <a href="purchaselist.php" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-yellow-400 transition-all text-gray-500 hover:text-gray-200 border-l-4 border-transparent hover:border-blue-500 pr-6">
                        <span class="inline-flex justify-center items-center ml-4">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
                            </svg>
                            <span class="ml-2 font-semibold text-sm tracking-wide truncate font-sans">Purchase List</span>
                    </a>
                </li>
                <li>
                    <a href="adminlogout.php" onclick="return confirmLogout(event);" class="relative flex flex-row items-center h-11 focus:outline-none hover:bg-yellow-400 text-gray-500 hover:text-gray-200 border-l-4 border-transparent hover:border-red-500 pr-6">
                        <span class="inline-flex justify-center items-center ml-4 text-gray-500">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                        </span>
                        <span class="ml-2 font-semibold text-sm tracking-wide truncate font-sans">Logout</span>
                    </a>
                </li>
            </ul>
        </div>
        <!-- Content -->
        <div class="flex-1  lg:ml-64 bg-gray-100 p-2">
            <button id="menu-button" class="text-2xl lg:text-2xl lg:block mt-10">
                <i class="fas fa-bars "></i>
            </button>
        </div>
    </div>

    <script src="../script.js"></script>
    <script>
    function confirmLogout(event) {
        if (!confirm("Are you sure you want to log out?")) {
            event.preventDefault(); // Prevent the default action (following the link)
            return false; // Prevent the link from being followed
        }
        return true; // Allow the link to be followed
    }
</script>
</body>

</html>