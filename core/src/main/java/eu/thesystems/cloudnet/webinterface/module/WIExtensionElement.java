package eu.thesystems.cloudnet.webinterface.module;

import org.jetbrains.annotations.NotNull;
import org.jetbrains.annotations.Nullable;

import java.util.function.Consumer;

public class WIExtensionElement {

    private final Type type;
    private final Action clickAction;
    private final String key;
    private final transient Consumer<Object> clickHandler;
    private final String targetKey;
    private String text;

    private WIExtensionElement(Type type, Action clickAction, String key, Consumer<Object> clickHandler, String targetKey, String text) {
        this.type = type;
        this.clickAction = clickAction;
        this.key = key;
        this.clickHandler = clickHandler;
        this.targetKey = targetKey;
        this.text = text;
    }

    public static WIExtensionElement createSupplyButton(@NotNull String key, @Nullable String initialText, @NotNull Consumer<Object> clickHandler) { // TODO Replace Object with Javalin WebSocket Connection
        return new WIExtensionElement(Type.BUTTON, Action.EXECUTE_JAVA, key, clickHandler, null, initialText);
    }

    public static WIExtensionElement createModalButton(@NotNull String key, @Nullable String initialText, @NotNull String targetKey) {
        return new WIExtensionElement(Type.BUTTON, Action.OPEN_MODAL, key, null, targetKey, initialText);
    }

    public static WIExtensionElement createTextDisplay(@NotNull String key, @Nullable String initialText) {
        return new WIExtensionElement(Type.TEXT_DISPLAY, null, key, null, null, initialText);
    }

    public static WIExtensionElement createTextInput(@NotNull String key, @Nullable String placeholder, @NotNull Consumer<String> textHandler) {
        return new WIExtensionElement(Type.TEXT_INPUT, Action.EXECUTE_JAVA, key, o -> textHandler.accept(String.valueOf(o)), null, placeholder);
    }

    // TODO Modal

    public void updateText(String text) {
        this.text = text;
        // TODO send to clients
    }

    public Type getType() {
        return this.type;
    }

    public Action getClickAction() {
        return this.clickAction;
    }

    public String getKey() {
        return this.key;
    }

    public String getText() {
        return this.text;
    }

    public enum Action {
        EXECUTE_JAVA, OPEN_MODAL
    }

    public enum Type {
        BUTTON, TEXT_DISPLAY, TEXT_INPUT, MODAL
    }

}
