<script src="https://code.jquery.com/jquery-1.9.1.js"></script>
<script>
    function showMessage(messageHTML) {
        $('#socket_event').prepend(messageHTML);
    }
    let websocket;

    $(document).ready(function () {
        function ws_connect() {
            websocket = new WebSocket("<?= \webinterface\main::provideSocketUrl()."/service/".$service_name."/liveLog"; ?>");

            websocket.onmessage = function (event) {
                showMessage(event.data);
            };

            websocket.onclose = function (e) {
                showMessage('<div class="dark:text-gray-200 text-gray-800 text-sm">Cannot connect</div>');
            };

            websocket.onerror = function (err) {
                websocket.close();

            };
        };
        ws_connect();
    });

</script>


<main class="w-full flex-grow p-6">

    <div class="py-3">
        <main class="h-full overflow-y-auto">
            <div class="container mx-auto grid">
                <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-1">
                    <!-- Create Node -->
                    <div class="w-full">
                        <div class="coding inverse-toggle px-5 pt-4 shadow-lg text-gray-100 dark:bg-gray-800 bg-white pb-6 pt-4 rounded-lg leading-normal overflow-hidden">

                            <div id="socket_event"></div>
                       </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</main>