package eu.thesystems.cloudnet.webinterface;

import de.dytanic.cloudnet.driver.module.ModuleLifeCycle;
import de.dytanic.cloudnet.driver.module.ModuleTask;
import de.dytanic.cloudnet.module.NodeCloudNetModule;
import eu.thesystems.cloudnet.webinterface.module.WIExtension;
import eu.thesystems.cloudnet.webinterface.module.WIExtensionElement;

import java.util.ArrayList;
import java.util.Arrays;
import java.util.Collection;
import java.util.concurrent.atomic.AtomicReference;

public class CloudNetWebInterface extends NodeCloudNetModule {

    private final Collection<WIExtension> extensions = new ArrayList<>();

    public void registerExtension(WIExtension extension) {
        this.extensions.add(extension);
    }

    @ModuleTask(event = ModuleLifeCycle.STARTED)
    public void startModule() {

        WIExtensionElement pasteResult = WIExtensionElement.createTextDisplay("paste_result", null);

        AtomicReference<String> pasteTarget = new AtomicReference<>();
        WIExtensionElement pasteInput = WIExtensionElement.createTextInput("target", "Target service", pasteTarget::set);

        this.registerExtension(new WIExtension("cloudnet_report_module", Arrays.asList(
                pasteInput,
                WIExtensionElement.createSupplyButton("create_paste", "Paste log of the node", o -> {
                    boolean all = pasteTarget.get() == null || pasteTarget.get().trim().isEmpty();
                    // create paste and set link to pasteResult.updateText
                }),
                pasteResult
        ), "CloudNet Report"));

    }

}
