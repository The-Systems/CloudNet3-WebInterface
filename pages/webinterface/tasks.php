<!--
  ~    Copyright 2020 CloudNetService Project and contributors
  ~
  ~    Licensed under the Apache License, Version 2.0 (the "License");
  ~    you may not use this file except in compliance with the License.
  ~    You may obtain a copy of the License at
  ~
  ~        http://www.apache.org/licenses/LICENSE-2.0
  ~
  ~    Unless required by applicable law or agreed to in writing, software
  ~    distributed under the License is distributed on an "AS IS" BASIS,
  ~    WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
  ~    See the License for the specific language governing permissions and
  ~    limitations under the License.
  -->

<div class="w-full overflow-x-hidden flex flex-col">
    <header class="grid justify-items-end w-full bg-transparent text-gray-400 p-4">
        <ul class="flex items-center flex-shrink-0 space-x-6">
            <li class="relative">
                <button id="switchTheme"
                        class="h-10 w-10 flex justify-center items-center focus:outline-none text-yellow-500">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                              d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"
                              clip-rule="evenodd"></path>
                    </svg>
                </button>
            </li>
            <li class="relative">
                <img src="/assets/icons/status.svg"/>
                <span aria-hidden="true"
                      class="absolute top-0 right-0 inline-block w-3 h-3 transform translate-x-1 -translate-y-1 bg-red-600 border-2 border-white rounded-full"></span>
            </li>
            <li class="relative">
                <img class="object-cover w-8 h-8 rounded-full"
                     src="https://pbs.twimg.com/profile_images/1221609781296881665/FjGb4yqO_400x400.jpg" alt=""
                     aria-hidden="true"/>
            </li>
        </ul>
    </header>

    <main class="w-full flex-grow p-6">
        <div class="py-3">
            <main class="h-full overflow-y-auto">
                <div class="container mx-auto grid">
                    <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-4">
                        <!-- Tasks start -->
                        <div class="min-w-0 p-4 dark:bg-gray-800 bg-white rounded-lg shadow-lg">
                            <h4 class="mb-4 font-semibold text-blue-500">Lobby</h4>
                            <div class="flex">
                                <span class="text-gray-400">•</span>
                                <p class="flex-1 dark:text-white text-gray-900 items-center pl-2">Memory Usage:
                                    50MB/100MB<br></p>
                            </div>
                            <div class="flex">
                                <span class="text-gray-400">•</span>
                                <p class="flex-1 dark:text-white text-gray-900 items-center pl-2">Nodes: Nodes-1<br></p>
                            </div>
                            <div class="flex">
                                <span class="text-gray-400">•</span>
                                <p class="flex-1 dark:text-white text-gray-900 items-center pl-2">AutoDeleteOnStop: true<br>
                                </p>
                            </div>
                            <div class="flex">
                                <span class="text-gray-400">•</span>
                                <p class="flex-1 dark:text-white text-gray-900 items-center pl-2">StartPort: 25566<br>
                                </p>
                            </div>
                            <div class="flex">
                                <span class="text-gray-400">•</span>
                                <p class="flex-1 dark:text-white text-gray-900 items-center pl-2">Groups: Lobby<br></p>
                            </div>
                            <div class="flex">
                                <span class="text-gray-400">•</span>
                                <p class="flex-1 dark:text-white text-gray-900 items-center pl-2">Environment:
                                    MINECRAFT_SERVER<br></p>
                            </div>
                            <div class="flex justify-center mt-4 space-x-3 text-sm text-white">
                                <div class="flex items-center">
                                    <button type="button"
                                            class="h-10 bg-blue-500 text-white rounded-md px-4 py-2 m-2 hover:bg-blue-600 focus:outline-none focus:shadow-outline">
                                        Edit
                                    </button>
                                    <button type="button"
                                            class="h-10 bg-blue-500 text-white rounded-md px-4 py-2 m-2 hover:bg-blue-600 focus:outline-none focus:shadow-outline">
                                        Delete
                                    </button>
                                </div>
                            </div>
                        </div>
                        <!-- Tasks end -->
                    </div>
                </div>
            </main>
        </div>
        <div class="py-3">
            <main class="h-full overflow-y-auto">
                <div class="container mx-auto grid">
                    <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-1">
                        <!-- Create Task -->
                        <div class="w-full">
                            <div class="coding inverse-toggle px-5 pt-4 shadow-lg text-gray-100 dark:bg-gray-800 bg-white pb-6 pt-4 rounded-lg leading-normal overflow-hidden">
                                <div class="top mb-2 flex">
                                    <h4 class="mb-2 font-semibold dark:text-white text-gray-900">Create Task</h4>
                                </div>
                                <div class="flex-1 flex flex-col md:flex-row text-sm font-mono subpixel-antialiased">
                                    <div class="w-full flex-1 mx-2">
                                        <input placeholder="Name"
                                               class="my-2 p-2 dark:bg-gray-900 bg-gray-100 flex border dark:border-gray-900 border-gray-100 rounded px-2 appearance-none outline-none w-full dark:text-white text-gray-900 focus:ring-2 focus:ring-blue-600">
                                    </div>
                                    <div class="w-full flex-1 mx-2">
                                        <input placeholder="Ram"
                                               class="my-2 p-2 dark:bg-gray-900 bg-gray-100 flex border dark:border-gray-900 border-gray-100 rounded px-2 appearance-none outline-none w-full dark:text-white text-gray-900 focus:ring-2 focus:ring-blue-600">
                                    </div>
                                    <div class="w-full flex-1 mx-2">
                                        <select class="my-2 p-2 dark:bg-gray-900 bg-gray-100 flex border dark:border-gray-900 border-gray-100 rounded px-2 appearance-none outline-none w-full dark:text-white text-gray-900 focus:ring-2 focus:ring-blue-600"
                                                id="node-state">
                                            <option class="text-sm font-mono subpixel-antialiased text-gray-100"
                                                    disabled selected>Select Node
                                            </option>
                                            <option class="text-sm font-mono subpixel-antialiased">Node-1</option>
                                            <option class="text-sm font-mono subpixel-antialiased">Node-2</option>
                                            <option class="text-sm font-mono subpixel-antialiased">Node-3</option>
                                        </select>
                                    </div>
                                    <div class="w-full flex-1 mx-2">
                                        <input placeholder="Port"
                                               class="my-2 p-2 dark:bg-gray-900 bg-gray-100 flex border dark:border-gray-900 border-gray-100 rounded px-2 appearance-none outline-none w-full dark:text-white text-gray-900 focus:ring-2 focus:ring-blue-600">
                                    </div>
                                    <div class="w-full flex-1 mx-2">
                                        <label class="inline-flex items-center mt-3">
                                            <input type="checkbox" class="form-checkbox h-5 w-5"><span
                                                    class="ml-2 dark:text-white text-gray-900">Static</span>
                                        </label>
                                        <label class="inline-flex items-center mt-3">
                                            <input type="checkbox" class="form-checkbox h-5 w-5" checked><span
                                                    class="ml-2 dark:text-white text-gray-900">AutoDeleteOnStop</span>
                                        </label>
                                    </div>
                                </div>
                                <button type="button"
                                        class="h-10 bg-blue-500 text-white rounded-md px-4 py-2 m-2 hover:bg-blue-600 focus:outline-none focus:shadow-outline">
                                    Create
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </main>
    <footer class="w-full bg-transparent text-gray-400 text-center p-4">Copyright © 2020 CloudNetService</footer>
</div>