package eu.thesystems.cloudnet.webinterface.module;

import java.util.Collection;

public class WIExtension {

    private final String key;
    private final Collection<WIExtensionElement> elements;
    private String displayName;

    public WIExtension(String key, Collection<WIExtensionElement> elements, String displayName) {
        this.key = key;
        this.elements = elements;
        this.displayName = displayName;
    }

    public String getKey() {
        return this.key;
    }

    public Collection<WIExtensionElement> getElements() {
        return this.elements;
    }

    public String getDisplayName() {
        return this.displayName;
    }

    public void updateDisplayName(String displayName) {
        this.displayName = displayName;
        // TODO send to clients
    }

}
