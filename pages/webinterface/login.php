<div class="container">
    <div class="section">
        <div class="row">
            <div class="col s12 m4 offset-m4">
                <div class="card-panel">
                    <h5 class="center">Login</h5>
                    <div class="row">
                        <form class="col s12" method="post">
                            <input type="hidden" name="action" value="login">
                            <input type="hidden" name="csrf" value="<?= $_SESSION['cn3-wi-access_csrf']; ?>">

                            <div class="row">
                                <div class="input-field col s12">
                                    <input id="username" type="text" name="username" class="validate">
                                    <label for="username">Benutzername</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12">
                                    <input id="password" type="password" name="password" class="validate">
                                    <label for="password">Password</label>
                                </div>
                            </div>
                            <button type="submit" class="waves-effect waves-light btn">Anmelden</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>