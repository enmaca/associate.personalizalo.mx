window.workshopDispatchEvent = (scriptContent) => {
    if (scriptContent.startsWith('livewire::')) {
        // Extract the event name after 'livewire::event'
        const eventName = scriptContent.replace('livewire::', '').trim();

        // Dispatch the Livewire event
        Livewire.dispatch(eventName);
    } else if (scriptContent.startsWith('javascript::')) {
        // Extract the event name after 'javascript::event'
        const eventName = scriptContent.replace('javascript::', '').trim();

        // Create and dispatch the pure JavaScript event
        const event = new Event(eventName);
        document.dispatchEvent(event);
    }
}