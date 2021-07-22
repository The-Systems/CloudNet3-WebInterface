<div class="container">
    <div class="section">
        <div class="row">
            <div class="col s12 m6">
                <div class="card-panel">
                </div>
            </div>
            <div class="col s12 m6">
                <div class="card-panel">
                    <h4 class="center">CloudNet - Webinterface</h4>
                    <h5 class="center"><?= \webinterface\main::getMessage("version") ?> <?= \webinterface\main::getCurrentVersion(); ?> <?= \webinterface\main::getMessage("from") ?></h5>

                    <p class="center"><a href="https://discord.gg/CYHuDpx" class="btn center"><?= \webinterface\main::getMessage("supportdiscord") ?></a></p>
                    <p class="center"><a href="https://www.spigotmc.org/resources/cloudnet-webinterface.58905/" class="btn center"><?= \webinterface\main::getMessage("spigotpage") ?></a></p>
                    <?php
                    $json = \webinterface\main::getVersion();
                    $version = \webinterface\main::getCurrentVersion();
                    $new_version = $json['response']['version'];
                    print_r($json);
                    if ($json['success'] != true) { ?>
                        <h1><span style="color: #FF0000">Der Kontrollserver ist zurzeit nicht erreichbar.</span></h1><?php
                    } elseif ($version != $new_version) { ?>
                        <p><span style="color: #FF0000"> <?= \webinterface\main::getMessage("oldversion1") ?></span></p>
                        <p><span style="color: #FF0000"> <?= \webinterface\main::getMessage("oldversion2") ?></span></p><?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>