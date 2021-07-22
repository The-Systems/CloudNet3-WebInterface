<main class="w-full flex-grow p-6">
    <div class="py-1">
        <main class="h-full overflow-y-auto">
            <div class="container mx-auto grid">
                <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-4">
                    <!--Users-->
                    <div class="flex items-center p-4 dark:bg-gray-800 bg-white rounded-lg shadow-lg">
                        <div class="p-3 mr-4 text-blue-500 bg-blue-100 rounded-full">
                            <img src="assets/icons/user.svg"/>
                        </div>
                        <div>
                            <p class="mb-2 text-base font-medium text-gray-400">Users</p>
                            <p class="text-xl font-semibold dark:text-white text-gray-900">35/100</p>
                        </div>
                    </div>
                    <!-- Servers -->
                    <div class="flex items-center p-4 dark:bg-gray-800 bg-white rounded-lg shadow-lg">
                        <div class="p-3 mr-4 text-blue-500 bg-blue-100 rounded-full">
                            <img src="assets/icons/server.svg"/>
                        </div>
                        <div>
                            <p class="mb-2 text-base font-medium text-gray-400">Servers</p>
                            <p class="text-xl font-semibold dark:text-white text-gray-900">10</p>
                        </div>
                    </div>
                    <!-- CPU -->
                    <div class="flex items-center p-4 dark:bg-gray-800 bg-white rounded-lg shadow-lg">
                        <div class="p-3 mr-4 text-blue-500 bg-blue-100 rounded-full">
                            <img src="assets/icons/cpu.svg"/>
                        </div>
                        <div>
                            <p class="mb-2 text-base font-medium text-gray-400">CPU</p>
                            <p class="text-xl font-semibold dark:text-white text-gray-900">55%/100%</p>
                        </div>
                    </div>
                    <!-- Ram -->
                    <div class="flex items-center p-4 dark:bg-gray-800 bg-white rounded-lg shadow-lg">
                        <div class="p-3 mr-4 text-blue-500 bg-blue-100 rounded-full">
                            <img src="assets/icons/ram.svg"/>
                        </div>
                        <div>
                            <p class="mb-2 text-base font-medium text-gray-400">Ram</p>
                            <p class="text-xl font-semibold dark:text-white text-gray-900">100MB/500MB</p>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <div class="py-3">
        <main class="h-full overflow-y-auto">
            <div class="container mx-auto grid">
                <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-2">
                    <!-- Ram Usage -->
                    <div class="min-w-0 p-4 dark:bg-gray-800 bg-white rounded-lg shadow-lg">
                        <h4 class="mb-4 font-semibold dark:text-white text-gray-900">Ram Usage</h4>
                        <canvas id="ram" width="350" height="100"></canvas>
                        <div class="flex justify-center mt-4 space-x-3 text-sm dark:text-white text-gray-900">
                            <div class="flex items-center">
                                <span class="inline-block w-3 h-3 mr-1 bg-green-600 rounded-full"></span>
                                <span>Usage in MB</span>
                            </div>
                        </div>
                    </div>
                    <!-- CPU Usage -->
                    <div class="min-w-0 p-4 dark:bg-gray-800 bg-white rounded-lg shadow-lg">
                        <h4 class="mb-4 font-semibold dark:text-white text-gray-900">CPU Usage</h4>
                        <canvas id="cpu" width="350" height="100"></canvas>
                        <div class="flex justify-center mt-4 space-x-3 text-sm dark:text-white text-gray-900">
                            <div class="flex items-center">
                                <span class="inline-block w-3 h-3 mr-1 bg-blue-600 rounded-full"></span>
                                <span>Usage in %</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <div class="py-3">
        <main class="h-full overflow-y-auto">
            <div class="container mx-auto grid">
                <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-2">
                    <!-- Stats -->
                    <div class="w-full">
                        <div class="coding inverse-toggle px-5 pt-4 shadow-lg dark:text-gray-100 text-gray-900 text-sm font-mono subpixel-antialiased dark:bg-gray-800 bg-white pb-6 pt-4 rounded-lg leading-normal overflow-hidden">
                            <div class="top mb-2 flex">
                                <div class="h-3 w-3 bg-red-500 rounded-full"></div>
                                <div class="ml-2 h-3 w-3 bg-yellow-300 rounded-full"></div>
                                <div class="ml-2 h-3 w-3 bg-green-500 rounded-full"></div>
                            </div>
                            <div class="mt-4 flex">
                                <span class="text-green-400">cloudnet:~$</span>
                                <p class="flex-1 typing items-center pl-2">Registered: 6482<br></p>
                                <img class="justify-items-end" src="assets/icons/pen.svg"/>
                            </div>
                            <div class="flex">
                                <span class="text-green-400">cloudnet:~$</span>
                                <p class="flex-1 typing items-center pl-2">Highest OnlineCount: 157<br></p>
                                <img class="justify-items-end" src="assets/icons/pen.svg"/>
                            </div>
                            <div class="flex">
                                <span class="text-green-400">cloudnet:~$</span>
                                <p class="flex-1 typing items-center pl-2">Logins: 102372<br></p>
                                <img class="justify-items-end" src="assets/icons/pen.svg"/>
                            </div>
                            <div class="flex">
                                <span class="text-green-400">cloudnet:~$</span>
                                <p class="flex-1 typing items-center pl-2">Command Executions: 345272<br></p>
                                <img class="justify-items-end" src="assets/icons/pen.svg"/>
                            </div>
                        </div>
                    </div>
                    <!-- Status -->
                    <div class="min-w-0 p-4 text-white bg-gradient-to-br from-red-600 to-red-800 rounded-lg shadow-xs">
                        <h4 class="mb-4 font-bold">Warning!</h4>
                        <p>
                            Currently you are using an outdated CloudNet version (${version}), to keep the Cloud up to date and
                            to get support, you can activate the auto updater in the launcher.cnl file.
                        </p>
                    </div>
                </div>
            </div>
        </main>
    </div>
</main>